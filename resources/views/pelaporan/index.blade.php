@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Data Pelaporan</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" class="mb-3">
        <input type="text" name="search" class="form-control" placeholder="Cari ID atau tipe laporan..." value="{{ $search }}">
    </form>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">+ Tambah Laporan</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Admin</th>
                <th>Tipe</th>
                <th>Referensi</th>
                <th>Tanggal</th>
                <th>Catatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $item)
            <tr>
                <td>{{ $item->id_laporan }}</td>
                <td>{{ $item->admin->name ?? '-' }}</td>
                <td>{{ $item->tipe_laporan }}</td>
                <td>{{ $item->id_referensi }}</td>
                <td>{{ $item->tanggal_laporan }}</td>
                <td>{{ $item->catatan }}</td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id_laporan }}">Edit</button>
                    <form action="{{ url('pelaporan/'.$item->id_laporan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="editModal{{ $item->id_laporan }}" tabindex="-1">
              <div class="modal-dialog">
                <form action="{{ url('pelaporan/'.$item->id_laporan) }}" method="POST" class="modal-content">
                    @csrf @method('PUT')
                    <div class="modal-header"><h5>Edit Laporan</h5></div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label>Admin</label>
                            <select name="id_admin" class="form-control">
                                @foreach($adminList as $a)
                                    <option value="{{ $a->id }}" {{ $item->id_admin == $a->id ? 'selected' : '' }}>{{ $a->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Tipe Laporan</label>
                            <select name="tipe_laporan" class="form-control">
                                <option {{ $item->tipe_laporan == 'Transaksi' ? 'selected' : '' }}>Transaksi</option>
                                <option {{ $item->tipe_laporan == 'Kunjungan' ? 'selected' : '' }}>Kunjungan</option>
                                <option {{ $item->tipe_laporan == 'dll' ? 'selected' : '' }}>dll</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>ID Referensi</label>
                            <input type="text" name="id_referensi" class="form-control" value="{{ $item->id_referensi }}">
                        </div>
                        <div class="mb-2">
                            <label>Tanggal Laporan</label>
                            <input type="date" name="tanggal_laporan" class="form-control" value="{{ $item->tanggal_laporan }}">
                        </div>
                        <div class="mb-2">
                            <label>Catatan</label>
                            <textarea name="catatan" class="form-control">{{ $item->catatan }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>
              </div>
            </div>
            @endforeach
        </tbody>
    </table>

    {{ $laporan->links() }}
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="createModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ url('pelaporan') }}" method="POST" class="modal-content">
        @csrf
        <div class="modal-header"><h5>Tambah Laporan</h5></div>
        <div class="modal-body">
            <div class="mb-2">
                <label>ID Laporan</label>
                <input type="text" name="id_laporan" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Admin</label>
                <select name="id_admin" class="form-control" required>
                    @foreach($adminList as $a)
                        <option value="{{ $a->id }}">{{ $a->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-2">
                <label>Tipe Laporan</label>
                <select name="tipe_laporan" class="form-control" required>
                    <option>Transaksi</option>
                    <option>Kunjungan</option>
                    <option>dll</option>
                </select>
            </div>
            <div class="mb-2">
                <label>ID Referensi</label>
                <input type="text" name="id_referensi" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Tanggal Laporan</label>
                <input type="date" name="tanggal_laporan" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Catatan</label>
                <textarea name="catatan" class="form-control"></textarea>
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
