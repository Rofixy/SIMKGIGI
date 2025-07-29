@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Profil Pasien</h5>
                </div>
                <div class="card-body">
                    @if ($pasien)
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Nama</th>
                                <td>: {{ $pasien->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>: {{ $pasien->user->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>No. Telepon</th>
                                <td>: {{ $pasien->telepon ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>: {{ ucfirst($pasien->jenis_kelamin) ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>: {{ $pasien->alamat ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td>: 
                                    {{ $pasien->tanggal_lahir 
                                        ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d F Y') 
                                        : '-' 
                                    }}
                                </td>
                            </tr>
                        </table>

                        <div class="text-end mt-4">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                                <i class="bi bi-pencil-square"></i> Edit Profil
                            </button>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            Data pasien belum tersedia.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit Profil --}}
<!-- Modal Edit Profil -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('pasien.update', $pasien->id) }}">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editModalLabel">Edit Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-2">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" value="{{ $pasien->nama }}" required>
                    </div>

                    <div class="mb-2">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="laki-laki" {{ $pasien->jenis_kelamin === 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="perempuan" {{ $pasien->jenis_kelamin === 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" name="alamat" id="alamat" class="form-control" value="{{ $pasien->alamat }}" required>
                    </div>

                    <div class="mb-2">
                        <label for="telepon" class="form-label">No. Telepon</label>
                        <input type="text" name="telepon" id="telepon" class="form-control" value="{{ $pasien->telepon }}" required>
                    </div>

                    <div class="mb-2">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ $pasien->tanggal_lahir }}" required>
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
@endsection
