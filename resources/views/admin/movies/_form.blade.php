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

<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-slate-700">Заглавие</label>
        <input
            type="text"
            name="title"
            value="{{ old('title', $movie->title ?? '') }}"
            class="mt-1 w-full rounded border-slate-300"
            required
        />
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700">Година</label>
        <input
            type="number"
            name="year"
            value="{{ old('year', $movie->year ?? '') }}"
            class="mt-1 w-full rounded border-slate-300"
            min="1888"
            max="2100"
        />
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700">Жанрове</label>
        @php
            $selected = collect(old('genre_ids', isset($movie) ? $movie->genres->pluck('id')->all() : []))->map(fn ($v) => (int) $v)->all();
        @endphp
        <select name="genre_ids[]" multiple class="mt-1 w-full rounded border-slate-300">
            @foreach ($genres as $g)
                <option value="{{ $g->id }}" @selected(in_array($g->id, $selected, true))>{{ $g->name }}</option>
            @endforeach
        </select>
        <div class="mt-1 text-xs text-slate-500">Ctrl/⌘ за избор на повече жанрове.</div>
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700">Описание</label>
        <textarea
            name="description"
            rows="6"
            class="mt-1 w-full rounded border-slate-300"
        >{{ old('description', $movie->description ?? '') }}</textarea>
    </div>
</div>

