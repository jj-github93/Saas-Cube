<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seedGenres = [
            [
                'id' => 1,
                'name' => 'Rock',
                'parent_id' => null,
                'icon' => '017-rock-guitar.png'
            ],
            [
                'id' => 2,
                'name' => 'Alternative',
                'parent_id' => 1,
                'icon' => '001-flash.png'
            ],
            [
                'name' => 'World',
                'parent_id' => null,
                'icon' => '022-world-.png'
            ],
            [
                'name' => 'Karaoke',
                'parent_id' => 3,
                'icon' => '009-karaoke.png'
            ],
            [
                'name' => 'Pop',
                'parent_id' => null,
                'icon' => '015-pop.png'
            ],
            [
                'name' => 'Easy Listening',
                'parent_id' => null,
                'icon' => '018-hat.png'
            ],
            [
                'name' => 'Metal',
                'parent_id' => 1,
                'icon' => '002-metal.png'
            ],
            [
                'name' => 'Latin',
                'parent_id' => 3,
                'icon' => '011-latin.png'
            ],
            [
                'name' => 'Children\'s',
                'parent_id' => 6,
                'icon' => '010-kids.png'
            ],
            [
                'name' => 'Supergroups',
                'parent_id' => 1,
                'icon' => '021-trendy.png'
            ],
            [
                'name' => 'Chill-out',
                'parent_id' => 6,
                'icon' => '005-focus.png'
            ],
            [
                'name' => 'Study',
                'parent_id' => 6,
                'icon' => '020-study.png'
            ],
            [
                'name' => 'Relaxation',
                'parent_id' => 6,
                'icon' => '019-sleep.png'
            ],
            [
                'name' => 'Choral',
                'parent_id' => 6,
                'icon' => '006-user.png'
            ],
            [
                'name' => 'Various',
                'parent_id' => 5,
                'icon' => '014-party.png'
            ],
            [
                'name' => 'Love',
                'parent_id' => 6,
                'icon' => '013-love.png'
            ],
            [
                'name' => 'Electronica',
                'parent_id' => 5,
                'icon' => '004-edm.png'
            ],
            [
                'name' => 'Dubstep',
                'parent_id' => 17,
                'icon' => '008-boom-box.png'
            ],
            [
                'name' => 'Funk',
                'parent_id' => 5,
                'icon' => '007-funk.png'
            ],
            [
                'name' => 'Wedding',
                'parent_id' => 6,
                'icon' => '003-wedding-dinner.png'
            ],
            [
                'name' => 'Elevator',
                'parent_id' => 17,
                'icon' => '012-amplify.png'
            ],
            [
                'name' => 'Folk',
                'parent_id' => null,
                'icon' => '016-genre.png'
            ],
            [
                'name' => 'Hip Hop',
                'parent_id' => null,
                'icon' => '17-hiphop.png'
            ]


        ];

        foreach ($seedGenres as $genre) {
            Genre::create($genre);
        }
    }
}
