<x-public-layout title="Confidentialité - GestionEval">
    <div class="max-w-4xl mx-auto px-6 py-16">
        
        <!-- En-tête minimalist -->
        <div class="mb-12 border-b border-border pb-8">
            <h1 class="text-4xl font-bold text-foreground mb-3">Politique de Confidentialité</h1>
            <p class="text-lg text-muted-foreground">
                Dernière mise à jour : {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </p>
        </div>

        <!-- Contenu -->
        <div class="space-y-12 text-foreground/90">
            
            <section class="space-y-4">
                <h2 class="text-2xl font-semibold text-foreground">1. Collecte des données</h2>
                <p class="leading-relaxed">
                    Nous collectons uniquement les informations nécessaires au fonctionnement de la plateforme académique : noms, prénoms, adresses e-mail, numéros d'étudiants, et les résultats d'évaluations. Ces données sont recueillies de manière sécurisée lors de la création de votre compte par l'administration.
                </p>
            </section>

            <section class="space-y-4">
                <h2 class="text-2xl font-semibold text-foreground">2. Utilisation des données</h2>
                <p class="leading-relaxed">
                    Les informations récoltées servent exclusivement à :
                </p>
                <ul class="list-disc list-inside space-y-2 text-muted-foreground ml-2">
                    <li>Gérer votre profil et vos accès.</li>
                    <li>Générer vos bilans de compétences et relevés de notes.</li>
                    <li>Maintenir la sécurité de la plateforme (logs de connexion, prévention des fraudes).</li>
                </ul>
            </section>

            <section class="space-y-4">
                <h2 class="text-2xl font-semibold text-foreground">3. Protection de vos données</h2>
                <p class="leading-relaxed">
                    Nous appliquons des protocoles de sécurité stricts. Vos mots de passe sont hachés cryptographiquement, et les requêtes sensibles sont protégées contre les attaques courantes (CSRF, XSS, injections SQL). Aucune donnée n'est revendue à des tiers ou utilisée à des fins publicitaires.
                </p>
            </section>

            <section class="space-y-4">
                <h2 class="text-2xl font-semibold text-foreground">4. Vos droits</h2>
                <p class="leading-relaxed">
                    Conformément aux lois de protection des données en vigueur, vous disposez d'un droit d'accès, de rectification et de suppression de vos données personnelles. Pour exercer ce droit, veuillez contacter votre administration ou le mainteneur de l'application.
                </p>
            </section>

            <!-- Card Maintainer -->
            <div class="mt-16 bg-card border border-border p-6 rounded-xl flex items-start gap-4">
                <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center shrink-0">
                    <i class="bx bxs-shield text-primary text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-foreground mb-1">Un engagement de sécurité</h3>
                    <p class="text-sm text-muted-foreground leading-relaxed">
                        Cette application est conçue avec la plus grande rigueur technique pour garantir l'intégrité du parcours académique de chaque étudiant. Code maintenu exclusivement par WAFFO LELE Rostand.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-public-layout>
