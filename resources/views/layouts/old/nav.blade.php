 <!-- Navigation -->
 <nav class="bg-white shadow-sm border-b border-gray-200  fixed top-0 w-full z-10 ">
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
         <div class="flex justify-between h-16">
             <div class="flex">
                 <div class="flex-shrink-0 flex items-center">
                     <h1 class="text-xl font-bold text-red-600">📚 Gestion Académique</h1>
                 </div>
                 <div class="hidden  sm:ml-8 sm:flex sm:space-x-8">
                     <a href="{{ route('dashboard') }}"
                         class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-red-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                         Tableau de bord
                     </a>
                     {{-- ZONE ADMIN & SUPERADMIN --}}
                     @if (auth()->user()->isAdmin())
                         <a href="{{ route('specialites.index') }}"
                             class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('specialites.*') ? 'border-red-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                             Spécialités
                         </a>
                         <a href="{{ route('modules.index') }}"
                             class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('modules.*') ? 'border-red-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                             Modules
                         </a>
                         <a href="{{ route('annees.index') }}"
                             class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('annees.*') ? 'border-red-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                             Années
                         </a>

                         <a href="{{ route('users.index') }}"
                             class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('users.index') ? 'border-red-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                             Utilisateurs
                         </a>
                     @endif

                     {{-- ZONE MANAGER / ADMIN / SUPERADMIN --}}
                     @if (auth()->user()->role->isAtLeast(\App\Enums\Role::MANAGER))
                         <a href="{{ route('evaluations.index') }}"
                             class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('evaluations.*') ? 'border-red-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                             Évaluations
                         </a>
                         <a href="{{ route('saisir-par-specialite') }}"
                             class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('saisir-par-specialite') ? 'border-red-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                            📊 Saisie par Spécialité
                         </a>
                        
                         <a href="{{ route('bilans.index') }}"
                             class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('bilans.*') ? 'border-red-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                             Bilans & Relevés
                         </a>
                     @endif

                     {{-- LIEN SPÉCIFIQUE ÉTUDIANT (USER) --}}
                     @if (auth()->user()->role === \App\Enums\Role::USER)
                         <a href="{{ route('evaluations.releve-notes', auth()->user()) }}"
                             class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('evaluations.releve-notes') ? 'border-red-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                             Mon Relevé
                         </a>
                     @endif
                 </div>
             </div>

             <div class="flex items-center">
                 <span class="text-sm text-gray-700 mr-4">{{ auth()->user()->name }}</span>
                 <form method="POST" action="{{ route('logout') }}">
                     @csrf
                     <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
                         Déconnexion11
                     </button>
                 </form>
             </div>
         </div>
     </div>
 </nav>

 <!-- Messages Flash -->
 @if (session('success'))
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
         <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-md">
             <div class="flex">
                 <div class="flex-shrink-0">
                     <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                         <path fill-rule="evenodd"
                             d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                             clip-rule="evenodd" />
                     </svg>
                 </div>
                 <div class="ml-3">
                     <p class="text-sm text-green-700">{{ session('success') }}</p>
                 </div>
             </div>
         </div>
     </div>
 @endif

 @if (session('error'))
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
         <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-md">
             <div class="flex">
                 <div class="flex-shrink-0">
                     <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                         <path fill-rule="evenodd"
                             d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                             clip-rule="evenodd" />
                     </svg>
                 </div>
                 <div class="ml-3">
                     <p class="text-sm text-red-700">{{ session('error') }}</p>
                 </div>
             </div>
         </div>
     </div>
 @endif

 @if (session('info'))
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
         <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-md">
             <div class="flex">
                 <div class="flex-shrink-0">
                     <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                         <path fill-rule="evenodd"
                             d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                             clip-rule="evenodd" />
                     </svg>
                 </div>
                 <div class="ml-3">
                     <p class="text-sm text-blue-700">{{ session('info') }}</p>
                 </div>
             </div>
         </div>
     </div>
 @endif
