<?php
/* =====================================================================
 * Formulaire de contact PUBLIC
 * Brique : Membre 2
 * ---------------------------------------------------------------------
 * Accessible sans authentification. Enregistre un message en base.
 *
 * NOTE SÉCURITÉ (version vulnérable) :
 *   - L'INSERT utilise une requête préparée -> le formulaire n'est PAS
 *     injectable en SQL (la SQLi est une autre brique, côté admin).
 *   - Mais AUCUN échappement HTML n'est appliqué : le contenu (dont un
 *     éventuel <script>) est stocké tel quel. La faille XSS stockée se
 *     déclenchera plus tard, à l'affichage dans le back-office admin
 *     (voir admin/messages.php).
 * ===================================================================== */

require_once __DIR__ . '/../config/database.php';   // fournit $pdo (voir Membre 1)

$sent  = false;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom     = trim($_POST['nom']     ?? '');
    $email   = trim($_POST['email']   ?? '');
    $sujet   = trim($_POST['sujet']   ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($nom === '' || $email === '' || $sujet === '' || $message === '') {
        $error = 'Tous les champs sont obligatoires.';
    } else {
        // Requête préparée : protège de la SQLi. Les valeurs partent
        // telles quelles en base (pas de nettoyage anti-XSS = volontaire).
        $stmt = $pdo->prepare(
            'INSERT INTO messages (nom, email, sujet, message)
             VALUES (:nom, :email, :sujet, :message)'
        );
        $stmt->execute([
            ':nom'     => $nom,
            ':email'   => $email,
            ':sujet'   => $sujet,
            ':message' => $message,
        ]);
        $sent = true;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nous contacter</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<main class="card">
    <h1>Nous contacter</h1>

    <?php if ($sent): ?>
        <p class="ok">Merci, votre message a bien été envoyé. Notre équipe vous répondra rapidement.</p>
        <p><a href="contact.php">Envoyer un autre message</a></p>
    <?php else: ?>
        <?php if ($error): ?>
            <p class="err"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="post" action="contact.php">
            <label>Nom
                <input type="text" name="nom" required>
            </label>
            <label>Email
                <input type="email" name="email" required>
            </label>
            <label>Sujet
                <input type="text" name="sujet" required>
            </label>
            <label>Message
                <textarea name="message" rows="6" required></textarea>
            </label>
            <button type="submit">Envoyer</button>
        </form>
    <?php endif; ?>
</main>
</body>
</html>
