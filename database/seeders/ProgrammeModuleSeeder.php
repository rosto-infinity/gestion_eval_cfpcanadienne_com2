<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ProgrammeModule;
use App\Models\Specialite;
use Illuminate\Database\Seeder;

class ProgrammeModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programmes = [
            'CIG' => [
                'intitule' => 'COMPTABILITE INFORMATISEE ET GESTION',
                'modules' => [
                    ['numero' => 1, 'titre' => 'Connaissances générales de base en français', 'hebdo' => 4, 'total' => 30],
                    ['numero' => 2, 'titre' => 'Connaissances générales de base en anglais', 'hebdo' => 4, 'total' => 40],
                    ['numero' => 3, 'titre' => 'Sensibilisation au VIH - SIDA', 'hebdo' => 2, 'total' => 10],
                    ['numero' => 4, 'titre' => 'Vie professionnelle', 'hebdo' => 4, 'total' => 40],
                    ['numero' => 5, 'titre' => 'Insertion professionnelle', 'hebdo' => 4, 'total' => 40],
                    ['numero' => 6, 'titre' => 'Outils et Techniques de Communication', 'hebdo' => 6, 'total' => 60],
                    ['numero' => 7, 'titre' => 'Notions fondamentales d’économie générale', 'hebdo' => 6, 'total' => 60],
                    ['numero' => 8, 'titre' => 'Notions fondamentales d’économie d’entreprise', 'hebdo' => 6, 'total' => 70],
                    ['numero' => 9, 'titre' => 'Techniques analytiques et de gestion', 'hebdo' => 8, 'total' => 120],
                    ['numero' => 10, 'titre' => 'Maîtrise du système de comptabilité générale', 'hebdo' => 8, 'total' => 160],
                    ['numero' => 11, 'titre' => 'Règles comptables et Fiscales des entreprises', 'hebdo' => 8, 'total' => 100],
                    ['numero' => 12, 'titre' => 'Logiciels de tenue des données comptables et analytiques', 'hebdo' => 8, 'total' => 120],
                    ['numero' => 13, 'titre' => 'Notion de mathématiques financières', 'hebdo' => 6, 'total' => 70],
                    ['numero' => 14, 'titre' => 'Stage en entreprise', 'hebdo' => 40, 'total' => 300],
                ],
            ],

            'DA' => [
                'intitule' => "DEVELOPPEMENT D'APPLICATION",
                'modules' => [
                    ['numero' => 1, 'titre' => 'Connaissances générales de base en Français', 'hebdo' => 4, 'total' => 30],
                    ['numero' => 2, 'titre' => 'Connaissances générales de base en Anglais', 'hebdo' => 4, 'total' => 40],
                    ['numero' => 3, 'titre' => 'Sensibilisation sur les IST et le VIH-SIDA', 'hebdo' => 2, 'total' => 10],
                    ['numero' => 4, 'titre' => 'Vie professionnelle', 'hebdo' => 4, 'total' => 40],
                    ['numero' => 5, 'titre' => 'Insertion professionnelle', 'hebdo' => 4, 'total' => 40],
                    ['numero' => 6, 'titre' => 'Initiation à l’informatique', 'hebdo' => 4, 'total' => 100],
                    ['numero' => 7, 'titre' => 'Initiation au développement', 'hebdo' => 6, 'total' => 100],
                    ['numero' => 8, 'titre' => 'Programmation', 'hebdo' => 6, 'total' => 140],
                    ['numero' => 9, 'titre' => 'Systèmes d’information et bases de données', 'hebdo' => 6, 'total' => 120],
                    ['numero' => 10, 'titre' => 'Pratique professionnelle dans un environnement de développement intégré (EDI)', 'hebdo' => 6, 'total' => 70],
                    ['numero' => 11, 'titre' => 'Stage professionnel en entreprise', 'hebdo' => 40, 'total' => 480],
                ],
            ],

            'GP' => [
                'intitule' => 'GRAPHISME DE PRODUCTION',
                'modules' => [
                    ['numero' => 1, 'titre' => 'Connaissances générales de base en français', 'hebdo' => 4, 'total' => 30],
                    ['numero' => 2, 'titre' => 'Connaissances générales de base en anglais', 'hebdo' => 4, 'total' => 40],
                    ['numero' => 3, 'titre' => 'Sensibilisation aux IST/MST/VIH – SIDA', 'hebdo' => 2, 'total' => 10],
                    ['numero' => 4, 'titre' => 'Vie professionnelle', 'hebdo' => 4, 'total' => 40],
                    ['numero' => 5, 'titre' => 'Insertion professionnelle', 'hebdo' => 4, 'total' => 40],
                    ['numero' => 6, 'titre' => 'Choix esthétiques et graphiques', 'hebdo' => 4, 'total' => 100],
                    ['numero' => 7, 'titre' => 'Techniques de reproduction', 'hebdo' => 4, 'total' => 100],
                    ['numero' => 8, 'titre' => 'Typographie et mise en page', 'hebdo' => 4, 'total' => 100],
                    ['numero' => 9, 'titre' => 'Illustration et numérisation', 'hebdo' => 3, 'total' => 80],
                    ['numero' => 10, 'titre' => 'Web et multimédia', 'hebdo' => 5, 'total' => 130],
                    ['numero' => 11, 'titre' => 'Stage d’intégration en entreprise', 'hebdo' => 40, 'total' => 320],
                ],
            ],

            'MI' => [
                'intitule' => 'MAINTENANCE INFORMATIQUE',
                'modules' => [
                    ['numero' => 1, 'titre' => 'Connaissances générales de base en français', 'hebdo' => 4, 'total' => 30],
                    ['numero' => 2, 'titre' => 'Connaissances générales de base en anglais', 'hebdo' => 4, 'total' => 40],
                    ['numero' => 3, 'titre' => 'Sensibilisation aux IST/MST/VIH-SIDA', 'hebdo' => 2, 'total' => 10],
                    ['numero' => 4, 'titre' => 'Vie professionnelle', 'hebdo' => 4, 'total' => 40],
                    ['numero' => 5, 'titre' => 'Insertion professionnelle', 'hebdo' => 2, 'total' => 40],
                    ['numero' => 6, 'titre' => 'Installation des équipements informatiques', 'hebdo' => 6, 'total' => 90],
                    ['numero' => 7, 'titre' => 'Installation des systèmes d’exploitation et des applications', 'hebdo' => 10, 'total' => 100],
                    ['numero' => 8, 'titre' => 'Notions d’informatique et d’Internet', 'hebdo' => 6, 'total' => 90],
                    ['numero' => 9, 'titre' => 'Maintenance des équipements', 'hebdo' => 4, 'total' => 50],
                    ['numero' => 10, 'titre' => 'Réparation des équipements', 'hebdo' => 4, 'total' => 50],
                    ['numero' => 11, 'titre' => 'Mise en place et administration d’un réseau local', 'hebdo' => 4, 'total' => 40],
                    ['numero' => 12, 'titre' => 'Techniques et outils de communication et suivi de la clientèle', 'hebdo' => 2, 'total' => 20],
                    ['numero' => 13, 'titre' => 'Stage d’insertion en entreprise', 'hebdo' => 8, 'total' => 320],
                ],
            ],

            'MRI' => [
                'intitule' => 'MAINTENANCE DES RESEAUX INFORMATIQUES',
                'modules' => [
                    ['numero' => 1, 'titre' => 'Connaissances générales de base en français', 'hebdo' => 4, 'total' => 30],
                    ['numero' => 2, 'titre' => 'Connaissances générales de base en anglais', 'hebdo' => 4, 'total' => 40],
                    ['numero' => 3, 'titre' => 'Sensibilisation aux IST/MST/VIH-SIDA', 'hebdo' => 2, 'total' => 10],
                    ['numero' => 4, 'titre' => 'Insertion professionnelle', 'hebdo' => 4, 'total' => 40],
                    ['numero' => 5, 'titre' => 'Vie professionnelle', 'hebdo' => 4, 'total' => 40],
                    ['numero' => 6, 'titre' => 'Outils et Techniques de Communication', 'hebdo' => 4, 'total' => 30],
                    ['numero' => 7, 'titre' => 'Installation des équipements informatiques', 'hebdo' => 6, 'total' => 90],
                    ['numero' => 8, 'titre' => 'Installation des systèmes d’exploitation et des applications', 'hebdo' => 10, 'total' => 80],
                    ['numero' => 9, 'titre' => 'Utilisation des systèmes d’exploitation et des applications', 'hebdo' => 6, 'total' => 90],
                    ['numero' => 10, 'titre' => 'Conception d’un réseau informatique', 'hebdo' => 10, 'total' => 100],
                    ['numero' => 11, 'titre' => 'Mise en place d’un réseau informatique', 'hebdo' => 10, 'total' => 70],
                    ['numero' => 12, 'titre' => 'Administration et gestion d’un réseau informatique', 'hebdo' => 10, 'total' => 120],
                    ['numero' => 13, 'titre' => 'Dépannage d’un réseau informatique', 'hebdo' => 4, 'total' => 40],
                    ['numero' => 14, 'titre' => 'Stage d’insertion en entreprise', 'hebdo' => 40, 'total' => 320],
                ],
            ],

            'PB' => [
                'intitule' => 'Peinture bâtiment',
                'modules' => [
                    // Connaissances générales (210h)
                    ['numero' => 1, 'titre' => 'Connaissances générales de base de la première langue', 'hebdo' => null, 'total' => 30, 'categorie' => 'Connaissances générales'],
                    ['numero' => 2, 'titre' => 'Connaissances générales de base de la seconde langue', 'hebdo' => null, 'total' => 80, 'categorie' => 'Connaissances générales'],
                    ['numero' => 3, 'titre' => 'Education à la citoyenneté et sensibilisation aux IST/VIH-SIDA et les maladies liées au métier', 'hebdo' => null, 'total' => 20, 'categorie' => 'Connaissances générales'],
                    ['numero' => 4, 'titre' => 'Insertion dans la vie professionnelle', 'hebdo' => null, 'total' => 40, 'categorie' => 'Connaissances générales'],
                    ['numero' => 5, 'titre' => 'Utilisation de l’outil informatique', 'hebdo' => null, 'total' => 40, 'categorie' => 'Connaissances générales'],
                    // Spécialité (870h)
                    ['numero' => 6, 'titre' => 'Métier et formation', 'hebdo' => null, 'total' => 15, 'categorie' => 'Spécialité'],
                    ['numero' => 7, 'titre' => 'Santé et sécurité au travail', 'hebdo' => null, 'total' => 45, 'categorie' => 'Spécialité'],
                    ['numero' => 8, 'titre' => 'Utilisation de l’équipement', 'hebdo' => null, 'total' => 30, 'categorie' => 'Spécialité'],
                    ['numero' => 9, 'titre' => 'Choix des couleurs', 'hebdo' => null, 'total' => 30, 'categorie' => 'Spécialité'],
                    ['numero' => 10, 'titre' => 'Préparation et finition des surfaces sur planches murales', 'hebdo' => null, 'total' => 105, 'categorie' => 'Spécialité'],
                    ['numero' => 11, 'titre' => 'Calcul des quantités de matériaux', 'hebdo' => null, 'total' => 60, 'categorie' => 'Spécialité'],
                    ['numero' => 12, 'titre' => 'Application des techniques de décapage, de nettoyage et de ponçage', 'hebdo' => null, 'total' => 60, 'categorie' => 'Spécialité'],
                    ['numero' => 13, 'titre' => 'Préparation et finition des surfaces calcaires', 'hebdo' => null, 'total' => 60, 'categorie' => 'Spécialité'],
                    ['numero' => 14, 'titre' => 'Techniques de décoration', 'hebdo' => null, 'total' => 90, 'categorie' => 'Spécialité'],
                    ['numero' => 15, 'titre' => 'Préparation et finition des surfaces synthétiques', 'hebdo' => null, 'total' => 15, 'categorie' => 'Spécialité'],
                    ['numero' => 16, 'titre' => 'Préparation et finition des surfaces en bois', 'hebdo' => null, 'total' => 105, 'categorie' => 'Spécialité'],
                    ['numero' => 17, 'titre' => 'Préparation et finition des surfaces métalliques', 'hebdo' => null, 'total' => 90, 'categorie' => 'Spécialité'],
                    ['numero' => 18, 'titre' => 'Pose des revêtements', 'hebdo' => null, 'total' => 120, 'categorie' => 'Spécialité'],
                    ['numero' => 19, 'titre' => 'Application des composés granuleux', 'hebdo' => null, 'total' => 45, 'categorie' => 'Spécialité'],
                    // Stage (480h)
                    ['numero' => 20, 'titre' => 'Stage en entreprise', 'hebdo' => null, 'total' => 480, 'categorie' => 'Stage'],
                ],
            ],

            'SD' => [
                'intitule' => 'SECRETARIAT DE DIRECTION',
                'modules' => [
                    // TOTAL 1 (220h)
                    ['numero' => 1, 'titre' => 'Connaissances générales de base Français', 'hebdo' => null, 'total' => 40, 'categorie' => 'Enseignements Généraux'],
                    ['numero' => 2, 'titre' => 'Connaissances générales de base Anglais', 'hebdo' => null, 'total' => 40, 'categorie' => 'Enseignements Généraux'],
                    ['numero' => 3, 'titre' => 'Sensibilisation aux IST / MST / VIH - SIDA', 'hebdo' => null, 'total' => 20, 'categorie' => 'Enseignements Généraux'],
                    ['numero' => 4, 'titre' => 'Insertion dans la vie professionnelle', 'hebdo' => null, 'total' => 60, 'categorie' => 'Enseignements Généraux'],
                    ['numero' => 5, 'titre' => 'Vie professionnelle', 'hebdo' => null, 'total' => 40, 'categorie' => 'Enseignements Généraux'],
                    ['numero' => 6, 'titre' => 'Établir des devis (Calcul des coûts d’activités)', 'hebdo' => null, 'total' => 20, 'categorie' => 'Enseignements Généraux'],
                    // TOTAL 2 (740h)
                    ['numero' => 7, 'titre' => 'Assurer les process administratifs', 'hebdo' => null, 'total' => 150, 'categorie' => 'Enseignements Professionnels'],
                    ['numero' => 8, 'titre' => 'Préparer, coordonner et suivre des projets', 'hebdo' => null, 'total' => 200, 'categorie' => 'Enseignements Professionnels'],
                    ['numero' => 9, 'titre' => 'Assurer la recherche, la synthèse et la diffusion de l’information (Gestion de l’information)', 'hebdo' => null, 'total' => 50, 'categorie' => 'Enseignements Professionnels'],
                    ['numero' => 10, 'titre' => 'Gérer la communication', 'hebdo' => null, 'total' => 100, 'categorie' => 'Enseignements Professionnels'],
                    ['numero' => 11, 'titre' => 'Utiliser les outils de bureautique', 'hebdo' => null, 'total' => 240, 'categorie' => 'Enseignements Professionnels'],
                    // TOTAL 3 (480h)
                    ['numero' => 12, 'titre' => 'Stage en entreprise', 'hebdo' => null, 'total' => 480, 'categorie' => 'Stage Pratique'],
                ],
            ],

            'SC' => [
                'intitule' => 'SECRETARIAT COMPTABLE',
                'modules' => [
                    ['numero' => 1, 'titre' => 'Connaissances générales de base en français', 'hebdo' => 4, 'total' => 30],
                    ['numero' => 2, 'titre' => 'Connaissances générales de base en anglais', 'hebdo' => 4, 'total' => 40],
                    ['numero' => 3, 'titre' => 'Sensibilisation aux IST/MST/VIH/SIDA', 'hebdo' => 2, 'total' => 10],
                    ['numero' => 4, 'titre' => 'La vie professionnelle', 'hebdo' => 4, 'total' => 40],
                    ['numero' => 5, 'titre' => 'Insertion dans la vie professionnelle', 'hebdo' => 4, 'total' => 40],
                    ['numero' => 6, 'titre' => 'Réalisation des tâches bureautiques et informatiques', 'hebdo' => 8, 'total' => 180],
                    ['numero' => 7, 'titre' => 'Réalisation des tâches de secrétariat', 'hebdo' => 8, 'total' => 100],
                    ['numero' => 8, 'titre' => 'Rédaction des écrits professionnels', 'hebdo' => 4, 'total' => 60],
                    ['numero' => 9, 'titre' => 'Tenue de la comptabilité générale', 'hebdo' => 8, 'total' => 180],
                    ['numero' => 10, 'titre' => 'Tenue de la comptabilité analytique de gestion', 'hebdo' => 8, 'total' => 120],
                    ['numero' => 11, 'titre' => 'Analyse d’une situation économique générale', 'hebdo' => 4, 'total' => 40],
                    ['numero' => 12, 'titre' => 'Analyse d’une situation économique d’entreprise', 'hebdo' => 4, 'total' => 60],
                    ['numero' => 13, 'titre' => 'Pratique de la comptabilité sur ordinateur', 'hebdo' => 8, 'total' => 100],
                    ['numero' => 14, 'titre' => 'Réalisation des calculs financiers', 'hebdo' => 4, 'total' => 50],
                    ['numero' => 15, 'titre' => 'Réalisation du stage en entreprise', 'hebdo' => 40, 'total' => 480],
                ],
            ],

            'WBM' => [
                'intitule' => 'WEBMESTRE',
                'modules' => [
                    ['numero' => 1, 'titre' => 'Connaissances générales de base en français', 'hebdo' => 4, 'total' => 30],
                    ['numero' => 2, 'titre' => 'Connaissances générales de base en anglais', 'hebdo' => 4, 'total' => 40],
                    ['numero' => 3, 'titre' => 'Sensibilisation aux IST/MST/VIH-SIDA', 'hebdo' => 2, 'total' => 10],
                    ['numero' => 4, 'titre' => 'Vie professionnelle', 'hebdo' => 4, 'total' => 40],
                    ['numero' => 5, 'titre' => 'Insertion professionnelle', 'hebdo' => 4, 'total' => 40],
                    ['numero' => 6, 'titre' => 'Initiation à l’informatique', 'hebdo' => 6, 'total' => 100],
                    ['numero' => 7, 'titre' => 'Introduction au HTML', 'hebdo' => 4, 'total' => 60],
                    ['numero' => 8, 'titre' => 'Image vectorielle', 'hebdo' => 2, 'total' => 60],
                    ['numero' => 9, 'titre' => 'Image matricielle', 'hebdo' => 2, 'total' => 60],
                    ['numero' => 10, 'titre' => 'Animation pour Internet', 'hebdo' => 2, 'total' => 50],
                    ['numero' => 11, 'titre' => 'Design visuel', 'hebdo' => 2, 'total' => 50],
                    ['numero' => 12, 'titre' => 'Gestion de projet', 'hebdo' => 2, 'total' => 30],
                    ['numero' => 13, 'titre' => 'Programmation Internet', 'hebdo' => 4, 'total' => 180],
                    ['numero' => 14, 'titre' => 'Système de gestion de base de données (SGBD)', 'hebdo' => 2, 'total' => 50],
                    ['numero' => 15, 'titre' => 'Réseautique', 'hebdo' => 2, 'total' => 50],
                    ['numero' => 16, 'titre' => 'Système d’exploitation Unix, Linux', 'hebdo' => 2, 'total' => 50],
                    ['numero' => 17, 'titre' => 'Site transactionnel', 'hebdo' => 2, 'total' => 50],
                    ['numero' => 18, 'titre' => 'Stage en entreprise', 'hebdo' => 40, 'total' => 320],
                ],
            ],

            'SB' => [
                'intitule' => 'SECRETARIAT BUREAUTIQUE',
                'modules' => [
                    ['numero' => 1, 'titre' => 'Connaissances générales de base du français', 'hebdo' => 9, 'total' => 40],
                    ['numero' => 2, 'titre' => 'Connaissances générales de base de l’anglais', 'hebdo' => 14, 'total' => 56],
                    ['numero' => 3, 'titre' => 'Sensibilisation aux IST/MST/VIH-SIDA', 'hebdo' => 6, 'total' => 24],
                    ['numero' => 4, 'titre' => 'Insertion dans la vie professionnelle', 'hebdo' => 6, 'total' => 40],
                    ['numero' => 5, 'titre' => 'Utilisation des outils bureautiques', 'hebdo' => 15, 'total' => 408],
                    ['numero' => 6, 'titre' => 'Accueil et communication', 'hebdo' => 15, 'total' => 60],
                    ['numero' => 7, 'titre' => 'Gestion de l’information', 'hebdo' => 20, 'total' => 80],
                    ['numero' => 8, 'titre' => 'Classement et archivage des documents', 'hebdo' => 15, 'total' => 30],
                    ['numero' => 9, 'titre' => 'Organisation des activités', 'hebdo' => 5, 'total' => 15],
                    ['numero' => 10, 'titre' => 'Encadrement de l’équipe de travail', 'hebdo' => 15, 'total' => 30],
                    ['numero' => 11, 'titre' => 'Stage en entreprise', 'hebdo' => 40, 'total' => 400],
                ],
            ],

            'PLB' => [
                'intitule' => 'PLOMBERIE',
                'modules' => [
                    // A - COMPETENCES GENERALES : 250h
                    ['numero' => 1, 'titre' => 'Travailler en milieu de travail', 'hebdo' => null, 'total' => 45, 'categorie' => 'A - COMPÉTENCES GÉNÉRALES'],
                    ['numero' => 2, 'titre' => 'Prévenir atteintes santé, sécurité, environnement', 'hebdo' => null, 'total' => 50, 'categorie' => 'A - COMPÉTENCES GÉNÉRALES'],
                    ['numero' => 3, 'titre' => 'Utiliser les fonctions en informatique', 'hebdo' => null, 'total' => 45, 'categorie' => 'A - COMPÉTENCES GÉNÉRALES'],
                    ['numero' => 4, 'titre' => 'Communiquer, accueil et suivi de la clientèle', 'hebdo' => null, 'total' => 40, 'categorie' => 'A - COMPÉTENCES GÉNÉRALES'],
                    ['numero' => 5, 'titre' => 'Lire et interpréter un plan de plomberie', 'hebdo' => null, 'total' => 40, 'categorie' => 'A - COMPÉTENCES GÉNÉRALES'],
                    ['numero' => 6, 'titre' => "S'initier à l'entrepreneuriat et gestion atelier", 'hebdo' => null, 'total' => 30, 'categorie' => 'A - COMPÉTENCES GÉNÉRALES'],

                    // B - COMPETENCES PARTICULIERES : 815h
                    ['numero' => 7, 'titre' => 'Installer tuyauterie eau froide et eau chaude', 'hebdo' => null, 'total' => 150, 'categorie' => 'B - COMPÉTENCES PARTICULIÈRES'],
                    ['numero' => 8, 'titre' => 'Installer appareils sanitaires (WC, lavabo, douche)', 'hebdo' => null, 'total' => 150, 'categorie' => 'B - COMPÉTENCES PARTICULIÈRES'],
                    ['numero' => 9, 'titre' => 'Installer évacuation eaux usées et fosse septique', 'hebdo' => null, 'total' => 120, 'categorie' => 'B - COMPÉTENCES PARTICULIÈRES'],
                    ['numero' => 10, 'titre' => 'Installer chauffe-eau, pompe, surpresseur, forage', 'hebdo' => null, 'total' => 110, 'categorie' => 'B - COMPÉTENCES PARTICULIÈRES'],
                    ['numero' => 11, 'titre' => 'Entretenir, réparer et dépanner une installation', 'hebdo' => null, 'total' => 120, 'categorie' => 'B - COMPÉTENCES PARTICULIÈRES'],
                    ['numero' => 12, 'titre' => 'Réaliser assemblages: soudure, PVC, cuivre, PER', 'hebdo' => null, 'total' => 95, 'categorie' => 'B - COMPÉTENCES PARTICULIÈRES'],
                    ['numero' => 13, 'titre' => 'Stage pratique en entreprise / chantier', 'hebdo' => null, 'total' => 70, 'categorie' => 'B - COMPÉTENCES PARTICULIÈRES'],
                ],
            ],
        ];

        foreach ($programmes as $code => $data) {
            $specialite = Specialite::firstOrCreate(
                ['code' => $code],
                ['intitule' => $data['intitule']]
            );

            // Nettoyer les anciens modules du programme pour cette spécialité si ré-exécution
            ProgrammeModule::where('specialite_id', $specialite->id)->delete();

            $ordre = 1;
            foreach ($data['modules'] as $moduleData) {
                ProgrammeModule::create([
                    'specialite_id' => $specialite->id,
                    'numero_module' => $moduleData['numero'],
                    'titre' => $moduleData['titre'],
                    'heures_hebdomadaires' => $moduleData['hebdo'],
                    'heures_total' => $moduleData['total'],
                    'categorie' => $moduleData['categorie'] ?? null,
                    'ordre' => $ordre++,
                ]);
            }
        }
    }
}
