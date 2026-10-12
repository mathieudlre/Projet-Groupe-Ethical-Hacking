<?php
/* =====================================================================
 * app-secure/admin/messages.php  —  VERSION CORRIGÉE (remédiation XSS)
 * ---------------------------------------------------------------------
 * Correctifs par rapport à la version vulnérable :
 *   1. Toutes les sorties sont échappées avec htmlspecialchars()
 *      -> un <script> stocké s'affiche comme du texte, il ne s'exécute plus.
 *   2. En-tête Content-Security-Policy (défense en profondeur) : même si un
 *      script passait, le navigateur refuserait de l'exécuter.
 * ===================================================================== */

require_once __DIR__ . '/../config/database.php';   // $pdo
require_once __DIR__ . '/../includes/auth.php';     // require_admin()

require_admin();

// Remédiation XSS (défense en profondeur) : politique de sécurité du contenu.
// 'self' uniquement -> pas de script inline, pas de script externe non autorisé.
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self'; base-uri 'self'");
header("X-Content-Type-Options: nosniff");

$stmt = $pdo->query(
    'SELECT id, nom, email, sujet, message, date_envoi
     FROM messages
     ORDER BY date_envoi DESC'
);
$messages = $stmt->fetchAll();

/** Raccourci d'échappement HTML. */
function e(?string $v): string {
    return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Messages reçus</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>
<body>
<main class="wide">
    <h1>Messages reçus (<?= count($messages) ?>)</h1>

    <?php if (!$messages): ?>
        <p>Aucun message pour le moment.</p>
    <?php else: ?>
        <?php foreach ($messages as $m): ?>
            <article class="msg">
                <header>
                    <strong><?= e($m['nom']) ?></strong>
                    &lt;<?= e($m['email']) ?>&gt;
                    <span class="date"><?= e($m['date_envoi']) ?></span>
                </header>

                <!-- CORRIGÉ : sujet et message échappés -> plus d'exécution de script -->
                <h2 class="sujet"><?= e($m['sujet']) ?></h2>
                <div class="corps"><?= nl2br(e($m['message'])) ?></div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</main>
</body>
</html>
