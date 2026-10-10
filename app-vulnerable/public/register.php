<?php
<<<<<<< HEAD
require_once "../config/database.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $password = $_POST["password"] ?? '';

    if (!empty($username) && !empty($email) && !empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashed_password]);
            $success = "Compte créé avec succès ! Vous pouvez vous connecter.";
        } catch (PDOException $e) {
            $error = "Erreur lors de l'inscription (email ou nom d'utilisateur déjà pris ?)";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
=======
/* =====================================================================
 * app-vulnerable/public/register.php
 * ---------------------------------------------------------------------
 * Création de compte (role 'user'), cohérente avec le schéma.
 * L'INSERT est une requête préparée : l'inscription N'EST PAS le point
 * d'injection (la SQLi ciblée est dans la recherche admin).
 * Mot de passe stocké EN CLAIR (version vulnérable).
 * ===================================================================== */

require_once __DIR__ . '/../config/database.php';  // $pdo

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifiant = trim($_POST['identifiant'] ?? '');
    $motdepasse  = $_POST['mot_de_passe'] ?? '';

    if ($identifiant !== '' && $motdepasse !== '') {
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO users (identifiant, mot_de_passe, role) VALUES (?, ?, 'user')"
            );
            $stmt->execute([$identifiant, $motdepasse]);
            $message = "Compte créé. Vous pouvez maintenant vous connecter.";
        } catch (PDOException $e) {
            // 23000 = violation de contrainte (identifiant déjà pris)
            $message = ($e->getCode() === '23000')
                ? "Cet identifiant existe déjà."
                : "Erreur : " . $e->getMessage();
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
>>>>>>> caa65dd59013646168dfec579d410b101dd24e85
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="register-page">
<<<<<<< HEAD
    <form method="POST">
        <h1>Inscription</h1>
        
        <?php if (!empty($error)): ?>
            <p style="color: red; text-align: center; margin-bottom: 15px;"><?= $error ?></p>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <p style="color: green; text-align: center; margin-bottom: 15px;"><?= $success ?></p>
        <?php endif; ?>

        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">S'inscrire</button>

        <a href="login.php">Déjà un compte ? Connexion</a>
    </form>
=======
<h1>Inscription</h1>

<?php if ($message): ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="identifiant" placeholder="Identifiant" required><br><br>
    <input type="password" name="mot_de_passe" placeholder="Mot de passe" required><br><br>
    <button type="submit">S'inscrire</button>
</form>

<a href="login.php">Connexion</a>
>>>>>>> caa65dd59013646168dfec579d410b101dd24e85
</body>
</html>
