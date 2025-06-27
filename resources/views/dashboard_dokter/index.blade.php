<!-- layouts/app.blade.php -->
<head>
    <!-- Tambahan ini WAJIB agar ikon Bootstrap muncul -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
@extends('layouts.app')


@section('content')


            <!-- DASHBOARD CONTENT -->
            <div class="container-fluid">
                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow card-stats h-100 py-2" style="border-left: 4px solid #4e73df;">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Pasien</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users stat-icon text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow card-stats h-100 py-2" style="border-left: 4px solid #1cc88a;">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Pasien Hari Ini</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-plus stat-icon text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow card-stats h-100 py-2" style="border-left: 4px solid #36b9cc;">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Jadwal Hari Ini</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar stat-icon text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow card-stats h-100 py-2" style="border-left: 4px solid #f6c23e;">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Total Rekam Medis</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file-medical stat-icon text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Row -->
                <div class="row">
                    <!-- Jadwal Hari Ini -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow">
                            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">Jadwal Hari Ini</h6>
                                <a href="#" class="btn btn-sm btn-primary">Lihat Semua</a>
                            </div>
                            <div class="card-body">
                                        <div class="d-flex align-items-center mb-3 p-2 border-left-primary" style="border-left: 3px solid #4e73df;">
                                            <div class="me-3">
                                                <div class="icon-circle bg-primary">
                                                    <i class="fas fa-clock text-white"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="small text-gray-500"></div>
                                                <div class="font-weight-bold"></div>
                                                <div class="text-gray-600 small"></div>
                                            </div>
                                        </div>
                                    <div class="text-center text-gray-500">
                                        <i class="fas fa-user-times fa-2x mb-2"></i>
                                        <p>Belum ada rekam medis</p>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <a href="#" class="btn btn-outline-primary btn-block w-100 p-3">
                                            <i class="fas fa-user-clock fa-2x mb-2"></i>
                                            <br>Lihat Pasien Hari Ini
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="#" class="btn btn-outline-info btn-block w-100 p-3">
                                            <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                                            <br>Kelola Jadwal
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="#" class="btn btn-outline-success btn-block w-100 p-3">
                                            <i class="fas fa-file-medical-alt fa-2x mb-2"></i>
                                            <br>Rekam Medis
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="#" class="btn btn-outline-warning btn-block w-100 p-3">
                                            <i class="fas fa-history fa-2x mb-2"></i>
                                            <br>Riwayat Pasien
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('styles')
<style>
    .card-stats {
        transition: transform 0.2s;
    }
    .card-stats:hover {
        transform: translateY(-5px);
    }
    .stat-icon {
        font-size: 2rem;
        opacity: 0.8;
    }
</style>
@endsection
@section('scripts')
<script>
    setTimeout(function(){
        location.reload();
    }, 600000); // 600000ms = 10 menit
</script>
@endsection

@endsection