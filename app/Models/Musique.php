<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Musique extends Model
{
    /** @use HasFactory<\Database\Factories\MusiqueFactory> */
    use HasFactory;

    /**
     * Une musique peut appartenir à un album
     * - Renvoie cet album, null s'il n'en a pas
     */
    public function album() {
        return $this->belongsTo(Album::class);
    }

    /**
     * Une musique peut contenir plusieurs artistes
     * - Renvoie ces artistes
     */
    public function artistes() {
        return $this->belongsToMany(Artiste::class);
    }

    /**
     * Une musique peut avoir plusieurs styles
     * - Renvoie ces styles
     */
    public function styles() {
        return $this->belongsToMany(Style::class);
    }
}
