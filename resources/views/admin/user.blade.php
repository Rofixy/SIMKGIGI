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
        /* Hide custom controls and pagination when DataTables is active */
        .custom-controls {
            display: none;
        }
        .custom-pagination {
            display: none;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><i class="bi bi-people"></i> Data User</h4>
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
            <input type="text" name="search" class="form-control" placeholder="Cari User..." value="{{ request('search') }}">
        </div>
    </form>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="userTable" class="table table-bordered table-striped align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $allUsers = $users instanceof \Illuminate\Pagination\LengthAwarePaginator 
                            ? $users->getCollection() 
                            : $users;
                    @endphp
                    @forelse($allUsers as $u)
                        <tr>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ ucfirst($u->role) }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning btn-action" data-bs-toggle="modal" data-bs-target="#modalEditUser{{ $u->id }}" title="Edit User">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form method="POST" action="{{ route('user.destroy', $u->id) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger btn-action" title="Hapus User">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Tidak ada data user</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Modals for Edit User -->
            @if(isset($allUsers))
                @foreach($allUsers as $u)
                    <div class="modal fade" id="modalEditUser{{ $u->id }}" tabindex="-1" aria-labelledby="editUserLabel{{ $u->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('user.update', $u->id) }}" class="edit-user-form">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editUserLabel{{ $u->id }}">Edit User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="name{{ $u->id }}" class="form-label">Nama</label>
                                            <input type="text" name="name" id="name{{ $u->id }}" class="form-control" value="{{ $u->name }}" required>
                                            <div class="invalid-feedback">Nama harus diisi</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email{{ $u->id }}" class="form-label">Email</label>
                                            <input type="email" name="email" id="email{{ $u->id }}" class="form-control" value="{{ $u->email }}" required>
                                            <div class="invalid-feedback">Email harus valid</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password{{ $u->id }}" class="form-label">Password</label>
                                            <small class="text-muted">(Kosongkan jika tidak ingin mengganti)</small>
                                            <input type="password" name="password" id="password{{ $u->id }}" class="form-control">
                                            <div class="invalid-feedback">Password minimal 6 karakter</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="role{{ $u->id }}" class="form-label">Role</label>
                                            <select name="role" id="role{{ $u->id }}" class="form-select" required>
                                                <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="dokter" {{ $u->role === 'dokter' ? 'selected' : '' }}>Dokter</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Custom Pagination (Hidden when DataTables is active) -->
    <div class="row mt-3 custom-pagination">
        <div class="col-md-6">
            <div class="dataTables_info">
                @if($users->count() > 0)
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
                @else
                    Showing 0 to 0 of 0 entries
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="dataTables_paginate paging_simple_numbers">
                {{ $users->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
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
        // Check if we're using Laravel pagination or DataTables
        var useDataTables = !window.location.search.includes('limit=') && !window.location.search.includes('search=');
        
        if (useDataTables) {
            // Initialize DataTables
            var table = $('#userTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: false,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
                    search: "_INPUT_",
                    searchPlaceholder: "Cari user...",
                    lengthMenu: "Tampilkan _MENU_ user per halaman",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ user",
                    infoEmpty: "Tidak ada data user",
                    infoFiltered: "(difilter dari _MAX_ total user)",
                    zeroRecords: "User tidak ditemukan",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                },
                dom: '<"top"<"row"<"col-md-6"l><"col-md-6"f>>>rt<"bottom"<"row"<"col-md-6"i><"col-md-6"p>>>',
                lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "Semua"]],
                pageLength: 5, // Set default to 5 as shown in your image
                columnDefs: [
                    { 
                        targets: [3], 
                        className: 'text-center',
                        orderable: false 
                    }
                ],
                order: [[0, 'asc']],
                initComplete: function() {
                    // Style DataTables controls
                    $('.dataTables_length label').addClass('form-label').css('font-weight', 'normal');
                    $('.dataTables_filter label').addClass('form-label').css('font-weight', 'normal');
                    
                    // Style the search input
                    $('.dataTables_filter input').addClass('form-control').css({
                        'display': 'inline-block',
                        'width': '200px',
                        'margin-left': '10px'
                    });
                    
                    // Style the length select
                    $('.dataTables_length select').addClass('form-select').css({
                        'display': 'inline-block',
                        'width': '80px'
                    });

                    // Hide custom controls and pagination when DataTables is active
                    $('.custom-controls').hide();
                    $('.custom-pagination').hide();
                }
            });
        } else {
            // Show custom controls when not using DataTables
            $('.custom-controls').show();
            $('.custom-pagination').show();
        }

        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);

        // Form validation for edit user forms
        $('.edit-user-form').on('submit', function(e) {
            var form = $(this);
            var isValid = true;
            
            // Reset previous validation states
            form.find('.is-invalid').removeClass('is-invalid');
            
            // Check required fields
            form.find('input[required], select[required]').each(function() {
                if ($(this).val().trim() === '') {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            
            // Email validation
            var emailField = form.find('input[type="email"]');
            var email = emailField.val().trim();
            if (email) {
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    emailField.addClass('is-invalid');
                    isValid = false;
                }
            }
            
            // Password validation (if provided)
            var passwordField = form.find('input[name="password"]');
            var password = passwordField.val();
            if (password && password.length < 6) {
                passwordField.addClass('is-invalid');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
                // Focus on first invalid field
                form.find('.is-invalid').first().focus();
                return false;
            }
        });

        // Clear validation errors when typing
        $('input, select').on('input change', function() {
            $(this).removeClass('is-invalid');
        });

        // Handle delete confirmation with better UX
        $('form[method="POST"]').on('submit', function(e) {
            if ($(this).find('input[name="_method"][value="DELETE"]').length > 0) {
                var userName = $(this).closest('tr').find('td:first').text();
                if (!confirm('Yakin ingin menghapus user "' + userName + '"?\n\nTindakan ini tidak dapat dibatalkan.')) {
                    e.preventDefault();
                    return false;
                }
            }
        });

        // Refresh DataTable after modal is hidden (in case of updates)
        $('.modal').on('hidden.bs.modal', function() {
            // Optional: You can add AJAX refresh here if needed
        });
    });
</script>
@endsection