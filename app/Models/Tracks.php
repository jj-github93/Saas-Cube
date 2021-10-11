<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracks extends Model
{
    use Hasfactory;

    protected $fillable = [
        'name', 'artist', 'album', 'genre_id', 'track_number', 'length', 'year'
    ];

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_track',
            'track_id', 'playlist_id');
    }
    public function genre(){
        return $this->belongsTo(Genre::class);
    }
}
