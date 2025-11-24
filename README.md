# 📚 Système de Gestion des Évaluations Académiques

Application web Laravel 12 pour la gestion complète des évaluations semestrielles, calcul automatique des moyennes et suivi des compétences des étudiants.

## ✨ Fonctionnalités Principales

### 🎓 Gestion Académique
- **Années Académiques**: Création et activation des périodes scolaires avec système d'année active
- **Spécialités**: Gestion des filières et programmes avec codes et intitulés
- **Modules**: Configuration des modules M1-M10 (2 semestres) avec coefficients
- **Utilisateurs**: Gestion complète avec rôles (administrateurs, enseignants, étudiants)
- **Étudiants**: Inscription et suivi des étudiants par spécialité/année

### 📝 Évaluations
- **Saisie Simple**: Ajout d'une note pour un module/étudiant
- **Saisie Multiple**: Formulaire intelligent pour saisir toutes les notes d'un semestre
- **Relevé de Notes**: Génération automatique de bulletins imprimables
- **Export PDF**: Génération de relevés de notes au format PDF
- **Calcul Automatique**: Moyennes semestrielles calculées en temps réel

### 📊 Bilans de Compétences
- **Calcul Pondéré**: 30% Évaluations + 70% Compétences = Moyenne Générale
- **Génération Massive**: Création automatique de bilans pour une cohorte entière
- **Tableau Récapitulatif**: Classement général avec statistiques par spécialité
- **Mentions**: Attribution automatique (Très Bien, Bien, Assez Bien, etc.)
- **Export PDF**: Bilans individuels et tableaux récapitulatifs exportables en PDF
- **Bilan par Spécialité**: Vue d'ensemble des performances par filière

### 📈 Reporting Avancé
- **Dashboard** avec statistiques globales et graphiques Chart.js
- **Tableaux de classement** par spécialité et année
- **Comparaison** entre spécialités
- **Filtres avancés** (année, spécialité, semestre)
- **Mode sombre/clair** avec persistance des préférences
- **Impression optimisée** pour les documents officiels

### 🔐 Sécurité & Administration
- **Authentification** sécurisée avec Laravel Breeze
- **Gestion des rôles** et permissions
- **Audit** des modifications importantes
- **Backup** automatique de la base de données
- **HTTPS** forcé en production

---

## 🚀 Installation Rapide

### Prérequis
- PHP 8.3+
- Composer 2.5+
- MySQL 8.0+ ou PostgreSQL 15+
- Node.js 18+ & NPM
- Extension PHP : `gd`, `zip`, `mbstring`, `xml`, `bcmath`

### Étapes

```bash
# 1. Cloner le projet
git clone https://github.com/votre-repo/gestion-evaluations.git
cd gestion-evaluations

# 2. Installer les dépendances avec le script dédié
composer run setup

# 3. (Optionnel) Charger des données de test
php artisan db:seed

# 4. Lancer le serveur de développement
composer run dev
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
│   ├── UserController.php
│   ├── EvaluationController.php
│   ├── BilanCompetenceController.php
│   └── BilanSpecialiteController.php
├── Models/
│   ├── AnneeAcademique.php
│   ├── Specialite.php
│   ├── Module.php
│   ├── User.php
│   ├── Evaluation.php
│   └── BilanCompetence.php
│
resources/views/
├── layouts/
│   ├── app.blade.php
│   └── pdf.blade.php
├── dashboard.blade.php
├── specialites/
├── modules/
├── evaluations/
│   ├── saisir-multiple.blade.php
│   └── releve-notes.blade.php
├── bilans/
│   ├── tableau-recapitulatif.blade.php
│   └── bilan-specialite-pdf.blade.php
├── annees/
└── profile/
```

---

## 🔧 Commandes Artisan Utiles

### Scripts Composer
```bash
# Installation complète (dépendances + migration + assets)
composer run setup

# Démarrage du serveur de dev avec tous les services
composer run dev

# Nettoyage et optimisation du code
composer run clean

# Exécution des tests
composer run test
```

### Base de données
```bash
# Rafraîchir complètement la DB (⚠️ supprime toutes les données)
php artisan migrate:fresh --seed

# Générer les bilans pour tous les étudiants d'une année
php artisan bilan:generer-tous {annee_id}
```

### PDF et Export
```bash
# Générer un relevé de notes PDF pour un étudiant
php artisan pdf:releve-notes {user_id} {annee_id}

# Générer le tableau récapitulatif PDF par spécialité
php artisan pdf:bilan-specialite {annee_id}
```

---

## 📊 Schéma de Base de Données

### Tables Principales

**annees_academiques**
- id, libelle, annee_debut, annee_fin, is_active

**specialites**
- id, code, intitule, description

**modules**
- id, code (M1-M10), intitule, coefficient, ordre, semestre

**users**
- id, matricule, nom, prenom, email, password, role
- specialite_id, annee_academique_id

**evaluations**
- id, user_id, module_id, annee_academique_id
- semestre (1 ou 2), note, coefficient

**bilans_competences**
- id, user_id, annee_academique_id
- moy_eval_semestre1, moy_eval_semestre2
- moy_competences, observations
- moyenne_generale, mention, decision

---

## 🧮 Formules de Calcul

