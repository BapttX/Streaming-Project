<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Style;
use App\Models\Artiste;
use App\Models\Album;
use App\Models\Musique;
use App\Models\Playlist;
use App\Models\Facture;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory(10)->create();
        $styles = collect(['Rap', 'Drill', 'OST Jeu Vidéo', 'Électro', 'Pop', 'Classique'])->map(function ($nom) {
            return Style::create(['libelle' => $nom]);
        });
        $artistes = Artiste::factory(20)->create();
        $albums = Album::factory(15)->make()->each(function ($album) use ($artistes) {
            $album->artiste_id = $artistes->random()->id;
            $album->save();
        });

        Musique::factory(50)->make()->each(function ($musique) use ($albums, $artistes, $styles) {
            if (rand(1, 100) <= 75) { // 75% de chance d'être dans un album
                $musique->album_id = $albums->random()->id;
            }
            $musique->save();

            $musique->artistes()->attach($artistes->random(rand(1, 3))->pluck('id')); // On attache entre 1 et 3 artistes à la musique
            
            $musique->styles()->attach($styles->random(rand(1, 2))->pluck('id')); // On lui donne 1 ou 2 styles de musique
        });

        Playlist::factory(5)->make()->each(function ($playlist) use ($users) {
            $playlist->user_id = $users->random()->id;
            $playlist->save();

            $playlist->musiques()->attach(Musique::inRandomOrder()->take(rand(5, 15))->pluck('id')); // On met entre 5 et 15 musiques aléatoires dans la playlist
        });

        $musiquesPayantes = Musique::where('prix', '>', 0)->get();
        if ($musiquesPayantes->count() > 0) {
            Facture::factory(10)->make()->each(function ($facture) use ($users, $musiquesPayantes) {
                $facture->user_id = $users->random()->id;
                $facture->save();

                $facture->musiques()->attach($musiquesPayantes->random(rand(1, 4))->pluck('id')); // On simule l'achat d'entre 1 et 4 musiques
            });
        }
    }
}