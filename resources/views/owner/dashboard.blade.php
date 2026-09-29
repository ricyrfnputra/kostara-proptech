<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Owner - Kostara</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-xl mx-auto bg-white rounded-lg shadow p-6">
        <h1 class="text-xl font-bold mb-2">Dashboard Owner</h1>
        <p>Halo, <strong>{{ auth()->user()->name }}</strong></p>
        <p class="text-gray-500 mb-4">Role: {{ auth()->user()->role }}</p>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white rounded px-4 py-2">
                Logout
            </button>
        </form>
    </div>
</body>
</html>