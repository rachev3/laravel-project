<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Review;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'stats' => [
                'movies' => Movie::query()->count(),
                'genres' => Genre::query()->count(),
                'reviews' => Review::query()->count(),
                'users' => User::query()->count(),
            ],
        ]);
    }
}

