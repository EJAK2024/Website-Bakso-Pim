<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak - Bakso Pim</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col items-center justify-center px-4">
    <div class="text-center">
        <div class="mb-6">
            <i class="fas fa-lock text-6xl text-red-400"></i>
        </div>
        <h1 class="text-6xl font-bold text-gray-800 mb-4">403</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-2">Akses Ditolak</h2>
        <p class="text-gray-500 mb-8 max-w-md mx-auto">
            Anda tidak memiliki izin untuk mengakses halaman ini. Hanya admin yang dapat mengakses panel administrasi.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/" class="inline-flex items-center justify-center px-6 py-3 bg-green-700 text-white font-medium rounded-lg hover:bg-green-800 transition-all duration-150 active:scale-95">
                <i class="fas fa-home mr-2"></i>Kembali ke Beranda
            </a>
            @auth
                <form method="POST" action="/logout" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-red-500 text-white font-medium rounded-lg hover:bg-red-600 transition-all duration-150 active:scale-95 w-full">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            @endauth
        </div>
    </div>
</body>
</html>
