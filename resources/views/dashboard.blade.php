@extends('layouts.main')

@section('content')
<div class="w-full max-w-4xl">
    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Bienvenue sur ton espace, <span id="user-name" class="text-indigo-600">...</span></h1>
        <p class="text-gray-500">Connecté avec : <span id="user-email" class="font-mono text-sm"></span></p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Mes Playlists</h3>
            <p class="text-gray-500 text-sm">Fonctionnalité à venir...</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Dernières Factures</h3>
            <p class="text-gray-500 text-sm">Fonctionnalité à venir...</p>
        </div>
    </div>
</div>

<script>
    const token = localStorage.getItem('api_token');

    if (!token) {
        window.location.href = '/login';
    } else {
        fetch('/api/user', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Token invalide');
            return response.json();
        })
        .then(user => {
            document.getElementById('user-name').textContent = user.name;
            document.getElementById('user-email').textContent = user.email;
        })
        .catch(() => {
            localStorage.removeItem('api_token');
            window.location.href = '/login';
        });
    }
</script>
@endsection