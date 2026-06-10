@extends('layouts.main')

@section('content')
<div class="w-full max-w-5xl mx-auto mt-8">
    <a href="/dashboard" class="text-zinc-400 hover:text-white font-bold text-sm mb-8 inline-flex items-center gap-2 transition">
        <i class="fa-solid fa-arrow-left text-xs"></i> Retour
    </a>

    <div id="playlist-header" class="flex flex-col md:flex-row items-end gap-8 mb-12">
        </div>

    <div class="bg-[#181818] border border-zinc-800 rounded-2xl shadow-2xl p-4">
        <table class="w-full text-left text-zinc-400">
            <thead class="border-b border-zinc-800 text-xs uppercase tracking-wider">
                <tr>
                    <th class="p-4 w-12 text-center">#</th>
                    <th class="p-4">Titre</th>
                    <th class="p-4 text-right"><i class="fa-regular fa-clock"></i></th>
                </tr>
            </thead>
            <tbody id="tracks-list">
                </tbody>
        </table>
    </div>
</div>

<script>
    const id = window.location.pathname.split('/').pop();
    const token = localStorage.getItem('api_token');

    if (!token) window.location.href = '/login';

    fetch('/api/playlists/' + id, {
        headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
        }
    })
    .then(res => {
        if(!res.ok) throw new Error("Playlist introuvable ou accès refusé");
        return res.json();
    })
    .then(playlist => {
        document.getElementById('playlist-header').innerHTML = `
            <div class="w-64 h-64 shadow-2xl rounded-2xl flex items-center justify-center bg-gradient-to-br from-indigo-900 to-black border border-zinc-800">
                <i class="fa-solid fa-music text-6xl text-indigo-500/50"></i>
            </div>
            <div class="flex flex-col gap-2">
                <span class="text-xs font-bold uppercase tracking-widest text-indigo-400">Playlist Privée</span>
                <h1 class="text-5xl md:text-7xl font-black mb-2 text-white">${playlist.nomPlaylist}</h1>
                <span class="text-zinc-400 font-medium">${playlist.musiques ? playlist.musiques.length : 0} titres</span>
            </div>
        `;

        if(playlist.musiques && playlist.musiques.length > 0) {
            document.getElementById('tracks-list').innerHTML = playlist.musiques.map((m, i) => `
                <tr class="hover:bg-zinc-800/50 group transition cursor-pointer" onclick="location.href='/musiques/${m.id}'">
                    <td class="p-4 text-center font-mono text-zinc-500 group-hover:text-white">${i + 1}</td>
                    <td class="p-4">
                        <div class="text-white font-bold group-hover:text-indigo-400 transition">${m.nomMusique}</div>
                    </td>
                    <td class="p-4 text-right font-mono text-zinc-500">
                        ${m.duree ? parseFloat(m.duree).toFixed(2).replace('.', ':') : '0:00'}
                    </td>
                </tr>
            `).join('');
        } else {
            document.getElementById('tracks-list').innerHTML = `<tr><td colspan="3" class="p-8 text-center text-zinc-500 italic">Cette playlist est vide. Va vite ajouter des sons !</td></tr>`;
        }
    })
    .catch(err => {
        console.error(err);
        window.location.href = '/dashboard';
    });
</script>
@endsection