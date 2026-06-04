@extends('layouts.main')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Bon retour !</h2>
    
    <div id="error-msg" class="hidden mb-4 p-3 bg-red-100 text-red-700 rounded text-sm"></div>

    <input type="email" id="email" placeholder="Adresse email" class="w-full mb-4 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
    <input type="password" id="password" placeholder="Mot de passe" class="w-full mb-6 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
    
    <button onclick="handleLogin()" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg transition duration-200">Se connecter</button>
    
    <p class="mt-6 text-center text-sm text-gray-600">Nouveau ici ? <a href="/register" class="text-indigo-600 font-bold hover:underline">Créer un compte</a></p>
</div>

<script>
    if(localStorage.getItem('api_token')) window.location.href = '/dashboard';

    async function handleLogin() {
        const data = {
            email: document.getElementById('email').value,
            password: document.getElementById('password').value
        };

        const response = await fetch('/api/login', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if(response.ok) {
            localStorage.setItem('api_token', result.token);
            window.location.href = '/dashboard';
        } else {
            const err = document.getElementById('error-msg');
            err.textContent = result.message || "Identifiants incorrects";
            err.classList.remove('hidden');
        }
    }
</script>
@endsection