<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    /** @use HasFactory<\Database\Factories\FactureFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'montant_total'];

    /**
     * La facture appartient à un utilisateur
     * - Renvoie l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Une facture contient une ou plusieurs musiques achetées
     * - Renvoie ces musiques
     */
    public function musiques()
    {
        return $this->belongsToMany(Musique::class)->withPivot('prix_unitaire');
    }
}
