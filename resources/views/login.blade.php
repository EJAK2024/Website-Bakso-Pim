<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin - Bakso Pim</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <nav class="bg-white py-4 sticky top-0 z-50 shadow-lg border-b border-gray-200">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <div class="text-xl sm:text-2xl font-bold">
                    <a href="/" class="flex items-center focus:outline-none focus:ring-0 focus:bg-transparent">
                        <img src="/images/logo.png" alt="Bakso Pim" class="inline-block h-10 w-10 sm:h-12 sm:w-12 object-cover rounded-full mr-2 shadow-md">
                        <span class="text-green-800" style="-webkit-text-stroke: 0.5px #166534; paint-order: stroke fill;">Bakso Pim</span>
                    </a>
                </div>
                <a href="/" class="font-medium text-gray-700 hover:text-green-700 transition-all duration-150 active:scale-95">
                    <i class="fas fa-arrow-left mr-1"></i>Kembali
                </a>
            </div>
        </div>
    </nav>

    <section class="flex-1 flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                    <i class="fas fa-lock text-2xl text-green-600"></i>
                </div>
                <h1 class="text-3xl font-bold text-green-700">Masuk Admin</h1>
                <p class="text-gray-500 mt-1">Silakan masuk untuk mengelola website</p>
            </div>

            <form method="POST" action="/login" class="bg-white rounded-xl shadow-lg p-8">
                @csrf

                @if ($errors->any())
                    <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start">
                        <i class="fas fa-exclamation-circle text-red-500 mt-0.5 mr-3"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                                <p class="text-red-600 text-sm">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mb-5">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <input type="email" name="dummy_email" id="dummy_email" tabindex="-1" class="absolute -left-[9999px]" aria-hidden="true">
                    <input type="email" name="email" id="email" placeholder="Masukkan email admin" required autofocus autocomplete="off" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <div class="mb-5">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" placeholder="Masukkan password" required autocomplete="new-password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <div class="mb-6 flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Ingat Saya</label>
                </div>

                <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-bold text-lg hover:bg-green-700 transition-all duration-150 active:scale-95 shadow-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login Admin
                </button>
            </form>
        </div>
    </section>

    <footer class="bg-green-900 text-white py-4">
        <div class="container mx-auto px-4 text-center text-sm">
            <p>&copy; 2026 Bakso Pim. Hak akses terbatas untuk admin.</p>
        </div>
    </footer>
</body>
</html>