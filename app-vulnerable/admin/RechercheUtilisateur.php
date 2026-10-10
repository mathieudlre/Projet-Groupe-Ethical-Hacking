<?php
require_once '../includes/auth.php';
require_once '../config/database.php'; // Utilisation du $pdo global

$resultats = [];
$erreur_sql = null;

if (isset($_GET['nom'])) {
    $nom = $_GET['nom'];

    try {
        // !!! VULNÉRABLE (volontaire) : Concaténation directe pour l'injection SQL UNION-based
        $sql = "SELECT identifiant, adresse, date_naissance FROM users WHERE identifiant LIKE '%$nom%'";
        $stmt = $pdo->query($sql);
        $resultats = $stmt->fetchAll();
    } catch (PDOException $e) {
        // Utile pour l'attaque UNION-based (affichage des erreurs SQL)
        $erreur_sql = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche utilisateur</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>
<body>
<main style="padding: 40px;">
    <h1>Recherche d'utilisateur (Admin)</h1>
    <form method="get">
        <input type="text" name="nom" placeholder="Rechercher un utilisateur" style="padding: 8px; width: 300px;">
        <button type="submit" style="padding: 8px 15px;">Rechercher</button>
    </form>

    <?php if ($erreur_sql): ?>
        <p style="color:red; margin-top: 15px;">Erreur SQL : <?= htmlspecialchars($erreur_sql) ?></p>
    <?php endif; ?>

    <table border="1" cellpadding="10" style="margin-top: 20px; border-collapse: collapse; width: 100%;">
        <tr>
            <th>Identifiant</th>
            <th>Adresse</th>
            <th>Date de naissance</th>
        </tr>
        <?php if (!empty($resultats)): ?>
            <?php foreach ($resultats as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['identifiant']) ?></td>
                    <td><?= htmlspecialchars($r['adresse']) ?></td>
                    <td><?= htmlspecialchars($r['date_naissance']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3" style="text-align: center;">Aucun résultat</td></tr>
        <?php endif; ?>
    </table>
</main>
</body>
</html>