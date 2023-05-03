<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\Perawat;
use Illuminate\Http\Request;

class HomecareController extends Controller
{
    public function index()
    {
        $homecare = Layanan::orderBy('created_at', 'asc')->take(9)->get();
        $perawat = Perawat::with('user')->where('status', '=', '0')->orderBy('created_at', 'asc')->paginate(9);
        return view('frontend.homecare.index', compact('homecare', 'perawat'));
    }
}
