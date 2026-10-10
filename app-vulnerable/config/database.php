<?php
<<<<<<< HEAD
$host = "localhost";
$dbname = "app_vulnerable";
$username = "appuser";
$password = "app123";
=======
/* =====================================================================
 * app-vulnerable/config/database.php  —  CONFIG UNIQUE (base "ehapp")
 * ---------------------------------------------------------------------
 * Expose :
 *   - $pdo                  : objet PDO prêt à l'emploi
 *   - get_pdo_connection()  : PDO   (pages login/contact/messages/secure)
 *   - get_connection()      : mysqli (page de recherche VULNÉRABLE)
 *
 * Identifiants par défaut = MySQL de XAMPP (root sans mot de passe).
 * Adapte $DB_USER / $DB_PASS si ta config est différente.
 * ===================================================================== */

$DB_HOST = '127.0.0.1';
$DB_NAME = 'ehapp';
$DB_USER = 'root';
$DB_PASS = '';
>>>>>>> caa65dd59013646168dfec579d410b101dd24e85

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
        ]
    );
}

function get_connection(): mysqli
{
    global $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS;
    // Pas de mode exception mysqli : on veut afficher $conn->error à l'écran
    // (utile pour l'étape ORDER BY de l'attaque SQLi).
    mysqli_report(MYSQLI_REPORT_OFF);
    $conn = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    if ($conn->connect_errno) {
        die('Erreur de connexion BDD (mysqli) : ' . $conn->connect_error);
    }
    $conn->set_charset('utf8mb4');
    return $conn;
}

try {
    $pdo = get_pdo_connection();
} catch (PDOException $e) {
    die('Erreur de connexion BDD : ' . $e->getMessage());
}
