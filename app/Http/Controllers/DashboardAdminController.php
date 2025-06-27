<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashBoardAdminController extends Controller
{
    /**
     * Tampilkan halaman dashboard admin.
     */
    public function index()
    {
        return view('dashboard_admin.index');
    }
}
