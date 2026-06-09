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
            document.getElementById('artist-header').innerHTML = `
                <h1 class="text-8xl font-black">${artiste.nom}</h1>
            `;

            document.getElementById('artist-albums').innerHTML = artiste.albums.map(a => `
                <div onclick="location.href='/albums/${a.id}'" class="spotify-card p-4 rounded-lg cursor-pointer">
                    <img src="https://via.placeholder.com/150" class="rounded mb-2">
                    <div class="font-bold truncate">${a.nomProjet}</div>
                </div>
            `).join('');

            // On récupère toutes les musiques de tous ses albums pour les afficher
            const allTracks = artiste.albums.flatMap(a => a.musiques);
            document.getElementById('popular-tracks').innerHTML = allTracks.slice(0, 5).map((t, i) => `
                <div onclick="location.href='/musiques/${t.id}'" class="flex items-center gap-4 p-3 hover:bg-white/5 rounded-lg cursor-pointer">
                    <span class="text-gray-500 w-4">${i+1}</span>
                    <span class="font-bold flex-grow">${t.titre}</span>
                </div>
            `).join('');
        });
</script>
@endsection