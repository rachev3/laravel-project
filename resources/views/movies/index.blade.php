<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Movies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-4">
                <h1 class="text-2xl font-semibold">Филми</h1>
            </div>

            <form method="GET" action="{{ route('movies.index') }}" class="mt-6 rounded bg-white p-4 border">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Заглавие</label>
                        <input
                            type="text"
                            name="title"
                            value="{{ $filters['title'] }}"
                            class="mt-1 w-full rounded border-slate-300"
                            placeholder="Търси по заглавие..."
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Жанр</label>
                        <select name="genre" class="mt-1 w-full rounded border-slate-300">
                            <option value="">Всички</option>
                            @foreach ($genres as $g)
                                <option value="{{ $g->slug }}" @selected($filters['genre'] === $g->slug)>{{ $g->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button class="rounded bg-slate-900 px-4 py-2 text-white">Търси</button>
                        <a href="{{ route('movies.index') }}" class="rounded border px-4 py-2">Изчисти</a>
                    </div>
                </div>
            </form>

            <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                @forelse ($movies as $movie)
                    <a href="{{ route('movies.show', $movie) }}" class="block rounded border bg-white p-4 hover:border-slate-400">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <div class="h-20 w-14 shrink-0 overflow-hidden rounded border bg-slate-50">
                                    @if ($movie->poster_path)
                                        <img
                                            src="{{ asset('storage/'.$movie->poster_path) }}"
                                            alt="Постер: {{ $movie->title }}"
                                            class="h-full w-full object-cover"
                                            loading="lazy"
                                        />
                                    @else
                                        <div class="flex h-full w-full items-center justify-center text-xs text-slate-400">
                                            Няма
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <div class="font-semibold">{{ $movie->title }}</div>
                                    <div class="text-sm text-slate-600">
                                        @if ($movie->year)
                                            {{ $movie->year }} ·
                                        @endif
                                        {{ $movie->genres->pluck('name')->join(', ') ?: 'Без жанр' }}
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                <div class="text-sm text-slate-600">Средна</div>
                                <div class="font-semibold">
                                    {{ $movie->reviews_avg_rating ? number_format($movie->reviews_avg_rating, 1) : '—' }}
                                </div>
                                <div class="text-xs text-slate-500">{{ $movie->reviews_count }} оценки</div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="rounded border bg-white p-4 text-slate-600">
                        Няма намерени филми.
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $movies->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

