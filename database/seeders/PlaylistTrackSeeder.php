<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Playlist;
use App\Models\Tracks;
use Illuminate\Support\Facades\DB;

class PlaylistTrackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $playlistOne = Playlist::find(1);
        $playlistTwo = Playlist::find(2);
        $playlistThree = Playlist::find(3);


        $tracksOne = [
            1, 2, 3, 4, 5, 6, 7, 8, 9,
        ];
        $tracksTwo = [
            11, 12, 13, 14, 15, 17
        ];
        $tracksThree = [
            18, 21, 23, 24, 25, 26, 27, 28, 29
        ];

        $playlistOne->tracks()->attach($tracksOne);

        $playlistTwo->tracks()->attach($tracksTwo);

        $playlistThree->tracks()->attach($tracksThree);


    }
}
