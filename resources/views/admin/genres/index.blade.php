<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin · Genres
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
                <div class="text-slate-600 text-sm">Общо: {{ $genres->total() }}</div>
                <a href="{{ route('admin.genres.create') }}" class="rounded bg-slate-900 px-4 py-2 text-white">
                    + Нов жанр
                </a>
            </div>

            <div class="overflow-x-auto rounded border bg-white">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-slate-700">
                        <tr>
                            <th class="px-4 py-3 text-left">Име</th>
                            <th class="px-4 py-3 text-left">Slug</th>
                            <th class="px-4 py-3 text-right">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($genres as $genre)
                            <tr>
                                <td class="px-4 py-3 font-medium">{{ $genre->name }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $genre->slug }}</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.genres.edit', $genre) }}" class="rounded border px-3 py-1 hover:border-slate-400">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.genres.destroy', $genre) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded border border-red-200 bg-red-50 px-3 py-1 text-red-700">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $genres->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

