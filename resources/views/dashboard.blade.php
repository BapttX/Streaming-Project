@extends('layouts.main')

@section('content')
<style>
    body {
        background-color: #121212 !important;
        color: #ffffff !important;
    }
    .dashboard-card {
        background-color: #181818;
        border: 1px solid #282828;
    }
    .spotify-input {
        background-color: #121212;
        border: 1px solid #404040;
        color: white;
    }
    .spotify-input:focus {
        border-color: #6366f1;
        outline: none;
    }
    .list-item-dark {
        background-color: #202020;
        border: 1px solid #2c2c2c;
        transition: all 0.2s ease;
    }
    .list-item-dark:hover {
        background-color: #282828;
        border-color: #404040;
    }
</style>

<div class="w-full max-w-4xl px-4 py-6">
    <div class="dashboard-card p-8 rounded-2xl shadow-xl mb-6 flex justify-between items-center">
        <div>
            <span class="text-xs uppercase font-bold tracking-widest text-indigo-400">Espace Personnel</span>
            <h1 class="text-3xl md:text-4xl font-black text-white mt-1 mb-2">Bienvenue, <span id="user-name" class="text-indigo-400">...</span></h1>
            <p class="text-zinc-400 text-sm font-medium">Connecté avec : <span id="user-email" class="font-mono text-indigo-300/80 bg-black/30 px-2 py-1 rounded"></span></p>
        </div>
        <div class="hidden md:block">
            <div class="w-16 h-16 bg-indigo-600/20 text-indigo-400 border border-indigo-500/30 rounded-full flex items-center justify-center text-2xl font-black shadow-inner" id="user-initials">
                </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <div class="dashboard-card p-6 rounded-2xl shadow-xl flex flex-col">
            <h3 class="text-xl font-bold text-white mb-4 flex items-center justify-between">
                <span><i class="fa-solid fa-music text-indigo-400 mr-2"></i>Mes Playlists</span>
                <span id="playlists-count" class="bg-indigo-600/20 text-indigo-400 border border-indigo-500/20 text-xs px-2.5 py-0.5 rounded-full font-bold">0</span>
            </h3>
            
            <form id="create-playlist-form" class="flex gap-2 mb-6">
                <input type="text" id="new-playlist-name" placeholder="Nom de ta nouvelle playlist..." required class="spotify-input p-3 rounded-lg flex-grow text-sm transition">
                <button type="submit" class="bg-indigo-600 text-white px-5 py-3 rounded-lg hover:bg-indigo-500 transition font-bold text-sm transform active:scale-95 shadow-lg shadow-indigo-600/20">
                    Créer
                </button>
            </form>

            <div id="playlists-container" class="flex flex-col gap-3 overflow-y-auto max-h-72 pr-1">
                <div class="text-center text-zinc-500 italic text-sm py-6">Chargement de tes playlists...</div>
            </div>
        </div>

        <div class="dashboard-card p-6 rounded-2xl shadow-xl flex flex-col">
            <h3 class="text-xl font-bold text-white mb-4">
                <i class="fa-solid fa-file-invoice-dollar text-indigo-400 mr-2"></i>Dernières Factures
            </h3>
            
            <div id="factures-container" class="flex flex-col gap-2 overflow-y-auto max-h-[380px] pr-1">
                <div class="text-center text-zinc-500 italic text-sm py-6">Chargement de tes factures...</div>
            </div>
        </div>

    </div>
</div>

