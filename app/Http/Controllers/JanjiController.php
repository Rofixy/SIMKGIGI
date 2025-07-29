<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Janji;
use Illuminate\Support\Facades\Auth;

class JanjiController extends Controller
{
    public function index()
    {
        // Ambil semua dokter dengan data user & jadwal jika sudah ada
        $dokter = Dokter::with('user', 'jadwal')->get();

        return view('pasien.buat_janji', compact('dokter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|exists:dokter,id',
            'jadwal' => 'required|date_format:Y-m-d\TH:i',
        ]);

        // Cari ID pasien dari user login
        $pasien = Pasien::where('user_id', Auth::id())->first();

        if (!$pasien) {
            return back()->with('error', 'Data pasien tidak ditemukan!');
        }

        Janji::create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $request->dokter_id,
            'jadwal' => $request->jadwal,
        ]);

        return redirect()->back()->with('success', 'Janji berhasil dibuat!');
    }
}
