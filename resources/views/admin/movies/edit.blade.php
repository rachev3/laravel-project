<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin · Edit Movie
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @include('admin._nav')

            @if (session('status'))
                <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            <div class="rounded border bg-white p-4">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <div>
                        <div class="font-semibold">{{ $movie->title }}</div>
                        <div class="text-sm text-slate-600">
                            <a class="underline" href="{{ route('movies.show', $movie) }}">Отвори публичната страница</a>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.movies.update', $movie) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    @include('admin.movies._form', ['movie' => $movie, 'genres' => $genres])

                    <div class="flex items-center gap-2">
                        <button class="rounded bg-slate-900 px-4 py-2 text-white">Запази</button>
                        <a href="{{ route('admin.movies.index') }}" class="rounded border px-4 py-2">Назад</a>
                    </div>
                </form>

                <hr class="my-6" />

                <div class="text-sm font-semibold text-slate-800">Постер</div>
                <div class="mt-2 flex items-start gap-4">
                    <div class="h-28 w-20 overflow-hidden rounded border bg-slate-50">
                        @if ($movie->poster_path)
                            <img
                                src="{{ asset('storage/'.$movie->poster_path) }}"
                                alt="Постер: {{ $movie->title }}"
                                class="h-full w-full object-cover"
                                loading="lazy"
                            />
                        @else
                            <div class="flex h-full w-full items-center justify-center text-xs text-slate-400">Няма</div>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('movies.poster.update', $movie) }}" enctype="multipart/form-data" class="space-y-2">
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
                        </div>
                        <button class="rounded bg-slate-900 px-4 py-2 text-white">Запази постер</button>
                        @if ($errors->has('poster'))
                            <div class="rounded border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                                {{ $errors->first('poster') }}
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

