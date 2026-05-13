<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CRUD Sample')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="max-w-5xl mx-auto px-4 py-8">
        <header class="mb-8">
            <h1 class="text-3xl font-bold">CRUD Sample</h1>
            <p class="text-sm text-gray-600">Contoh sederhana Create, Read, Update, Delete untuk belajar Laravel.</p>
        </header>

        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-100 border border-green-200 text-green-700 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
