<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $limit = $request->get('limit', 10); // default 10 if not set

        $obat = Obat::when($search, function ($query) use ($search) {
                return $query->where('kd_obat', 'like', "%$search%")
                            ->orWhere('nm_obat', 'like', "%$search%")
                            ->orWhere('jml_obat', 'like', "%$search%")
                            ->orWhere('hrg_obat', 'like', "%$search%");
            })
            ->orderByRaw('CAST(kd_obat AS UNSIGNED) ASC') // numeric sort even for varchar
            ->paginate($limit)
            ->appends(['search' => $search, 'limit' => $limit]); // maintain query params

        return view('obat.index', compact('obat', 'search', 'limit'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kd_obat' => 'required|unique:obat,kd_obat',
            'nm_obat' => 'required',
            'jml_obat' => 'required|integer|min:1',
            'hrg_obat' => 'required|numeric|min:0',
        ]);

        Obat::create($request->all());

        return redirect()->route('obat.index')->with('success', 'Obat berhasil ditambahkan.');
    }

    public function edit($kd_obat)
    {
        $obat = Obat::findOrFail($kd_obat);
        return view('obat.edit', compact('obat'));
    }

    public function update(Request $request, $kd_obat)
    {
        $request->validate([
            'nm_obat' => 'required',
            'jml_obat' => 'required|integer|min:1',
            'hrg_obat' => 'required|numeric|min:0',
        ]);

        $obat = Obat::findOrFail($kd_obat);
        $obat->update($request->only(['nm_obat', 'jml_obat', 'hrg_obat']));

        return redirect()->route('obat.index')->with('success', 'Obat berhasil diperbarui.');
    }

    public function destroy($kd_obat)
    {
        $obat = Obat::findOrFail($kd_obat);
        $obat->delete();

        return redirect()->route('obat.index')->with('success', 'Obat berhasil dihapus.');
    }
}
