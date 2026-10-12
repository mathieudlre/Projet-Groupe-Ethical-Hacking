<?php
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
</body>
</html>
