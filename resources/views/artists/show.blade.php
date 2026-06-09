@extends('layouts.main')

@section('content')
<div id="artist-header" class="h-64 flex flex-col justify-end p-8 rounded-3xl bg-gradient-to-t from-indigo-900 to-black mb-8">
    </div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
    <div>
        <h3 class="text-xl font-bold mb-6">Titres populaires</h3>
        <div id="popular-tracks" class="flex flex-col"></div>
    </div>
    <div>
        <h3 class="text-xl font-bold mb-6">Discographie</h3>
        <div id="artist-albums" class="grid grid-cols-2 gap-4"></div>
    </div>
</div>

<script>
    const id = window.location.pathname.split('/').pop();
    
    fetch('/api/artistes/' + id)
        .then(res => res.json())
        .then(artiste => {
            console.log("Données Artiste :", artiste);

            document.getElementById('artist-header').innerHTML = `
                <h1 class="text-6xl md:text-8xl font-black text-white drop-shadow-lg">${artiste.nomArtiste || 'Artiste inconnu'}</h1>
            `;

            if (artiste.albums && artiste.albums.length > 0) {
                document.getElementById('artist-albums').innerHTML = artiste.albums.map(a => `
                    <div onclick="location.href='/albums/${a.id}'" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-indigo-300 transition cursor-pointer group">
                        <img src="https://picsum.photos/seed/album${a.id}/150/150" class="rounded-lg mb-3 object-cover aspect-square w-full shadow-sm group-hover:shadow-md transition" onerror="this.src='https://picsum.photos/150/150'">
                        <div class="font-bold text-gray-800 truncate">${a.nomAlbum || 'Album'}</div>
                    </div>
                `).join('');
            } else {
                document.getElementById('artist-albums').innerHTML = '<p class="text-gray-500 italic">Aucun album pour le moment.</p>';
            }

            if (artiste.musiques && artiste.musiques.length > 0) {
                document.getElementById('popular-tracks').innerHTML = artiste.musiques.slice(0, 5).map((m, i) => `
                    <div onclick="location.href='/musiques/${m.id}'" class="flex items-center gap-4 p-3 hover:bg-gray-100 transition rounded-lg cursor-pointer group">
                        <span class="text-gray-400 font-bold w-6 text-right group-hover:text-indigo-500">${i + 1}</span>
                        <img src="https://picsum.photos/seed/${m.id}/50/50" class="w-12 h-12 rounded object-cover shadow-sm">
                        <span class="font-bold text-gray-800 flex-grow truncate group-hover:text-indigo-600 transition">${m.nomMusique}</span>
                        <span class="text-gray-500 text-sm">${m.duree ? parseFloat(m.duree).toFixed(2).replace('.', ':') : '0:00'}</span>
                    </div>
                `).join('');
            } else {
                document.getElementById('popular-tracks').innerHTML = '<p class="text-gray-500 italic">Aucun titre disponible.</p>';
            }
        })
        .catch(err => {
            console.error("Erreur lors du traitement JavaScript :", err); 
            document.getElementById('artist-header').innerHTML = `<h1 class="text-4xl text-red-500 font-bold">Erreur de chargement</h1>`;
        });
</script>
@endsection