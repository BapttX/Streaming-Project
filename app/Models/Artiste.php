<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artiste extends Model
{
    /** @use HasFactory<\Database\Factories\ArtisteFactory> */
    use HasFactory;

    /**
     * Un artiste a plusieurs albums
     * - Renvoie ces albums
     */
    public function albums() {
        return $this->hasMany(Album::class);
    }

    /**
     * Un artiste peut être présent sur plusieurs musiques
     * - Renvoie ces musiques
     */
    public function musiques() {
        return $this->belongsToMany(Musique::class);
    }
}
