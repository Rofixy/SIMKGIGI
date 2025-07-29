<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class DokterController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $limit = $request->get('limit', 10);

        $dokter = Dokter::with('user')
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%");
                })
                ->orWhere('spesialisasi', 'like', "%$search%")
                ->orWhere('telepon', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate($limit)
            ->appends(['search' => $search, 'limit' => $limit]);

        return view('admin.dokter', compact('dokter', 'search', 'limit'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'spesialisasi' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'dokter',
            ]);

            // Handle upload foto dengan logging untuk debugging
            $fotoName = null;
            
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                
                Log::info('File upload info:', [
                    'has_file' => true,
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'is_valid' => $file->isValid(),
                    'error' => $file->getError()
                ]);

                if ($file->isValid()) {
                    // Pastikan direktori ada
                    $directory = 'foto_dokter';
                    if (!Storage::disk('public')->exists($directory)) {
                        Storage::disk('public')->makeDirectory($directory);
                    }

                    // Generate nama file unik
                    $fotoName = time() . '_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                    
                    // Upload file
                    $uploaded = $file->storeAs($directory, $fotoName, 'public');
                    
                    if (!$uploaded) {
                        throw new \Exception('Gagal mengupload foto');
                    }
                    
                    Log::info('File uploaded successfully:', [
                        'filename' => $fotoName,
                        'path' => $uploaded
                    ]);
                } else {
                    Log::error('File tidak valid:', [
                        'error_code' => $file->getError(),
                        'error_message' => $file->getErrorMessage()
                    ]);
                }
            } else {
                Log::info('No file uploaded');
            }

            // Buat record dokter dengan nama foto yang benar
            $dokter = Dokter::create([
                'user_id' => $user->id,
                'spesialisasi' => $request->spesialisasi,
                'telepon' => $request->telepon,
                'foto' => $fotoName, // Ini akan NULL jika tidak ada foto, atau nama file jika ada
            ]);

            Log::info('Dokter created with foto:', ['foto' => $fotoName]);

            DB::commit();
            return redirect()->route('dokter.index')->with('success', 'Dokter berhasil ditambahkan.');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating dokter:', ['error' => $e->getMessage()]);
            
            // Hapus file jika sudah terupload tapi terjadi error
            if (isset($fotoName) && $fotoName && Storage::disk('public')->exists('foto_dokter/' . $fotoName)) {
                Storage::disk('public')->delete('foto_dokter/' . $fotoName);
            }
            
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $dokter = Dokter::with('user')->findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $dokter->user_id,
            'password' => 'nullable|string|min:6',
            'spesialisasi' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nama.required' => 'Nama dokter harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.min' => 'Password minimal 6 karakter.',
            'spesialisasi.required' => 'Spesialisasi harus diisi.',
            'telepon.required' => 'Nomor telepon harus diisi.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto harus jpeg, png, jpg, atau gif.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        try {
            DB::beginTransaction();

            // Update data user
            $userData = [
                'name' => $request->nama,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $dokter->user->update($userData);

            // Handle upload foto - gunakan foto lama sebagai default
            $fotoName = $dokter->foto;
            
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                
                Log::info('Updating file info:', [
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'is_valid' => $file->isValid(),
                    'current_foto' => $dokter->foto
                ]);

                if ($file->isValid()) {
                    // Pastikan direktori ada
                    $directory = 'foto_dokter';
                    if (!Storage::disk('public')->exists($directory)) {
                        Storage::disk('public')->makeDirectory($directory);
                    }

                    // Upload foto baru terlebih dahulu
                    $newFotoName = time() . '_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $uploaded = $file->storeAs($directory, $newFotoName, 'public');
                    
                    if ($uploaded) {
                        // Hapus foto lama setelah foto baru berhasil diupload
                        if ($dokter->foto && Storage::disk('public')->exists('foto_dokter/' . $dokter->foto)) {
                            Storage::disk('public')->delete('foto_dokter/' . $dokter->foto);
                            Log::info('Old file deleted:', ['file' => $dokter->foto]);
                        }
                        
                        $fotoName = $newFotoName;
                        Log::info('New file uploaded successfully:', ['filename' => $fotoName]);
                    } else {
                        throw new \Exception('Gagal mengupload foto baru');
                    }
                } else {
                    Log::error('New file is not valid:', [
                        'error_code' => $file->getError(),
                        'error_message' => $file->getErrorMessage()
                    ]);
                    throw new \Exception('File foto tidak valid');
                }
            }

            // Update data dokter
            $dokter->update([
                'spesialisasi' => $request->spesialisasi,
                'telepon' => $request->telepon,
                'foto' => $fotoName,
            ]);

            Log::info('Dokter updated with foto:', ['foto' => $fotoName]);

            DB::commit();
            return redirect()->route('dokter.index')->with('success', 'Data dokter berhasil diperbarui.');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating dokter:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $dokter = Dokter::with('user')->findOrFail($id);

            // Hapus foto jika ada
            if ($dokter->foto && Storage::disk('public')->exists('foto_dokter/' . $dokter->foto)) {
                Storage::disk('public')->delete('foto_dokter/' . $dokter->foto);
                Log::info('File deleted on destroy:', ['file' => $dokter->foto]);
            }

            $dokter->delete();
            $dokter->user->delete();

            DB::commit();
            return redirect()->route('dokter.index')->with('success', 'Dokter berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error deleting dokter:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function getDokter(Request $request)
    {
        $search = $request->get('search');

        $dokter = Dokter::with('user')
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                })
                ->orWhere('spesialisasi', 'like', "%$search%");
            })
            ->get();

        return response()->json($dokter);
    }

    public function show($id)
    {
        $dokter = Dokter::with('user')->findOrFail($id);
        return view('admin.dokter-show', compact('dokter'));
    }

    public function toggleStatus($id)
    {
        try {
            $dokter = Dokter::findOrFail($id);
            $user = $dokter->user;

            $newStatus = $user->status === 'active' ? 'inactive' : 'active';
            $user->update(['status' => $newStatus]);

            $message = $newStatus === 'active' ? 'Dokter berhasil diaktifkan.' : 'Dokter berhasil dinonaktifkan.';

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Error toggling status:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}