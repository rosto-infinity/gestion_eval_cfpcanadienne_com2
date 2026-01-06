<!-- Mobile Navigation Menu -->
<nav class="space-y-2">
    <a href="{{ route('dashboard') }}" 
       class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard') ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
        <i class='bx bxs-dashboard mr-3'></i>
        Tableau de bord
    </a>
    
    <a href="{{ route('welcome') }}" 
       class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('welcome') ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
        <i class='bx bxs-home mr-3'></i>
        Accueil
    </a>

    @if(auth()->user()->isAdmin())
        <div class="pt-4 pb-2">
            <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">
                Administration
            </h3>
        </div>
        
        <a href="{{ route('annees.index') }}" 
           class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('annees.*') ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
            <i class='bx bxs-calendar mr-3'></i>
            Années
        </a>
        
        <a href="{{ route('specialites.index') }}" 
           class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('specialites.*') ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
            <i class='bx bxs-briefcase mr-3'></i>
            Spécialités
        </a>
        
        <a href="{{ route('modules.index') }}" 
           class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('modules.*') ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
            <i class='bx bxs-book mr-3'></i>
            Modules
        </a>
        
        <a href="{{ route('users.index') }}" 
           class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('users.*') ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
            <i class='bx bxs-user-circle mr-3'></i>
            Utilisateurs
        </a>
    @endif

    @if(auth()->user()->role->isAtLeast(\App\Enums\Role::MANAGER))
        <div class="pt-4 pb-2">
            <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">
                Évaluations
            </h3>
        </div>
        
        <a href="{{ route('evaluations.index') }}" 
           class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('evaluations.*') ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
            <i class='bx bxs-check-circle mr-3'></i>
            Évaluations
        </a>
        
        <a href="{{ route('saisir-par-specialite') }}" 
           class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('saisir-par-specialite') ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
            <i class='bx bxs-check-circle mr-3'></i>
            Saisie/Spécialité
        </a>
        
        <a href="{{ route('bilans.index') }}" 
           class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('bilans.*') ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
            <i class='bx bxs-bar-chart-alt-2 mr-3'></i>
            Bilans & Relevés
        </a>
        
        <a href="{{ route('bilan.specialite.index') }}" 
           class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('bilan.specialite.*') ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
            <i class='bx bxs-chart mr-3'></i>
            Bilans Spécialité
        </a>
    @endif

    @if(auth()->user()->role === \App\Enums\Role::USER)
        <a href="{{ route('evaluations.releve-notes', auth()->user()) }}" 
           class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('evaluations.releve-notes') ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
            <i class='bx bxs-file-pdf mr-3'></i>
            Mon Relevé
        </a>
    @endif

    <div class="pt-4 pb-2 mt-4 border-t border-gray-200 dark:border-gray-700">
        <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">
            Compte
        </h3>
    </div>
    
    <a href="{{ route('profile.edit') }}" 
       class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('profile.edit') ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700' }}">
        <i class='bx bxs-cog mr-3'></i>
        Paramètres
    </a>
    
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20">
            <i class='bx bxs-log-out-circle mr-3'></i>
            Déconnexion
        </button>
    </form>
</nav>
