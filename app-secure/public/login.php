<?php
/* =====================================================================
 * app-vulnerable/public/login.php
 * ---------------------------------------------------------------------
 * Connexion cohérente avec le schéma : colonnes `identifiant` /
 * `mot_de_passe` (et non username/password). Mots de passe EN CLAIR
 * (version vulnérable) -> comparaison directe.
 * auth.php est inclus EN PREMIER : il démarre la session avec le cookie
 * sans HttpOnly (indispensable au scénario XSS).
 * ===================================================================== */

require_once __DIR__ . '/../includes/auth.php';    // démarre la session
require_once __DIR__ . '/../config/database.php';  // $pdo

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifiant = trim($_POST['identifiant'] ?? '');
    $motdepasse  = $_POST['mot_de_passe'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM users WHERE identifiant = ?');
    $stmt->execute([$identifiant]);
    $user = $stmt->fetch();

    // Comparaison en clair (mots de passe non hachés dans la version vulnérable)
    if ($user && hash_equals($user['mot_de_passe'], $motdepasse)) {
        session_regenerate_id(true);
        $_SESSION['user'] = $user;
        header('Location: ' . ($user['role'] === 'admin' ? '../admin/messages.php' : 'index.php'));
        exit;
    }
    $erreur = 'Identifiant ou mot de passe incorrect.';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<h1>Connexion</h1>

<?php if ($erreur): ?>
    <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="identifiant" placeholder="Identifiant" required><br><br>
    <input type="password" name="mot_de_passe" placeholder="Mot de passe" required><br><br>
    <button type="submit">Se connecter</button>
</form>

<a href="register.php">Créer un compte</a>
</body>
</html>
