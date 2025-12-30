<section id="sidebar">
    <a href="#" class="brand pt-5">
        <img src="/android-chrome-192x192.png" alt="logo-app-cfpc" style="height:30px; margin-left:13px">
    </a>
    
    <ul class="side-menu top">
        <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" title="Tableau de bord">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('welcome') ? 'active' : '' }}">
            <a href="{{ route('welcome') }}" title="Tableau de bord">
                <i class='bx bxs-home'></i>
                <span class="text">Accueil</span>
            </a>
        </li>

        @if(auth()->user()->isAdmin())
            <li class="{{ request()->routeIs('annees.*') ? 'active' : '' }}">
                <a href="{{ route('annees.index') }}" title="Gestion des années">
                    <i class='bx bxs-calendar'></i>
                    <span class="text">Années</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('specialites.*') ? 'active' : '' }}">
                <a href="{{ route('specialites.index') }}" title="Spécialités">
                    <i class='bx bxs-briefcase'></i>
                    <span class="text">Spécialités</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('modules.*') ? 'active' : '' }}">
                <a href="{{ route('modules.index') }}" title="Modules">
                    <i class='bx bxs-book'></i>
                    <span class="text">Modules</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}" title="Utilisateurs">
                    <i class='bx bxs-user-circle'></i>
                    <span class="text">Utilisateurs</span>
                </a>
            </li>
        @endif

        @if(auth()->user()->role->isAtLeast(\App\Enums\Role::MANAGER))
            <li class="{{ request()->routeIs('evaluations.*') ? 'active' : '' }}">
                <a href="{{ route('evaluations.index') }}" title="Évaluations">
                    <i class='bx bxs-check-circle'></i>
                    <span class="text">Évaluations</span>
                </a>
                
            </li>
            <li class="{{ request()->routeIs('saisir-par-specialite') ? 'active' : '' }}">
                <a href="{{ route('saisir-par-specialite') }}" title="Évaluations">
                    <i class='bx bxs-check-circle'></i>
                    <span class="text"> Saisie/Spécialité</span>
                </a>

            </li>
            <li class="{{ request()->routeIs('bilans.*') ? 'active' : '' }}">
                <a href="{{ route('bilans.index') }}" title="Bilans">
                    <i class='bx bxs-bar-chart-alt-2'></i>
                    <span class="text">Bilans & Relevés</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('bilan.specialite.*') ? 'active' : '' }}">
                <a href="{{ route('bilan.specialite.index') }}" title="Bilan par spécialité">
                    <i class='bx bxs-chart'></i>
                    <span class="text">Bilans Spécialité</span>
                </a>
            </li>
        @endif

        @if(auth()->user()->role === \App\Enums\Role::USER)
            <li class="{{ request()->routeIs('evaluations.releve-notes') ? 'active' : '' }}">
                <a href="{{ route('evaluations.releve-notes', auth()->user()) }}" title="Voir mes notes">
                    <i class='bx bxs-file-pdf'></i>
                    <span class="text">Mon Relevé</span>
                </a>
            </li>
        @endif
    </ul>

    <ul class="side-menu">
        <li class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <a href="{{ route('profile.edit') }}" title="Paramètres">
                <i class='bx bxs-cog'></i>
                <span class="text">Paramètres</span>
            </a>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout pl-3" title="Déconnexion" style="background: none; border: none; cursor: pointer; width: 100%; text-align: left; display: flex; align-items: center;">
                    <i class='bx bxs-log-out-circle text-primary '></i>
                    <span class="text text-primary ml-2">Déconnexion</span>
                </button>
            </form>
        </li>
    </ul>
</section>
