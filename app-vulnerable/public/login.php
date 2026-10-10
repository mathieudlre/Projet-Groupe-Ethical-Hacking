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
<<<<<<< HEAD
        header("Location: index.php");
        exit;
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect";
=======
        header('Location: ' . ($user['role'] === 'admin' ? '../admin/messages.php' : 'index.html'));
        exit;
>>>>>>> caa65dd59013646168dfec579d410b101dd24e85
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
<<<<<<< HEAD
<body class="login-page">

<form method="POST" action="login.php">
    <h1>Connexion</h1>

    <?php if (isset($error)): ?>
        <p style="color: red; text-align: center; margin-bottom: 15px;"><?php echo $error; ?></p>
    <?php endif; ?>

    <input type="text" name="username" placeholder="Nom d'utilisateur" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
=======
<body>
<h1>Connexion</h1>

<?php if ($erreur): ?>
    <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="identifiant" placeholder="Identifiant" required><br><br>
    <input type="password" name="mot_de_passe" placeholder="Mot de passe" required><br><br>
>>>>>>> caa65dd59013646168dfec579d410b101dd24e85
    <button type="submit">Se connecter</button>

<<<<<<< HEAD
    <a href="register.php">Créer un compte</a>
</form>

=======
<a href="register.php">Créer un compte</a>
>>>>>>> caa65dd59013646168dfec579d410b101dd24e85
</body>
</html>
