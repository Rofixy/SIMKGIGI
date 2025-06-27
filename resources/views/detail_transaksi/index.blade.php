@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Data Detail Transaksi</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Search -->
    <form method="GET" class="mb-3">
        <input type="text" name="search" class="form-control" placeholder="Cari ID atau transaksi..." value="{{ $search }}">
    </form>

    <!-- Tambah -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">+ Tambah Detail</button>

    <!-- Tabel -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>No Transaksi</th>
                <th>Obat</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detail as $item)
            <tr>
                <td>{{ $item->id_detail }}</td>
                <td>{{ $item->no_transaksi }}</td>
                <td>{{ $item->obat->nm_obat ?? '-' }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>Rp {{ number_format($item->subtotal, 2) }}</td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id_detail }}">Edit</button>
                    <form action="{{ url('detail-transaksi/'.$item->id_detail) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="editModal{{ $item->id_detail }}" tabindex="-1">
              <div class="modal-dialog">
                <form action="{{ url('detail-transaksi/'.$item->id_detail) }}" method="POST" class="modal-content">
                    @csrf @method('PUT')
                    <div class="modal-header"><h5>Edit Detail Transaksi</h5></div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label>No Transaksi</label>
                            <select name="no_transaksi" class="form-control">
                                @foreach($transaksi as $t)
                                    <option value="{{ $t->no_transaksi }}" {{ $item->no_transaksi == $t->no_transaksi ? 'selected' : '' }}>{{ $t->no_transaksi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Obat</label>
                            <select name="kode_obat" class="form-control">
                                @foreach($obat as $o)
                                    <option value="{{ $o->kd_obat }}" {{ $item->kode_obat == $o->kd_obat ? 'selected' : '' }}>{{ $o->nm_obat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" value="{{ $item->jumlah }}">
                        </div>
                        <div class="mb-2">
                            <label>Subtotal</label>
                            <input type="number" step="0.01" name="subtotal" class="form-control" value="{{ $item->subtotal }}">
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

    {{ $detail->links() }}
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ url('detail-transaksi') }}" method="POST" class="modal-content">
        @csrf
        <div class="modal-header"><h5>Tambah Detail Transaksi</h5></div>
        <div class="modal-body">
            <div class="mb-2">
                <label>ID Detail</label>
                <input type="text" name="id_detail" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>No Transaksi</label>
                <select name="no_transaksi" class="form-control" required>
                    @foreach($transaksi as $t)
                        <option value="{{ $t->no_transaksi }}">{{ $t->no_transaksi }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-2">
                <label>Obat</label>
                <select name="kode_obat" class="form-control" required>
                    @foreach($obat as $o)
                        <option value="{{ $o->kd_obat }}">{{ $o->nm_obat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-2">
                <label>Jumlah</label>
                <input type="number" name="jumlah" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Subtotal</label>
                <input type="number" step="0.01" name="subtotal" class="form-control" required>
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