### Moyennes Semestrielles (pondérées)
```
MOY_S1 = (Σ (note_module × coefficient)) / Σ coefficients (semestre 1)
MOY_S2 = (Σ (note_module × coefficient)) / Σ coefficients (semestre 2)
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

## 🎯 Workflow Administrateur

1. **Configuration initiale**
   - Créer l'année académique active
   - Créer les spécialités et modules
   - Configurer les coefficients des modules

2. **Gestion des utilisateurs**
   - Créer les comptes administrateurs et enseignants
   - Importer ou créer les comptes étudiants

3. **Saisie des évaluations**
   - Utiliser "Saisie Multiple" pour gagner du temps
   - Saisir les notes par semestre avec validation
   - Vérifier les relevés individuels

4. **Génération des bilans**
   - Générer massivement les bilans pour une cohorte
   - Saisir les notes de compétences (70%)
   - Valider les décisions finales

5. **Reporting**
   - Consulter le tableau récapitulatif par spécialité
   - Exporter les documents officiels en PDF
   - Analyser les statistiques de réussite

---

## 💻 Développement

### Environnement de développement
```bash
# Démarrer tous les services en parallèle
composer run dev

# Services inclus:
# - Serveur web (php artisan serve)
# - File d'attente (queue:listen)
# - Logs en temps réel (pail)
# - Vite pour les assets frontend
```

### Code Quality
```bash
# Formater le code selon les standards PSR-12
composer run pint

# Analyser le code avec PHPStan
composer run phpstan

# Exécuter les tests
composer run pest
```

### Assets Frontend
```bash
# Compilation pour le développement (hot reload)
npm run dev

# Compilation pour la production
npm run build

# Watch mode
npm run watch
```

---

## 🚢 Déploiement

### Production Setup
```bash
# Optimiser pour la production
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build

# Permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data .
```

### Variables d'environnement Production
```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:your_generated_key_here
APP_URL=https://evaluations.votre-ecole.edu

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=prod_evaluations
DB_USERNAME=prod_user
DB_PASSWORD=strong_secure_password

# Configuration PDF
DOMPDF_PAPER_SIZE=A4
DOMPDF_DPI=150

# Mail configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.votre-ecole.edu
MAIL_PORT=587
MAIL_USERNAME=notifications@votre-ecole.edu
MAIL_PASSWORD=mail_password
```

### Cron Jobs (pour tâches planifiées)
```bash
# Ajouter dans le crontab système
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

### Tâches Planifiées
- Backup quotidien de la base de données
- Nettoyage des fichiers temporaires
- Génération des rapports mensuels

---

## 🔧 Technologies Utilisées

### Backend
- **Laravel 12** - Framework PHP moderne
- **MySQL** - Base de données relationnelle
- **Redis** - Cache et file d'attente
- **DomPDF** - Génération de documents PDF
- **Laravel Excel** - Exportation vers Excel

### Frontend
- **Tailwind CSS** - Framework CSS utility-first
- **Alpine.js** - JavaScript léger pour les interactions
- **Chart.js** - Visualisation des données
- **Boxicons** - Icônes modernes
- **Vite** - Build tool moderne

### Outils de Développement
- **Laravel Pint** - Formateur de code
- **PHPStan** - Analyse statique
- **Pest** - Framework de tests
- **Laravel Debugbar** - Débogage en développement
- **Concurrently** - Exécution parallèle de processus

---

## 📝 Améliorations Futures

### Court terme (prochaines versions)
- [x] Export PDF des bilans et relevés de notes
- [x] Génération massive des bilans
- [x] Tableau de bord avec statistiques
- [ ] Import/Export Excel des notes
- [ ] Notifications par email aux étudiants

### Moyen terme
- [ ] Application mobile (React Native)
- [ ] API REST pour intégrations tierces
- [ ] Système de commentaires pour les décisions
- [ ] Historique des modifications
- [ ] Multi-langues (français/anglais)

### Long terme
- [ ] Système d'alertes (étudiants en difficultés)
- [ ] Module de planification pédagogique
- [ ] Intégration avec les systèmes universitaires existants
- [ ] Intelligence artificielle pour l'analyse prédictive
- [ ] Portail étudiant avec suivi personnalisé

---

##  Maintenance

### Journal des Modifications
- **v1.2.0** (2025-03-15): Ajout des exports PDF, génération massive de bilans
- **v1.1.0** (2025-02-20): Interface sombre/clair, tableau de bord amélioré
- **v1.0.0** (2025-01-10): Version initiale stable

### Support Technique
- **Correctifs critiques**: 24h
- **Correctifs mineurs**: 72h
- **Nouvelles fonctionnalités**: selon roadmap

---

## 📄 Licence

Ce projet est sous licence MIT. Voir `LICENSE` pour plus d'informations.

---

## 📞 Support

Pour toute question ou problème:
- 📧 Email: contact@cfpcanadienne.com
- 📱 GitHub Issues: [Créer une issue](https://github.com/votre-repo/gestion-evaluations/issues)


**Heures de support**: Lundi-Vendredi, 8h-18h (GMT+1)

---

## 👥 Auteurs

- **Développeur** - WAFFO LELE Rostand (chef de projet)

---

## 🙏 Remerciements

- **Laravel Community** - Documentation et support exceptionnels
- **Tailwind Labs** - Outils CSS révolutionnaires
- **DomPDF Team** - Bibliothèque robuste pour la génération PDF
- **Enseignants testeurs** - Retours précieux et suggestions pertinentes

---

**Fait avec ❤️ pour l'éducation** 🎓  
*Version 1.2.0 - Mise à jour: 23 Novembre 2025*