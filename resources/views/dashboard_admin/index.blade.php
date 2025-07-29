@extends('layouts.app') {{-- Sesuaikan layout jika pakai admin template khusus --}}

@section('title', 'Dashboard Admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Dashboard Admin</h1>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Pengguna</h5>
                    <p class="display-6">{{ $userCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Dokter</h5>
                    <p class="display-6">{{ $dokterCount }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
