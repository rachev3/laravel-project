<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $movie->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

            <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="md:col-span-1">
                    <div class="rounded border bg-white p-4">
                        <div class="aspect-[2/3] overflow-hidden rounded border bg-slate-50">
                            @if ($movie->poster_path)
                                <img
                                    src="{{ asset('storage/'.$movie->poster_path) }}"
                                    alt="Постер: {{ $movie->title }}"
                                    class="h-full w-full object-cover"
                                    loading="lazy"
                                />
                            @else
                                <div class="flex h-full w-full items-center justify-center text-sm text-slate-400">
                                    Няма постер
                                </div>
                            @endif
                        </div>

                        @if (session('status'))
                            <div class="mt-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->has('poster'))
                            <div class="mt-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                                <div class="font-semibold">Проблем с постера:</div>
                                <ul class="mt-1 list-disc pl-5">
                                    @foreach ($errors->get('poster') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @can('updatePoster', $movie)
                            <form
                                method="POST"
                                action="{{ route('movies.poster.update', $movie) }}"
                                enctype="multipart/form-data"
                                class="mt-4 space-y-2"
                            >
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Качи/смени постер</label>
                                    <input
                                        type="file"
                                        name="poster"
                                        accept=".jpg,.jpeg,.png,.webp,image/*"
                                        class="mt-1 w-full rounded border-slate-300"
                                        required
                                    />
                                    <div class="mt-1 text-xs text-slate-500">JPG/PNG/WEBP до 4MB</div>
                                </div>

                                <button class="rounded bg-slate-900 px-4 py-2 text-white">Запази</button>
                            </form>
                        @endcan
                    </div>
                </div>

                <div class="md:col-span-2">
                    @if ($movie->description)
                        <div class="rounded border bg-white p-4">
                            <div class="text-sm text-slate-700 whitespace-pre-line">{{ $movie->description }}</div>
                        </div>
                    @else
                        <div class="rounded border bg-white p-4 text-slate-600">
                            Няма описание.
                        </div>
                    @endif
                </div>
            </div>

            <h2 class="mt-8 text-xl font-semibold">Твоето ревю</h2>

            @php
                $myReview = auth()->check()
                    ? $movie->reviews->firstWhere('user_id', auth()->id())
                    : null;
            @endphp

            @auth
                <div class="mt-4 rounded border bg-white p-4">
                    @if ($errors->any())
                        <div class="mb-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                            <div class="font-semibold">Има проблем с формата:</div>
                            <ul class="mt-1 list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form
                        method="POST"
                        action="{{ $myReview ? route('movies.reviews.update', [$movie, $myReview]) : route('movies.reviews.store', $movie) }}"
                        class="space-y-4"
                    >
                        @csrf
                        @if ($myReview)
                            @method('PATCH')
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Оценка (1–10)</label>
                            <input
                                type="number"
                                name="rating"
                                min="1"
                                max="10"
                                value="{{ old('rating', $myReview?->rating) }}"
                                class="mt-1 w-full rounded border-slate-300"
                                required
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Коментар</label>
                            <textarea
                                name="comment"
                                rows="4"
                                class="mt-1 w-full rounded border-slate-300"
                                required>{{ old('comment', $myReview?->comment) }}</textarea>
                        </div>

                        <div class="flex items-center gap-2">
                            <button class="rounded bg-slate-900 px-4 py-2 text-white">
                                {{ $myReview ? 'Обнови ревюто' : 'Добави ревю' }}
                            </button>
                        </div>
                    </form>

                    @if ($myReview)
                        <form method="POST" action="{{ route('movies.reviews.destroy', [$movie, $myReview]) }}" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button class="rounded border border-red-200 bg-red-50 px-4 py-2 text-red-700">
                                Изтрий
                            </button>
                        </form>
                    @endif
                </div>
            @else
                <div class="mt-4 rounded border bg-white p-4 text-slate-600">
                    Трябва да си логнат, за да добавиш ревю.
                </div>
            @endauth

            <h2 class="mt-8 text-xl font-semibold">Оценки и коментари</h2>

            <div class="mt-4 space-y-3">
                @forelse ($movie->reviews as $review)
                    <div class="rounded border bg-white p-4">
                        <div class="flex items-start justify-between gap-4">
                            <div class="text-sm text-slate-600">
                                {{ $review->user?->name ?? 'Потребител' }} · {{ $review->created_at?->format('d.m.Y H:i') }}
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="font-semibold">Оценка: {{ $review->rating }}/10</div>
                                @auth
                                    @if ($review->user_id === auth()->id())
                                        <span class="rounded bg-slate-100 px-2 py-1 text-xs text-slate-700">Твоето</span>
                                    @endif
                                @endauth
                            </div>
                        </div>
                        <div class="mt-2 text-slate-800 whitespace-pre-line">{{ $review->comment }}</div>
                    </div>
                @empty
                    <div class="rounded border bg-white p-4 text-slate-600">
                        Все още няма коментари.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>

