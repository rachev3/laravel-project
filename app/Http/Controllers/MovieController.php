<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $title = (string) $request->query('title', '');
        $genre = (string) $request->query('genre', '');

        $moviesQuery = Movie::query()
            ->with('genres')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');

        if ($title !== '') {
            $moviesQuery->where('title', 'like', '%'.$title.'%');
        }

        if ($genre !== '') {
            $moviesQuery->whereHas('genres', function ($q) use ($genre) {
                $q->where('slug', $genre);
            });
        }

        $movies = $moviesQuery
            ->orderByDesc('reviews_avg_rating')
            ->paginate(12)
            ->withQueryString();

        $genres = Genre::query()
            ->orderBy('name')
            ->get(['name', 'slug']);

        return view('movies.index', [
            'movies' => $movies,
            'genres' => $genres,
            'filters' => [
                'title' => $title,
                'genre' => $genre,
            ],
        ]);
    }

    public function show(Movie $movie)
    {
        $movie->load([
            'genres',
            'reviews' => fn ($q) => $q->latest()->with('user'),
        ]);

        $movie->loadAvg('reviews', 'rating');
        $movie->loadCount('reviews');

        return view('movies.show', [
            'movie' => $movie,
        ]);
    }
}

