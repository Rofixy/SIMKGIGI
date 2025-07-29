<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dokter;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $dokterCount = Dokter::count();
        // tambahkan variabel lain jika dibutuhkan

        return view('dashboard_admin.index', compact('userCount', 'dokterCount'));
    }
}
