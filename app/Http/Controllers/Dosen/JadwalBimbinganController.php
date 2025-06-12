<?php


namespace App\Http\Controllers\Dosen;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Dosen;
use App\Models\DetailDosen;
use App\Models\PengajuanJudul;
use App\Models\JadwalBimbingan;
use App\Models\DokumenOnline;
use App\Models\Mahasiswa;


class JadwalBimbinganController extends Controller
{
    /**
     * Display dashboard with summary statistics
     */
    public function dashboard()
    {
        try {
            // Get current dosen
            $dosen = Auth::user()->dosen;


            if (!$dosen) {
                return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
            }


            // Get total students under guidance
            $totalMahasiswa = DetailDosen::where('dosen_id', $dosen->id)
                ->where('status', 'diterima')
                ->whereHas('pengajuanJudul', function($query) {
                    $query->where('approved_ta', 'berjalan');
                })
                ->count();


            // Get total title submissions
            $totalPengajuanJudul = DetailDosen::where('dosen_id', $dosen->id)
                ->count();


            // Get total guidance schedules
            $totalJadwalBimbingan = JadwalBimbingan::where('dosen_id', $dosen->id)
                ->count();


            // Get latest title submissions
            $latestSubmissions = PengajuanJudul::whereHas('detailDosen', function($query) use ($dosen) {
                    $query->where('dosen_id', $dosen->id);
                })
                ->with('mahasiswa')
                ->orderBy('id', 'desc')
                ->limit(5)
                ->get();


            // Get today's guidance schedule
            $today = Carbon::now()->format('Y-m-d');
            $todaySchedules = JadwalBimbingan::where('dosen_id', $dosen->id)
                ->where('tanggal_pengajuan', $today)
                ->where('status', 'diterima')
                ->with(['pengajuanJudul', 'pengajuanJudul.mahasiswa'])
                ->get();


            return view('dosen.dashboard', compact(
                'totalMahasiswa',
                'totalPengajuanJudul',
                'totalJadwalBimbingan',
                'latestSubmissions',
                'todaySchedules'
            ));


        } catch (\Exception $e) {


            // Provide default values for the view
            $totalMahasiswa = 0;
            $totalPengajuanJudul = 0;
            $totalJadwalBimbingan = 0;
            $latestSubmissions = collect([]);
            $todaySchedules = collect([]);


            return view('dosen.dashboard', compact(
                'totalMahasiswa',
                'totalPengajuanJudul',
                'totalJadwalBimbingan',
                'latestSubmissions',
                'todaySchedules'
            ));
        }
    }


    /**
     * Tampilkan halaman jadwal bimbingan dengan semua informasi yang diperlukan
     * (Menggabungkan fungsi index, today, dan mendatang dalam satu halaman)
     */
    public function jadwalBimbingan()
    {
        try {
            // Get current dosen
            $dosen = Auth::user()->dosen;


            if (!$dosen) {
                return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
            }


            // Get today's date
            $today = Carbon::now()->format('Y-m-d');


            // Get today's schedules
            $todaySchedules = JadwalBimbingan::where('dosen_id', $dosen->id)
                ->where('tanggal_pengajuan', $today)
                ->with(['pengajuanJudul.mahasiswa', 'dokumenOnline'])
                ->orderBy('waktu_pengajuan', 'asc')
                ->get();


            // Get schedules waiting for confirmation (pending)
            $menungguKonfirmasi = JadwalBimbingan::where('dosen_id', $dosen->id)
                ->where('status', 'diproses')
                ->with(['pengajuanJudul.mahasiswa', 'dokumenOnline'])
                ->orderBy('tanggal_pengajuan', 'asc')
                ->orderBy('waktu_pengajuan', 'asc')
                ->get();


            // Get completed schedules
            $totalSelesai = JadwalBimbingan::where('dosen_id', $dosen->id)
                ->where('status', 'diterima')
                ->with(['pengajuanJudul.mahasiswa', 'dokumenOnline'])
                ->orderBy('tanggal_pengajuan', 'desc')
                ->orderBy('waktu_pengajuan', 'desc')
                ->get();


            // Get total counts for cards
            $todaySchedulesCount = $todaySchedules->count();
            $pendingSchedulesCount = $menungguKonfirmasi->count();
            $completedSchedulesCount = $totalSelesai->count();


            // Get upcoming schedules (future schedules or pending schedules)
            $upcomingSchedules = JadwalBimbingan::where('dosen_id', $dosen->id)
                ->where(function($query) use ($today) {
                    $query->where('tanggal_pengajuan', '>=', $today)
                        ->orWhere('status', 'diproses');
                })
                ->with(['pengajuanJudul.mahasiswa', 'dokumenOnline'])
                ->orderBy('tanggal_pengajuan', 'asc')
                ->orderBy('waktu_pengajuan', 'asc')
                ->get();


            // Add missing variables from previous fixes
            $bimbinganHariIni = $todaySchedules;
            $jadwalHariIni = $todaySchedules;
            $jadwalMendatang = $upcomingSchedules; // Tambahkan alias ini


            return view('dosen.jadwal-bimbingan', compact(
                'todaySchedules',
                'todaySchedulesCount',
                'pendingSchedulesCount',
                'completedSchedulesCount',
                'upcomingSchedules',
                'bimbinganHariIni',
                'menungguKonfirmasi',
                'totalSelesai',
                'jadwalHariIni',
                'jadwalMendatang'
            ));


        } catch (\Exception $e) {
            // Provide default values
            $todaySchedules = collect([]);
            $todaySchedulesCount = 0;
            $pendingSchedulesCount = 0;
            $completedSchedulesCount = 0;
            $upcomingSchedules = collect([]);
            $bimbinganHariIni = collect([]);
            $menungguKonfirmasi = collect([]);
            $totalSelesai = collect([]);
            $jadwalHariIni = collect([]);
            $jadwalMendatang = collect([]); // Tambahkan default value ini


            return view('dosen.jadwal-bimbingan', compact(
                'todaySchedules',
                'todaySchedulesCount',
                'pendingSchedulesCount',
                'completedSchedulesCount',
                'upcomingSchedules',
                'bimbinganHariIni',
                'menungguKonfirmasi',
                'totalSelesai',
                'jadwalHariIni',
                'jadwalMendatang'
            ))->with('error', 'Terjadi kesalahan saat memuat jadwal bimbingan.');
        }
    }


