<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashBoardDokterController extends Controller
{
    /**
     * Tampilkan halaman dashboard dokter.
     */
    public function index()
    {
        return view('dashboard_dokter.index');
    }
}
