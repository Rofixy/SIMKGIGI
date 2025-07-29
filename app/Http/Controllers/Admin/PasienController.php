<?
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('search');

        $pasien = Pasien::when($keyword, function ($query, $keyword) {
            return $query->where('nama', 'like', "%$keyword%")
                         ->orWhere('no_rm', 'like', "%$keyword%");
        })->paginate(10);

        return view('admin.pasien.index', compact('pasien', 'keyword'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_rm' => 'required|unique:pasien',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
        ]);

        Pasien::create($request->all());

        return back()->with('success', 'Data pasien berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);

        $request->validate([
            'no_rm' => 'required|unique:pasien,no_rm,' . $id,
            'nama' => 'required',
            'jenis_kelamin' => 'required',
        ]);

        $pasien->update($request->all());

        return back()->with('success', 'Data pasien berhasil diperbarui');
    }

    public function destroy($id)
    {
        Pasien::destroy($id);

        return back()->with('success', 'Data pasien berhasil dihapus');
    }
}

