<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekamMedis;
use App\Models\Kunjungan;

class RekamMedisController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $limit = $request->get('limit', 10); // default 10 jika tidak dipilih

        $rekam = RekamMedis::with('kunjungan')
            ->when($search, function ($query) use ($search) {
                $query->where('id_rekammedis', 'like', "%$search%")
                      ->orWhere('diagnosa', 'like', "%$search%")
                      ->orWhere('resep_obat', 'like', "%$search%");
            })
            ->orderByRaw('CAST(id_rekammedis AS UNSIGNED) ASC') // urut numerik
            ->paginate($limit)
            ->appends(['search' => $search, 'limit' => $limit]);

        $kunjungan = Kunjungan::all();

        return view('rekam_medis.index', compact('rekam', 'search', 'limit', 'kunjungan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_rekammedis' => 'required|unique:rekam_medis',
            'id_kunjungan' => 'required',
            'diagnosa' => 'required',
            'resep_obat' => 'required'
        ]);

        RekamMedis::create($request->all());
        return back()->with('success', 'Rekam medis berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_kunjungan' => 'required',
            'diagnosa' => 'required',
            'resep_obat' => 'required'
        ]);

        RekamMedis::findOrFail($id)->update($request->except(['_token', '_method']));
        return back()->with('success', 'Rekam medis berhasil diperbarui.');
    }

    public function destroy($id)
    {
        RekamMedis::findOrFail($id)->delete();
        return back()->with('success', 'Rekam medis berhasil dihapus.');
    }
}
