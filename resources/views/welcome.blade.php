<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Le Foyer Anderlechtois — Activités</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --color-primary: #252f32;
            --color-accent: #6765ff;
            --color-text: #1f2937;
            --color-text-muted: #6b7280;
            --color-bg: #f0f1f5;
            --color-card: #ffffff;
            --color-border: #e5e7eb;
        }

        body {
            font-family: 'DM Sans', ui-sans-serif, system-ui, sans-serif;
            background-color: var(--color-bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem 1rem;
            position: relative;
            overflow: hidden;
        }

        /* Fond subtil avec motif */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(ellipse at 20% 50%, rgba(103, 101, 255, 0.06) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(103, 101, 255, 0.04) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 100%, rgba(37, 47, 50, 0.03) 0%, transparent 40%);
            pointer-events: none;
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 420px;
            animation: fadeUp 0.6s ease-out both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Logo */
        .logo {
            margin-bottom: 2.5rem;
            animation: fadeUp 0.6s ease-out 0.1s both;
        }

        .logo svg {
            width: 140px;
            height: 140px;
            filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.06));
        }

        /* Card */
        .card {
            background: var(--color-card);
            border-radius: 1rem;
            box-shadow:
                0 1px 2px rgba(0, 0, 0, 0.04),
                0 4px 12px rgba(0, 0, 0, 0.06),
                0 16px 40px rgba(0, 0, 0, 0.04);
            padding: 2.5rem;
            width: 100%;
            text-align: center;
            border: 1px solid rgba(0, 0, 0, 0.04);
            animation: fadeUp 0.6s ease-out 0.2s both;
        }

        .title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-text);
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .description {
            color: var(--color-text-muted);
            margin-bottom: 2rem;
            line-height: 1.6;
            font-size: 0.9375rem;
        }

        /* Boutons */
        .button-group {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.625rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9375rem;
            font-weight: 600;
            padding: 0.75rem 1.25rem;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            letter-spacing: -0.01em;
        }

        .btn-primary {
            background-color: var(--color-primary);
            color: white;
            border: 2px solid var(--color-primary);
        }

        .btn-primary:hover {
            background-color: #1a2024;
            border-color: #1a2024;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 47, 50, 0.2);
        }

        .btn-secondary {
            background-color: var(--color-card);
            color: var(--color-text);
            border: 2px solid var(--color-border);
        }

        .btn-secondary:hover {
            background-color: #f9fafb;
            border-color: #d1d5db;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        /* Séparateur */
        .divider {
            display: flex;
            align-items: center;
            margin: 1.75rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background-color: var(--color-border);
        }

        .divider span {
            color: #9ca3af;
            padding: 0 1rem;
            font-size: 0.8125rem;
            font-weight: 500;
        }

        /* État connecté */
        .welcome-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            background: #f0fdf4;
            color: #15803d;
            font-size: 0.8125rem;
            font-weight: 600;
            padding: 0.375rem 0.875rem;
            border-radius: 2rem;
            margin-bottom: 1.25rem;
        }

        .welcome-badge svg {
            width: 14px;
            height: 14px;
        }

        .user-name {
            font-weight: 700;
            color: var(--color-text);
        }

        .welcome-text {
            color: var(--color-text-muted);
            margin-bottom: 2rem;
            line-height: 1.6;
            font-size: 0.9375rem;
        }

        /* Footer */
        .footer {
            margin-top: 2rem;
            font-size: 0.8125rem;
            color: #9ca3af;
            animation: fadeUp 0.6s ease-out 0.35s both;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .card {
                padding: 2rem 1.5rem;
            }

            .logo svg {
                width: 110px;
                height: 110px;
            }

            .title {
                font-size: 1.3rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <x-application-logo />
        </div>

        <div class="card">
            @guest
                <h1 class="title">Bienvenue</h1>
                <p class="description">
                    Plateforme d'inscription aux activités du Foyer Anderlechtois.
                    Connectez-vous pour découvrir et participer aux événements.
                </p>

                <div class="button-group">
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Se connecter
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">
                        Créer un compte
                    </a>
                </div>
            @else
                <div class="welcome-badge">
                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Connecté
                </div>

                <h1 class="title">Bon retour, {{ Auth::user()->name }}</h1>
                <p class="welcome-text">
                    Accédez à votre tableau de bord pour consulter vos activités et gérer vos inscriptions.
                </p>

                <div class="button-group">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        Accéder au tableau de bord
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-secondary" style="width: 100%;">
                            Se déconnecter
                        </button>
                    </form>
                </div>
            @endguest
        </div>

        <p class="footer">Le Foyer Anderlechtois</p>
    </div>
</body>

</html>