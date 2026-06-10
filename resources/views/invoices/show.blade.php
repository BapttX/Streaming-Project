@extends('layouts.main')

@section('content')
<div class="w-full max-w-xl mx-auto py-8">
    
    <a href="/dashboard" class="text-zinc-400 hover:text-white font-bold text-sm mb-6 inline-flex items-center gap-2 transition">
        <i class="fa-solid fa-arrow-left text-xs"></i> Retour au tableau de bord
    </a>

    <div class="bg-[#181818] border border-zinc-800 rounded-2xl shadow-2xl p-8 flex flex-col relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-500"></div>

        <div class="flex justify-between items-start border-b border-zinc-800 pb-6 mt-2">
            <div>
                <h1 class="text-2xl font-black text-white tracking-tight">REÇU 10<span class="text-indigo-400">H</span></h1>
                <p class="text-xs text-zinc-500 mt-1 font-mono">ID de transaction : #<span id="facture-id">...</span></p>
            </div>
            <div class="text-right">
                <span class="bg-indigo-600/10 text-indigo-400 border border-indigo-500/20 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Payé</span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 py-6 border-b border-zinc-800 text-sm">
            <div>
                <div class="text-zinc-500 font-bold uppercase text-xs tracking-wider">Date d'achat</div>
                <div id="facture-date" class="text-white font-medium mt-1">...</div>
            </div>
            <div class="text-right">
                <div class="text-zinc-500 font-bold uppercase text-xs tracking-wider">Destinataire</div>
                <div id="facture-client" class="text-white font-medium mt-1">...</div>
            </div>
        </div>

        <div class="py-6 flex flex-col gap-4">
            <div class="text-zinc-500 font-bold uppercase text-xs tracking-wider mb-1">Articles achetés</div>
            <div id="facture-articles" class="flex flex-col gap-3">
                </div>
        </div>

        <div class="border-t border-zinc-800 pt-6 mt-4 flex justify-between items-baseline">
            <span class="text-base font-bold text-white">Montant Total</span>
            <span id="facture-total" class="text-3xl font-black text-indigo-400">0,00 €</span>
        </div>
        
        <div class="text-center text-zinc-600 text-xs mt-10 border-t border-dashed border-zinc-800 pt-6">
            Merci pour ton achat sur 10H !<br>
            Ce document fait office de preuve de propriété de la licence d'écoute numérique.
        </div>
    </div>
</div>

<script>
    const id = window.location.pathname.split('/').pop();
    const token = localStorage.getItem('api_token');

    if (!token) {
        window.location.href = '/login';
    } else {
        fetch('/api/factures/' + id, {
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })
        .then(res => {
            if (!res.ok) throw new Error("Facture introuvable");
            return res.json();
        })
        .then(f => {
            document.getElementById('facture-id').textContent = f.id;
            
            const dateObj = new Date(f.created_at);
            document.getElementById('facture-date').textContent = dateObj.toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' });
            
            document.getElementById('facture-client').textContent = f.user ? (f.user.name || `${f.user.prenom} ${f.user.nom}`) : "Client 10H";
            
            document.getElementById('facture-total').textContent = parseFloat(f.montant).toFixed(2) + ' €';

            if (f.musiques && f.musiques.length > 0) {
                document.getElementById('facture-articles').innerHTML = f.musiques.map(m => {
                    const prixUnitaire = m.pivot && m.pivot.prix_unitaire ? parseFloat(m.pivot.prix_unitaire) : parseFloat(m.prix);
                    
                    return `
                        <div class="flex justify-between items-center text-sm">
                            <div class="truncate pr-4">
                                <span class="font-bold text-white">${m.nomMusique}</span>
                            </div>
                            <span class="font-mono text-zinc-300 flex-shrink-0">${prixUnitaire.toFixed(2)} €</span>
                        </div>
                    `;
                }).join('');
            }
        })
        .catch(err => {
            console.error(err);
            window.location.href = '/dashboard';
        });
    }
</script>
@endsection