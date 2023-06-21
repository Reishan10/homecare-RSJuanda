<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Homecare;
use App\Models\ReviewRatingPaketHomecare;
use App\Models\TransaksiHomecare;
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

        $averageRatings = [];
        foreach ($user as $row) {
            $averageRating = TransaksiHomecare::where('dokter_id', $row->id)->avg('rating');
            $averageRatings[$row->id] = round($averageRating, 1);
        }

        $reviewRatings = TransaksiHomecare::with('user')
            ->whereNotNull('rating')
            ->orderBy('rating', 'desc')
            ->take(10)
            ->get();

        return view('frontend.paketHomecare.index', compact('user', 'paketHomecare', 'averageRatings', 'reviewRatings'));
    }

    public function detail($id)
    {
        $user = User::with('dokter')->find($id);
        $averageRatings = TransaksiHomecare::where('dokter_id', $user->id)->avg('rating');
        return view('frontend.paketHomecare.detail', compact('user', 'averageRatings'));
    }
}
