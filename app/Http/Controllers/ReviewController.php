<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Movie $movie)
    {
        abort_unless($request->user(), 403);

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:10'],
            'comment' => ['required', 'string', 'min:2', 'max:2000'],
        ]);

        $review = Review::firstOrNew([
            'movie_id' => $movie->id,
            'user_id' => $request->user()->id,
        ]);

        $review->fill($validated);
        $review->save();

        return redirect()
            ->route('movies.show', $movie)
            ->with('status', 'Ревюто е записано.');
    }

    public function update(Request $request, Movie $movie, Review $review)
    {
        abort_unless($request->user(), 403);
        abort_unless($review->movie_id === $movie->id, 404);

        $this->authorize('update', $review);

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:10'],
            'comment' => ['required', 'string', 'min:2', 'max:2000'],
        ]);

        $review->update($validated);

        return redirect()
            ->route('movies.show', $movie)
            ->with('status', 'Ревюто е обновено.');
    }

    public function destroy(Request $request, Movie $movie, Review $review)
    {
        abort_unless($request->user(), 403);
        abort_unless($review->movie_id === $movie->id, 404);

        $this->authorize('delete', $review);

        $review->delete();

        return redirect()
            ->route('movies.show', $movie)
            ->with('status', 'Ревюто е изтрито.');
    }
}

