@extends('layouts.app')

@section('title', $movie->title)

@section('content')
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold">{{ $movie->title }}</h1>
            <div class="mt-1 text-sm text-slate-600">
                @if ($movie->year)
                    {{ $movie->year }} ·
                @endif
                {{ $movie->genres->pluck('name')->join(', ') ?: 'Без жанр' }}
            </div>
        </div>

        <div class="text-right">
            <div class="text-sm text-slate-600">Средна оценка</div>
            <div class="text-2xl font-semibold">
                {{ $movie->reviews_avg_rating ? number_format($movie->reviews_avg_rating, 1) : '—' }}
            </div>
            <div class="text-xs text-slate-500">{{ $movie->reviews_count }} оценки</div>
        </div>
    </div>

    @if ($movie->description)
        <div class="mt-6 rounded border bg-white p-4">
            <div class="text-sm text-slate-700 whitespace-pre-line">{{ $movie->description }}</div>
        </div>
    @endif

    <h2 class="mt-8 text-xl font-semibold">Оценки и коментари</h2>

    <div class="mt-4 space-y-3">
        @forelse ($movie->reviews as $review)
            <div class="rounded border bg-white p-4">
                <div class="flex items-start justify-between gap-4">
                    <div class="text-sm text-slate-600">
                        {{ $review->user?->name ?? 'Потребител' }} · {{ $review->created_at?->format('d.m.Y H:i') }}
                    </div>
                    <div class="font-semibold">Оценка: {{ $review->rating }}/10</div>
                </div>
                <div class="mt-2 text-slate-800 whitespace-pre-line">{{ $review->comment }}</div>
            </div>
        @empty
            <div class="rounded border bg-white p-4 text-slate-600">
                Все още няма коментари.
            </div>
        @endforelse
    </div>
@endsection

