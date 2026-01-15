<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin · New Movie
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @include('admin._nav')

            <div class="rounded border bg-white p-4">
                <form method="POST" action="{{ route('admin.movies.store') }}" class="space-y-4">
                    @csrf

                    @include('admin.movies._form', ['genres' => $genres])

                    <div class="flex items-center gap-2">
                        <button class="rounded bg-slate-900 px-4 py-2 text-white">Създай</button>
                        <a href="{{ route('admin.movies.index') }}" class="rounded border px-4 py-2">Отказ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

