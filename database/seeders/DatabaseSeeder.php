<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\Review;
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

        $admin = User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        $user1 = User::updateOrCreate(
            ['email' => 'maria@example.com'],
            [
                'name' => 'Maria Petrova',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );

        $user2 = User::updateOrCreate(
            ['email' => 'ivan@example.com'],
            [
                'name' => 'Ivan Dimitrov',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );

        $genres = [
            ['name' => 'Екшън', 'slug' => 'action'],
            ['name' => 'Драма', 'slug' => 'drama'],
            ['name' => 'Комедия', 'slug' => 'comedy'],
            ['name' => 'Научна фантастика', 'slug' => 'sci-fi'],
            ['name' => 'Трилър', 'slug' => 'thriller'],
            ['name' => 'Анимация', 'slug' => 'animation'],
            ['name' => 'Приключенски', 'slug' => 'adventure'],
            ['name' => 'Романтика', 'slug' => 'romance'],
            ['name' => 'Криминален', 'slug' => 'crime'],
            ['name' => 'Ужаси', 'slug' => 'horror'],
            ['name' => 'Фентъзи', 'slug' => 'fantasy'],
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
            [
                'title' => 'Стъклената улица',
                'year' => 2020,
                'description' => 'Криминален трилър за изчезване, което разкрива цяла мрежа от лъжи.',
                'genres' => ['crime', 'thriller'],
            ],
            [
                'title' => 'Сянката на моста',
                'year' => 2015,
                'description' => 'Детектив се връща в родния си град и намира старо дело, което никога не е било затворено.',
                'genres' => ['crime', 'drama'],
            ],
            [
                'title' => 'Писма от лятото',
                'year' => 2014,
                'description' => 'Романтика с лека комедийна нотка и много спомени.',
                'genres' => ['romance', 'comedy'],
            ],
            [
                'title' => 'Порталът на мъглата',
                'year' => 2021,
                'description' => 'Приключение и фентъзи: група приятели откриват портал към свят, който не трябва да съществува.',
                'genres' => ['fantasy', 'adventure'],
            ],
            [
                'title' => 'Звезден прах',
                'year' => 2013,
                'description' => 'Научна фантастика за колония, която губи връзка със Земята.',
                'genres' => ['sci-fi', 'drama'],
            ],
            [
                'title' => 'Последната експедиция',
                'year' => 2012,
                'description' => 'Приключенски филм за екип, който търси изгубен артефакт в планините.',
                'genres' => ['adventure', 'action'],
            ],
            [
                'title' => 'Къщата на хълма',
                'year' => 2019,
                'description' => 'Ужаси с бавно напрежение и тайна, която не иска да бъде разкрита.',
                'genres' => ['horror', 'thriller'],
            ],
            [
                'title' => 'Невидимият гост',
                'year' => 2018,
                'description' => 'Трилър за свидетел, който знае твърде много.',
                'genres' => ['thriller', 'crime'],
            ],
            [
                'title' => 'Сърце на зимата',
                'year' => 2017,
                'description' => 'Романтична драма за втори шанс.',
                'genres' => ['romance', 'drama'],
            ],
            [
                'title' => 'Островът на ветровете',
                'year' => 2016,
                'description' => 'Приключение на остров, където правилата са различни.',
                'genres' => ['adventure'],
            ],
            [
                'title' => 'Комета 9',
                'year' => 2024,
                'description' => 'Екшън/сай-фай за мисия, която трябва да отклони комета.',
                'genres' => ['sci-fi', 'action'],
            ],
            [
                'title' => 'Смелият пиксел',
                'year' => 2022,
                'description' => 'Анимация за малък герой в дигитален свят.',
                'genres' => ['animation', 'adventure'],
            ],
            [
                'title' => 'Шумът в тъмното',
                'year' => 2021,
                'description' => 'Ужаси за изоставено кино, в което нещо все още работи.',
                'genres' => ['horror'],
            ],
        ];

        $moviesByTitle = [];
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

            $moviesByTitle[$movie->title] = $movie;
        }

        // Примерни ревюта (съобразено с unique(movie_id, user_id))
        $reviewTemplates = [
            [
                'user' => $admin,
                'rating' => 9,
                'comment' => 'Много силен филм — добра атмосфера и отлично темпо.',
            ],
            [
                'user' => $user1,
                'rating' => 8,
                'comment' => 'Хареса ми историята и изпълнението. Бих гледала пак.',
            ],
            [
                'user' => $user2,
                'rating' => 7,
                'comment' => 'Добър, но на места предвидим. Все пак си заслужава.',
            ],
        ];

        $titlesForReviews = array_slice(array_keys($moviesByTitle), 0, 12);
        foreach ($titlesForReviews as $idx => $title) {
            $movie = $moviesByTitle[$title];

            foreach ($reviewTemplates as $tIdx => $tpl) {
                $baseRating = $tpl['rating'];
                $rating = max(1, min(10, $baseRating + (($idx + $tIdx) % 3) - 1)); // 1..10, леко разнообразие

                Review::updateOrCreate(
                    [
                        'movie_id' => $movie->id,
                        'user_id' => $tpl['user']->id,
                    ],
                    [
                        'rating' => $rating,
                        'comment' => $tpl['comment'],
                    ]
                );
            }
        }
    }
}
