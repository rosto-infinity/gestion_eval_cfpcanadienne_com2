# 🌟 Transition Thème Sombre / Clair : Effet Goutte d'Eau (Circular Reveal)

Ce document analyse le style de transition mis en place dans le projet pour le basculement entre le mode Clair et Sombre, et propose un guide complet pour standardiser et optimiser l'effet "goutte d'eau" (Circular View Transition API).

---

## 🔍 Analyse de l'état actuel

Actuellement, le projet implémente avec brio une transition ultra-moderne utilisant l'**API native Web View Transitions**. 

### Points Clés de l'implémentation existante :
1. **Emplacements** : L'effet est codé en doublon directement dans les fichiers de mise en page :
   - [`resources/views/layouts/app.blade.php`](file:///home/devinsto/sites/gestion_eval_cfpcanadienne_com2/resources/views/layouts/app.blade.php)
   - [`resources/views/layouts/public.blade.php`](file:///home/devinsto/sites/gestion_eval_cfpcanadienne_com2/resources/views/layouts/public.blade.php)
2. **Technologie** : Combinaison d'Alpine.js pour la gestion de l'état réactif, du LocalStorage pour la persistance et de l'API `document.startViewTransition` pour le rendu graphique.
3. **Désynchronisation** : Le composant réutilisable [`theme-toggle.blade.php`](file:///home/devinsto/sites/gestion_eval_cfpcanadienne_com2/resources/views/components/theme-toggle.blade.php) n'intègre **pas encore** cet effet, limitant la centralisation du code.
4. **Fallback** : Le code prévoit intelligemment une dégradation élégante (changement immédiat) pour les navigateurs obsolètes ou ne supportant pas l'API View Transitions (Safari ancien, Firefox sans flag).

---

## ⚙️ Guide d'Implémentation de l'effet "Goutte d'Eau"

L'effet repose sur un "reveal" circulaire qui s'agrandit à partir des coordonnées du clic de la souris pour recouvrir l'ancien écran par le nouveau.

### 1. La Logique JavaScript (Alpine.js)
C'est la fonction maîtresse qui capture l'événement du clic, calcule la distance maximale (hypothénuse) pour que le cercle englobe tout l'écran, puis applique l'animation.

```javascript
async toggleTheme(event) {
    const isDark = !this.darkMode;
    
    // Si le navigateur ne supporte pas les View Transitions, on change juste la valeur
    if (!document.startViewTransition) {
        this.darkMode = isDark;
        return;
    }
    
    // Récupérer la source du clic (ou le centre de l'écran si c'est un raccourci clavier)
    const x = event.clientX ?? window.innerWidth / 2;
    const y = event.clientY ?? window.innerHeight / 2;
    
    // Calculer le rayon final (distance jusqu'au coin le plus éloigné de l'écran)
    const endRadius = Math.hypot(
        Math.max(x, window.innerWidth - x),
        Math.max(y, window.innerHeight - y)
    );
    
    // Lancer la transition de vue
    const transition = document.startViewTransition(async () => {
        this.darkMode = isDark;
        // Attendre que le DOM soit mis à jour par Alpine
        await this.$nextTick();
    });
    
    // Une fois la vue prête, lancer l'animation Web
    await transition.ready;
    
    document.documentElement.animate(
        {
            clipPath: [
                `circle(0px at ${x}px ${y}px)`,
                `circle(${endRadius}px at ${x}px ${y}px)`
            ],
        },
        {
            duration: 500,
            easing: 'cubic-bezier(0.4, 0, 0.2, 1)',
            pseudoElement: '::view-transition-new(root)', // Appliqué sur la nouvelle couche
        }
    );
}
```

### 2. Les Règles CSS Cruciales ([`resources/css/app.css`](file:///home/devinsto/sites/gestion_eval_cfpcanadienne_com2/resources/css/app.css))
Par défaut, les View Transitions effectuent un fondu-enchaîné (cross-fade). Pour obtenir la goutte d'eau propre sans mélange de transparence, nous devons désactiver l'animation par défaut et ordonner les couches :

```css
/* View Transition pour l'effet goutte d'eau / cercle */
::view-transition-old(root),
::view-transition-new(root) {
  animation: none;
  mix-blend-mode: normal;
}

/* La couche actuelle (ancienne) reste immobile en dessous */
::view-transition-old(root) {
  z-index: 1;
}

/* La nouvelle couche (avec le nouveau thème) apparaît au-dessus pour être dévoilée */
::view-transition-new(root) {
  z-index: 9999;
}
```

### 3. Le Bouton de Déclenchement (HTML / Blade)
Le bouton doit passer l'objet `$event` à la fonction afin que les coordonnées `clientX` et `clientY` soient lues par le script JavaScript.

```html
<button @click="toggleTheme($event)" type="button" class="theme-toggle-btn">
    <!-- Icône Soleil visible en Light mode -->
    <i class="bx bx-sun text-yellow-500 dark:hidden"></i>
    <!-- Icône Lune visible en Dark mode -->
    <i class="bx bx-moon text-blue-400 hidden dark:block"></i>
</button>
```

---

## 🚀 Recommandations pour le Futur

Pour assurer la robustesse et la maintenabilité du projet, il est conseillé d'adopter ces deux améliorations :

### A. Centraliser la Logique dans Global Store Alpine
Au lieu de répliquer la fonction `toggleTheme` dans chaque layout (`app.blade.php`, `public.blade.php`), on pourrait la déclarer globalement dans [`resources/js/app.js`](file:///home/devinsto/sites/gestion_eval_cfpcanadienne_com2/resources/js/app.js) :

```javascript
document.addEventListener('alpine:init', () => {
    Alpine.store('theme', {
        darkMode: JSON.parse(localStorage.getItem('darkMode') || 'false'),
        
        async toggle(event) {
            const isDark = !this.darkMode;
            if (!document.startViewTransition) {
                this.darkMode = isDark;
                return;
            }
            const x = event.clientX ?? window.innerWidth / 2;
            const y = event.clientY ?? window.innerHeight / 2;
            const endRadius = Math.hypot(Math.max(x, window.innerWidth - x), Math.max(y, window.innerHeight - y));
            
            const transition = document.startViewTransition(() => {
                this.darkMode = isDark;
                document.documentElement.classList.toggle('dark', isDark);
                localStorage.setItem('darkMode', JSON.stringify(isDark));
            });
            
            await transition.ready;
            document.documentElement.animate(
                { clipPath: [`circle(0px at ${x}px ${y}px)`, `circle(${endRadius}px at ${x}px ${y}px)`] },
                { duration: 500, easing: 'ease-out', pseudoElement: '::view-transition-new(root)' }
            );
        }
    });
});
```

### B. Standardiser via le Composant Réutilisable
Activer le composant [`theme-toggle.blade.php`](file:///home/devinsto/sites/gestion_eval_cfpcanadienne_com2/resources/views/components/theme-toggle.blade.php) en y insérant cette logique, puis remplacer tous les déclencheurs personnalisés par :
```html
<x-theme-toggle />
```
Ceci réduirait drastiquement la duplication de code et faciliterait les maintenances futures.

---
💡 *Note technique : L'API View Transitions respecte nativement la préférence utilisateur 'Reduced Motion'. L'implémentation respecte cette éthique.*
