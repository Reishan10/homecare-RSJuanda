<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ChatPayment;
use App\Models\ReviewRatingTelemedicine;
use App\Models\User;
use Illuminate\Http\Request;

class TelemedicineController extends Controller
{
    public function index()
    {
        $user = User::where('type', 3)
            ->join('dokter', 'users.id', '=', 'dokter.user_id')
            ->where('dokter.status', '=', '0')
            ->orderBy('users.created_at', 'asc')
            ->paginate(9, ['users.*']);

        $averageRatings = [];
        foreach ($user as $row) {
            $averageRating = ChatPayment::where('dokter_id', $row->dokter->id)->avg('rating');
            $averageRatings[$row->id] = round($averageRating, 1);
        }

        $reviewRatings = ChatPayment::with('user')
            ->whereNotNull('rating')
            ->orderBy('rating', 'desc')
            ->take(10)
            ->get();

        return view('frontend.telemedicine.index', compact('user', 'averageRatings', 'reviewRatings'));
    }

    public function detail($id)
    {
        $user = User::with('dokter')->find($id);
        $averageRatings = ChatPayment::where('dokter_id', $user->dokter->id)->avg('rating');
        return view('frontend.telemedicine.detail', compact('user', 'averageRatings'));
    }
}
