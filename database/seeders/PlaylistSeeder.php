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
                'name' => 'Test Playlist',
                //'owner' => 2
            ],
            [
                'name' => 'Admin Playlist',
                //'owner' => 1,
            ],
        ];

        foreach ($playlists as $playlist) {
            Playlist::create($playlist);
        }
    }
}
