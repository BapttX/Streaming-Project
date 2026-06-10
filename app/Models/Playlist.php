<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    /** @use HasFactory<\Database\Factories\PlaylistFactory> */
    use HasFactory;

    protected $fillable = ['nomPlaylist', 'user_id'];
    
    /**
     * La playlist appartient à un utilisateur
     * - Renvoie l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Une playlist contient plusieurs musiques
     * - Renvoie ces musiques
     */
    public function musiques()
    {
        return $this->belongsToMany(Musique::class);
    }
}
