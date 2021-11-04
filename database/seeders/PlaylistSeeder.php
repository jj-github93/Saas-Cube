<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Playlist;

class PlaylistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $playlists = [
            [
                'name' => 'Private Astronaut Playlist',
                'user_id' => 6
            ],
            [
                'name' => 'Public Astronaut Playlist',
                'user_id' => 6,
                'protected' => 0,
            ],
            [
                'name' => 'Private Admin Playlist',
                'user_id' => 1
            ],
            [
                'name' => 'Public Admin Playlist',
                'user_id' => 1,
                'protected' => 0,
            ],

            [
                'name' => 'Private Manager Playlist',
                'user_id' => 5,
            ],
            [
                'name' => 'Public Manager Playlist',
                'user_id' => 5,
                'protected' => 0,
            ],
        ];

        foreach ($playlists as $playlist) {
            Playlist::create($playlist);
        }
    }
}
