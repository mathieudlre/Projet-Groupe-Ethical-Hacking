<?php
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
</body>
</html>