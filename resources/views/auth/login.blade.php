<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Kostara</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
    <div class="w-full max-w-sm bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-center mb-1">Kostara</h1>
        <p class="text-center text-gray-500 mb-6">Silakan login</p>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autofocus
                       class="w-full border border-gray-300 rounded px-3 py-2">
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium mb-1">Password</label>
                <input id="password" type="password" name="password" required
                       class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember"> Ingat saya
            </label>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium rounded py-2">
                Masuk
            </button>
        </form>
    </div>
</body>
</html>