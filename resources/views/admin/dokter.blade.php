@extends('layouts.app')

@section('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
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
        /* Foto dokter */
        .doctor-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }
        /* Hide default search and pagination when using DataTables */
        .custom-controls {
            display: none;
        }
        .custom-pagination {
            display: none;
        }
    </style>
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-person-badge me-2"></i>Data Dokter Gigi</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="bi bi-plus-circle me-1"></i>Tambah Dokter
        </button>
    </div>

    <!-- Custom Search Form (Hidden when DataTables is active) -->
    <form method="GET" class="row g-2 mb-3 align-items-center custom-controls">
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
            <input type="text" name="search" class="form-control" placeholder="Cari Dokter..." value="{{ request('search') }}">
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="dokterTable" class="table table-striped table-hover table-bordered w-100">
                <thead class="table-primary">
                    <tr>
                        <th width="10%">Foto</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Spesialisasi</th>
                        <th width="15%">Telepon</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dokter as $d)
                    <tr>
                        <td class="text-center">
                            @if($d->foto)
                                <img src="{{ asset('storage/foto_dokter/' . $d->foto) }}" " width="60" height="60" class="rounded-circle object-fit-cover">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $d->user->name }}</td>
                        <td>{{ $d->user->email }}</td>
                        <td>{{ $d->spesialisasi }}</td>
                        <td>{{ $d->telepon }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning btn-action" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal{{ $d->id }}"
                                    title="Edit Dokter">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <form action="{{ route('dokter.destroy', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus dokter ini?')">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger btn-action" title="Hapus Dokter">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data dokter</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Page -->
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="dataTables_info">
                Showing {{ $dokter->firstItem() }} to {{ $dokter->lastItem() }} of {{ $dokter->total() }} entries
            </div>
        </div>
        <div class="col-md-6">
            <div class="dataTables_paginate paging_simple_numbers">
                <ul class="pagination justify-content-end">
                    {{-- Previous Page Link --}}
                    @if ($dokter->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">Previous</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $dokter->previousPageUrl() }}" rel="prev">Previous</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($dokter->getUrlRange(1, $dokter->lastPage()) as $page => $url)
                        @if ($page == $dokter->currentPage())
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
                    @if ($dokter->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $dokter->nextPageUrl() }}" rel="next">Next</a>
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
            <form action="{{ route('dokter.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createModalLabel">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Dokter Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                               id="nama" name="nama" value="{{ old('nama') }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="spesialisasi" class="form-label">Spesialisasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('spesialisasi') is-invalid @enderror" 
                               id="spesialisasi" name="spesialisasi" value="{{ old('spesialisasi') }}" required>
                        @error('spesialisasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                               id="telepon" name="telepon" value="{{ old('telepon') }}" required>
                        @error('telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Dokter</label>
                        <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                               id="foto" name="foto" accept="image/*">
                        <div class="form-text">Format yang diizinkan: JPG, JPEG, PNG (Max: 2MB)</div>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modals -->
@foreach($dokter as $d)
<div class="modal fade" id="editModal{{ $d->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $d->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('dokter.update', $d->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="editModalLabel{{ $d->id }}">
                        <i class="bi bi-pencil-square me-2"></i>Edit Dokter: {{ $d->user->name }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Current Photo Display -->
                    @if($d->foto)
                    <div class="mb-3 text-center">
                        <label class="form-label">Foto Saat Ini:</label><br>
                        <img src="{{ asset('storage/foto_dokter/' . $d->foto) }}" 
                             class="rounded-circle" 
                             style="width: 100px; height: 100px; object-fit: cover;" 
                             alt="Foto {{ $d->user->name }}">
                    </div>
                    @endif
                    
                    <div class="mb-3">
                        <label for="edit_nama{{ $d->id }}" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                               id="edit_nama{{ $d->id }}" name="nama" value="{{ old('nama', $d->user->name) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_email{{ $d->id }}" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="edit_email{{ $d->id }}" name="email" value="{{ old('email', $d->user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_password{{ $d->id }}" class="form-label">Password Baru</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="edit_password{{ $d->id }}" name="password" 
                               placeholder="Kosongkan jika tidak ingin mengubah password">
                        <div class="form-text">Kosongkan jika tidak ingin mengubah password</div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_spesialisasi{{ $d->id }}" class="form-label">Spesialisasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('spesialisasi') is-invalid @enderror" 
                               id="edit_spesialisasi{{ $d->id }}" name="spesialisasi" value="{{ old('spesialisasi', $d->spesialisasi) }}" required>
                        @error('spesialisasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_telepon{{ $d->id }}" class="form-label">Telepon <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                               id="edit_telepon{{ $d->id }}" name="telepon" value="{{ old('telepon', $d->telepon) }}" required>
                        @error('telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_foto{{ $d->id }}" class="form-label">Foto Baru</label>
                        <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                               id="edit_foto{{ $d->id }}" name="foto" accept="image/*">
                        <div class="form-text">Kosongkan jika tidak ingin mengubah foto. Format: JPG, JPEG, PNG (Max: 2MB)</div>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-warning text-dark">
                        <i class="bi bi-save me-1"></i>Simpan Perubahan
                    </button>
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

<script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#dokterTable').DataTable({
            responsive: true,
            processing: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
                search: "_INPUT_",
                searchPlaceholder: "Cari dokter...",
                lengthMenu: "Tampilkan _MENU_ dokter per halaman",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ dokter",
                infoEmpty: "Tidak ada data dokter",
                zeroRecords: "Dokter tidak ditemukan",
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
                { targets: [0, 5], className: 'text-center' },
                { targets: [5], orderable: false }
            ],
            order: [[1, 'asc']], // Default sort by name
            initComplete: function() {
                $('.dataTables_length label').addClass('form-label');
                $('.dataTables_filter label').addClass('form-label');
                
                // Style the search input
                $('.dataTables_filter input').addClass('form-control').css({
                    'display': 'inline-block',
                    'width': 'auto',
                    'margin-left': '10px'
                });
                
                // Style the length select
                $('.dataTables_length select').addClass('form-select').css({
                    'display': 'inline-block',
                    'width': 'auto'
                });
            }
        });

        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            $('.alert-dismissible').alert('close');
        }, 5000);

        // Form validation
        $('form').on('submit', function(e) {
            var form = $(this);
            var isValid = true;
            
            // Check required fields
            form.find('input[required]').each(function() {
                if ($(this).val().trim() === '') {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            
            // Email validation
            var emailFields = form.find('input[type="email"]');
            emailFields.each(function() {
                var email = $(this).val();
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (email && !emailRegex.test(email)) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                return false;
            }
        });

        // Clear validation errors when typing
        $('input').on('input', function() {
            $(this).removeClass('is-invalid');
        });

        // File upload preview
        $('input[type="file"]').on('change', function() {
            var input = this;
            var file = input.files[0];
            
            if (file) {
                // Check file size (2MB limit)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    $(input).val('');
                    return;
                }
                
                // Check file type
                var allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Format file tidak didukung. Gunakan JPG, JPEG, atau PNG.');
                    $(input).val('');
                    return;
                }
            }
        });
    });
</script>
@endsection