@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4"><i class="fas fa-file-medical me-2"></i>Rekam Medis Pasien</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Filter dan Pencarian -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('dokter.rekam_medis') }}">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="search" class="form-label">Cari Pasien</label>
                        <input type="text" name="search" class="form-control" 
                               placeholder="Nama pasien atau nomor rekam medis..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tanggal" class="form-label">Filter Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" 
                               value="{{ request('tanggal') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i>Cari
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Rekam Medis -->
    <div class="row">
        @forelse($rekamMedis as $rm)
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-0">
                                <i class="fas fa-user me-2"></i>
                                <strong>{{ $rm->pasien->user->name }}</strong>
                                <small class="text-muted ms-2">
                                    ({{ $rm->pasien->no_rm ?? 'No. RM: ' . $rm->pasien->id }})
                                </small>
                            </h6>
                        </div>
                        <div class="col-md-4 text-end">
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($rm->tanggal_periksa)->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Keluhan:</h6>
                            <p class="mb-3">{{ $rm->keluhan }}</p>
                            
                            <h6 class="text-primary">Diagnosa:</h6>
                            <p class="mb-3">{{ $rm->diagnosa ?? 'Belum ada diagnosa' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">Pemeriksaan:</h6>
                            <p class="mb-3">{{ $rm->pemeriksaan ?? 'Belum dilakukan pemeriksaan' }}</p>
                            
                            <h6 class="text-primary">Resep Obat:</h6>
                            <p class="mb-3">{{ $rm->resep_obat ?? 'Tidak ada resep' }}</p>
                        </div>
                    </div>

                    @if($rm->catatan)
                    <div class="mt-3">
                        <h6 class="text-primary">Catatan Tambahan:</h6>
                        <p class="mb-0">{{ $rm->catatan }}</p>
                    </div>
                    @endif

                    <div class="mt-3 border-top pt-3">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <small class="text-muted">
                                    <i class="fas fa-user-md me-1"></i>
                                    Diperiksa oleh: {{ $rm->dokter->user->name }}
                                </small>
                            </div>
                            <div class="col-md-4 text-end">
                                <button class="btn btn-sm btn-outline-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editRekamModal{{ $rm->id }}">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </button>
                                <button class="btn btn-sm btn-outline-info ms-1" 
                                        onclick="printRekamMedis({{ $rm->id }})">
                                    <i class="fas fa-print me-1"></i>Print
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit Rekam Medis -->
        <div class="modal fade" id="editRekamModal{{ $rm->id }}" tabindex="-1" aria-labelledby="editRekamModalLabel{{ $rm->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="{{ route('dokter.rekam_medis.update', $rm->id) }}" method="POST" class="modal-content">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editRekamModalLabel{{ $rm->id }}">
                            Edit Rekam Medis - {{ $rm->pasien->user->name }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="keluhan{{ $rm->id }}" class="form-label">Keluhan</label>
                                <textarea name="keluhan" id="keluhan{{ $rm->id }}" class="form-control" rows="3" required>{{ $rm->keluhan }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pemeriksaan{{ $rm->id }}" class="form-label">Pemeriksaan</label>
                                <textarea name="pemeriksaan" id="pemeriksaan{{ $rm->id }}" class="form-control" rows="3">{{ $rm->pemeriksaan }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="diagnosa{{ $rm->id }}" class="form-label">Diagnosa</label>
                                <textarea name="diagnosa" id="diagnosa{{ $rm->id }}" class="form-control" rows="3">{{ $rm->diagnosa }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="resep_obat{{ $rm->id }}" class="form-label">Resep Obat</label>
                                <textarea name="resep_obat" id="resep_obat{{ $rm->id }}" class="form-control" rows="3">{{ $rm->resep_obat }}</textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="catatan{{ $rm->id }}" class="form-label">Catatan Tambahan</label>
                                <textarea name="catatan" id="catatan{{ $rm->id }}" class="form-control" rows="2">{{ $rm->catatan }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($rekamMedis->hasPages())
    <div class="d-flex justify-content-center">
        {{ $rekamMedis->links() }}
    </div>
    @endif

    <!-- Jika tidak ada data -->
    @empty($rekamMedis->count())
    <div class="text-center py-5">
        <i class="fas fa-file-medical fa-3x text-muted mb-3"></i>
        <h5 class="text-muted">Belum ada rekam medis</h5>
        <p class="text-muted">Rekam medis pasien akan muncul di sini setelah pemeriksaan dilakukan.</p>
    </div>
    @endempty
</div>

<!-- CSS Tambahan -->
<style>
.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.text-primary {
    color: #0d6efd !important;
}

.border-top {
    border-top: 1px solid #dee2e6 !important;
}

@media print {
    .btn, .modal, .pagination {
        display: none !important;
    }
    
    .card {
        border: 1px solid #000 !important;
        break-inside: avoid;
    }
}
</style>

<!-- JavaScript untuk Print -->
<script>
function printRekamMedis(id) {
    // Implementasi print rekam medis
    window.print();
}

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.remove();
            }, 500);
        });
    }, 5000);
});
</script>
@endsection