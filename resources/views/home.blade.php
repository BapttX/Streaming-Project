@extends('layouts.main')

@section('content')
<h2 class="text-2xl font-bold mb-8">Découvrir</h2>

<div id="musiques-grid" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
    </div>

<script>
    fetch('/api/musiques')
        .then(res => res.json())
        .then(musiques => {
            const grid = document.getElementById('musiques-grid');
            grid.innerHTML = musiques.map(m => `
                <div class="spotify-card p-4 rounded-lg cursor-pointer group">
                    <div class="relative mb-4">
                        <img src="https://picsum.photos/seed/${m.id}/300/300" class="w-full aspect-square object-cover rounded-md shadow-lg" onerror="this.src='https://picsum.photos/300/300'">
                        <button onclick="location.href='/musiques/${m.id}'" class="absolute bottom-2 right-2 w-12 h-12 bg-indigo-500 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all translate-y-2 group-hover:translate-y-0 shadow-xl">
                            <i class="fa-solid fa-play text-black text-xl"></i>
                        </button>
                    </div>
                    <a href="/musiques/${m.id}" class="font-bold block truncate hover:underline">${m.nomMusique}</a>
                    <div class="text-sm text-gray-400 mt-1">
                        ${m.artistes.map(a => `<a href="/artistes/${a.id}" class="hover:underline">${a.nomArtiste}</a>`).join(', ')}
                    </div>
                </div>
            `).join('');
        });
</script>
@endsection