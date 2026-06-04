<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>10H</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <nav class="bg-gray-900 text-white p-4 shadow-md flex justify-between items-center">
        <a href="/dashboard" class="text-xl font-bold tracking-wider">10<span class="text-indigo-500">H</span></a>
        <div id="auth-menu">
            </div>
    </nav>

    <main class="flex-grow container mx-auto p-6 flex justify-center items-center">
        @yield('content')
    </main>

    <script>
        async function logout() {
            const token = localStorage.getItem('api_token');
            if (token) {
                await fetch('/api/logout', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });
            }
            localStorage.removeItem('api_token');
            window.location.href = '/login';
        }

        if (localStorage.getItem('api_token')) {
            document.getElementById('auth-menu').innerHTML = `
                <button onclick="logout()" class="text-sm font-semibold text-gray-300 hover:text-white transition">Déconnexion</button>
            `;
        }
    </script>
</body>
</html>