@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Data Transaksi</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" class="mb-3">
        <input type="text" name="search" class="form-control" placeholder="Cari No Transaksi..." value="{{ $search }}">
    </form>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">+ Tambah Transaksi</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No Transaksi</th>
                <th>Pasien</th>
                <th>Kunjungan</th>
                <th>Total Bayar</th>
                <th>Tanggal</th>
                <th>Metode</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $item)
            <tr>
                <td>{{ $item->no_transaksi }}</td>
                <td>{{ $item->pasien->name ?? '-' }}</td>
                <td>{{ $item->id_kunjungan }}</td>
                <td>Rp {{ number_format($item->total_bayar, 2, ',', '.') }}</td>
                <td>{{ $item->tanggal }}</td>
                <td>{{ $item->metode_pembayaran }}</td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->no_transaksi }}">Edit</button>
                    <form action="{{ url('transaksi/'.$item->no_transaksi) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="editModal{{ $item->no_transaksi }}" tabindex="-1">
              <div class="modal-dialog">
                <form action="{{ url('transaksi/'.$item->no_transaksi) }}" method="POST" class="modal-content">
                    @csrf @method('PUT')
                    <div class="modal-header"><h5>Edit Transaksi</h5></div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label>Pasien</label>
                            <select name="id_pasien" class="form-control">
                                @foreach($pasienList as $p)
                                    <option value="{{ $p->id }}" {{ $item->id_pasien == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Kunjungan</label>
                            <select name="id_kunjungan" class="form-control">
                                @foreach($kunjunganList as $k)
                                    <option value="{{ $k->id_kunjungan }}" {{ $item->id_kunjungan == $k->id_kunjungan ? 'selected' : '' }}>{{ $k->id_kunjungan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Total Bayar</label>
                            <input type="number" name="total_bayar" class="form-control" value="{{ $item->total_bayar }}">
                        </div>
                        <div class="mb-2">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ $item->tanggal }}">
                        </div>
                        <div class="mb-2">
                            <label>Metode</label>
                            <select name="metode_pembayaran" class="form-control">
                                <option value="Cash" {{ $item->metode_pembayaran == 'Cash' ? 'selected' : '' }}>Cash</option>
                                <option value="Online" {{ $item->metode_pembayaran == 'Online' ? 'selected' : '' }}>Online</option>
                            </select>
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

    {{ $transaksi->links() }}
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="createModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ url('transaksi') }}" method="POST" class="modal-content">
        @csrf
        <div class="modal-header"><h5>Tambah Transaksi</h5></div>
        <div class="modal-body">
            <div class="mb-2">
                <label>No Transaksi</label>
                <input type="text" name="no_transaksi" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Pasien</label>
                <select name="id_pasien" class="form-control" required>
                    @foreach($pasienList as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-2">
                <label>Kunjungan</label>
                <select name="id_kunjungan" class="form-control" required>
                    @foreach($kunjunganList as $k)
                    <option value="{{ $k->id_kunjungan }}">{{ $k->id_kunjungan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-2">
                <label>Total Bayar</label>
                <input type="number" name="total_bayar" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Metode Pembayaran</label>
                <select name="metode_pembayaran" class="form-control" required>
                    <option value="Cash">Cash</option>
                    <option value="Online">Online</option>
                </select>
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
