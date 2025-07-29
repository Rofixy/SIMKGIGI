@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4"><i class="fas fa-calendar-check me-2"></i>Buat Janji Temu dengan Dokter</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @foreach($dokter as $d)
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        @if ($d->foto && file_exists(public_path('storage/foto_dokter/' . $d->foto)))
                            <img src="{{ asset('storage/foto_dokter/' . $d->foto) }}" 
                                class="rounded-circle doctor-img me-3" 
                                alt="Foto {{ $d->user->name }}"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="rounded-circle doctor-img bg-light d-flex align-items-center justify-content-center me-3" style="display: none;">
                                <i class="bi bi-person-circle text-muted" style="font-size: 2rem;"></i>
                            </div>
                        @else
                            <div class="rounded-circle doctor-img bg-light d-flex align-items-center justify-content-center me-3">
                                <i class="bi bi-person-circle text-muted" style="font-size: 2rem;"></i>
                            </div>
                        @endif

                        <div>
                            <p class="mb-0"><strong>Dokter:</strong> {{ $d->user->name }}</p>
                        </div>
                    </div>

                    <h6 class="text-primary">Jadwal Praktek:</h6>
                    <ul class="list-group mb-3">
                        @foreach($d->jadwal as $jadwal)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $jadwal->hari }} - {{ $jadwal->jam_mulai }} s/d {{ $jadwal->jam_selesai }}
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#buatJanjiModal{{ $jadwal->id }}">
                                Buat Janji
                            </button>
                        </li>

                        <!-- Modal Buat Janji -->
                        <div class="modal fade" id="buatJanjiModal{{ $jadwal->id }}" tabindex="-1" aria-labelledby="buatJanjiModalLabel{{ $jadwal->id }}" aria-hidden="true">
                          <div class="modal-dialog">
                            <form action="{{ route('janji.store') }}" method="POST" class="modal-content">
                                @csrf
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="buatJanjiModalLabel{{ $jadwal->id }}">Buat Janji</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Dokter:</strong> {{ $d->user->name }}</p>
                                    <p><strong>Hari:</strong> {{ $jadwal->hari }}</p>
                                    <p><strong>Jam:</strong> {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</p>

                                    <input type="hidden" name="id_jadwal" value="{{ $jadwal->id }}">
                                    <div class="mb-3">
                                        <label for="keluhan" class="form-label">Keluhan</label>
                                        <textarea name="keluhan" class="form-control" placeholder="Ceritakan keluhan Anda..." required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button class="btn btn-primary">Kirim Janji</button>
                                </div>
                            </form>
                          </div>
                        </div>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
