<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Fisioterapi;
use App\Models\Perawat;
use App\Models\ReviewRatingFisioterapi;
use App\Models\TransaksiFisioterapi;
use App\Models\User;
use Illuminate\Http\Request;

class FisioterapiController extends Controller
{
    public function index()
    {
        $fisioterapi = Fisioterapi::orderBy('created_at', 'asc')->take(9)->get();
        $perawat = Perawat::with('user')->where('status', '=', '0')->orderBy('created_at', 'asc')->paginate(9);

        $averageRatings = [];
        foreach ($perawat as $row) {
            $averageRating = TransaksiFisioterapi::where('perawat_id', $row->user->id)->avg('rating');
            $averageRatings[$row->id] = round($averageRating, 1);
        }

        $reviewRatings = TransaksiFisioterapi::with('user')
            ->whereNotNull('rating')
            ->orderBy('rating', 'desc')
            ->take(10)
            ->get();
        return view('frontend.fisioterapi.index', compact('fisioterapi', 'perawat', 'averageRatings', 'reviewRatings'));
    }

    public function detail($id)
    {
        $perawat = Perawat::with('user')->find($id);
        $averageRatings = TransaksiFisioterapi::where('perawat_id', $perawat->user->id)->avg('rating');
        return view('frontend.fisioterapi.detail', compact('perawat', 'averageRatings'));
    }
}
