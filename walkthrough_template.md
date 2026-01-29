# Modèle Excel Avancé (Smart Template)

## Vue d'ensemble
Ce document détaille la création d'un modèle d'importation Excel intelligent, interactif et sécurisé pour guider l'utilisateur lors de la saisie des données.

## Fonctionnalités
1.  **Menus Déroulants (Dropdowns)** : Empêche les erreurs de saisie pour les champs à choix multiples.
2.  **Protection** : Empêche la modification accidentelle des en-têtes (qui casserait l'import).
3.  **Données Dynamiques** : Les listes déroulantes sont synchronisées avec la base de données.

## Modifications Techniques

### 1. Classe `UserTemplateExport`
Création d'une nouvelle classe dédiée remplaçant la génération à la volée. Elle implémente `WithEvents` pour manipuler le fichier Excel en profondeur via PhpSpreadsheet.

- **Menus Déroulants implémentés** :
    - **Sexe** : M, F, Autre.
    - **Niveau** : Liste complète des niveaux (L1-M2, 3ème-Tle) via `Niveau::cases()`.
    - **Spécialité** : Liste dynamique récupérée depuis la table `specialites`.
    - **Année Académique** : Liste dynamique récupérée depuis la table `annee_academiques`.
    - **Statut** : actif, inactif, suspendu, archive.

- **Protection de la Feuille** :
    - Activation de la protection de feuille (`setSheet(true)`).
    - Verrouillage explicite de la structure.
    - **Déverrouillage sélectif** : Seules les lignes de données (à partir de la ligne 2) sont déverrouillées pour permettre la saisie.

### 2. Auto-Dimensionnement
Utilisation du trait `ShouldAutoSize` pour que les colonnes s'adaptent automatiquement à la largeur des en-têtes verbeux (ex: "Matricule (optionnel...)"), rendant le tableau lisible dès l'ouverture.

## Vérification
Téléchargez le modèle depuis l'application ("Télécharger le modèle Excel") et vérifiez :
- [ ] Impossible de modifier la ligne 1.
- [ ] La colonne "Sexe" propose un menu déroulant.
- [ ] La colonne "Spécialité" propose vos spécialités enregistrées.
