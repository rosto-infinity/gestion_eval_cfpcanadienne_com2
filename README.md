# 📚 Système de Gestion des Évaluations Académiques

Application web Laravel 12 pour la gestion complète des évaluations semestrielles, calcul automatique des moyennes et suivi des compétences des étudiants.

## ✨ Fonctionnalités Principales

### 🎓 Gestion Académique
- **Années Académiques**: Création et activation des périodes scolaires
- **Spécialités**: Gestion des filières et programmes
- **Modules**: Configuration des modules M1-M10 (2 semestres)
- **Étudiants**: Inscription et suivi des étudiants par spécialité/année

### 📝 Évaluations
- **Saisie Simple**: Ajout d'une note pour un module/étudiant
- **Saisie Multiple**: Formulaire intelligent pour saisir toutes les notes d'un semestre
- **Relevé de Notes**: Génération automatique de bulletins imprimables
- **Calcul Automatique**: Moyennes semestrielles calculées en temps réel

### 📊 Bilans de Compétences
- **Calcul Pondéré**: 30% Évaluations + 70% Compétences = Moyenne Générale
- **Génération Massive**: Création automatique de bilans pour une cohorte
- **Tableau Récapitulatif**: Classement général avec statistiques
- **Mentions**: Attribution automatique (Très Bien, Bien, Assez Bien, etc.)

### 📈 Reporting
- Dashboard avec statistiques globales
- Tableaux de classement
- Export PDF (via impression navigateur)
- Filtres avancés (année, spécialité, semestre)

---

## 🚀 Installation Rapide

### Prérequis
- PHP 8.2+
- Composer
- MySQL 8.0+ ou PostgreSQL 15+
- Node.js 18+ & NPM

### Étapes

```bash
# 1. Cloner le projet
git clone https://github.com/votre-repo/gestion-evaluations.git
cd gestion-evaluations

# 2. Installer les dépendances
composer install
npm install

# 3. Configuration
cp .env.example .env
php artisan key:generate

# 4. Configurer la base de données dans .env
DB_CONNECTION=mysql
DB_DATABASE=gestion_evaluations
DB_USERNAME=root
DB_PASSWORD=

# 5. Créer la base de données
php artisan migrate

# 6. (Optionnel) Charger des données de test
php artisan db:seed

# 7. Compiler les assets
npm run build

# 8. Lancer le serveur
php artisan serve
```

Accédez à: `http://localhost:8000`

**Identifiants par défaut**: 
- Email: admin@example.com
- Mot de passe: password

---

## 📁 Structure du Projet

```
app/
├── Http/Controllers/
│   ├── AnneeAcademiqueController.php
│   ├── SpecialiteController.php
│   ├── ModuleController.php
│   ├── EvaluationController.php
│   └── BilanCompetenceController.php
├── Models/
│   ├── AnneeAcademique.php
│   ├── Specialite.php
│   ├── Module.php
│   ├── User.php (Étudiant)
│   ├── Evaluation.php
│   └── BilanCompetence.php
│
resources/views/
├── layouts/
│   └── app.blade.php
├── dashboard.blade.php
├── specialites/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── modules/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── evaluations/
│   ├── index.blade.php
│   ├── saisir-multiple.blade.php
│   └── releve-notes.blade.php
├── bilans/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── show.blade.php
│   └── tableau-recapitulatif.blade.php
└── annees/
    ├── index.blade.php
    ├── create.blade.php
    └── edit.blade.php
```

---

## 🔧 Commandes Artisan Utiles

### Base de données
```bash
# Rafraîchir complètement la DB (⚠️ supprime toutes les données)
php artisan migrate:fresh

# Rafraîchir avec les seeders
php artisan migrate:fresh --seed

# Créer un nouveau seeder
php artisan make:seeder SpecialiteSeeder

# Exécuter un seeder spécifique
php artisan db:seed --class=SpecialiteSeeder
```

### Cache
```bash
# Nettoyer tous les caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimiser pour la production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Création de composants
```bash
# Créer un nouveau modèle avec migration et controller
php artisan make:model Enseignant -mc

# Créer un controller resource
php artisan make:controller EnseignantController --resource

