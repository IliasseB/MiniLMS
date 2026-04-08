<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini LMS — Connexion</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md px-4">

        <!-- Logo / Titre -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-indigo-600">Mini LMS</h1>
            <p class="text-gray-400 mt-2 text-sm">Connectez-vous pour accéder à votre espace</p>
        </div>

        <!-- Carte de connexion -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            <!-- Erreurs de validation -->
            @if($errors->any())
                <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-6">
                    @foreach($errors->all() as $error)
                        <p class="text-red-600 text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Status session -->
            @if(session('status'))
                <div class="bg-green-50 border border-green-100 rounded-xl p-4 mb-6">
                    <p class="text-green-600 text-sm">{{ session('status') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-5">
                    <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">
                        Adresse email
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        placeholder="votre@email.fr"
                        required autofocus
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                </div>

                <!-- Mot de passe -->
                <div class="mb-5">
                    <label for="password" class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">
                        Mot de passe
                    </label>
                    <input id="password" type="password" name="password"
                        placeholder="••••••••"
                        required autocomplete="current-password"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                </div>

                <!-- Se souvenir de moi -->
                <div class="flex items-center justify-between mb-6">
                    <label for="remember_me" class="flex items-center gap-2 cursor-pointer">
                        <input id="remember_me" type="checkbox" name="remember"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-400">
                        <span class="text-sm text-gray-500">Se souvenir de moi</span>
                    </label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                <!-- Bouton connexion -->
                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-3 rounded-xl font-semibold text-sm hover:bg-indigo-700 transition">
                    Se connecter
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-gray-400 mt-6">© {{ date('Y') }} Mini LMS — Crée par Iliasse Bellouch</p>
    </div>

</body>
</html>