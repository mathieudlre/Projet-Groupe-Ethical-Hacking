<?php

require_once __DIR__ . '/../config/database.php';   // $pdo
require_once __DIR__ . '/../includes/auth.php';     // fourni par Membre 1

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
                    <!-- Le NOM et l'EMAIL sont échappés : volontairement NON vulnérables,
                         pour montrer dans le rapport que seuls sujet/message sont touchés. -->
                    <strong><?= htmlspecialchars($m['nom']) ?></strong>
                    &lt;<?= htmlspecialchars($m['email']) ?>&gt;
                    <span class="date"><?= htmlspecialchars($m['date_envoi']) ?></span>
                </header>

                <!-- <<< FAILLE XSS STOCKÉ (sujet affiché brut, sans htmlspecialchars) -->
                <h2 class="sujet"><?= $m['sujet'] ?></h2>

                <!-- <<< FAILLE XSS STOCKÉ (message affiché brut, sans htmlspecialchars) -->
                <div class="corps"><?= $m['message'] ?></div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</main>
</body>
</html>
