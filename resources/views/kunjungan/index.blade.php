@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Data Kunjungan</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" class="mb-3">
        <input type="text" name="search" class="form-control" placeholder="Cari kode atau nama pasien..." value="{{ $search }}">
    </form>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">+ Tambah Kunjungan</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Kunjungan</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Keluhan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kunjungan as $item)
            <tr>
                <td>{{ $item->id_kunjungan }}</td>
                <td>{{ $item->pasien->name ?? '-' }}</td>
                <td>{{ $item->dokter->name ?? '-' }}</td>
                <td>{{ $item->tgl_kunjungan }}</td>
                <td>{{ $item->jam_kunjungan }}</td>
                <td>{{ $item->keluhan }}</td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id_kunjungan }}">Edit</button>
                    <form action="{{ url('kunjungan/'.$item->id_kunjungan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="editModal{{ $item->id_kunjungan }}" tabindex="-1">
              <div class="modal-dialog">
                <form action="{{ url('kunjungan/'.$item->id_kunjungan) }}" method="POST" class="modal-content">
                    @csrf @method('PUT')
                    <div class="modal-header"><h5>Edit Kunjungan</h5></div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label>Pasien</label>
                            <select name="id_pasien" class="form-control" required>
                                @foreach($pasienList as $p)
                                    <option value="{{ $p->id }}" {{ $item->id_pasien == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Dokter</label>
                            <select name="id_dokter" class="form-control" required>
                                @foreach($dokterList as $d)
                                    <option value="{{ $d->id }}" {{ $item->id_dokter == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Tanggal</label>
                            <input type="date" name="tgl_kunjungan" class="form-control" value="{{ $item->tgl_kunjungan }}">
                        </div>
                        <div class="mb-2">
                            <label>Jam</label>
                            <input type="time" name="jam_kunjungan" class="form-control" value="{{ $item->jam_kunjungan }}">
                        </div>
                        <div class="mb-2">
                            <label>Keluhan</label>
                            <textarea name="keluhan" class="form-control">{{ $item->keluhan }}</textarea>
                        </div>
                        <div class="mb-2">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control">{{ $item->keterangan }}</textarea>
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

    {{ $kunjungan->links() }}
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="createModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ url('kunjungan') }}" method="POST" class="modal-content">
        @csrf
        <div class="modal-header"><h5>Tambah Kunjungan</h5></div>
        <div class="modal-body">
            <div class="mb-2">
                <label>ID Kunjungan</label>
                <input type="text" name="id_kunjungan" class="form-control" required>
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
                <label>Dokter</label>
                <select name="id_dokter" class="form-control" required>
                    @foreach($dokterList as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-2">
                <label>Tanggal</label>
                <input type="date" name="tgl_kunjungan" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Jam</label>
                <input type="time" name="jam_kunjungan" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>Keluhan</label>
                <textarea name="keluhan" class="form-control"></textarea>
            </div>
            <div class="mb-2">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control"></textarea>
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
