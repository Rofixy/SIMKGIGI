<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Kunjungan;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $transaksi = Transaksi::with('pasien', 'kunjungan')
            ->when($search, function ($q) use ($search) {
                $q->where('no_transaksi', 'like', "%$search%");
            })->latest()->paginate(10);

        $pasienList = User::where('role', 'pasien')->get();
        $kunjunganList = Kunjungan::all();

        return view('transaksi.index', compact('transaksi', 'search', 'pasienList', 'kunjunganList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_transaksi' => 'required|unique:transaksi',
            'id_pasien' => 'required',
            'id_kunjungan' => 'required',
            'total_bayar' => 'required|numeric',
            'tanggal' => 'required|date',
            'metode_pembayaran' => 'required|in:Cash,Online'
        ]);

        Transaksi::create($request->all());
        return back()->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_pasien' => 'required',
            'id_kunjungan' => 'required',
            'total_bayar' => 'required|numeric',
            'tanggal' => 'required|date',
            'metode_pembayaran' => 'required|in:Cash,Online'
        ]);

        Transaksi::findOrFail($id)->update($request->except(['_token', '_method']));
        return back()->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Transaksi::findOrFail($id)->delete();
        return back()->with('success', 'Transaksi berhasil dihapus.');
    }
}
