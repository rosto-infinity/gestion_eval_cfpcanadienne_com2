# TP & GUIDE AVANCÉ : PARTITIONNEMENT DE BASE DE DONNÉES MYSQL
## Module : BTS IGL244 — Bases de Données Avancées (Diapo 14 / Chapitre 10)
### Cas d'étude pratique : Base `boutique` — Table `produits` (~54 638 lignes)

---

> **⚠️ RAPPEL DE SÉCURITÉ DBA (Important)** :  
> La table `boutique.produits` contient **54 638 enregistrements réels**.  
> Ce document est un guide pédagogique exhaustif et technique. Il détaille **mot à mot et ligne par ligne** chaque commande SQL, son comportement interne sur le moteur InnoDB, ses répercussions sur le système de fichiers, et les pièges d'examen à éviter.

---

## 0. Schéma Réel de la Table `boutique.produits`

```sql
-- Structure actuelle de votre table dans MySQL 8.0 / phpMyAdmin :
CREATE TABLE `produits` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(100) NOT NULL,
  `prix` DECIMAL(10,2) NOT NULL,
  `en_stock` TINYINT(1) DEFAULT '1',
  `spec` JSON NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## 1. FONDEMENT 1 : LE PARTITIONNEMENT

### Énoncé théorique (Diapo 14) :
> *« Partitionnement : Division logique d'une table unique en sous-ensembles physiques indépendants sur le disque. »*

### Reformulation pour `boutique.produits` :
> **Question 1.1** :  
> La table `produits` stocke actuellement 54 638 articles dans un fichier unique `produits.ibd` sur le disque dur.  
> 1. Expliquez comment le partitionnement horizontal découpe ce fichier en plusieurs sous-fichiers indépendants tout en restant 100% transparent pour votre application web (PHP/Laravel).  
> 2. **Vigilance DBA (Règle d'or MySQL)** : Quelle est la contrainte stricte imposée par InnoDB sur la clé primaire (`PRIMARY KEY`) lors du partitionnement ? Pourquoi l'erreur `ERROR 1503` apparaît-elle si l'on partitionne sur `prix` avec la structure par défaut ?

---

### Explication Détaillée des Commandes SQL

#### 🔹 Commande 1 : Partitionnement par `RANGE (id)` (Sur la Clé Primaire existante)

```sql
USE boutique;

ALTER TABLE produits
PARTITION BY RANGE (id) (
    PARTITION p_tranche_1   VALUES LESS THAN (15000),
    PARTITION p_tranche_2   VALUES LESS THAN (30000),
    PARTITION p_tranche_3   VALUES LESS THAN (45000),
    PARTITION p_tranche_max VALUES LESS THAN MAXVALUE
);
```

##### 🔬 Décorticage Ligne par Ligne :
1. `USE boutique;`  
   * **Action** : Sélectionne la base de données active `boutique` pour s'assurer que toutes les instructions s'appliquent à la bonne base.
2. `ALTER TABLE produits`  
   * **Action** : Modifie la structure de la table existante `produits`.
3. `PARTITION BY RANGE (id)`  
   * `PARTITION BY` : Clause déclenchant le partitionnement horizontal de la table.  
   * `RANGE` : Indique que le partitionnement se base sur des **intervalles continus** de valeurs (du plus petit au plus grand).  
   * `(id)` : La colonne de partitionnement. Ici, la colonne `id` est un entier (`INT`), ce qui satisfait directement la condition de MySQL qui exige un type entier dans `RANGE (expression)`. Comme `id` est la clé primaire unique de la table, **aucune violation de contrainte DBA n'est commise**.
4. `PARTITION p_tranche_1 VALUES LESS THAN (15000),`  
   * Crée la première partition physique nommée `p_tranche_1` (fichier `produits#p#p_tranche_1.ibd` sur disque).  
   * `VALUES LESS THAN (15000)` : Stocke strictement tous les enregistrements dont l'`id` est **strictement inférieur à 15 000** (de 1 à 14 999). L'identifiant 15 000 ira dans la partition suivante.
