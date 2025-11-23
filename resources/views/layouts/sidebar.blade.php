	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">AdminHub</span>
		</a>
		<ul class="side-menu top">
			<li class="">
				<a href="{{ route('dashboard') }}">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="{{ route('specialites.index') }}" 
        class="border-2 {{ request()->routeIs('specialites.*') ?
         'border-red-600' : 
         'border-transparent' }} ">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">
           Spécialités
          </span>
				</a>
			</li>
			<li>
				<a href="{{ route('modules.index') }}"  class="border-2 {{ request()->routeIs('modules.*') ?
         'border-red-600' : 
         'border-transparent' }} ">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text"> Modules</span>
				</a>
			</li>
			<li>
				<a href="{{ route('annees.index') }}"  class="border-2 {{ request()->routeIs('annees.*') ?
         'border-red-600' : 
         'border-transparent' }} ">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text"> annees</span>
				</a>
			</li>
			<li>
				<a href="{{ route('users.index') }}"  class="border-2 {{ request()->routeIs('users.index') ?
         'border-red-600' : 
         'border-transparent' }} ">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text"> users</span>
				</a>
			</li>
			<li>
				<a href="{{ route('evaluations.index') }}"  class="border-2 {{ request()->routeIs('evaluations.*') ?
         'border-red-600' : 
         'border-transparent' }} ">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text"> evaluations</span>
				</a>
			</li>
			<li>
				<a href="{{ route('bilans.index') }}"  class="border-2 {{ request()->routeIs('bilans.*') ?
         'border-red-600' : 
         'border-transparent' }} ">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text"> bilans</span>
				</a>
			</li>
			<li>
				<a href="{{ route('bilan.specialite.index') }}"  class="border-2 {{ request()->routeIs('bilan.specialite.*') ?
         'border-red-600' : 
         'border-transparent' }} ">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text"> bilans.specialite</span>
				</a>
			</li>
			
		
		</ul>
    
		<ul class="side-menu">
			<li>
				<a href="#">
					<i class='bx bxs-cog' ></i>
					<span class="text">Settings</span>
				</a>
			</li>
			<li>
				<a href="#" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->