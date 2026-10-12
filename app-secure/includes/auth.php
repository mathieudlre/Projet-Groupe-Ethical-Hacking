<?php
/* =====================================================================
 * app-secure/includes/auth.php  —  VERSION CORRIGÉE
 * ---------------------------------------------------------------------
 * Remédiation vol de session : le cookie de session est protégé.
 *   - HttpOnly = true  -> le cookie N'EST PLUS lisible via JavaScript
 *                         (document.cookie) : le payload XSS ne peut plus
 *                         le voler, même s'il parvenait à s'exécuter.
 *   - SameSite = Strict -> limite l'envoi du cookie en cross-site (CSRF).
 *   - Secure   = true à activer en HTTPS (laissé false pour un lab en HTTP).
 * ===================================================================== */

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', '1');    // <<< correction : cookie inaccessible au JS
    ini_set('session.use_strict_mode', '1');
    session_set_cookie_params([
        'httponly' => true,     // <<< correction
        'secure'   => false,    // passer à true derrière HTTPS
        'samesite' => 'Strict',
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
