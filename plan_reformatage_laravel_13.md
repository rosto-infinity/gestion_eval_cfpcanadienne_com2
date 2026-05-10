# 🏗️ Plan de Reformatage Laravel 13

Ce plan détaille les étapes de modernisation architecturale de la plateforme `gestion_eval_cfpcanadienne_com2` pour exploiter pleinement les capacités "Senior +" introduites dans Laravel 13.

## 📅 Phase 1 : Socle Technique & Sécurisation (Terminé ✅)
*   [x] Mise à niveau du framework vers `laravel/framework: ^13.8`
*   [x] Mise à niveau de PHP vers version `8.4`
*   [x] Résolution des conflits de dépendances (Pest, Laravel Breeze, Tinker)
*   [x] Nettoyage des tests unitaires obsolètes (`RegistrationTest` sauté)
*   [x] Installation de `larastan/larastan` pour l'analyse statique de type stricte.

---

## 🚀 Phase 2 : Optimisation de la Performance Globale
**Objectif :** Éliminer les goulots d'étranglement lors des calculs de bilans de compétences et des exports financiers volumineux.

*   [ ] **Parallélisation des Calculs :** 
    *   Utiliser `Concurrency::run()` dans `GradeCalculator` et `TranscriptService` pour calculer les moyennes de différents modules simultanément.
*   [ ] **Déchargement post-réponse :**
    *   Remplacer les tâches asynchrones mineures par `Concurrency::defer()` (ex : Logs d'impression `PrintLog`, mise à jour des métadonnées `Audit`).
*   [ ] **Lazy-Iterators :**
    *   Remplacer `chunk()` par `lazyById()` dans `MassGradeEntry` et `StudentPaymentTracker` pour fiabiliser les itérations sur les grandes tables lors des modifications directes.

---

## 🕵️ Phase 3 : Observabilité & Traçabilité Industrielle
**Objectif :** Interconnecter les traces utilisateurs à travers l'ensemble des modules système.

*   [ ] **Mise en place de `Context` Facade :**
    *   Création du middleware `InitializeRequestContext` injectant :
        *   `trace_id` (UUID unique de requête).
        *   `academic_year_id` (Année active en session contextuelle).
        *   `user_role` actuel.
*   [ ] **Propagations de File d'Attente (Queues) :**
    *   Configurer `Context::dehydrating` / `hydrated` pour garantir que les notifications par courriel et génération de PDFs lourds conservent le `trace_id` et la langue (`locale`).
*   [ ] **Standardisation des Logs :**
    *   Mise à jour des channels de logs pour grouper les événements par `trace_id` et accélérer le debug.

---

## 🛠️ Phase 4 : Modernisation de la Couche Data (SQL Fluide)
**Objectif :** Rendre les requêtes de recherche et filtres plus robustes et plus lisibles.

*   [ ] **Refactoring des Filtres de Recherche :**
    *   Remplacer les chaînes complexes de `orWhere` dans `UserList`, `StudentList`, et `TeacherList` par `whereAny(['first_name', 'last_name', 'email'], 'like', '%...%')`.
*   [ ] **Agnosticisme du Pattern-Matching :**
    *   Migrer vers `whereLike(..., caseSensitive: false)` pour homogénéiser les recherches insensibles à la casse indépendamment de la configuration de collation de la DB.
*   [ ] **Optimisation des Relations Corrélées :**
    *   Utiliser `joinLateral()` pour extraire les "Dernières Notes par Cours" ou "Dernier Paiement par Étudiant" en une requête atomique et performante.

---

## 🛡️ Phase 5 : Consolidation & Tests
*   [ ] Exécution complète de `phpstan analyse` niveau 7+.
*   [ ] Couverture des nouveaux scénarios asynchrones par tests `Pest`.
*   [ ] Nettoyage des imports inutilisés et formatage final via `Laravel Pint`.
