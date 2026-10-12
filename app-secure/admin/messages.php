<?php
// <<< REMÉDIATION 1 : Ajout de la politique CSP (Content Security Policy)
// On bloque l'exécution de tout script inline (les balises <script> injectées ne s'exécuteront pas)
header("Content-Security-Policy: default-src 'self'; script-src 'none';");

require_once DIR . '/../config/database.php';   // $pdo
require_once DIR . '/../includes/auth.php';     // fourni par Membre 1

require_admin();

$stmt = $pdo->query(
    'SELECT id, nom, email, sujet, message, date_envoi
     FROM messages
     ORDER BY date_envoi DESC'
);
$messages = $stmt->fetchAll();
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
                    <strong><?= htmlspecialchars($m['nom']) ?></strong>
                    &lt;<?= htmlspecialchars($m['email']) ?>&gt;
                    <span class="date"><?= htmlspecialchars($m['date_envoi']) ?></span>
                </header>

                <!-- <<< REMÉDIATION 2 : Échappement des sorties avec htmlspecialchars -->
                <h2 class="sujet"><?= htmlspecialchars($m['sujet'], ENT_QUOTES, 'UTF-8') ?></h2>

                <!-- <<< REMÉDIATION 2 : Échappement des sorties avec htmlspecialchars -->
                <div class="corps"><?= htmlspecialchars($m['message'], ENT_QUOTES, 'UTF-8') ?></div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</main>
</body>
</html>
