@extends('layouts.main')

@section('content')
<div id="track-details" class="flex flex-col md:flex-row items-end gap-8 mt-12">
    </div>

<script>
    const id = window.location.pathname.split('/').pop();
    fetch('/api/musiques/' + id)
        .then(res => res.json())
        .then(m => {
            
            const stylesText = (m.styles && m.styles.length > 0) 
                ? m.styles.map(s => s.libelle).join(' / ') 
                : 'Musique';

            const albumHtml = m.album 
                ? `<span class="text-gray-500">•</span> <a href="/albums/${m.album.id}" class="text-gray-300 hover:underline font-semibold">${m.album.nomAlbum}</a>` 
                : `<span class="text-gray-500">•</span> <span class="text-gray-400 italic">Single</span>`;

            const artistesHtml = (m.artistes && m.artistes.length > 0)
                ? m.artistes.map(a => `<a href="/artistes/${a.id}" class="hover:underline">${a.nomArtiste}</a>`).join(', ')
                : 'Artiste inconnu';

            document.getElementById('track-details').innerHTML = `
                <img src="https://picsum.photos/seed/${m.id}/300/300" class="w-64 h-64 shadow-2xl rounded-lg object-cover">
                <div class="flex flex-col gap-2">
                    <span class="text-xs uppercase font-bold tracking-widest text-indigo-400">${stylesText}</span>
                    <h1 class="text-6xl font-black mb-4">${m.nomMusique}</h1>
                    <div class="flex items-center gap-2 text-lg">
                        <span class="font-bold">${artistesHtml}</span>
                        ${albumHtml}
                    </div>
                </div>
            `;
        })
        .catch(err => console.error("Erreur lors du chargement de la musique :", err));
</script>
@endsection