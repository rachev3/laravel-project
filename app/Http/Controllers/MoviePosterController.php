<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MoviePosterController extends Controller
{
    public function update(Request $request, Movie $movie)
    {
        $this->authorize('updatePoster', $movie);

        $validated = $request->validate([
            'poster' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $newPath = $request->file('poster')->store('posters', 'public');

        if ($movie->poster_path && Storage::disk('public')->exists($movie->poster_path)) {
            Storage::disk('public')->delete($movie->poster_path);
        }

        $movie->forceFill([
            'poster_path' => $newPath,
        ])->save();

        return back()->with('status', 'Постерът е обновен.');
    }
}

