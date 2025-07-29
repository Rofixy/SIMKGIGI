@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Data Pasien</h4>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search -->
    <form method="GET" class="mb-3">
        <input type="text" name="search" class="form-control" placeholder="Cari pasien..." value="{{ $keyword }}">
    </form>

    <!-- Tambah Button -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Pasien</button>

    <!-- Tabel -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No RM</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pasien as $p)
            <tr>
                <td>{{ $p->no_rm }}</td>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->jenis_kelamin }}</td>
                <td>{{ $p->tanggal_lahir }}</td>
                <td>{{ $p->telepon }}</td>
                <td>{{ $p->alamat }}</td>
                <td>
                    <!-- Edit -->
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $p->id }}">Edit</button>

                    <!-- Hapus -->
                    <form action="{{ route('pasien.destroy', $p->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                    </form>
                </td>
            </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="modalEdit{{ $p->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('pasien.update', $p->id) }}" method="POST" class="modal-content">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5>Edit Data Pasien</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-2">
                                <label>No RM</label>
                                <input type="text" name="no_rm" class="form-control" value="{{ $p->no_rm }}" required>
                            </div>
                            <div class="mb-2">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" value="{{ $p->nama }}" required>
                            </div>
                            <div class="mb-2">
                                <label>Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control" required>
                                    <option value="">- Pilih -</option>
                                    <option value="laki-laki" {{ $p->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="perempuan" {{ $p->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" value="{{ $p->tanggal_lahir }}">
                            </div>
                            <div class="mb-2">
                                <label>Telepon</label>
                                <input type="text" name="telepon" class="form-control" value="{{ $p->telepon }}">
                            </div>
                            <div class="mb-2">
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control">{{ $p->alamat }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    {{ $pasien->links() }}
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('pasien.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5>Tambah Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label>No RM</label>
                    <input type="text" name="no_rm" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="">- Pilih -</option>
                        <option value="laki-laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control">
                </div>
                <div class="mb-2">
                    <label>Telepon</label>
                    <input type="text" name="telepon" class="form-control">
                </div>
                <div class="mb-2">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
