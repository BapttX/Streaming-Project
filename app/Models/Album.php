<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    /** @use HasFactory<\Database\Factories\AlbumFactory> */
    use HasFactory;

    /**
     * Un album appartient à un artiste
     * - Renvoie l'artiste
     */
    public function artiste() {
        return $this->belongsTo(Artiste::class);
    }

    /**
     * Un album contient plusieurs musiques
     * - Renvoie ces musiques
     */
    public function musiques() {
        return $this->hasMany(Musique::class);
    }
}
