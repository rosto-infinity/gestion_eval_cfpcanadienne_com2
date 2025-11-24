<!-- SIDEBAR -->
<section id="sidebar">
    <a href="#" class="brand pt-5">
				<img src="/android-chrome-192x192.png" alt="logo-app-cfpc" srcset="" style="height:30px; margin-left:13px" >
        <span class="text text-red-500 ml-2 ">CFPC</span>
    </a>
    <ul class="side-menu top">
        <!-- Dashboard -->
        <li class="">
            <a href="{{ route('dashboard') }}">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>

        <!-- Spécialités -->
        <li>
            <a href="{{ route('specialites.index') }}" 
                class="border-2 {{ request()->routeIs('specialites.*') ? 'border-red-600' : 'border-transparent' }}">
                <i class='bx bxs-briefcase'></i>
                <span class="text">Spécialités</span>
            </a>
        </li>

        <!-- Modules -->
        <li>
            <a href="{{ route('modules.index') }}" 
                class="border-2 {{ request()->routeIs('modules.*') ? 'border-red-600' : 'border-transparent' }}">
                <i class='bx bxs-book'></i>
                <span class="text">Modules</span>
            </a>
        </li>

        <!-- Années Académiques -->
        <li>
            <a href="{{ route('annees.index') }}" 
                class="border-2 {{ request()->routeIs('annees.*') ? 'border-red-600' : 'border-transparent' }}">
                <i class='bx bxs-calendar'></i>
                <span class="text">Années</span>
            </a>
        </li>

        <!-- Utilisateurs -->
        <li>
            <a href="{{ route('users.index') }}" 
                class="border-2 {{ request()->routeIs('users.index') ? 'border-red-600' : 'border-transparent' }}">
                <i class='bx bxs-user-circle'></i>
                <span class="text">Utilisateurs</span>
            </a>
        </li>

        <!-- Évaluations -->
        <li>
            <a href="{{ route('evaluations.index') }}" 
                class="border-2 {{ request()->routeIs('evaluations.*') ? 'border-red-600' : 'border-transparent' }}">
                <i class='bx bxs-check-circle'></i>
                <span class="text">Évaluations</span>
            </a>
        </li>

        <!-- Bilans Compétences -->
        <li>
            <a href="{{ route('bilans.index') }}" 
                class="border-2 {{ request()->routeIs('bilans.*') ? 'border-red-600' : 'border-transparent' }}">
                <i class='bx bxs-bar-chart-alt-2'></i>
                <span class="text">Bilans</span>
            </a>
        </li>

        <!-- Bilans Spécialité -->
        <li>
            <a href="{{ route('bilan.specialite.index') }}" 
                class="border-2 {{ request()->routeIs('bilan.specialite.*') ? 'border-red-600' : 'border-transparent' }}">
                <i class='bx bxs-chart'></i>
                <span class="text">Bilans Spécialité</span>
            </a>
        </li>
    </ul>

    <!-- Bottom Menu -->
    <ul class="side-menu">
        <!-- Settings -->
        <li>
            <a href="#">
                <i class='bx bxs-cog'></i>
                <span class="text">Paramètres</span>
            </a>
        </li>

        <!-- Logout -->
       <li>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout pl-3" style="background: none; border: none; cursor: pointer; padding: 0;">
            <i class='bx bxs-log-out-circle'></i>
            <span class="text">Déconnexion</span>
        </button>
    </form>
</li>

    </ul>
</section>
<!-- SIDEBAR -->
