<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini LMS - @yield('title')</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body class="bg-gray-100">

    <!-- Barre de navigation -->
    <nav class="bg-white shadow mb-6">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="text-xl font-bold text-indigo-600">Mini LMS</a>
            <div class="flex gap-4">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('formations.index') }}" class="text-gray-600 hover:text-indigo-600">Formations</a>
                    <a href="{{ route('chapitres.index') }}" class="text-gray-600 hover:text-indigo-600">Chapitres</a>
                    <a href="{{ route('sous-chapitres.index') }}" class="text-gray-600 hover:text-indigo-600">Sous-chapitres</a>
                    <a href="{{ route('apprenants.index') }}" class="text-gray-600 hover:text-indigo-600">Apprenants</a>
                    <a href="{{ route('quiz.index') }}" class="text-gray-600 hover:text-indigo-600">Quiz</a>
                    <a href="{{ route('notes.index') }}" class="text-gray-600 hover:text-indigo-600">Notes</a>
                @else
                    <a href="{{ route('mes-formations') }}" class="text-gray-600 hover:text-indigo-600">Mes formations</a>
                    <a href="{{ route('mes-notes') }}" class="text-gray-600 hover:text-indigo-600">Mes notes</a>
                @endif
                <!-- Déconnexion -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-700">Déconnexion</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Messages de succès -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mb-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Messages d'erreur -->
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 mb-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Contenu principal -->
    <main class="max-w-7xl mx-auto px-4">
        @yield('content')
    </main>

</body>
</html>