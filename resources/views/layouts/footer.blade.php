<footer class="bg-background border-t border-border py-12 relative z-10 mt-auto">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8 text-sm">
        <!-- Logo et Description -->
        <div>
            <div class="flex items-center gap-2 font-bold text-lg mb-4">
                <div class="flex items-center justify-center w-9 h-9 bg-primary text-primary-foreground rounded-lg shadow-md shadow-primary/10 overflow-hidden">
                    <img src="/android-chrome-192x192.png" alt="logo-eval" class="w-7 h-7 object-contain">
                </div>
                <span>Gestion<span class="text-primary">Eval</span></span>
            </div>
            <p class="text-muted-foreground mb-6 leading-relaxed">
                Solution de gestion académique développée avec passion pour l'éducation et le suivi des performances.
            </p>
            <div class="flex flex-col gap-1">
                <p class="text-muted-foreground text-xs">
                    &copy; {{ date('Y') }} EvalAcad. Tous droits réservés.
                </p>
                <a href="{{ route('changelog') }}" class="text-xs font-bold text-primary hover:underline flex items-center gap-1 mt-1">
                    <i class="bx bxs-rocket"></i>
                    Version stable 1.3.0
                </a>
            </div>
        </div>

        <!-- Application -->
        <div>
            <h4 class="font-bold text-foreground mb-4">Application</h4>
            <ul class="space-y-2 text-muted-foreground">
                <li><a href="/#features" class="hover:text-primary transition-colors">Fonctionnalités</a></li>
                <li><a href="/#methodology" class="hover:text-primary transition-colors">Méthodologie</a></li>
                <li><a href="{{ route('changelog') }}" class="hover:text-primary transition-colors">Historique (Changelog)</a></li>
                @auth
                    <li><a href="{{ route('dashboard') }}" class="hover:text-primary transition-colors">Accès Panel</a></li>
                @else
                    <li><a href="{{ route('login') }}" class="hover:text-primary transition-colors">Connexion Directe</a></li>
                @endauth
            </ul>
        </div>

        <!-- Support -->
        <div>
            <h4 class="font-bold text-foreground mb-4">Support</h4>
            <ul class="space-y-2 text-muted-foreground">
                <li><a href="#" class="hover:text-primary transition-colors">Documentation</a></li>
                <li><a href="#" class="hover:text-primary transition-colors">Contactez-nous</a></li>
                <li><a href="#" class="hover:text-primary transition-colors">FAQ Utilisateur</a></li>
            </ul>
        </div>

        <!-- Légal -->
        <div>
            <h4 class="font-bold text-foreground mb-4">Informations</h4>
            <ul class="space-y-2 text-muted-foreground">
                <li><a href="#" class="hover:text-primary transition-colors">Confidentialité</a></li>
                <li><a href="#" class="hover:text-primary transition-colors">Mentions légales</a></li>
                <li class="pt-2 border-t border-border/50">
                    <span class="text-muted-foreground flex items-center gap-1.5">
                        <i class="bx bxs-heart text-primary"></i>
                        Par WAFFO LELE Rostand
                    </span>
                </li>
            </ul>
        </div>
    </div>
</footer>