# 📊 Rapport d'Analyse Fonctionnelle : Gestion des Évaluations CFPC (2025-2026)

Ce document détaille les fonctionnalités du système de gestion des évaluations du **CFP Canadienne (CFPC)**, mettant l'accent sur la structure pédagogique spécifique et les règles de calcul de fin d'année.

---

## 🏗️ 1. GESTION ACADÉMIQUE
### ✅ État : Opérationnel
*   **Années Académiques** : Gestion dynamique des périodes scolaires avec notion d'"Année Active" pour le filtrage global.
*   **Spécialités** : Configuration des filières de formation (ex: GI, MSI, SANTE) avec codes uniques.
*   **Structure des Modules (M1-M10)** : Organisation de l'année en 10 modules répartis sur deux semestres (M1-M5 S1, M6-M10 S2).
*   **Coefficients & Pondération** : Attribution de coefficients par module pour le calcul des moyennes semestrielles.

**Importance** : Assure la flexibilité du système face aux changements de programmes annuels et garantit l'intégrité des données à travers les années.

---

## 👥 2. GESTION DES ACTEURS & SÉCURITÉ
### ✅ État : Opérationnel
*   **Système de Rôles** : Gestion multi-utilisateurs via 3 rôles principaux (Admin, Enseignant, Étudiant).
*   **Profils Étudiants** : Matricule unique, affectation à une spécialité et suivi de l'année académique.
*   **Gestion des Enseignants** : Attribution des modules et suivi des saisies par matière.
*   **Sécurité des Accès** : Authentification centralisée et protection des routes critiques.

**Importance** : Centralise les informations de la communauté éducative et sécurise les données sensibles (notes et dossiers personnels).

---

## 📝 3. CŒUR DE L'ÉVALUATION (30% des notes)
### ✅ État : Opérationnel
*   **Saisie Simple** : Interface pour l'ajout ponctuel de notes par étudiant/module.
*   **Saisie Multiple (Mode Rapide)** : Formulaire intelligent Livewire permettant de saisir toutes les notes d'un semestre pour une spécialité en une seule fois.
*   **Calcul des Moyennes Semestrielles** : Application automatique des coefficients.
    *   *Formule* : `MOY_SX = (Σ (Note × Coeff)) / Σ Coeffs`.
*   **Moyenne des Évaluations (30%)** : Moyenne pondérée des S1 et S2 représentant 30% de la note finale.

**Importance** : Réduit drastiquement le temps de saisie pour le corps enseignant et élimine les erreurs de calcul manuel.

---

## 🏆 4. BILAN DES COMPÉTENCES (70% des notes)
### ✅ État : Opérationnel
*   **Règle Spécifique CFPC** : Intégration de la note de compétences "Terrain/Pratique" qui pèse pour 70% du résultat final.
*   **Génération Massive des Bilans** : Création automatique de la structure de bilan pour toute une cohorte après la fin des examens.
*   **Calcul de la Moyenne Générale (100%)** :
    *   *Formule* : `(Moy_Evaluations × 0.30) + (Note_Compétences × 0.70)`.
*   **Décisions de Fin d'Année** : Passage automatique en mode "Admis" ou "Ajourné" basé sur le seuil de 10.00/20.

**Importance** : C'est le cœur métier du CFPC, valorisant la pratique professionnelle au-delà de la théorie académique.

---

## 📊 5. REPORTING & EXPORTS OFFICIELS
### ✅ État : Opérationnel
*   **Relevés de Notes Individuels (PDF)** : Génération de documents officiels avec détail des modules, moyennes et mentions.
*   **Tableau Récapitulatif (PV de délibération)** : Vue d'ensemble par spécialité avec classement, statistiques de réussite et taux d'admission.
*   **Dashboard Statistique** : Visualisation graphique des performances globales et par filière via Chart.js.
*   **Mentions Automatiques** : De "Excellent" (≥18) à "Ajourné" (<10).

**Importance** : Professionnalise la délivrance des documents officiels et facilite le pilotage stratégique par l'administration.

---

## ⏳ 6. AMÉLIORATIONS & VISION 2026
### 📅 Court Terme (Q1-Q2 2026)
*   **Interopérabilité Excel** : Import/Export massif des notes via fichiers tableurs pour faciliter le travail hors-ligne.
*   **Notifications Automatisées** : Envoi des résultats par email aux parents/étudiants dès validation.
*   **Historique d'Audit** : Traçabilité complète des modifications sur les notes pour éviter les fraudes.

### 🚀 Vision Long Terme
*   **Application Mobile** : Consultation des notes et planning en temps réel.
*   **IA de Suivi Prédictif** : Identification précoce des étudiants en difficulté scolaire.
*   **Portail Étudiant Self-Service** : Téléchargement autonome des attestations de scolarité.

**Importance** : Ancre le CFPC dans la modernité numérique et améliore continuellement le service rendu aux étudiants.
