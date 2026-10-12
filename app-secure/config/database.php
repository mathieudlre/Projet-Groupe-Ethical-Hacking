<?php
/* =====================================================================
 * app-secure/config/database.php  —  CONFIG (base "ehapp")
 * ---------------------------------------------------------------------
 * Version sécurisée : uniquement PDO, en mode exception, requêtes
 * préparées réelles côté serveur (EMULATE_PREPARES = false).
 * ===================================================================== */

$DB_HOST = '127.0.0.1';
$DB_NAME = 'ehapp';
$DB_USER = 'root';
$DB_PASS = '';

function get_pdo_connection(): PDO
{
    global $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS;
    return new PDO(
        "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4",
        $DB_USER,
        $DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
}

try {
    $pdo = get_pdo_connection();
} catch (PDOException $e) {
    // On ne divulgue pas le détail de l'erreur côté client (bonne pratique).
    http_response_code(500);
    die('Erreur de connexion à la base de données.');
}
