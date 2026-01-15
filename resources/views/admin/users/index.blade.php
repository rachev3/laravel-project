<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin · Users
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

            @if ($errors->has('user'))
                <div class="mb-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                    {{ $errors->first('user') }}
                </div>
            @endif

            <div class="mb-4 flex items-center justify-between gap-3">
                <div class="text-slate-600 text-sm">Общо: {{ $users->total() }}</div>
                <a href="{{ route('admin.users.create') }}" class="rounded bg-slate-900 px-4 py-2 text-white">
                    + Нов потребител
                </a>
            </div>

            <div class="overflow-x-auto rounded border bg-white">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-slate-700">
                        <tr>
                            <th class="px-4 py-3 text-left">Потребител</th>
                            <th class="px-4 py-3 text-left">Email</th>
                            <th class="px-4 py-3 text-left">Role</th>
                            <th class="px-4 py-3 text-right">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($users as $user)
                            <tr>
                                <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $user->email }}</td>
                                <td class="px-4 py-3">
                                    @if ($user->is_admin)
                                        <span class="rounded bg-slate-900 px-2 py-1 text-xs text-white">admin</span>
                                    @else
                                        <span class="rounded bg-slate-100 px-2 py-1 text-xs text-slate-700">user</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="rounded border px-3 py-1 hover:border-slate-400">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">
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
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

