<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracks extends Model
{
    use Hasfactory;
    protected $fillable = [
        'name', 'artist', 'album', 'genre', 'track_number', 'length', 'year'
    ];

    public function Genre(){
        return $this->belongsTo(Genre::class);
    }
}