5. `PARTITION p_tranche_2 VALUES LESS THAN (30000),`  
   * Stocke les lignes où `15 000 <= id < 30 000`.
6. `PARTITION p_tranche_3 VALUES LESS THAN (45000),`  
   * Stocke les lignes où `30 000 <= id < 45 000`.
7. `PARTITION p_tranche_max VALUES LESS THAN MAXVALUE`  
   * `MAXVALUE` : Constante spéciale MySQL représentant l'infini supérieur ($+\infty$).  
   * **Rôle crucial** : Elle absorbe tous les `id >= 45 000` (ex: 54 638, 100 000, etc.). **Sans cette clause**, si vous tentez d'insérer un produit avec un `id` de 50 000, MySQL rejettera l'insertion avec l'erreur fatale : `ERROR 1526 (HY000): Table has no partition for value 50000`.

---

#### 🔹 Commande 2 : Partitionnement Métier par `RANGE COLUMNS (prix)` (Clé Primaire Composite)

```sql
USE boutique;

-- Étape 1 : Adapter la clé primaire pour intégrer la colonne de partitionnement
ALTER TABLE produits DROP PRIMARY KEY, ADD PRIMARY KEY (id, prix);

-- Étape 2 : Partitionnement par tranches de prix
ALTER TABLE produits
PARTITION BY RANGE COLUMNS (prix) (
    PARTITION p_entree_gamme VALUES LESS THAN (300.00),
    PARTITION p_milieu_gamme VALUES LESS THAN (800.00),
    PARTITION p_haut_gamme   VALUES LESS THAN (1300.00),
    PARTITION p_luxe         VALUES LESS THAN MAXVALUE
);
```

##### 🔬 Décorticage Ligne par Ligne :
1. `ALTER TABLE produits DROP PRIMARY KEY, ADD PRIMARY KEY (id, prix);`  
   * **Pourquoi cette ligne est obligatoire ?**  
     En vertu de la règle DBA MySQL : **toute colonne utilisée dans l'expression de partitionnement doit obligatoirement faire partie intégrante de toutes les clés primaires et index uniques**.  
     Si `prix` ne faisait pas partie de la clé primaire, MySQL devrait inspecter *toutes* les partitions pour vérifier l'unicité d'une clé primaire, ce qui détruirait l'intérêt du partitionnement physique.  
   * `DROP PRIMARY KEY` retire l'ancienne clé unique sur `id` seul.  
   * `ADD PRIMARY KEY (id, prix)` crée une clé primaire composite `(id, prix)`. L'unicité de chaque produit reste assurée car `id` est auto-incrémenté.
2. `PARTITION BY RANGE COLUMNS (prix)`  
   * **Différence capitale entre `RANGE` et `RANGE COLUMNS` :**  
     - `RANGE (expression)` exige impérativement que l'expression renvoie un entier (`INT`).  
     - `RANGE COLUMNS (colonne)` est une fonctionnalité avancée de MySQL permettant de partitionner directement sur des types non-entiers comme `DECIMAL(10,2)`, `DATE`, `DATETIME` ou `VARCHAR`, **sans nécessiter de conversion ou de fonction `CAST()`**.
3. `PARTITION p_entree_gamme VALUES LESS THAN (300.00),`  
   * Stocke les produits dont le prix est strictement inférieur à 300,00 €.
4. `PARTITION p_luxe VALUES LESS THAN MAXVALUE`  
   * Récupère tous les produits dont le prix est supérieur ou égal à 1 300,00 €.

---

## 2. FONDEMENT 2 : PARTITION PRUNING (ÉLAGAGE DE REQUÊTES)

### Énoncé théorique (Diapo 14) :
> *« Partition Pruning (Élagage) : L'optimiseur SQL ignore automatiquement les partitions non ciblées par la clause WHERE. »*

