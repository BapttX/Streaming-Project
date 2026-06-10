<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - 10H</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
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

    <div class="bg-[#181818] p-10 rounded-2xl shadow-2xl w-full max-w-md border border-gray-800 my-8">
        
        <div class="text-center mb-8">
            <a href="/" class="text-4xl font-black tracking-tighter">10<span class="text-indigo-500">H</span></a>
            <h1 class="text-2xl font-bold mt-4">Inscris-toi pour écouter</h1>
        </div>

        <div id="error-message" class="hidden bg-red-500/10 text-red-500 p-3 rounded mb-6 text-sm font-semibold text-center border border-red-500/20"></div>

        <form id="register-form" class="flex flex-col gap-4">
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold mb-2 text-gray-300">Prénom</label>
                    <input type="text" id="prenom" required class="spotify-input w-full p-3 rounded-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2 text-gray-300">Nom</label>
                    <input type="text" id="nom" required class="spotify-input w-full p-3 rounded-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold mb-2 text-gray-300">Quelle est ton adresse e-mail ?</label>
                <input type="email" id="email" required placeholder="test@example.com" class="spotify-input w-full p-3 rounded-sm">
            </div>

            <div>
                <label class="block text-sm font-bold mb-2 text-gray-300">Crée un mot de passe</label>
                <input type="password" id="password" required minlength="8" placeholder="8 caractères minimum" class="spotify-input w-full p-3 rounded-sm">
            </div>

            <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3.5 rounded-full mt-6 transition transform hover:scale-[1.02]">
                S'inscrire
            </button>
        </form>

        <hr class="border-gray-800 my-8">

        <div class="text-center text-gray-400 font-semibold">
            Tu as déjà un compte ? 
            <a href="/login" class="text-white hover:text-indigo-400 hover:underline transition">Connecte-toi ici</a>
        </div>

    </div>

    <script>
        document.getElementById('register-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const prenom = document.getElementById('prenom').value;
            const nom = document.getElementById('nom').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const errorDiv = document.getElementById('error-message');
            const fullName = prenom + ' ' + nom;

            fetch('/api/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ name: fullName, email: email, password: password })
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                if (res.status === 200 || res.status === 201) { 
                    localStorage.setItem('api_token', res.body.token);
                    window.location.href = '/home';
                } else {
                    let errorMsg = res.body.message || "Erreur lors de l'inscription.";
                    if (res.body.errors) {
                        errorMsg = Object.values(res.body.errors).flat().join('<br>');
                    }
                    errorDiv.innerHTML = errorMsg;
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