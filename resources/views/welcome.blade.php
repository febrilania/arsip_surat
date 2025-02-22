<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Surat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-3xl w-full bg-white shadow-lg rounded-2xl p-8">
            <h1 class="text-3xl font-bold text-center text-blue-600 mb-4">Selamat Datang di Arsip Surat</h1>
            <p class="text-center text-gray-600 mb-6">Kelola surat masuk dan keluar dengan mudah dan cepat.</p>

            <div class="flex justify-center gap-4">
                <a href="{{ route('login') }}" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">Masuk</a>
                <a href="{{ route('register') }}" class="px-6 py-3 bg-gray-300 text-gray-900 font-semibold rounded-lg hover:bg-gray-400 transition">Daftar</a>
            </div>
        </div>
    </div>
</body>

</html>