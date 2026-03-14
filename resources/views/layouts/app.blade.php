<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DataHub') }}</title>
    <link rel="icon" href="{{ asset('logo.png') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300&family=Barlow+Condensed:wght@400;600;700&display=swap" rel="stylesheet" />

    <!-- CSS -->
    @vite(['resources/css/nexcore-theme.css', 'resources/css/layouts/app.css', 'resources/css/partials/command_palette.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('styles')

    <!-- Dark Mode Initial Check -->
    @vite(['resources/js/theme-init.js'])
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="navbar-container">
            <!-- Logo & Brand -->
            <a href="{{ auth()->check() && auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}"
                class="navbar-brand">
                <svg width="34" height="34" viewBox="0 0 34 34" fill="none" class="navbar-logo-svg">
                    <rect x="2" y="7"  width="30" height="6" rx="1" fill="#3A7BA8" opacity=".65"/>
                    <rect x="2" y="14" width="30" height="6" rx="1" fill="#3A7BA8" opacity=".82"/>
                    <rect x="2" y="21" width="30" height="6" rx="1" fill="#3A7BA8"/>
                    <circle cx="27" cy="10" r="1.4" fill="#2ecc71"/>
                    <circle cx="27" cy="17" r="1.4" fill="#A8D4DC"/>
                    <circle cx="27" cy="24" r="1.4" fill="#D42B2B"/>
                </svg>
                <span class="navbar-title">NEX<span>CORE</span></span>
            </a>

            <!-- Navigation Links -->
            <ul class="navbar-nav">
                <!-- 1. Dashboard -->
                @auth
                    <li>
                        <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}"
                            class="{{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-chart-line"></i> Dashboard
                        </a>
                    </li>
                @endauth

                <!-- 2. Catalogue -->
                <li>
                    <a href="{{ route('resources.index') }}"
                        class="{{ request()->routeIs('resources.index') ? 'active' : '' }}">
                        <i class="fas fa-server"></i> Catalogue
                    </a>
                </li>

                @auth
                    <!-- GESTION (RESPONSABLE/ADMIN) -->
                    @if(auth()->user()->role === 'responsable' || auth()->user()->role === 'admin')
                        <li>
                            <a href="{{ route('reservations.manager') }}"
                                class="{{ request()->routeIs('reservations.manager') ? 'active' : '' }}">
                                <i class="fas fa-inbox"></i> Demandes
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('resources.manager') }}"
                                class="{{ request()->routeIs('resources.manager') ? 'active' : '' }}">
                                <i class="fas fa-tasks"></i> Ma Gestion
                            </a>
                        </li>
                        @php
                            $incidentCount = \App\Models\Incident::where('status', 'ouvert')->count();
                        @endphp
                        <li>
                            <a href="{{ route('incidents.manager') }}"
                                class="{{ request()->routeIs('incidents.manager') ? 'active' : '' }}"
                                style="position: relative;">
                                <i class="fas fa-exclamation-triangle"></i> Incidents
                                @if($incidentCount > 0)
                                    <span class="notification-badge">{{ $incidentCount }}</span>
                                @endif
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->role === 'user')
                        <li>
                            <a href="{{ route('reservations.index') }}"
                                class="{{ request()->routeIs('reservations.index') ? 'active' : '' }}">
                                <i class="fas fa-calendar-check"></i> Mes Réservations
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->isAdmin())
                        @php
                            $pendingUserCount = \App\Models\User::where('role', 'guest')
                                ->where('is_active', false)
                                ->whereNull('rejection_reason')
                                ->count();
                        @endphp
                        <li>
                            <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}"
                                style="position: relative;">
                                <i class="fas fa-users"></i> Utilisateurs
                                @if($pendingUserCount > 0)
                                    <span class="notification-badge">{{ $pendingUserCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.logs') }}" class="{{ request()->routeIs('admin.logs') ? 'active' : '' }}">
                                <i class="fas fa-history"></i> Logs
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <!-- Right Side: Utils & User Area -->
            <div class="navbar-right">
                <!-- Group 3: Utility Tools -->
                <div class="navbar-utils">
                    <!-- Notifications -->
                    @auth
                        <a href="{{ route('notifications.index') }}"
                            class="nav-util-link {{ request()->routeIs('notifications.index') ? 'active' : '' }}"
                            title="Notifications">
                            <i class="fas fa-bell"></i>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="notification-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                            @endif
                        </a>
                    @endauth

                    <!-- À Propos -->
                    <a href="{{ route('about') }}"
                        class="nav-util-link {{ request()->routeIs('about') ? 'active' : '' }}" title="À Propos">
                        <i class="fas fa-info-circle"></i>
                    </a>

                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="btn-theme-toggle" title="Basculer le thème">
                        <i class="fas fa-moon"></i>
                    </button>
                </div>


                <!-- User Area -->
                <div class="navbar-user">
                    @auth
                        <div class="user-info">
                            <a href="{{ route('profile.edit') }}" title="Mon Profil"
                                style="text-decoration: none; color: inherit; display: flex; flex-direction: column; align-items: flex-end;">
                                <div class="user-name">{{ Auth::user()->name }}</div>
                                <div class="user-role">
                                    @php
                                        $roles = [
                                            'admin' => 'Administrateur',
                                            'responsable' => 'Responsable Tech',
                                            'user' => 'Ingénieur Réseau',
                                            'guest' => 'Invité'
                                        ];
                                    @endphp
                                    {{ $roles[Auth::user()->role] ?? Auth::user()->role }}
                                </div>
                            </a>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="btn-logout" title="Se déconnecter">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    @else
                        <div class="auth-buttons-guest">
                            <a href="{{ route('login') }}" class="btn-auth-nav btn-login-nav">SE CONNECTER</a>
                            <a href="{{ route('register') }}" class="btn-auth-nav btn-register-nav">S'INSCRIRE</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTENU PRINCIPAL -->
    <main class="main-content">
        @auth
            @php
                $tomorrow = \Carbon\Carbon::tomorrow()->toDateString();
                $expiringTomorrow = auth()->user()->reservations()
                    ->whereIn('status', ['Approuvée', 'Active'])
                    ->whereDate('end_date', $tomorrow)
                    ->count();
            @endphp

            @if($expiringTomorrow > 0)
                <div class="expiry-banner">
                    <div class="expiry-banner-content">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Attention : Vous avez <strong>{{ $expiringTomorrow }}</strong>
                            réservation{{ $expiringTomorrow > 1 ? 's' : '' }} qui se
                            termine{{ $expiringTomorrow > 1 ? 'nt' : '' }} demain.</span>
                        <a href="{{ route('reservations.index') }}" class="expiry-banner-link">Gérer mes réservations</a>
                    </div>
                </div>
            @endif
        @endauth

        @include('partials.flash')

        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="main-footer">
        <p>&copy; {{ date('Y') }} - Gestion de Ressources Data Center</p>
        <p> Created with fun by: Salim El Bourmaki</p>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- Theme toggle logic moved to resources/js/layouts/app.js --}}
    @vite(['resources/js/app.js', 'resources/js/layouts/app.js', 'resources/js/partials/command_palette.js', 'resources/js/partials/flash.js'])

    @stack('scripts')

    <!-- AI Chatbot Widget -->
    @include('partials.chatbot')

    <!-- Global Command Palette -->
    @include('partials.command_palette')
</body>

</html>