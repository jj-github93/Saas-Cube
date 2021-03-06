<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'protected', 'user_id'
    ];

    public function tracks()
    {
        return $this->belongsToMany(Tracks::class, 'playlist_track',
            'playlist_id', 'track_id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
