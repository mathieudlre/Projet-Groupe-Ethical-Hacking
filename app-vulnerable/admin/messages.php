<?php
/* =====================================================================
 * Back-office : consultation des messages de contact
 * Brique : Membre 2   —   *** POINT VULNÉRABLE AU XSS STOCKÉ ***
 * ---------------------------------------------------------------------
 * Réservé à l'administrateur. Liste les messages reçus et affiche leur
 * contenu. C'est ICI que la faille se déclenche : le sujet et le message
 * sont réaffichés SANS échappement (pas de htmlspecialchars).
 *
 * Quand l'admin ouvre cette page, son navigateur exécute tout <script>
 * présent dans un message -> XSS stocké -> vol du cookie de session.
 *
 * Localisation exacte de la faille pour le rapport :
 *   - fichier : admin/messages.php
 *   - champs  : "sujet" et "message"
 *   - lignes  : voir les commentaires "<<< FAILLE XSS" plus bas
 * ===================================================================== */

require_once __DIR__ . '/../config/database.php';   // $pdo
require_once __DIR__ . '/../includes/auth.php';     // fourni par Membre 1

require_admin();   // bloque l'accès si l'utilisateur n'est pas admin

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