<script>
    const token = localStorage.getItem('api_token');

    if (!token) {
        window.location.href = '/login';
    } else {
        const fetchOptions = {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        };

        fetch('/api/user', fetchOptions)
            .then(res => {
                if (!res.ok) throw new Error('Token invalide');
                return res.json();
            })
            .then(user => {
                const displayName = user.name || `${user.prenom} ${user.nom}`;
                document.getElementById('user-name').textContent = displayName;
                document.getElementById('user-email').textContent = user.email;
                document.getElementById('user-initials').textContent = displayName.charAt(0).toUpperCase();
                
                loadPlaylists();
                loadFactures();
            })
            .catch(() => {
                localStorage.removeItem('api_token');
                window.location.href = '/login';
            });

        function loadPlaylists() {
            fetch('/api/playlists', fetchOptions)
                .then(res => {
                    if (!res.ok) throw new Error("Erreur serveur API Playlists");
                    return res.json();
                })
                .then(playlists => {
                    const container = document.getElementById('playlists-container');
                    
                    if (!Array.isArray(playlists)) throw new Error("Format invalide reçu");

                    document.getElementById('playlists-count').textContent = playlists.length;
                    
                    if (playlists.length === 0) {
                        container.innerHTML = '<p class="text-zinc-500 italic text-sm text-center py-4">Tu n\'as pas encore créé de playlist.</p>';
                        return;
                    }

                    container.innerHTML = playlists.map(p => `
                        <div class="flex items-center justify-between p-3.5 list-item-dark rounded-xl group cursor-pointer">
                            <div>
                                <div class="font-bold text-white group-hover:text-indigo-400 transition mb-0.5">${p.nomPlaylist}</div>
                                <div class="text-xs text-zinc-400 font-medium"><i class="fa-solid fa-compact-disc text-zinc-500 mr-1"></i>${p.musiques ? p.musiques.length : 0} titre(s)</div>
                            </div>
                            <button class="w-8 h-8 bg-zinc-800 text-zinc-400 hover:text-indigo-400 hover:bg-zinc-700 rounded-full flex items-center justify-center transition shadow-md">
                                <i class="fa-solid fa-play text-xs pl-0.5"></i>
                            </button>
                        </div>
                    `).join('');
                })
                .catch(err => {
                    console.error("Bug Playlists:", err);
                    document.getElementById('playlists-container').innerHTML = '<p class="text-red-400 italic text-sm text-center py-4">Impossible de charger les playlists.</p>';
                    document.getElementById('playlists-count').textContent = "!";
                });
        }

        document.getElementById('create-playlist-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const nomInput = document.getElementById('new-playlist-name');
            
            fetch('/api/playlists', {
                method: 'POST',
                headers: fetchOptions.headers,
                body: JSON.stringify({ nomPlaylist: nomInput.value })
            })
            .then(res => {
                if (!res.ok) throw new Error("Erreur création playlist");
                return res.json();
            })
            .then(() => {
                nomInput.value = '';
                loadPlaylists(); 
            })
            .catch(err => console.error("Bug Création:", err));
        });

        function loadFactures() {
            fetch('/api/factures', fetchOptions)
                .then(res => {
                    if (!res.ok) throw new Error("Erreur serveur API Factures");
                    return res.json();
                })
                .then(factures => {
                    const container = document.getElementById('factures-container');
                    
                    if (!Array.isArray(factures) || factures.length === 0) {
                        container.innerHTML = '<p class="text-zinc-500 italic text-sm text-center py-4">Aucune facture disponible.</p>';
                        return;
                    }

                    container.innerHTML = factures.map(f => {
                        const dateObj = new Date(f.created_at);
                        const dateFormatee = dateObj.toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' });
                        
                        return `
                        <div class="flex items-center justify-between p-4 bg-zinc-900/50 border border-zinc-800/60 rounded-xl hover:bg-zinc-800/40 transition">
                            <div>
                                <div class="font-bold text-white">Facture #${f.id}</div>
                                <div class="text-xs text-zinc-400 mt-0.5"><i class="fa-regular fa-calendar text-zinc-500 mr-1"></i>${dateFormatee}</div>
                            </div>
                            <div class="text-right flex flex-col gap-1">
                                <div class="font-black text-indigo-400">${f.montant ? parseFloat(f.montant).toFixed(2) + ' €' : '0,00 €'}</div>
                                <a href="/factures/${f.id}" class="text-xs text-zinc-500 hover:text-white hover:underline transition">Détails <i class="fa-solid fa-chevron-right text-[10px] ml-0.5"></i></a>
                            </div>
                        </div>
                    `}).join('');
                })
                .catch(err => {
                    console.error("Bug Factures:", err);
                    document.getElementById('factures-container').innerHTML = '<p class="text-red-400 italic text-sm text-center py-4">Impossible de charger les factures.</p>';
                });
        }
    }
</script>
@endsection