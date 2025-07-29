<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pasien;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Redirect setelah registrasi berhasil.
     */
    protected $redirectTo = '/profil'; // Biar langsung ke profil pasien

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Validasi data registrasi.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Buat user + otomatis buat data pasien jika role = pengguna
     */
    protected function create(array $data)
    {
        // Buat user baru
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'pengguna', // Default role = pengguna
        ]);

        // Buat data pasien
        Pasien::create([
            'user_id'       => $user->id,
            'no_rm'         => 'RM' . time(),
            'tanggal_lahir' => now()->subYears(20), // Default: umur 20
            'alamat'        => '-',
            'telepon'       => '-',
        ]);

        return $user;
    }
}
