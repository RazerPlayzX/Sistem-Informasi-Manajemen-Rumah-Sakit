<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Dokter - SIMRS Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-900 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-3xl shadow-2xl max-w-md w-full border border-slate-100">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-sky-100 text-sky-600 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl">
                <i class="fa-solid fa-user-md"></i>
            </div>
            <h1 class="text-xl font-bold text-slate-800">Otentikasi Dokter SIMRS</h1>
            <p class="text-xs text-slate-400 mt-1">Silakan masukkan email klinis untuk masuk ke sistem</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-3 rounded-xl text-xs font-medium mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Email Dokter</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="dokter@simrs.com" class="w-full p-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-sky-100 outline-none transition" required>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Kata Sandi</label>
                <input type="password" name="password" placeholder="••••••••" class="w-full p-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-sky-100 outline-none transition" required>
            </div>
            <button type="submit" class="w-full bg-sky-600 text-white py-3.5 rounded-xl font-semibold hover:bg-sky-700 active:scale-[0.99] transition text-sm shadow-md shadow-sky-100">
                Masuk ke Sistem Portal Medis
            </button>
        </form>
    </div>
</body>
</html>