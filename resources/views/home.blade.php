<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Начало
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 space-y-6">
                    <div class="rounded border bg-white p-4">
                        <div class="flex items-center justify-between gap-3">
                            <h1 class="text-2xl font-semibold">Система за оценки и коментари на филми</h1>
                            <a href="{{ route('movies.index') }}" class="rounded bg-slate-900 px-4 py-2 text-white">
                                Разгледай филмите
                            </a>
                        </div>
                        <div class="mt-2 text-slate-600">
                            Последно добавени филми, последни ревюта и последно качени постери.
                        </div>
                    </div>

                    <div class="rounded border bg-white p-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold">Последно добавени филми</h2>
                            <a href="{{ route('movies.index') }}" class="text-sm underline">Всички</a>
                        </div>

                        <div class="mt-4 grid grid-cols-1 gap-3 md:grid-cols-2">
                            @forelse ($latestMovies as $movie)
                                <a href="{{ route('movies.show', $movie) }}" class="rounded border p-3 hover:border-slate-400">
                                    <div class="flex items-start gap-3">
                                        <div class="h-16 w-12 shrink-0 overflow-hidden rounded border bg-slate-50">
                                            @if ($movie->poster_path)
                                                <img src="{{ asset('storage/'.$movie->poster_path) }}" alt="Постер: {{ $movie->title }}" class="h-full w-full object-cover" loading="lazy" />
                                            @else
                                                <div class="flex h-full w-full items-center justify-center text-xs text-slate-400">—</div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-semibold">{{ $movie->title }}</div>
                                            <div class="text-sm text-slate-600">
                                                {{ $movie->year ?: '—' }} · {{ $movie->genres->pluck('name')->join(', ') ?: 'Без жанр' }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-slate-600">Няма филми.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="rounded border bg-white p-4">
                        <h2 class="text-lg font-semibold">Последни ревюта</h2>

                        <div class="mt-4 space-y-3">
                            @forelse ($latestReviews as $review)
                                <div class="rounded border p-3">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="text-sm text-slate-600">
                                            {{ $review->user?->name ?? 'Потребител' }}
                                            ·
                                            <a class="underline" href="{{ route('movies.show', $review->movie) }}">{{ $review->movie?->title }}</a>
                                            ·
                                            {{ $review->created_at?->format('d.m.Y H:i') }}
                                        </div>
                                        <div class="font-semibold">Оценка: {{ $review->rating }}/10</div>
                                    </div>
                                    <div class="mt-2 text-slate-800 whitespace-pre-line">{{ $review->comment }}</div>
                                </div>
                            @empty
                                <div class="text-slate-600">Няма ревюта.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded border bg-white p-4">
                        <h2 class="text-lg font-semibold">Последно качени постери</h2>

                        <div class="mt-4 grid grid-cols-3 gap-2">
                            @forelse ($latestPosters as $movie)
                                <a href="{{ route('movies.show', $movie) }}" class="block overflow-hidden rounded border bg-slate-50">
                                    <img src="{{ asset('storage/'.$movie->poster_path) }}" alt="Постер: {{ $movie->title }}" class="aspect-[2/3] w-full object-cover" loading="lazy" />
                                </a>
                            @empty
                                <div class="col-span-3 text-slate-600">Няма качени постери.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="rounded border bg-white p-4">
                        <h2 class="text-lg font-semibold">Вход</h2>
                        <div class="mt-2 text-slate-600 text-sm">
                            За да добавяш ревюта или да управляваш постери/админ панела, трябва да си логнат.
                        </div>
                        <div class="mt-4 flex items-center gap-2">
                            @auth
                                <a href="{{ route('dashboard') }}" class="rounded bg-slate-900 px-4 py-2 text-white">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="rounded bg-slate-900 px-4 py-2 text-white">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="rounded border px-4 py-2">Register</a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

