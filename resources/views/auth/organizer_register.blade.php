<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Organizer - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-indigo-900 text-white min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white text-slate-900 rounded-4x1 p-8 shadow-2xl">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center text-white font-bold text-2xl mx-auto mb-4">AH</div>
            <h1 class="text-2xl font-black">Daftar Organizer</h1>
            <p class="text-slate-500">Buat akun organizer untuk mengelola organisasi Anda.</p>
        </div>

        @if($errors->any())
            <div class="bg-red-100 text-red-600 p-4 rounded-xl mb-6 font-bold text-sm">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('organizer.register.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Organisasi</label>
                <input type="text" name="organization_name" value="{{ old('organization_name') }}" class="w-full px-4 py-3 border rounded-lg" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Anda</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-3 border rounded-lg" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 border rounded-lg" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                <input type="password" name="password" class="w-full px-4 py-3 border rounded-lg" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full px-4 py-3 border rounded-lg" required>
            </div>
            <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded-lg font-bold">Buat Akun Organizer</button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-slate-400">Sudah punya akun? <a href="{{ route('organizer.login') }}" class="font-bold text-indigo-600">Masuk di sini</a></p>
        </div>
    </div>
</body>

</html>
