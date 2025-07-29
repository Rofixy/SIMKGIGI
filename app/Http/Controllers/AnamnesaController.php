<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anamnesa;
use App\Models\Janji;

class AnamnesaController extends Controller
{
    /**
     * Tampilkan form input anamnesa berdasarkan janji
     */
    public function create($janji_id)
    {
        $janji = Janji::with('pasien')->findOrFail($janji_id);
        return view('dokter.anamnesa', compact('janji'));
    }

    /**
     * Simpan data anamnesa ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'janji_id'    => 'required|exists:janji,id',
            'keluhan'     => 'required|string',
            'pemeriksaan' => 'nullable|string',
            'diagnosa'    => 'nullable|string',
            'tindakan'    => 'nullable|string',
        ]);

        Anamnesa::create($validated);

        return redirect()->back()->with('success', 'Anamnesa berhasil disimpan.');
    }
}
