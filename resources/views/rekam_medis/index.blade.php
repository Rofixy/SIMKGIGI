@extends('layouts.app')

@section('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .dataTables_wrapper {
        padding: 20px 0;
    }
    .dataTables_length select {
        width: 70px;
        display: inline-block;
        margin: 0 10px;
    }
    .dataTables_filter input {
        margin-left: 10px;
        border: 1px solid #ddd;
        padding: 5px 10px;
        border-radius: 4px;
    }
    .dataTables_info {
        padding-top: 15px;
    }
    .dataTables_paginate {
        margin-top: 15px;
    }
    .btn-action {
        padding: 5px 10px;
        margin: 0 3px;
        font-size: 12px;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-notes-medical me-2"></i>Data Rekam Medis</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="fas fa-plus me-1"></i>Tambah Rekam Medis
        </button>
    </div>

    <form method="GET" class="row g-2 mb-3 align-items-center">
        <div class="col-auto">
            <label for="limit" class="col-form-label">Show</label>
        </div>
        <div class="col-auto">
            <select name="limit" id="limit" class="form-select" onchange="this.form.submit()">
                @foreach([5, 10, 25, 50, 100] as $val)
                    <option value="{{ $val }}" {{ request('limit', 10) == $val ? 'selected' : '' }}>{{ $val }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            entries
        </div>
        <div class="col ms-auto">
            <input type="text" name="search" class="form-control" placeholder="Cari Rekam Medis..." value="{{ $search }}">
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="rekamTable" class="table table-striped table-hover table-bordered w-100">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Kunjungan</th>
                        <th>Diagnosa</th>
                        <th>Resep Obat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekam as $r)
                    <tr>
                        <td>{{ $r->id_rekammedis }}</td>
                        <td>{{ $r->id_kunjungan }}</td>
                        <td>{{ $r->diagnosa }}</td>
                        <td>{{ $r->resep_obat }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning btn-action" data-bs-toggle="modal" data-bs-target="#editModal{{ $r->id_rekammedis }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ url('rekam-medis/'.$r->id_rekammedis) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger btn-action">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editModal{{ $r->id_rekammedis }}" tabindex="-1">
                      <div class="modal-dialog">
                        <form method="POST" action="{{ url('rekam-medis/'.$r->id_rekammedis) }}" class="modal-content">
                            @csrf @method('PUT')
                            <div class="modal-header bg-warning text-white">
                                <h5>Edit Rekam Medis</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label>ID Kunjungan</label>
                                    <select name="id_kunjungan" class="form-control">
                                        @foreach($kunjungan as $k)
                                        <option value="{{ $k->id_kunjungan }}" {{ $r->id_kunjungan == $k->id_kunjungan ? 'selected' : '' }}>{{ $k->id_kunjungan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label>Diagnosa</label>
                                    <textarea name="diagnosa" class="form-control">{{ $r->diagnosa }}</textarea>
                                </div>
                                <div class="mb-2">
                                    <label>Resep Obat</label>
                                    <textarea name="resep_obat" class="form-control">{{ $r->resep_obat }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button class="btn btn-warning text-white">Simpan</button>
                            </div>
                        </form>
                      </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <div class="dataTables_info">
                Showing {{ $rekam->firstItem() }} to {{ $rekam->lastItem() }} of {{ $rekam->total() }} entries
            </div>
        </div>
        <div class="col-md-6">
            <div class="dataTables_paginate paging_simple_numbers">
                <ul class="pagination justify-content-end">
                    {{-- Previous Page Link --}}
                    @if ($rekam->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">Previous</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $rekam->previousPageUrl() }}" rel="prev">Previous</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($rekam->getUrlRange(1, $rekam->lastPage()) as $page => $url)
                        @if ($page == $rekam->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($rekam->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $rekam->nextPageUrl() }}" rel="next">Next</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">Next</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

</div>

<!-- Modal Tambah -->
<div class="modal fade" id="createModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ url('rekam-medis') }}" method="POST" class="modal-content">
        @csrf
        <div class="modal-header bg-primary text-white">
            <h5>Tambah Rekam Medis</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-2">
                <label>ID Rekam Medis</label>
                <input type="text" name="id_rekammedis" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>ID Kunjungan</label>
                <select name="id_kunjungan" class="form-control" required>
                    @foreach($kunjungan as $k)
                    <option value="{{ $k->id_kunjungan }}">{{ $k->id_kunjungan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-2">
                <label>Diagnosa</label>
                <textarea name="diagnosa" class="form-control" required></textarea>
            </div>
            <div class="mb-2">
                <label>Resep Obat</label>
                <textarea name="resep_obat" class="form-control" required></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-primary">Simpan</button>
        </div>
    </form>
  </div>
</div>
@endsection

<!-- Edit Modals -->
@foreach($rekam as $item)
<div class="modal fade" id="editModal{{ $item->id_rekammedis }}" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="{{ url('rekam-medis/'.$item->id_rekammedis) }}" class="modal-content">
        @csrf
        @method('PUT')
        <div class="modal-header bg-warning text-white">
            <h5>Edit Rekam Medis</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-2">
                <label>ID Rekam Medis</label>
                <input type="text" class="form-control" value="{{ $item->id_rekammedis }}" readonly>
            </div>
            <div class="mb-2">
                <label>ID Kunjungan</label>
                <select name="id_kunjungan" class="form-control" required>
                    @foreach($kunjungan as $k)
                        <option value="{{ $k->id_kunjungan }}" {{ $item->id_kunjungan == $k->id_kunjungan ? 'selected' : '' }}>
                            {{ $k->id_kunjungan }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-2">
                <label>Diagnosa</label>
                <textarea name="diagnosa" class="form-control" required>{{ $item->diagnosa }}</textarea>
            </div>
            <div class="mb-2">
                <label>Resep Obat</label>
                <textarea name="resep_obat" class="form-control" required>{{ $item->resep_obat }}</textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-warning text-white">Simpan Perubahan</button>
        </div>
    </form>
  </div>
</div>
@endforeach


@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#rekamTable').DataTable({
        responsive: true,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
            search: "_INPUT_",
            searchPlaceholder: "Cari rekam medis...",
            lengthMenu: "Tampilkan _MENU_ rekam per halaman",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data",
            zeroRecords: "Data tidak ditemukan",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }
        },
        dom: '<"top"<"row"<"col-md-6"l><"col-md-6"f>>>rt<"bottom"<"row"<"col-md-6"i><"col-md-6"p>>>',
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]],
        pageLength: 10,
        columnDefs: [
            { targets: [4], className: 'text-center', orderable: false }
        ]
    });
});
</script>
@endsection
