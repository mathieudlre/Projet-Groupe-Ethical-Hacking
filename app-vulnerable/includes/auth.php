<?php
// app-vulnerable/includes/auth.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function require_admin() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        http_response_code(403);
        die("Accès refusé : réservé à l'administrateur.");
    }
}

function is_logged_in() {
    return isset($_SESSION['user']);
}