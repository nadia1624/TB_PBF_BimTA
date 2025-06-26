<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\JadwalBimbingan;

class RiwayatBimbinganController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Get current dosen
            $dosen = Auth::user()->dosen;

            if (!$dosen) {
                return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
            }

            // Get current date and time
            $now = Carbon::now();
            $today = $now->format('Y-m-d');
            $currentTime = $now->format('H:i:s');

            // Query dasar untuk riwayat bimbingan yang sudah selesai
            $query = JadwalBimbingan::where('dosen_id', $dosen->id)
                ->with(['pengajuanJudul.mahasiswa', 'dokumenOnline'])
                ->where(function($q) use ($today, $currentTime) {
                    // Metode offline: tanggal dan waktu pengajuan sudah lewat
                    $q->where(function($subQ) use ($today, $currentTime) {
                        $subQ->where('metode', 'offline')
                             ->where(function($dateQ) use ($today, $currentTime) {
                                 $dateQ->where('tanggal_pengajuan', '<', $today)
                                       ->orWhere(function($timeQ) use ($today, $currentTime) {
                                           $timeQ->where('tanggal_pengajuan', '=', $today)
                                                 ->where('waktu_pengajuan', '<', $currentTime);
                                       });
                             });
                    })
                    // Metode online: dokumen online dengan status selesai
                    ->orWhere(function($subQ) {
                        $subQ->where('metode', 'online')
                             ->whereHas('dokumenOnline', function($docQ) {
                                 $docQ->where('status', 'selesai');
                             });
                    });
                })
                ->orderBy('tanggal_pengajuan', 'desc')
                ->orderBy('waktu_pengajuan', 'desc');

            // Filter berdasarkan pencarian jika ada
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($searchQ) use ($search) {
                    $searchQ->whereHas('pengajuanJudul.mahasiswa', function($q) use ($search) {
                        $q->where('nama', 'like', '%' . $search . '%')
                          ->orWhere('nim', 'like', '%' . $search . '%')
                          ->orWhere('nama_lengkap', 'like', '%' . $search . '%');
                    })->orWhereHas('pengajuanJudul', function($q) use ($search) {
                        $q->where('judul', 'like', '%' . $search . '%');
                    });
                });
            }

            // Filter berdasarkan rentang tanggal jika ada
            if ($request->has('start_date') && !empty($request->start_date)) {
                $query->whereDate('tanggal_pengajuan', '>=', $request->start_date);
            }

            if ($request->has('end_date') && !empty($request->end_date)) {
                $query->whereDate('tanggal_pengajuan', '<=', $request->end_date);
            }

            // Filter berdasarkan metode jika ada
            if ($request->has('metode') && !empty($request->metode)) {
                $query->where('metode', $request->metode);
            }

            // Get riwayat bimbingan with pagination
            $riwayatBimbingan = $query->paginate(10)->appends($request->query());

            // Get statistics for cards
            $totalRiwayat = JadwalBimbingan::where('dosen_id', $dosen->id)
                ->where(function($q) use ($today, $currentTime) {
                    $q->where(function($subQ) use ($today, $currentTime) {
                        $subQ->where('metode', 'offline')
                             ->where(function($dateQ) use ($today, $currentTime) {
                                 $dateQ->where('tanggal_pengajuan', '<', $today)
                                       ->orWhere(function($timeQ) use ($today, $currentTime) {
                                           $timeQ->where('tanggal_pengajuan', '=', $today)
                                                 ->where('waktu_pengajuan', '<', $currentTime);
                                       });
                             });
                    })
                    ->orWhere(function($subQ) {
                        $subQ->where('metode', 'online')
                             ->whereHas('dokumenOnline', function($docQ) {
                                 $docQ->where('status', 'selesai');
                             });
                    });
                })
                ->count();

            $riwayatBulanIni = JadwalBimbingan::where('dosen_id', $dosen->id)
                ->where(function($q) use ($today, $currentTime) {
                    $q->where(function($subQ) use ($today, $currentTime) {
                        $subQ->where('metode', 'offline')
                             ->where(function($dateQ) use ($today, $currentTime) {
                                 $dateQ->where('tanggal_pengajuan', '<', $today)
                                       ->orWhere(function($timeQ) use ($today, $currentTime) {
                                           $timeQ->where('tanggal_pengajuan', '=', $today)
                                                 ->where('waktu_pengajuan', '<', $currentTime);
                                       });
                             });
                    })
                    ->orWhere(function($subQ) {
                        $subQ->where('metode', 'online')
                             ->whereHas('dokumenOnline', function($docQ) {
                                 $docQ->where('status', 'selesai');
                             });
                    });
                })
                ->whereMonth('tanggal_pengajuan', Carbon::now()->month)
                ->whereYear('tanggal_pengajuan', Carbon::now()->year)
                ->count();

            $riwayatOnline = JadwalBimbingan::where('dosen_id', $dosen->id)
                ->where('metode', 'online')
                ->whereHas('dokumenOnline', function($docQ) {
                    $docQ->where('status', 'selesai');
                })
                ->count();

            $riwayatOffline = JadwalBimbingan::where('dosen_id', $dosen->id)
                ->where('metode', 'offline')
                ->where(function($dateQ) use ($today, $currentTime) {
                    $dateQ->where('tanggal_pengajuan', '<', $today)
                          ->orWhere(function($timeQ) use ($today, $currentTime) {
                              $timeQ->where('tanggal_pengajuan', '=', $today)
                                    ->where('waktu_pengajuan', '<', $currentTime);
                          });
                })
                ->count();

            return view('dosen.riwayat-bimbingan', compact(
                'riwayatBimbingan',
                'totalRiwayat',
                'riwayatBulanIni',
                'riwayatOnline',
                'riwayatOffline'
            ));

        } catch (\Exception $e) {
            // Provide default values in case of error
            $riwayatBimbingan = collect([])->paginate(10);
            $totalRiwayat = 0;
            $riwayatBulanIni = 0;
            $riwayatOnline = 0;
            $riwayatOffline = 0;

            return view('dosen.riwayat-bimbingan', compact(
                'riwayatBimbingan',
                'totalRiwayat',
                'riwayatBulanIni',
                'riwayatOnline',
                'riwayatOffline'
            ))->with('error', 'Terjadi kesalahan saat memuat riwayat bimbingan.');
        }
    }
}
