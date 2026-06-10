@extends('layouts.main')

@section('content')
<div class="w-full max-w-4xl mx-auto mt-12">
    <div id="alert-message" class="hidden p-4 rounded-lg mb-6 text-sm font-bold text-center border"></div>

    <div id="track-details" class="flex flex-col md:flex-row items-end gap-8">
        </div>
</div>

<script>
    const id = window.location.pathname.split('/').pop();
    const token = localStorage.getItem('api_token');

    fetch('/api/musiques/' + id)
        .then(res => res.json())
        .then(m => {
            const stylesText = (m.styles && m.styles.length > 0) 
                ? m.styles.map(s => s.libelle).join(' / ') 
                : 'Musique';

            const albumHtml = m.album 
                ? `<span class="text-gray-500">•</span> <a href="/albums/${m.album.id}" class="text-zinc-400 hover:underline font-semibold">${m.album.nomAlbum}</a>` 
                : `<span class="text-gray-500">•</span> <span class="text-zinc-500 italic">Single</span>`;

            const artistesHtml = (m.artistes && m.artistes.length > 0)
                ? m.artistes.map(a => `<a href="/artistes/${a.id}" class="hover:underline text-white font-bold">${a.nomArtiste}</a>`).join(', ')
                : 'Artiste inconnu';

            const prixFlottant = parseFloat(m.prix);
            let boutonAchat = '';
            
            if (token) {
                boutonAchat = prixFlottant > 0 
                    ? `<button onclick="acheterMusique()" class="mt-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black px-6 py-3 rounded-full transition transform hover:scale-105 shadow-lg shadow-indigo-600/20 text-sm">
                        Acheter pour ${prixFlottant.toFixed(2)} €
                       </button>`
                    : `<span class="mt-4 inline-block bg-zinc-800 text-emerald-400 font-bold px-4 py-2 rounded-full text-xs uppercase tracking-wider border border-emerald-500/20">
                        <i class="fa-solid fa-cloud-download mr-1"></i> Titre Gratuit
                       </span>`;
            }

            document.getElementById('track-details').innerHTML = `
                <img src="https://picsum.photos/seed/${m.id}/300/300" class="w-64 h-64 shadow-2xl rounded-2xl object-cover border border-zinc-800">
                <div class="flex flex-col gap-2 items-start flex-grow">
                    <span class="text-xs uppercase font-bold tracking-widest text-indigo-400">${stylesText}</span>
                    <h1 class="text-4xl md:text-6xl font-black mb-2 text-white">${m.nomMusique}</h1>
                    <div class="flex items-center gap-2 text-lg text-zinc-300">
                        <span>Par ${artistesHtml}</span>
                        ${albumHtml}
                    </div>
                    ${boutonAchat}
                </div>
            `;
        })
        .catch(err => console.error("Erreur lors du chargement de la musique :", err));

    function acheterMusique() {
        const alertDiv = document.getElementById('alert-message');
        
        fetch('/api/factures', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({ musique_id: id })
        })
        .then(async response => {
            const data = await response.json();
            
            alertDiv.classList.remove('hidden', 'bg-emerald-500/10', 'text-emerald-400', 'border-emerald-500/20', 'bg-red-500/10', 'text-red-400', 'border-red-500/20');
            
            if (response.status === 201) {
                alertDiv.innerHTML = `<i class="fa-solid fa-circle-check mr-2"></i> ${data.message} ! Retrouve ton reçu sur ton tableau de bord.`;
                alertDiv.classList.add('bg-emerald-500/10', 'text-emerald-400', 'border-emerald-500/20');
            } else {
                alertDiv.innerHTML = `<i class="fa-solid fa-triangle-exclamation mr-2"></i> ${data.message || "Erreur lors de l'achat."}`;
                alertDiv.classList.add('bg-red-500/10', 'text-red-400', 'border-red-500/20');
            }
        })
        .catch(err => {
            console.error(err);
            alertDiv.innerHTML = "Impossible de joindre le serveur de paiement.";
            alertDiv.classList.remove('hidden');
            alertDiv.classList.add('bg-red-500/10', 'text-red-400', 'border-red-500/20');
        });
    }
</script>
@endsection