### Reformulation pour `boutique.produits` :
> **Question 2.1** :  
> Sur votre catalogue de 54 638 produits, un client filtre les produits par tranche de prix (`WHERE prix < 250.00`) ou par identifiant (`WHERE id BETWEEN 100 AND 5000`).  
> 1. Définissez le mécanisme d'élagage (*Partition Pruning*) de l'optimiseur de requêtes MySQL.  
> 2. Rédigez les requêtes avec `EXPLAIN` et analysez les colonnes du plan d'exécution prouvant que MySQL ne lit qu'une seule partition et ignore les 40 000+ autres lignes.

---

### Explication Détaillée des Commandes SQL

#### 🔹 Commande 1 : Diagnostic du Pruning sur `id`

```sql
USE boutique;

EXPLAIN SELECT id, nom, prix, en_stock
FROM produits
WHERE id BETWEEN 100 AND 5000;
```

##### 🔬 Décorticage Technique :
1. `EXPLAIN`  
   * Préfixe devant une requête `SELECT` qui demande à l'optimiseur MySQL de décomposer sa stratégie d'exécution sans exécuter la requête elle-même.
2. `SELECT id, nom, prix, en_stock FROM produits WHERE id BETWEEN 100 AND 5000;`  
   * Cible les produits dont l'`id` est compris entre 100 et 5 000.  
   * Comme la partition `p_tranche_1` couvre `id < 15000`, la totalité de l'intervalle `[100, 5000]` est contenue dans cette partition unique.

##### 📊 Décryptage du Résultat de l'EXPLAIN :
| Colonne de l'EXPLAIN | Valeur observée | Signification Technique |
| :--- | :--- | :--- |
| **`table`** | `produits` | Table ciblée. |
| **`partitions`** | **`p_tranche_1`** | **LE PRUNING S'EST PRODUIT !** MySQL n'ouvre que le sous-fichier physique `p_tranche_1.ibd`. Les partitions `p_tranche_2`, `p_tranche_3` et `p_tranche_max` sont purement et simplement ignorées. |
| **`type`** | `range` | Balayage d'un intervalle d'index (très rapide). |
| **`rows`** | ~4 901 | MySQL estime qu'il n'a à lire que ~4 901 lignes au lieu des 54 638 lignes de la table entière. Gain de lecture I/O : **> 90% d'économie**. |

---

#### 🔹 Commande 2 : Surveillance Métrique via `information_schema.PARTITIONS`

```sql
USE boutique;

SELECT 
    PARTITION_NAME,
    TABLE_ROWS,
    ROUND(DATA_LENGTH / 1024 / 1024, 2) AS data_mb,
    ROUND(INDEX_LENGTH / 1024 / 1024, 2) AS index_mb
FROM information_schema.PARTITIONS
WHERE TABLE_SCHEMA = 'boutique'
  AND TABLE_NAME = 'produits';
```

##### 🔬 Décorticage Technique :
1. `FROM information_schema.PARTITIONS`  
   * Accède au dictionnaire de données interne de MySQL qui recense l'état de chaque partition physique sur le disque.
2. `TABLE_ROWS`  
   * Nombre approximatif de lignes stockées dans la partition physique. Permet de vérifier si les données sont réparties équitablement.
3. `ROUND(DATA_LENGTH / 1024 / 1024, 2) AS data_mb`  
   * Convertit la taille des données brutes stockées (en octets) en Mégaoctets (Mo) pour visualiser l'empreinte disque de chaque partition.
4. `WHERE TABLE_SCHEMA = 'boutique' AND TABLE_NAME = 'produits'`  
   * Filtre uniquement sur votre base et votre table.

---

## 3. FONDEMENT 3 : MAINTENANCE INSTANTANÉE (DROP PARTITION VS DELETE)

### Énoncé théorique (Diapo 14) :
> *« Maintenance Instantanée : Purger des millions de lignes d'une année via DROP PARTITION en quelques millisecondes sans lock. »*

