<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin · New User
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @include('admin._nav')

            <div class="rounded border bg-white p-4">
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

                <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Име</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="mt-1 w-full rounded border-slate-300" required />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="mt-1 w-full rounded border-slate-300" required />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Парола</label>
                        <input type="password" name="password" class="mt-1 w-full rounded border-slate-300" required />
                        <div class="mt-1 text-xs text-slate-500">Минимум 8 символа.</div>
                    </div>

                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="is_admin" value="1" class="rounded border-slate-300" @checked(old('is_admin')) />
                        <span>Admin</span>
                    </label>

                    <div class="flex items-center gap-2">
                        <button class="rounded bg-slate-900 px-4 py-2 text-white">Създай</button>
                        <a href="{{ route('admin.users.index') }}" class="rounded border px-4 py-2">Отказ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

