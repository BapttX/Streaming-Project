@extends('layouts.main')

@section('content')
<div id="track-details" class="flex flex-col md:flex-row items-end gap-8 mt-12">
    </div>

<script>
    const id = window.location.pathname.split('/').pop();
    fetch('/api/musiques/' + id)
        .then(res => res.json())
        .then(m => {
            document.getElementById('track-details').innerHTML = `
                <img src="https://via.placeholder.com/300" class="w-64 h-64 shadow-2xl rounded-lg">
                <div class="flex flex-col gap-2">
                    <span class="text-xs uppercase font-bold tracking-widest text-indigo-400">Musique • ${m.style.nom}</span>
                    <h1 class="text-6xl font-black mb-4">${m.titre}</h1>
                    <div class="flex items-center gap-2 text-lg">
                        <span class="font-bold">${m.artistes.map(a => `<a href="/artistes/${a.id}" class="hover:underline">${a.nom}</a>`).join(', ')}</span>
                        <span class="text-gray-500">•</span>
                        <a href="/albums/${m.album.id}" class="text-gray-300 hover:underline font-semibold">${m.album.nomProjet}</a>
                    </div>
                </div>
            `;
        });
</script>
@endsection