### Reformulation pour `boutique.produits` :
> **Question 3.1** :  
> La direction souhaite purger l'intégralité du catalogue des anciens produits (les 15 000 premiers produits de `p_tranche_1`).  
> Comparez de manière exhaustive le comportement du moteur InnoDB entre un `DELETE FROM produits WHERE id < 15000;` et la commande `ALTER TABLE produits DROP PARTITION p_tranche_1;`.  
> **Question 3.2** :  
> Comment vider les données d'une partition sans détruire sa structure (`TRUNCATE PARTITION`) ?

---

### Explication Détaillée des Commandes SQL

#### 🔹 Commande 1 : Suppression Définitive d'une Partition (`DROP PARTITION`)

```sql
USE boutique;

ALTER TABLE produits DROP PARTITION p_tranche_1;
```

##### 🔬 Décorticage Technique & Comparatif avec `DELETE` :
* **Que fait `DELETE FROM produits WHERE id < 15000;` ?**
  1. MySQL parcourt les 15 000 lignes une par une (*row-by-row*).
  2. Pour chaque ligne supprimée, il écrit l'état précédent dans l'espace **Undo Log** (pour permettre un `ROLLBACK`).
  3. Il écrit chaque suppression dans les **Redo Logs** et le **Binary Log**.
  4. Il pose des verrous exclusifs de ligne (*Exclusive Row Locks*) et d'intervalles (*Gap Locks*), empêchant les clients d'insérer ou de mettre à jour des produits.
  5. Il laisse des "trous" vides fragmentés dans le fichier `.ibd` sans rendre l'espace disque au système d'exploitation.
  6. Temps moyen sur 15 000 lignes : **plusieurs secondes, voire minutes**, surchargeant le CPU et la RAM.

* **Que fait `ALTER TABLE produits DROP PARTITION p_tranche_1;` ?**
  1. MySQL modifie une seule ligne de métadonnées dans son dictionnaire interne.
  2. Le moteur InnoDB appelle directement le système d'exploitation pour détruire le fichier physique `produits#p#p_tranche_1.ibd` via un simple appel système `unlink()`.
  3. Aucun Undo Log n'est généré (l'opération est DDL, non soumise au rollback ligne par ligne).
  4. Aucun verrou prolongé sur la table.
  5. Temps moyen : **~5 à 15 millisecondes**, même pour 1 million de lignes ! L'espace disque est immédiatement restitué à l'OS.

---

#### 🔹 Commande 2 : Vider une Partition sans la Détruire (`TRUNCATE PARTITION`)

```sql
USE boutique;

ALTER TABLE produits TRUNCATE PARTITION p_tranche_1;
```

##### 🔬 Décorticage :
* `DROP PARTITION` supprime **les données ET la définition de la partition**. Si vous insérez ensuite un produit avec `id = 10`, MySQL échouera car la plage n'existe plus.  
* `TRUNCATE PARTITION` supprime **100% des lignes instantanément**, mais **conserve la coquille de la partition**. La plage `id < 15000` reste prête à accueillir de nouvelles insertions.

---

#### 🔹 Commande 3 : Découpage / Réorganisation à Chaud (`REORGANIZE PARTITION`)

```sql
USE boutique;

ALTER TABLE produits REORGANIZE PARTITION p_tranche_max INTO (
    PARTITION p_tranche_4   VALUES LESS THAN (60000),
    PARTITION p_tranche_max VALUES LESS THAN MAXVALUE
);
```

##### 🔬 Décorticage :
* **Problème** : Dans une table partitionnée avec `MAXVALUE`, on ne peut pas utiliser un simple `ADD PARTITION` car `MAXVALUE` couvre déjà tout jusqu'à l'infini.
* **Solution** : `REORGANIZE PARTITION` permet de scinder la partition de queue `p_tranche_max` en deux sous-partitions sans interrompre le service ni perdre une seule ligne existante.

---

## 4. FONDEMENT 4 : LES 4 MODES MAJEURS DE PARTITIONNEMENT

### Énoncé théorique (Diapo 14) :
> *« Modes Majeurs : RANGE (intervalles continus), LIST (listes discrètes), HASH et KEY (hachage uniforme). »*

