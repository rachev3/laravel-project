<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'latestMovies' => Movie::query()
                ->with('genres')
                ->latest()
                ->take(6)
                ->get(),
            'latestReviews' => Review::query()
                ->with(['movie', 'user'])
                ->latest()
                ->take(6)
                ->get(),
            'latestPosters' => Movie::query()
                ->whereNotNull('poster_path')
                ->latest('updated_at')
                ->take(6)
                ->get(),
        ]);
    }
}

