<?php
require_once __DIR__ . '/../includes/auth.php';   // démarre la session proprement
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Vulnérable</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <div class="logo">AppVuln</div>
        <nav>
            <?php if (isset($_SESSION['user'])): ?>
                <span style="color: white; margin-right: 15px;">Bienvenue, <?php echo htmlspecialchars($_SESSION['user']['identifiant']); ?></span>
                <a href="logout.php" class="btn secondary">Déconnexion</a>
            <?php else: ?>
                <a href="login.php" class="btn">Connexion</a>
            <?php endif; ?>
            <a href="../admin/messages.php" class="btn secondary">Admin</a>
        </nav>
    </header>

    <main>
        <section class="hero">
            <h1>Application vulnérable</h1>
            <p>Bienvenue sur la plateforme de test de failles web.</p>
            <div class="buttons">
                <a href="contact.php" class="btn secondary">Nous contacter</a>
            </div>
        </section>
    </main>

    <footer>
        <p>Projet Ethical Hacking</p>
    </footer>
</body>
</html>
