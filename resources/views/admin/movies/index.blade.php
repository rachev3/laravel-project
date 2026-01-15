<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin · Movies
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('admin._nav')

            @if (session('status'))
                <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            <div class="mb-4 flex items-center justify-between gap-3">
                <div class="text-slate-600 text-sm">Общо: {{ $movies->total() }}</div>
                <a href="{{ route('admin.movies.create') }}" class="rounded bg-slate-900 px-4 py-2 text-white">
                    + Нов филм
                </a>
            </div>

            <div class="overflow-x-auto rounded border bg-white">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-slate-700">
                        <tr>
                            <th class="px-4 py-3 text-left">Филм</th>
                            <th class="px-4 py-3 text-left">Жанрове</th>
                            <th class="px-4 py-3 text-left">Постер</th>
                            <th class="px-4 py-3 text-right">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($movies as $movie)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-medium">{{ $movie->title }}</div>
                                    <div class="text-xs text-slate-500">{{ $movie->year ?: '—' }}</div>
                                </td>
                                <td class="px-4 py-3 text-slate-700">
                                    {{ $movie->genres->pluck('name')->join(', ') ?: '—' }}
                                </td>
                                <td class="px-4 py-3">
                                    @if ($movie->poster_path)
                                        <span class="rounded bg-green-50 px-2 py-1 text-xs text-green-800">OK</span>
                                    @else
                                        <span class="rounded bg-slate-100 px-2 py-1 text-xs text-slate-600">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.movies.edit', $movie) }}" class="rounded border px-3 py-1 hover:border-slate-400">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.movies.destroy', $movie) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded border border-red-200 bg-red-50 px-3 py-1 text-red-700">
                                            Delete
                                        </button>
                                    </form>
                                    <a href="{{ route('movies.show', $movie) }}" class="rounded border px-3 py-1 hover:border-slate-400">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $movies->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

