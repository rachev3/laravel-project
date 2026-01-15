<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;

class AdminMovieController extends Controller
{
    public function index()
    {
        $movies = Movie::query()
            ->with('genres')
            ->latest()
            ->paginate(15);

        return view('admin.movies.index', [
            'movies' => $movies,
        ]);
    }

    public function create()
    {
        return view('admin.movies.create', [
            'genres' => Genre::query()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'year' => ['nullable', 'integer', 'min:1888', 'max:2100'],
            'description' => ['nullable', 'string', 'max:10000'],
            'genre_ids' => ['nullable', 'array'],
            'genre_ids.*' => ['integer', 'exists:genres,id'],
        ]);

        $movie = Movie::create([
            'title' => $validated['title'],
            'year' => $validated['year'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        $movie->genres()->sync($validated['genre_ids'] ?? []);

        return redirect()
            ->route('admin.movies.edit', $movie)
            ->with('status', 'Филмът е създаден.');
    }

    public function edit(Movie $movie)
    {
        $movie->load('genres');

        return view('admin.movies.edit', [
            'movie' => $movie,
            'genres' => Genre::query()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'year' => ['nullable', 'integer', 'min:1888', 'max:2100'],
            'description' => ['nullable', 'string', 'max:10000'],
            'genre_ids' => ['nullable', 'array'],
            'genre_ids.*' => ['integer', 'exists:genres,id'],
        ]);

        $movie->update([
            'title' => $validated['title'],
            'year' => $validated['year'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        $movie->genres()->sync($validated['genre_ids'] ?? []);

        return back()->with('status', 'Филмът е обновен.');
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();

        return redirect()
            ->route('admin.movies.index')
            ->with('status', 'Филмът е изтрит.');
    }
}

