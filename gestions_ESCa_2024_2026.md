# 📊 Rapport d'Analyse Fonctionnelle : Gestion ESCa (2024-2026)

Ce document détaille les fonctionnalités du système de gestion de l'ESCA, classées par catégories, état d'avancement et importance stratégique.

---

## 🏗️ 1. GESTION ACADÉMIQUE (Cœur du Système)

### ✅ État : Opérationnel (Terminé)

*   **Filières & Spécialités** : Configuration des parcours (BTS, Licence).
*   **Structuration des Niveaux & Semestres** : Définition de la progression pédagogique.
*   **Unités d'Enseignement (UE) & Matières** : Gestion du catalogue de cours.
*   **Innovation 2025 : Tronc Commun** : Capacité à partager des matières entre différentes spécialités.

**Importance** : C'est le socle sur lequel repose toute l'organisation. Elle garantit la cohérence des diplômes et la conformité aux normes universitaires.

---

## 👥 2. GESTION DES RESSOURCES HUMAINES (Acteurs)

### ✅ État : Opérationnel (Terminé)

*   **Gestion des Utilisateurs & Rôles** : Système sécurisé avec 5 rôles (Admin, Enseignant, Étudiant, Comptable, Personnel).
*   **Profils Étudiants** : Dossier administratif complet (matricule, photo, informations personnelles).
*   **Profils Enseignants (Détails Pédagogiques)** :
    *   **Grades** : Suivi des grades académiques (Assistant, Maître-Assistant, Maître de Conférences, Professeur).
    *   **Spécialités** : Expertise par domaine (GI, MSI, SANTE, etc.).
    *   **Affectations** : Mapping précis entre enseignants, matières et niveaux pour chaque année académique.
*   **Personnel Administratif (Contrôle d'Accès)** :
    *   **Gestion par Département** : Droits d'accès limités selon l'unité (Service Académique, Comptabilité, RH).
    *   **Filament Shield** : Permissions granulaires pour protéger les données sensibles.

**Importance** : Centralise les données de tous les intervenants, facilitant la communication et la traçabilité des actions au sein de l'établissement.

---

## 🏫 3. GESTION DES GROUPES DE TD & TP (Pédagogie)

### ✅ État : Opérationnel (Terminé)

*   **Création de Groupes** : Subdivision des niveaux en groupes de TD/TP (ex: BTS1-GIM-A).
*   **Affectation des Étudiants** : Répartition automatique ou manuelle dans les groupes.
*   **Capacité Maximale** : Contrôle des effectifs par salle et par groupe.

**Importance** : Crucial pour la qualité de l'enseignement technique. Permet une gestion fluide des travaux pratiques et dirige les étudiants vers les bons créneaux sans surcharge.

---

## 📅 4. GESTION DE l'ENSEIGNEMENT (Planning)

### ✅ État : Opérationnel (Terminé)

*   **Gestion des Salles** : Inventaire des salles avec types (Amphi, Laboratoire) et capacités.
*   **Créneaux Horaires** : Définition des plages de cours (Lundi au Samedi).
*   **Emplois du Temps** : Génération et consultation des plannings par niveau et par groupe.
*   **Affectation Enseignants-Matières** : Lien direct entre les intervenants et leurs cours.

**Importance** : Optimise l'utilisation des infrastructures et du temps des enseignants. Évite les conflits d'horaires et de salles.

---

## 📝 5. GESTION DES ÉVALUATIONS & NOTES

### ✅ État : Opérationnel (Terminé)

*   **Sessions d'Examens** : Organisation des sessions normales et de rattrapage avec périodes définies.
*   **Épreuves & Barèmes** : Configuration détaillée des examens par matière (coefficients, durée, salles).
*   **Contrôle de la Saisie (Activation/Désactivation)** :
    *   **FENÊTRES DE SAISIE** : Activation dynamique de la saisie des notes via le statut des sessions d'examens (Ouverte / Fermée).
    *   **SÉCURITÉ** : Verrouillage automatique de la saisie après clôture pour garantir l'intégrité des données.
*   **Saisie Massive des Notes** : Interface Livewire ultra-rapide permettant aux enseignants de saisir les notes d'une classe entière sur un seul écran avec sauvegarde automatique.
*   **Documents & États Générés (PDF & Excel)** :
    *   **FICHES DE SALLES** : Édition automatique pour les sessions normales et de rattrapage.
    *   **BILANS D'EXAMENS** : Rapports statistiques par spécialité, par filière et bilans globaux.
    *   **RAPPORTS DE RATTRAPAGES** : Listes des admis et des candidats aux sessions secondaires.
    *   **FICHES SCOLAIRES & RELEVÉS** : Automatisation totale des résultats individuels et des procès-verbaux de délibération.

**Importance** : Garantit l'intégrité des résultats académiques. Accélère la délibération et la publication des notes pour les étudiants tout en automatisant la paperasse administrative.

---

## 💰 6. GESTION COMPTABLE & SALAIRES

### ⏳ État : En Cours / Planifié (Q1-Q2 2026)

*   **Gestion des Frais Scolaires** : Grilles tarifaires par filière et niveau.
*   **Suivi des Paiements** : Enregistrement des transactions, relances pour impayés.
*   **Gestion des Salaires (RH Financière)** : Calcul des rémunérations des enseignants et du personnel en fonction des heures ou du contrat.
*   **États Financiers** : Rapports de trésorerie et bilans par année académique.

**Importance** : Assure la viabilité financière de l'ESCA. Elle permet un suivi rigoureux des entrées (scolarité) et des sorties (salaires, charges).

---

## 🖨️ 7. GESTION ADMINISTRATIVE & IMPRESSIONS

### ⏳ État : En Cours / Planifié (Q2 2026)

*   **Cartes Étudiantes** : Génération de cartes avec QR Code sécurisé.
*   **Système d'Impression Centralisé** : Modèles pour attestations, certificats et PV de délibération.
*   **Historique des Impressions** : Traçabilité totale pour éviter les fraudes.

**Importance** : Modernise l'image de l'école et renforce la sécurité des documents officiels délivrés aux étudiants.

---

## 🚀 8. FONCTIONNALITÉS FUTURES (Vision 2026-2027-2028)

*   **Portail Étudiant Standalone** : Interface dédiée pour consulter notes, planning et paiements en ligne.
*   **Application Mobile** : Notifications en temps réel pour les changements d'emploi du temps.
*   **Gestion des Sanctions & Assiduité** : Suivi des absences et du comportement.

**Importance** : Améliore l'expérience utilisateur et positionne l'ESCA comme un établissement à la pointe de la technologie.
