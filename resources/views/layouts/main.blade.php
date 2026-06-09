<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>10H - Streaming</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #121212; color: #white; }
        .spotify-card { background: #181818; transition: background 0.3s; }
        .spotify-card:hover { background: #282828; }
    </style>
</head>
<body class="text-white min-h-screen flex flex-col">

    <nav class="bg-black/90 sticky top-0 z-50 p-4 border-b border-gray-800 shadow-xl">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/home" class="text-2xl font-black tracking-tighter text-white">10<span class="text-indigo-500">H</span></a>
            
            <div id="nav-content" class="flex items-center gap-6">
                </div>
        </div>
    </nav>

    <main class="flex-grow container mx-auto p-6">
        @yield('content')
    </main>

    <script>
        const token = localStorage.getItem('api_token');
        const nav = document.getElementById('nav-content');

        if (token) {
            fetch('/api/user', {
                headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(user => {
                nav.innerHTML = `
                    <a href="/dashboard" class="flex items-center gap-2 hover:text-indigo-400 transition">
                        <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-xs font-bold">
                            ${user.name[0]}
                        </div>
                        <span class="hidden md:inline font-semibold">${user.name}</span>
                    </a>
                    <button onclick="logout()" class="text-gray-400 hover:text-white text-sm">Déconnexion</button>
                `;
            });
        } else {
            nav.innerHTML = `
                <a href="/login" class="text-gray-300 hover:text-white font-semibold">Connexion</a>
                <a href="/register" class="bg-white text-black px-6 py-2 rounded-full font-bold hover:scale-105 transition transform">S'inscrire</a>
            `;
        }

        function logout() {
            localStorage.removeItem('api_token');
            window.location.href = '/login';
        }
    </script>
</body>
</html>