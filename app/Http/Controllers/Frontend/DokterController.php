<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DokterController extends Controller
{
    public function index()
    {
        $user = User::with('dokter')->where('type', 3)->orderBy('created_at', 'asc')->paginate(9);
        return view('frontend.dokter', compact('user'));
    }

    public function detail($id)
    {
        $user = User::with('dokter')->find($id);
        return view('frontend.dokter_detail', compact('user'));
    }
}