### Reformulation pour `boutique.produits` :
> **Question 4.1** :  
> Rédigez la requête de création de table illustrant chacun des 4 modes majeurs pour le catalogue `boutique` :  
> 1. **Mode RANGE** : Découpage par lots croissants sur `id`.  
> 2. **Mode LIST** : Découpage par état fini de stock (`en_stock` : 0 = Rupture, 1 = Disponible).  
> 3. **Mode HASH** : Répartition mathématique automatique en 4 partitions équilibrées.  
> 4. **Mode KEY** : Variante optimisée par l'algorithme interne de hachage MySQL.

---

### Explication Détaillée des 4 Modes

```
                        ┌────────────────────────────────────────────────────────┐
                        │      LES 4 MODES MAJEURS DE PARTITIONNEMENT MYSQL      │
                        └────────────────────────────────────────────────────────┘
                                                    │
         ┌──────────────────────────┬───────────────┴──────────────┬──────────────────────────┐
         ▼                          ▼                              ▼                          ▼
   1. RANGE / COLUMNS            2. LIST                        3. HASH                    4. KEY
 (Intervalles continus)     (Listes discrètes)            (Hachage arithmétique)      (Hachage interne MD5)
 Ex: id < 20000, 40000...   Ex: en_stock IN (0), (1)      Ex: HASH(id) PARTITIONS 4   Ex: KEY() PARTITIONS 4
```

---

### 🔹 Mode 1 : `PARTITION BY RANGE (id)`

```sql
CREATE TABLE IF NOT EXISTS produits_range (
    id INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    en_stock TINYINT(1) DEFAULT '1',
    spec JSON NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB
PARTITION BY RANGE (id) (
    PARTITION p_lot1  VALUES LESS THAN (20000),
    PARTITION p_lot2  VALUES LESS THAN (40000),
    PARTITION p_lot3  VALUES LESS THAN (60000),
    PARTITION p_futur VALUES LESS THAN MAXVALUE
);
```
* **Principe** : Découpage par bornes strictes.
* **Cas d'usage e-commerce** : Historiques de ventes par année (`YEAR(date_vente)`), archivage de logs, tranches d'identifiants chronologiques.

---

### 🔹 Mode 2 : `PARTITION BY LIST (en_stock)`

```sql
CREATE TABLE IF NOT EXISTS produits_list (
    id INT NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    en_stock TINYINT(1) NOT NULL DEFAULT '1',
    spec JSON NOT NULL,
    PRIMARY KEY (id, en_stock)
) ENGINE=InnoDB
PARTITION BY LIST (en_stock) (
    PARTITION p_rupture_stock VALUES IN (0),
    PARTITION p_en_stock      VALUES IN (1)
);
```

##### 🔬 Décorticage :
* `PARTITION BY LIST (en_stock)` : Ne fonctionne pas par comparaison d'intervalles (`<`), mais par **appartenance explicite à un ensemble fini de valeurs**.
* `PARTITION p_rupture_stock VALUES IN (0)` : Tout produit avec `en_stock = 0` est rangé ici.
* `PARTITION p_en_stock VALUES IN (1)` : Tout produit avec `en_stock = 1` est rangé ici.
* **Vigilance DBA** : `PRIMARY KEY (id, en_stock)` est obligatoire car `en_stock` est la colonne de partitionnement.

---

### 🔹 Mode 3 : `PARTITION BY HASH (id) PARTITIONS 4`

```sql
CREATE TABLE IF NOT EXISTS produits_hash (
    id INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    en_stock TINYINT(1) DEFAULT '1',
    spec JSON NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB
PARTITION BY HASH (id)
PARTITIONS 4;
```

