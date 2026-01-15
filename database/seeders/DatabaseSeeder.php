<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        $genres = [
            ['name' => 'Екшън', 'slug' => 'action'],
            ['name' => 'Драма', 'slug' => 'drama'],
            ['name' => 'Комедия', 'slug' => 'comedy'],
            ['name' => 'Научна фантастика', 'slug' => 'sci-fi'],
            ['name' => 'Трилър', 'slug' => 'thriller'],
            ['name' => 'Анимация', 'slug' => 'animation'],
        ];

        foreach ($genres as $g) {
            Genre::updateOrCreate(['slug' => $g['slug']], $g);
        }

        $genreIdsBySlug = Genre::query()
            ->whereIn('slug', collect($genres)->pluck('slug')->all())
            ->pluck('id', 'slug');

        $movies = [
            [
                'title' => 'Нощна смяна',
                'year' => 2020,
                'description' => 'Един обикновен дежурен лекар попада в поредица от необясними случаи.',
                'genres' => ['thriller', 'drama'],
            ],
            [
                'title' => 'Код: Утре',
                'year' => 2022,
                'description' => 'Инженер открива, че бъдещето може да се симулира — но на каква цена?',
                'genres' => ['sci-fi', 'thriller'],
            ],
            [
                'title' => 'Последният кадър',
                'year' => 2019,
                'description' => 'Млад режисьор търси истината зад изчезването на стара филмова лента.',
                'genres' => ['drama'],
            ],
            [
                'title' => 'Смях до сълзи',
                'year' => 2018,
                'description' => 'Комедия за приятелство, което оцелява въпреки катастрофални планове.',
                'genres' => ['comedy'],
            ],
            [
                'title' => 'Синя орбита',
                'year' => 2021,
                'description' => 'Екипаж на мисия до далечна орбита получава сигнал, който променя всичко.',
                'genres' => ['sci-fi', 'action'],
            ],
            [
                'title' => 'Ритъм на града',
                'year' => 2017,
                'description' => 'Енергичен екшън с преследвания и музика в сърцето на нощния град.',
                'genres' => ['action'],
            ],
            [
                'title' => 'Малки герои',
                'year' => 2016,
                'description' => 'Анимация за смелостта да помогнеш, дори когато си най-малкият.',
                'genres' => ['animation', 'comedy'],
            ],
            [
                'title' => 'Тиха истина',
                'year' => 2023,
                'description' => 'Драма за изборите, които правим, когато никой не гледа.',
                'genres' => ['drama'],
            ],
        ];

        foreach ($movies as $m) {
            $movie = Movie::updateOrCreate(
                ['title' => $m['title'], 'year' => $m['year']],
                [
                    'description' => $m['description'],
                ]
            );

            $movie->genres()->sync(
                collect($m['genres'])
                    ->map(fn (string $slug) => $genreIdsBySlug[$slug] ?? null)
                    ->filter()
                    ->values()
                    ->all()
            );
        }
    }
}
