<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use App\Models\Obat;

class DetailTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $detail = DetailTransaksi::with(['transaksi', 'obat'])
            ->when($search, function ($q) use ($search) {
                $q->where('id_detail', 'like', "%$search%")
                  ->orWhere('no_transaksi', 'like', "%$search%");
            })
            ->latest()
            ->paginate(10);

        $transaksi = Transaksi::all();
        $obat = Obat::all();

        return view('detail_transaksi.index', compact('detail', 'search', 'transaksi', 'obat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_detail' => 'required|unique:detail_transaksi',
            'no_transaksi' => 'required',
            'kode_obat' => 'required',
            'jumlah' => 'required|integer|min:1',
            'subtotal' => 'required|numeric|min:0'
        ]);

        DetailTransaksi::create($request->all());
        return back()->with('success', 'Detail transaksi berhasil ditambahkan.');
    }

    public function update(Request $request, $id_detail)
    {
        $request->validate([
            'no_transaksi' => 'required',
            'kode_obat' => 'required',
            'jumlah' => 'required|integer|min:1',
            'subtotal' => 'required|numeric|min:0'
        ]);

        DetailTransaksi::findOrFail($id_detail)->update($request->all());
        return back()->with('success', 'Detail transaksi berhasil diperbarui.');
    }

    public function destroy($id_detail)
    {
        DetailTransaksi::findOrFail($id_detail)->delete();
        return back()->with('success', 'Detail transaksi berhasil dihapus.');
    }
}
