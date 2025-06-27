<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\User;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $kunjungan = Kunjungan::with(['pengguna', 'dokter'])
            ->when($search, function ($q) use ($search) {
                $q->where('id_kunjungan', 'like', "%$search%")
                  ->orWhereHas('pengguna', fn($q) => $q->where('name', 'like', "%$search%"));
            })->latest()->paginate(10);

        $penggunaList = User::where('role', 'pengguna')->get();
        $dokterList = User::where('role', 'dokter')->get();

        return view('kunjungan.index', compact('kunjungan', 'search', 'penggunaList', 'dokterList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kunjungan' => 'required|unique:kunjungan',
            'id_pengguna' => 'required',
            'id_dokter' => 'required',
            'tgl_kunjungan' => 'required|date',
            'jam_kunjungan' => 'required',
        ]);

        Kunjungan::create($request->all());
        return back()->with('success', 'Kunjungan berhasil ditambahkan.');
    }

    public function update(Request $request, $id_kunjungan)
    {
        $request->validate([
            'id_pengguna' => 'required',
            'id_dokter' => 'required',
            'tgl_kunjungan' => 'required|date',
            'jam_kunjungan' => 'required',
        ]);

        Kunjungan::where('id_kunjungan', $id_kunjungan)->update($request->except(['_token', '_method']));
        return back()->with('success', 'Kunjungan berhasil diperbarui.');
    }

    public function destroy($id_kunjungan)
    {
        Kunjungan::where('id_kunjungan', $id_kunjungan)->delete();
        return back()->with('success', 'Kunjungan berhasil dihapus.');
    }
}
