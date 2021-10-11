<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'parent_id', 'icon'
    ];

    protected $parentColumn = 'parent_id';

    function parent(){
        return $this->belongsTo(Genre::class, $this->parentColumn);
    }
    function tracks(){
        return $this->hasMany(Tracks::class);
    }
}
