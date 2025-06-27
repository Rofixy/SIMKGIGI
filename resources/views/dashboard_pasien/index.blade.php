@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <!-- Total Janji -->
    <div class="col-md-4 mb-4">
        <div class="card border-left-primary shadow card-stats h-100 py-2">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Janji</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAppointments ?? 0 }}</div>
                </div>
                <i class="bi bi-calendar-check stat-icon text-primary"></i>
            </div>
        </div>
    </div>

    <!-- Janji Mendatang -->
    <div class="col-md-4 mb-4">
        <div class="card border-left-success shadow card-stats h-100 py-2">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Janji Mendatang</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $upcomingAppointments ?? 0 }}</div>
                </div>
                <i class="bi bi-clock stat-icon text-success"></i>
            </div>
        </div>
    </div>

    <!-- Janji Selesai -->
    <div class="col-md-4 mb-4">
        <div class="card border-left-info shadow card-stats h-100 py-2">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Janji Selesai</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $completedAppointments ?? 0 }}</div>
                </div>
                <i class="bi bi-check-circle stat-icon text-info"></i>
            </div>
        </div>
    </div>
</div>

<!-- Card Buat Janji Sendiri di Bawah -->
<div class="row mb-4">
    <div class="col-md-6 offset-md-3">
        <div class="card shadow h-100 py-3 appointment-card text-center">
            <div class="card-header bg-light text-success font-weight-bold">
                Buat Janji Temu Berikutnya
            </div>
            <div class="card-body">
                <a href="#" class="btn btn-success">
                    <i class="bi bi-calendar-plus"></i> Buat Janji
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

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
    .appointment-card {
        border-left: 4px solid var(--primary-color);
        transition: all 0.3s ease;
    }
    .appointment-card:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .border-left-primary {
        border-left: 0.25rem solid var(--primary-color) !important;
    }
    .border-left-success {
        border-left: 0.25rem solid var(--success-color) !important;
    }
    .border-left-info {
        border-left: 0.25rem solid var(--info-color) !important;
    }
    .border-left-warning {
        border-left: 0.25rem solid var(--warning-color) !important;
    }
</style>
@endsection

@section('scripts')
<script>
    // Auto refresh setiap 10 menit
    setTimeout(function(){
        location.reload();
    }, 600000);
</script>
@endsection
