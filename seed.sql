-- Génère :n formations fictives (10 000 par défaut via seed.php)
-- CTE récursive : n(i) produit les nombres 1, 2, 3, … :n
WITH RECURSIVE n(i) AS (
    SELECT 1
    UNION ALL
    SELECT i + 1 FROM n WHERE i < CAST(:n AS INTEGER)   -- CAST obligatoire, voir seed.php
)
INSERT INTO formations (titre, description, niveau)
SELECT
    'Formation n° ' || i,
    'Description générée automatiquement pour le test de charge (ligne ' || i || ').',
    'L' || (1 + i % 3)          -- répartit sur L1, L2, L3
FROM n;
