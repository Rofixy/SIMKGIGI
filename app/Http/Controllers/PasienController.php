<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasienController extends Controller
{
    /**
     * Menampilkan profil pasien yang sedang login.
     */
    public function profil()
    {
        $pasien = Pasien::with('user')->where('user_id', Auth::id())->first();

        if (!$pasien) {
            return redirect()->back()->with('error', 'Data pasien tidak ditemukan.');
        }

        return view('pasien.profil', compact('pasien'));
    }

    /**
     * Memperbarui data profil pasien dari halaman profil.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'           => 'required|string|max:255',
            'jenis_kelamin'  => 'required|in:laki-laki,perempuan',
            'tanggal_lahir'  => 'required|date',
            'alamat'         => 'required|string|max:255',
            'telepon'        => 'required|string|max:20',
        ]);

        $pasien = Pasien::findOrFail($id);

        if ($pasien->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $pasien->update($request->only([
            'nama',
            'jenis_kelamin',
            'tanggal_lahir',
            'alamat',
            'telepon'
        ]));

        return redirect()->route('pasien.profil')->with('success', 'Profil berhasil diperbarui.');
    }
}
