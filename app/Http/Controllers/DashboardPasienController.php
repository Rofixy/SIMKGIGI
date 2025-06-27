<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardPasienController extends Controller
{
    /**
     * Tampilkan halaman dashboard pengguna.
     */
    public function index()
    {
        return view('dashboard_pasien.index');
    }
}
