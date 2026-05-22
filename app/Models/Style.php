<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    /** @use HasFactory<\Database\Factories\StyleFactory> */
    use HasFactory;

    /**
     * Un style peut représenter plusieurs musiques
     * - Renvoie ces musiques
     */
    public function musiques() {
        return $this->belongsToMany(Musique::class);
    }
}
