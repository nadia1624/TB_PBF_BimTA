@extends('layouts.dosen')

@section('title', 'Dashboard Dosen')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>

    <!-- Stats Cards -->
    <div class="row my-4">
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="icon-square rounded bg-light text-dark p-3 me-3">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-xs text-uppercase mb-1">Total Mahasiswa Bimbingan</div>
                            <div class="h1 mb-0 font-weight-bold">{{ $totalMahasiswa ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="icon-square rounded bg-light text-dark p-3 me-3">
                                <i class="fas fa-file-alt fa-2x"></i>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-xs text-uppercase mb-1">Pengajuan Judul</div>
                            <div class="h1 mb-0 font-weight-bold">{{ $totalPengajuanJudul ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="icon-square rounded bg-light text-dark p-3 me-3">
                                <i class="fas fa-calendar-alt fa-2x"></i>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-xs text-uppercase mb-1">Jadwal Bimbingan</div>
                            <div class="h1 mb-0 font-weight-bold">{{ $totalJadwalBimbingan ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Rows -->
    <div class="row">
        <!-- Pengajuan Judul Terbaru -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold">Pengajuan Judul Terbaru</h6>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if(isset($latestSubmissions) && $latestSubmissions->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($latestSubmissions as $submission)
                            <div class="list-group-item px-3 py-3 d-flex align-items-center">
                                <div class="icon-square bg-light text-dark p-2 me-3">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="ms-2 flex-grow-1">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $submission->mahasiswa->nama }} - {{ $submission->mahasiswa->nim }}</h6>
                                        <small>{{ \Carbon\Carbon::parse($submission->created_at)->format('d F Y') }} · {{ \Carbon\Carbon::parse($submission->created_at)->format('H:i') }}</small>
                                    </div>
                                    <p class="mb-1 text-muted small">{{ $submission->judul }}</p>
                                </div>
                                <div class="ms-auto">
                                    <a href="#" class="text-decoration-none">
                                        <small class="text-primary">Review <i class="fas fa-chevron-right ms-1"></i></small>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="card-footer bg-white border-top-0 text-end">
                            <a href="{{ route('dosen.jadwal-bimbingan') }}" class="text-decoration-none">
                                Lihat Semua Jadwal <i class="fas fa-chevron-right ms-1"></i>
                            </a>
                        </div>
                    @else
                        <div class="text-center p-4">
                            <p class="mb-0">Tidak ada pengajuan judul terbaru</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Jadwal Bimbingan Hari Ini -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold">Jadwal Bimbingan Hari Ini</h6>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($todaySchedules) && $todaySchedules->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($todaySchedules as $schedule)
                            <div class="list-group-item px-3 py-3 border-0">
                                <div class="d-flex align-items-center">
                                    <div class="icon-square bg-light text-dark p-2 me-3">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $schedule->pengajuanJudul->mahasiswa->nama }}</h6>
                                        <p class="mb-1 text-muted small">{{ $schedule->pengajuanJudul->judul }}</p>
                                        <div>
                                            <span class="badge bg-primary">{{ \Carbon\Carbon::parse($schedule->waktu_pengajuan)->format('H:i') }}</span>
                                            <span class="badge {{ $schedule->metode == 'online' ? 'bg-info' : 'bg-success' }}">{{ $schedule->metode == 'online' ? 'Online' : 'Offline' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="icon-square d-inline-block bg-light text-secondary p-3 mb-3 rounded-circle">
                                <i class="fas fa-calendar-check fa-3x"></i>
                            </div>
                            <h5 class="text-muted">Tidak ada jadwal bimbingan hari ini</h5>
                        </div>
                    @endif
                </div>
                @if(isset($todaySchedules) && $todaySchedules->count() > 0)
                <div class="card-footer bg-white border-top-0 text-end">
                    <a href="{{ route('dosen.jadwal-bimbingan') }}" class="text-decoration-none">
                        Lihat Semua Jadwal <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Any JavaScript functionality can go here
    });
</script>
@endsection