##### 🔬 Décorticage :
* `PARTITION BY HASH (id)` : MySQL applique une fonction arithmétique de modulo :  
  $$\text{Numéro de partition} = \text{id} \pmod 4$$
  - Si `id = 1` $\rightarrow 1 \pmod 4 = 1 \rightarrow$ partition `p1`
  - Si `id = 2` $\rightarrow 2 \pmod 4 = 2 \rightarrow$ partition `p2`
  - Si `id = 3` $\rightarrow 3 \pmod 4 = 3 \rightarrow$ partition `p3`
  - Si `id = 4` $\rightarrow 4 \pmod 4 = 0 \rightarrow$ partition `p0`
* `PARTITIONS 4` : Crée automatiquement 4 partitions physiques (`p0`, `p1`, `p2`, `p3`) contenant chacune environ $54\,638 / 4 \approx 13\,659$ lignes.
* **Objectif** : Éviter les goulots d'étranglement (*hotspots*) d'écritures en répartissant la charge de manière 100% égale sur plusieurs disques.

---

### 🔹 Mode 4 : `PARTITION BY KEY () PARTITIONS 4`

```sql
CREATE TABLE IF NOT EXISTS produits_key (
    id INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    en_stock TINYINT(1) DEFAULT '1',
    spec JSON NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB
PARTITION BY KEY ()
PARTITIONS 4;
```

##### 🔬 Décorticage :
* `PARTITION BY KEY ()` : Variante optimisée de `HASH`. Les parenthèses vides `()` signifient que MySQL prend **automatiquement la clé primaire (`id`)** sans que vous ayez besoin de la repréciser.
* **Différence avec HASH** : `HASH` n'accepte que des expressions renvoyant un entier, alors que `KEY` accepte des colonnes non-entières (comme des `VARCHAR` ou `UUID`) car MySQL utilise sa propre fonction de dispersion cryptographique interne (base MD5/Murmur).

---

## 5. TABLEAU COMPARATIF EXHAUSTIF DES 4 MODES

| Critère | MODE RANGE | MODE LIST | MODE HASH | MODE KEY |
| :--- | :--- | :--- | :--- | :--- |
| **Logique de découpage** | Intervalles continus (`< x`) | Énumération discrète (`IN (...)`) | Modulo arithmétique (`expr % N`) | Hachage interne MySQL |
| **Colonnes acceptées** | Entiers (ou non-entiers avec `RANGE COLUMNS`) | Entiers (ou chaînes avec `LIST COLUMNS`) | Uniquement expressions entières | Tous types de clés (y compris UUID/VARCHAR) |
| **Élagage (*Pruning*)** | Exceptionnel sur plages (`BETWEEN`, `<`, `>`) | Exceptionnel sur égalité (`=`, `IN`) | Actif uniquement sur égalité exacte (`=`) | Actif uniquement sur égalité exacte (`=`) |
| **Maintenance `DROP PARTITION`** | Idéal pour purger une tranche entière | Idéal pour purger une catégorie | Non applicable (déséquilibre le modulo) | Non applicable |
| **Cas type Boutique** | Tranches de prix ou ID séquentiels | Disponibilité en stock (0 / 1) | Distribution égale de 55 000 produits | Distribution par code produit ou clé |

---

## 6. SCRIPT DE TEST RAPIDE & SANS RISQUE

Pour vous entraîner sans toucher à votre vraie table `boutique.produits`, exécutez ces requêtes dans votre console MySQL :

```sql
USE boutique;

-- 1. Créer une table de démonstration avec 3 partitions
CREATE TABLE IF NOT EXISTS produits_demo (
    id INT NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    en_stock TINYINT(1) DEFAULT '1',
    spec JSON NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB
PARTITION BY RANGE (id) (
    PARTITION p_part1 VALUES LESS THAN (20000),
    PARTITION p_part2 VALUES LESS THAN (40000),
    PARTITION p_part3 VALUES LESS THAN MAXVALUE
);

-- 2. Copier un échantillon de 100 vrais produits
INSERT INTO produits_demo SELECT * FROM produits LIMIT 100;

-- 3. Tester le Partition Pruning avec EXPLAIN
EXPLAIN SELECT * FROM produits_demo WHERE id = 42;
```
