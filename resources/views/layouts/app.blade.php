<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', 'Филми')</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-slate-50 text-slate-900">
        <nav class="border-b bg-white">
            <div class="mx-auto max-w-5xl px-4 py-4 flex items-center justify-between">
                <a href="{{ route('movies.index') }}" class="font-semibold">
                    Филми
                </a>

                <div class="text-sm text-slate-600">
                    @auth
                        {{ auth()->user()->name }}
                    @else
                        Гост
                    @endauth
                </div>
            </div>
        </nav>

        <main class="mx-auto max-w-5xl px-4 py-8">
            @if (session('status'))
                <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </main>
    </body>
</html>