    /**
     * Accept a guidance schedule request.
     */
    public function accept(Request $request, $id)
    {
        $jadwal = JadwalBimbingan::find($id);

        if (!$jadwal) {
            return redirect()->back()->with('error', 'Jadwal bimbingan tidak ditemukan');
        }

        // Validasi metode wajib dipilih oleh dosen
        $request->validate([
            'metode' => 'required|in:online,offline',
            'keterangan' => 'nullable|string|max:1000'
        ]);

        $jadwal->status = 'diterima';
        $jadwal->metode = $request->metode;

        if ($request->metode === 'offline') {
            $jadwal->keterangan_diterima_offline = $request->keterangan;
        }

        $jadwal->save();

        if ($request->metode === 'online') {
            DokumenOnline::create([
                'jadwal_bimbingan_id' => $jadwal->id,
                'status' => 'menunggu'
            ]);

            return redirect()->route('dosen.dokumen.online')
                ->with('success', 'Jadwal bimbingan online berhasil diterima');
        }

        return redirect()->back()->with('success', 'Jadwal bimbingan offline berhasil diterima');
    }




    /**
     * Reject a guidance schedule request.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'keterangan_ditolak' => 'required|string',
        ]);


        $jadwal = JadwalBimbingan::find($id);


        if ($jadwal) {
            $jadwal->status = 'ditolak';
            $jadwal->keterangan_ditolak = $request->keterangan_ditolak;
            $jadwal->save();


            return redirect()->back()->with('success', 'Jadwal bimbingan berhasil ditolak');
        }


        return redirect()->back()->with('error', 'Jadwal bimbingan tidak ditemukan');
    }


    /**
     * Show the details of a guidance document.
     */
    public function showDocument($id)
    {
        $dokumen = DokumenOnline::with([
                'jadwalBimbingan',
                'jadwalBimbingan.pengajuanJudul',
                'jadwalBimbingan.pengajuanJudul.mahasiswa'
            ])
            ->findOrFail($id);


        return view('dosen.dokumen-detail', compact('dokumen'));
    }


    /**
     * Update the guidance document with lecturer's review.
     */
    public function updateDocument(Request $request, $id)
    {
        $request->validate([
            'keterangan_dosen' => 'required|string',
            'dokumen_dosen' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);


        $dokumen = DokumenOnline::find($id);


        if (!$dokumen) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan');
        }


        $dokumen->keterangan_dosen = $request->keterangan_dosen;
        $dokumen->tanggal_review = Carbon::now()->format('Y-m-d');
        $dokumen->status = 'selesai';


        // Upload document if provided
        if ($request->hasFile('dokumen_dosen')) {
            $file = $request->file('dokumen_dosen');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/dokumen_dosen'), $fileName);
            $dokumen->dokumen_dosen = 'uploads/dokumen_dosen/' . $fileName;
        }


        $dokumen->save();


        return redirect()->back()->with('success', 'Dokumen berhasil diperbarui');
    }
}
