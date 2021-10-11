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
                'name' => 'Test Playlist'
            ],
            [
                'name' => 'Admin Playlist'
            ],
        ];

        foreach ($playlists as $playlist) {
            Playlist::create($playlist);
        }
    }
}
