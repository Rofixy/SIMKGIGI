@extends('layouts.app')

@section('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Styling untuk DataTables */
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
        /* Tombol aksi */
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
        <h2><i class="fas fa-pills me-2"></i>Data Obat</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="fas fa-plus me-1"></i>Tambah Obat
        </button>
    </div>

    {{-- Searching --}}
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
            <input type="text" name="search" class="form-control" placeholder="Cari Obat..." value="{{ $search }}">
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
            <table id="obatTable" class="table table-striped table-hover table-bordered w-100">
                <thead class="table-primary">
                    <tr>
                        <th width="15%">Kode Obat</th>
                        <th>Nama Obat</th>
                        <th width="10%">Stok</th>
                        <th width="15%">Harga</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($obat as $item)
                    <tr>
                        <td>{{ $item->kd_obat }}</td>
                        <td>{{ $item->nm_obat }}</td>
                        <td class="text-center">{{ $item->jml_obat }}</td>
                        <td class="text-end">Rp {{ number_format($item->hrg_obat, 2, ',', '.') }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning btn-action" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->kd_obat }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('obat.destroy', $item->kd_obat) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus obat ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger btn-action">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Halaman --}}
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="dataTables_info">
                Showing {{ $obat->firstItem() }} to {{ $obat->lastItem() }} of {{ $obat->total() }} entries
            </div>
        </div>
        <div class="col-md-6">
            <div class="dataTables_paginate paging_simple_numbers">
                <ul class="pagination justify-content-end">
                    {{-- Previous Page Link --}}
                    @if ($obat->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">Previous</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $obat->previousPageUrl() }}" rel="prev">Previous</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($obat->getUrlRange(1, $obat->lastPage()) as $page => $url)
                        @if ($page == $obat->currentPage())
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
                    @if ($obat->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $obat->nextPageUrl() }}" rel="next">Next</a>
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

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('obat.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createModalLabel"><i class="fas fa-plus me-2"></i>Tambah Obat Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kd_obat" class="form-label">Kode Obat</label>
                        <input type="text" class="form-control" id="kd_obat" name="kd_obat" required>
                    </div>
                    <div class="mb-3">
                        <label for="nm_obat" class="form-label">Nama Obat</label>
                        <input type="text" class="form-control" id="nm_obat" name="nm_obat" required>
                    </div>
                    <div class="mb-3">
                        <label for="jml_obat" class="form-label">Jumlah Stok</label>
                        <input type="number" class="form-control" id="jml_obat" name="jml_obat" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="hrg_obat" class="form-label">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="hrg_obat" name="hrg_obat" min="0" step="100" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modals -->
@foreach($obat as $item)
<div class="modal fade" id="editModal{{ $item->kd_obat }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->kd_obat }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('obat.update', $item->kd_obat) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="editModalLabel{{ $item->kd_obat }}"><i class="fas fa-edit me-2"></i>Edit Obat</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Obat</label>
                        <input type="text" class="form-control" value="{{ $item->kd_obat }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nm_obat{{ $item->kd_obat }}" class="form-label">Nama Obat</label>
                        <input type="text" class="form-control" id="nm_obat{{ $item->kd_obat }}" name="nm_obat" value="{{ $item->nm_obat }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="jml_obat{{ $item->kd_obat }}" class="form-label">Jumlah Stok</label>
                        <input type="number" class="form-control" id="jml_obat{{ $item->kd_obat }}" name="jml_obat" value="{{ $item->jml_obat }}" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="hrg_obat{{ $item->kd_obat }}" class="form-label">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" id="hrg_obat{{ $item->kd_obat }}" name="hrg_obat" value="{{ $item->hrg_obat }}" min="0" step="100" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Batal</button>
                    <button type="submit" class="btn btn-warning text-white"><i class="fas fa-save me-1"></i>Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection

@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

<script>
    $(document).ready(function() {
        $('#obatTable').DataTable({
            responsive: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
                search: "_INPUT_",
                searchPlaceholder: "Cari obat...",
                lengthMenu: "Tampilkan _MENU_ obat per halaman",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ obat",
                infoEmpty: "Tidak ada data obat",
                zeroRecords: "Obat tidak ditemukan",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            },
            dom: '<"top"<"row"<"col-md-6"l><"col-md-6"f>>>rt<"bottom"<"row"<"col-md-6"i><"col-md-6"p>>>',
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
            pageLength: 10,
            columnDefs: [
                { targets: [2], className: 'text-center' },
                { targets: [3], className: 'text-end' },
                { targets: [4], className: 'text-center', orderable: false }
            ],
            initComplete: function() {
                $('.dataTables_length label').addClass('form-label');
                $('.dataTables_filter label').addClass('form-label');
            }
        });
    });
</script>
@endsection