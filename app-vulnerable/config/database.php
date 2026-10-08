<?php
/* =====================================================================
 * Connexion à la base de données (PDO)
 * ---------------------------------------------------------------------
 * ATTENTION : ce fichier est partagé avec le Membre 1 (socle applicatif).
 * À réconcilier avec sa version pour n'en garder qu'une seule.
 * Adapte les identifiants à ta config MySQL locale.
 * ===================================================================== */

$DB_HOST = '127.0.0.1';
$DB_NAME = 'ehapp';
$DB_USER = 'ehapp';
$DB_PASS = 'changeme';

try {
    $pdo = new PDO(
        "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4",
        $DB_USER,
        $DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die('Erreur de connexion BDD : ' . $e->getMessage());
}
