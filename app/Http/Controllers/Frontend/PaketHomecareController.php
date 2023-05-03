<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Homecare;
use App\Models\User;
use Illuminate\Http\Request;

class PaketHomecareController extends Controller
{
    public function index()
    {
        $user = User::where('type', 3)
            ->join('dokter', 'users.id', '=', 'dokter.user_id')
            ->where('dokter.status', '=', '0')
            ->orderBy('users.created_at', 'asc')
            ->paginate(9, ['users.*']);
        $paketHomecare = Homecare::orderBy('created_at', 'asc')->take(8)->get();
        return view('frontend.paketHomecare.index', compact('user', 'paketHomecare'));
    }
}
