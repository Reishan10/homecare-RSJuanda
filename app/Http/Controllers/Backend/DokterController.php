<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function index()
    {
        $dokter = User::where('type', 3)->get();
        return view('backend.dokter.index', compact('dokter'));
    }
}
