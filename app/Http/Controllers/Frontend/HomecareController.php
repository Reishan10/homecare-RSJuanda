<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\Perawat;
use App\Models\ReviewRatingHomecare;
use App\Models\TransaksiHomecarePerawat;
use Illuminate\Http\Request;

class HomecareController extends Controller
{
    public function index()
    {
        $homecare = Layanan::orderBy('created_at', 'asc')->take(8)->get();
        $perawat = Perawat::with('user')->where('status', '=', '0')->orderBy('created_at', 'asc')->paginate(9);
        $averageRatings = [];
        foreach ($perawat as $row) {
            $averageRating = TransaksiHomecarePerawat::where('perawat_id', $row->user->id)->avg('rating');
            $averageRatings[$row->id] = round($averageRating, 1);
        }

        $reviewRatings = TransaksiHomecarePerawat::with('user')
            ->whereNotNull('rating')
            ->orderBy('rating', 'desc')
            ->take(10)
            ->get();

        return view('frontend.homecare.index', compact('homecare', 'perawat', 'averageRatings', 'reviewRatings'));
    }

    public function detail($id)
    {
        $perawat = Perawat::with('user')->find($id);
        $averageRatings = TransaksiHomecarePerawat::where('perawat_id', $perawat->user->id)->avg('rating');
        return view('frontend.homecare.detail', compact('perawat', 'averageRatings'));
    }
}
