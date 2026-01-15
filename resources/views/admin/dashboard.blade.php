<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('admin._nav')

            <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                <div class="rounded border bg-white p-4">
                    <div class="text-sm text-slate-600">Movies</div>
                    <div class="text-2xl font-semibold">{{ $stats['movies'] }}</div>
                </div>
                <div class="rounded border bg-white p-4">
                    <div class="text-sm text-slate-600">Genres</div>
                    <div class="text-2xl font-semibold">{{ $stats['genres'] }}</div>
                </div>
                <div class="rounded border bg-white p-4">
                    <div class="text-sm text-slate-600">Reviews</div>
                    <div class="text-2xl font-semibold">{{ $stats['reviews'] }}</div>
                </div>
                <div class="rounded border bg-white p-4">
                    <div class="text-sm text-slate-600">Users</div>
                    <div class="text-2xl font-semibold">{{ $stats['users'] }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

