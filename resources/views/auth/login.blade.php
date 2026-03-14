<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - NexCore DataCenter</title>
    <link rel="icon" href="{{ asset('logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300&family=Barlow+Condensed:wght@400;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @vite(['resources/css/auth/login.css'])
</head>
<body>
    <div class="login-content {{ (isset($panel) && $panel === 'register') || request('panel') === 'register' || session('panel') === 'register' ? 'sign-up-mode' : '' }}">
        
        <!-- Brand Logo -->
        <a href="{{ url('/') }}" class="login-brand">
            <svg width="34" height="34" viewBox="0 0 34 34" fill="none">
                <rect x="2" y="7"  width="30" height="6" rx="1" fill="#FFFFFF" opacity=".65"/>
                <rect x="2" y="14" width="30" height="6" rx="1" fill="#FFFFFF" opacity=".82"/>
                <rect x="2" y="21" width="30" height="6" rx="1" fill="#FFFFFF"/>
                <circle cx="27" cy="10" r="1.4" fill="#2ecc71"/>
                <circle cx="27" cy="17" r="1.4" fill="#A8D4DC"/>
                <circle cx="27" cy="24" r="1.4" fill="#D42B2B"/>
            </svg>
            <span class="login-brand-text">NEX<span>CORE</span></span>
        </a>

        <div class="forms-container">
            <div class="signin-signup">
                <!-- FORMULAIRE DE CONNEXION -->
                <form method="POST" action="{{ route('login') }}" class="sign-in-form">
                    @csrf
                    <h2 class="title">Accès Client</h2>

                    <div class="input-field">
                        <i class="material-icons">email</i>
                        <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                    </div>
                    @error('email') <span class="error-msg">{{ $message }}</span> @enderror

                    <div class="input-field">
                        <i class="material-icons">lock</i>
                        <input type="password" name="password" placeholder="Mot de passe" required>
                    </div>
                    @error('password') <span class="error-msg">{{ $message }}</span> @enderror

                    <div class="form-options">
                        <a href="{{ route('password.request') }}" class="forgot-pass">Mot de passe oublié ?</a>
                    </div>

                    <input type="submit" value="SE CONNECTER" class="btn" />

                    <a href="{{ route('resources.index') }}" class="guest-link-auth">Consulter le catalogue</a>
                </form>

                <!-- FORMULAIRE D'INSCRIPTION -->
                <form method="POST" action="{{ route('register') }}" class="sign-up-form">
                    @csrf
                    <h2 class="title">Nouveau Compte</h2>

                    <div class="input-field">
                        <i class="material-icons">person</i>
                        <input type="text" name="name" placeholder="Nom complet" required value="{{ old('name') }}">
                    </div>
                    @error('name') <span class="error-msg">{{ $message }}</span> @enderror

                    <div class="input-field">
                        <i class="material-icons">email</i>
                        <input type="email" name="email" placeholder="Email professionnel" required value="{{ old('email') }}">
                    </div>
                    @error('email') <span class="error-msg">{{ $message }}</span> @enderror

                    <div class="input-field">
                        <i class="material-icons">lock</i>
                        <input type="password" name="password" placeholder="Mot de passe" required>
                    </div>
                    @error('password') <span class="error-msg">{{ $message }}</span> @enderror

                    <div class="input-field">
                        <i class="material-icons">lock_outline</i>
                        <input type="password" name="password_confirmation" placeholder="Confirmer le mot de passe" required>
                    </div>

                    <input type="submit" value="CRÉER MON COMPTE" class="btn" />
                    <a href="{{ route('resources.index') }}" class="guest-link-auth">Continuer sans compte</a>
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Première visite ?</h3>
                    <p>Déployez vos infrastructures en quelques clics sur notre réseau mondial ultra-performant.</p>
                    <button class="btn transparent" id="sign-up-btn">M'INSCRIRE</button>
                </div>
                <img src="{{ asset('images/log.png') }}" class="image" alt="NexCore Auth" />
            </div>

            <div class="panel right-panel">
                <div class="content">
                    <h3>Déjà partenaire ?</h3>
                    <p>Accédez à votre console de gestion NexCore pour piloter vos ressources critiques.</p>
                    <button class="btn transparent" id="sign-in-btn">ME CONNECTER</button>
                </div>
                <img src="{{ asset('images/register.png') }}" class="image" alt="NexCore Portal" />
            </div>
        </div>
    </div>

    @vite(['resources/js/auth/login.js'])
</body>
</html>