<?php
/* =====================================================================
 * app-vulnerable/config/db.php
 * ---------------------------------------------------------------------
 * Alias historique : certaines pages font `require '../config/db.php'`.
 * On redirige vers la config unique pour éviter toute divergence.
 * ===================================================================== */
require_once __DIR__ . '/database.php';
