<?php
/* =====================================================================
 * app-vulnerable/includes/auth.php  —  VERSION VULNÉRABLE
 * ---------------------------------------------------------------------
 * *** POINT CLÉ DU SCÉNARIO XSS ***
 * Le cookie de session est volontairement SANS HttpOnly : il reste
 * lisible via JavaScript (document.cookie), ce qui rend possible le vol
 * de session par le payload XSS. La version corrigée le remettra à true.
 * ===================================================================== */

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', '0');   // <<< faille volontaire
    ini_set('session.cookie_secure',   '0');
    session_set_cookie_params([
        'httponly' => false,   // <<< cookie lisible en JS
        'secure'   => false,
        'samesite' => 'Lax',
    ]);
    session_start();
}

/** Bloque l'accès si l'utilisateur n'est pas admin. */
function require_admin() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        http_response_code(403);
        die("Accès refusé : réservé à l'administrateur.");
    }
}

function is_admin() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

function is_logged_in() {
    return isset($_SESSION['user']);
}

function logout() {
    $_SESSION = [];
    session_destroy();
}