# Créer une migration
php artisan make:migration add_photo_to_users_table
```

---

## 📊 Schéma de Base de Données

### Tables Principales

**annees_academiques**
- id, libelle, date_debut, date_fin, is_active

**specialites**
- id, code, intitule, description

**modules**
- id, code (M1-M10), intitule, coefficient, ordre

**users** (Étudiants)
- id, matricule, nom, prenom, email, password
- specialite_id, annee_academique_id

**evaluations**
- id, user_id, module_id, annee_academique_id
- semestre (1 ou 2), note

**bilans_competences**
- id, user_id, annee_academique_id
- moy_eval_semestre1, moy_eval_semestre2
- moy_evaluations (30%), moy_competences (70%)
- moyenne_generale (100%), observations

---

## 🧮 Formules de Calcul

### Moyennes Semestrielles
```
MOY_S1 = (M1 + M2 + M3 + M4 + M5) / 5
MOY_S2 = (M6 + M7 + M8 + M9 + M10) / 5
```

### Moyenne des Évaluations (30%)
```
MOY_EVAL = (MOY_S1 + MOY_S2) / 2
```

### Moyenne Générale (100%)
```
MOY_GENERALE = (MOY_EVAL × 0.30) + (MOY_COMPETENCES × 0.70)
```

### Mentions
- **Très Bien**: ≥ 16/20
- **Bien**: 14 ≤ note < 16
- **Assez Bien**: 12 ≤ note < 14
- **Passable**: 10 ≤ note < 12
- **Ajourné**: < 10

---

## 🎯 Workflow Typique

1. **Configuration initiale**
   - Créer l'année académique active
   - Créer les spécialités
   - Créer les modules (M1-M10)

2. **Inscription des étudiants**
   - Créer les comptes étudiants
   - Associer à une spécialité et année

3. **Saisie des évaluations**
   - Utiliser "Saisie Multiple" pour gagner du temps
   - Saisir les notes par semestre
   - Vérifier les relevés individuels

4. **Génération des bilans**
   - Créer les bilans de compétences
   - Saisir la note de compétences (70%)
   - Le système calcule automatiquement la moyenne générale

5. **Consultation des résultats**
   - Tableau récapitulatif avec classement
   - Export/Impression des documents
   - Statistiques globales

---

## 🔒 Sécurité

### Authentification
- Utilise Laravel Breeze pour l'authentification
- Middleware `auth` sur toutes les routes protégées
- Sessions sécurisées

### Validation des Données
- Validation stricte côté serveur
- Règles de validation dans les controllers
- Protection CSRF sur tous les formulaires

### Contraintes DB
- Clés étrangères avec `ON DELETE` appropriés
- Contraintes UNIQUE pour éviter les doublons
- Soft deletes pour les utilisateurs

---

## 🧪 Tests (à implémenter)

```bash
# Créer un test
php artisan make:test BilanCompetenceTest

# Exécuter les tests
php artisan test

# Tests avec couverture
php artisan test --coverage
```

### Tests Recommandés
- Calcul des moyennes semestrielles
- Calcul de la moyenne générale (30% + 70%)
- Attribution des mentions
- Validation des notes (0-20)
- Contraintes d'unicité des évaluations

---

## 🚢 Déploiement

### Sur Serveur Partagé
```bash
# Optimiser pour la production
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build

# Permissions
chmod -R 755 storage bootstrap/cache
```

### Variables d'environnement Production
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=prod_db
DB_USERNAME=prod_user
DB_PASSWORD=strong_password
```

---

## 📝 Améliorations Futures

- [ ] Export Excel/PDF natif (Laravel Excel, DomPDF)
- [ ] Graphiques avec Chart.js
- [ ] API REST pour applications mobiles
- [ ] Multi-rôles (Admin, Enseignant, Étudiant)
- [ ] Notifications email automatiques
- [ ] Historique des modifications
- [ ] Import CSV des étudiants
- [ ] Gestion des absences
- [ ] Module de messagerie
- [ ] Application mobile (React Native / Flutter)

---

## 🤝 Contribution

Les contributions sont les bienvenues ! 

1. Fork le projet
2. Créer une branche (`git checkout -b feature/AmazingFeature`)
3. Commit (`git commit -m 'Add AmazingFeature'`)
4. Push (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

---

## 📄 Licence

Ce projet est sous licence MIT. Voir `LICENSE` pour plus d'informations.

---

## 📞 Support

Pour toute question ou problème:
- 📧 Email: support@example.com
- 📱 GitHub Issues: [Créer une issue](https://github.com/votre-repo/issues)

---

## 👥 Auteurs

- **Votre Nom** - *Développement initial*

---

## 🙏 Remerciements

- Laravel Framework
- Tailwind CSS
- Communauté Laravel

---

**Fait avec ❤️ pour l'éducation** 🎓