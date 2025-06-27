<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelaporan;
use App\Models\User;

class PelaporanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $laporan = Pelaporan::with('admin')
            ->when($search, function ($q) use ($search) {
                $q->where('id_laporan', 'like', "%$search%")
                  ->orWhere('tipe_laporan', 'like', "%$search%");
            })->latest()->paginate(10);

        $adminList = User::where('role', 'admin')->get();

        return view('pelaporan.index', compact('laporan', 'search', 'adminList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_laporan' => 'required|unique:pelaporan',
            'id_admin' => 'required',
            'tipe_laporan' => 'required',
            'id_referensi' => 'required',
            'tanggal_laporan' => 'required|date',
        ]);

        Pelaporan::create($request->all());
        return back()->with('success', 'Laporan berhasil ditambahkan.');
    }

    public function update(Request $request, $id_laporan)
    {
        $request->validate([
            'id_admin' => 'required',
            'tipe_laporan' => 'required',
            'id_referensi' => 'required',
            'tanggal_laporan' => 'required|date',
        ]);

        Pelaporan::findOrFail($id_laporan)->update($request->except(['_token', '_method']));
        return back()->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy($id_laporan)
    {
        Pelaporan::findOrFail($id_laporan)->delete();
        return back()->with('success', 'Laporan berhasil dihapus.');
    }
}
