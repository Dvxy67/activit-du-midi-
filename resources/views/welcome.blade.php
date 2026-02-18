<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Site Activités</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: Figtree, ui-sans-serif, system-ui, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }

        .logo {
            margin-bottom: 2rem;
        }

        .logo svg {
            width: 48px;
            height: 48px;
            color: #6b7280;
        }

        .card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
        }

        .description {
            color: #6b7280;
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            padding: 0.625rem 1rem;
            text-decoration: none;
            transition: all 0.15s ease-in-out;
        }

        .btn-primary {
            background-color: #1f2937;
            color: white;
        }

        .btn-primary:hover {
            background-color: #374151;
        }

        .btn-secondary {
            background-color: white;
            color: #6b7280;
            border: 1px solid #d1d5db;
        }

        .btn-secondary:hover {
            background-color: #f9fafb;
            color: #374151;
        }

        .divider {
            margin: 1.5rem 0;
            text-align: center;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background-color: #e5e7eb;
        }

        .divider span {
            background-color: white;
            color: #9ca3af;
            padding: 0 1rem;
            font-size: 0.875rem;
        }

        .auth-links {
            margin-top: 1.5rem;
            font-size: 0.875rem;
        }

        .auth-links a {
            color: #6b7280;
            text-decoration: none;
        }

        .auth-links a:hover {
            color: #374151;
            text-decoration: underline;
        }

        .dashboard-card {
            text-align: center;
        }

        .dashboard-card .title {
            color: #059669;
        }

        .welcome-back {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>
    <div class="logo">
        <x-application-logo style="width: 48px; height: 48px; color: #6b7280;" />
    </div>

    <div class="card">
        @guest
        <h1 class="title">Site Activités</h1>
        <p class="description">
            Plateforme d'inscription aux activités hebdomadaires.
            Connectez-vous pour découvrir et participer aux événements.
        </p>

        <div class="button-group">
            <a href="{{ route('register') }}" class="btn btn-primary">
                Créer un compte
            </a>
            <a href="{{ route('login') }}" class="btn btn-secondary">
                Se connecter
            </a>
        </div>
        @else
        <div class="dashboard-card">
            <h1 class="title">Bon retour !</h1>
            <p class="welcome-back">
                Vous êtes connecté en tant que <strong>{{ Auth::user()->name }}</strong>
            </p>

            <div class="button-group">
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    Accéder au tableau de bord
                </a>

                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary" style="width: 100%; border: none;">
                        Se déconnecter
                    </button>
                </form>
            </div>
        </div>
        @endguest
    </div>
</body>

</html>