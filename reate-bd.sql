💡 CORRIGÉ OFFICIEL (BASH / SQL
-- 1. Supprimer l'ancienne procédure défectueuse
DROP PROCEDURE IF EXISTS GenererProduitsMassifs;

-- 2. Changer le délimiteur
DELIMITER //

-- 3. Créer la procédure corrigée avec la colonne 'spec'
CREATE PROCEDURE GenererProduitsMassifs()
BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE random_ram INT;
    DECLARE random_prix DECIMAL(10,2);

    WHILE i <= 1000 DO
        SET random_ram = ELT(FLOOR(1 + RAND() * 4), 4, 8, 16, 32);
        SET random_prix = ROUND(50 + (RAND() * 1500), 2);

        INSERT INTO produits (nom, prix, en_stock, spec)
        VALUES (
            CONCAT('Produit Test - ', i),
            random_prix,
            IF(RAND() > 0.1, TRUE, FALSE),
            JSON_OBJECT(
                'ram', random_ram,
                'couleur', ELT(FLOOR(1 + RAND() * 3), 'noir', 'gris', 'argent'),
                'garantie', FLOOR(1 + RAND() * 3),
                'id_virtuel', i
            )
        );

        SET i = i + 1;
    END WHILE;
END

DELIMITER //


-- 5. Exécuter la nouvelle procédure
CALL GenererProduitsMassifs();

-- 6. Nettoyer la procédure après exécution
DROP PROCEDURE GenererProduitsMassifs;
)

