@extends('layouts.main')

@section('content')
<div id="album-header" class="flex items-end gap-8 mb-12"></div>

<div class="bg-black/20 rounded-xl p-4">
    <table class="w-full text-left text-gray-400">
        <thead class="border-b border-gray-800 text-xs uppercase tracking-wider">
            <tr>
                <th class="p-4 w-12">#</th>
                <th class="p-4">Titre</th>
                <th class="p-4 text-right"><i class="fa-regular fa-clock"></i></th>
            </tr>
        </thead>
        <tbody id="tracks-list"></tbody>
    </table>
</div>

<script>
    const id = window.location.pathname.split('/').pop();
    fetch('/api/albums/' + id)
        .then(res => res.json())
        .then(album => {
            document.getElementById('album-header').innerHTML = `
                <img src="https://picsum.photos/seed/album${album.id}/300/300" class="w-64 h-64 shadow-2xl rounded-lg object-cover">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest">Album</span>
                    <h1 class="text-7xl font-black mb-4">${album.nomAlbum}</h1>
                    <a href="/artistes/${album.artiste.id}" class="text-xl font-bold hover:underline">${album.artiste.nomArtiste}</a>
                </div>
            `;

            document.getElementById('tracks-list').innerHTML = album.musiques.map((m, i) => `
                <tr class="hover:bg-white/10 group transition cursor-pointer" onclick="location.href='/musiques/${m.id}'">
                    <td class="p-4">${i + 1}</td>
                    <td class="p-4">
                        <div class="text-white font-medium">${m.nomMusique}</div>
                    </td>
                    <td class="p-4 text-right">3:45</td>
                </tr>
            `).join('');
        });
</script>
@endsection