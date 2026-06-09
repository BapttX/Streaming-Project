<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - 10H</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #121212; color: white; }
        .spotify-input { 
            background-color: #121212; 
            border: 1px solid #404040; 
            color: white; 
        }
        .spotify-input:focus { 
            border-color: white; 
            outline: none; 
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="bg-[#181818] p-10 rounded-2xl shadow-2xl w-full max-w-md border border-gray-800">
        
        <div class="text-center mb-10">
            <a href="/" class="text-5xl font-black tracking-tighter">10<span class="text-indigo-500">H</span></a>
            <h1 class="text-2xl font-bold mt-6">Connecte-toi à 10H</h1>
        </div>

        <div id="error-message" class="hidden bg-red-500/10 text-red-500 p-3 rounded mb-6 text-sm font-semibold text-center border border-red-500/20"></div>

        <form id="login-form" class="flex flex-col gap-5">
            <div>
                <label class="block text-sm font-bold mb-2 text-gray-300">Adresse e-mail</label>
                <input type="email" id="email" required placeholder="test@example.com" class="spotify-input w-full p-3.5 rounded-sm transition">
            </div>

            <div>
                <label class="block text-sm font-bold mb-2 text-gray-300">Mot de passe</label>
                <input type="password" id="password" required placeholder="Mot de passe" class="spotify-input w-full p-3.5 rounded-sm transition">
            </div>

            <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3.5 rounded-full mt-4 transition transform hover:scale-[1.02]">
                Se connecter
            </button>
        </form>

        <hr class="border-gray-800 my-8">

        <div class="text-center text-gray-400 font-semibold">
            Pas encore de compte ? 
            <a href="/register" class="text-white hover:text-indigo-400 hover:underline transition">S'inscrire à 10H</a>
        </div>

    </div>

    <script>
        document.getElementById('login-form').addEventListener('submit', function(e) {
            e.preventDefault(); // Empêche la page de se recharger
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const errorDiv = document.getElementById('error-message');

            fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email: email, password: password })
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                if (res.status === 200) {
                    localStorage.setItem('api_token', res.body.token);
                    window.location.href = '/home';
                } else {
                    errorDiv.textContent = res.body.message || "Identifiants incorrects.";
                    errorDiv.classList.remove('hidden');
                }
            })
            .catch(err => {
                errorDiv.textContent = "Erreur de connexion au serveur.";
                errorDiv.classList.remove('hidden');
            });
        });
    </script>

</body>
</html>