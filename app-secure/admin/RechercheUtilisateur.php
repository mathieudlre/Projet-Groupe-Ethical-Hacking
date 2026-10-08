<?php
require_once '../includes/auth.php';
require_once '../config/db.php';   // doit exposer get_pdo_connection()

$resultats = [];

if (isset($_GET['nom'])) {
    $nom = trim($_GET['nom']);

    if (preg_match('/^[a-zA-Z0-9._-]{0,50}$/', $nom)) {
        $pdo = get_pdo_connection();
        $stmt = $pdo->prepare(
            "SELECT identifiant, adresse, date_naissance FROM users WHERE identifiant LIKE :nom"
        );
        $stmt->execute(['nom' => '%' . $nom . '%']);
        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Recherche utilisateur</title></head>
<body>
<h1>Recherche d'utilisateur</h1>
<form method="get">
    <input type="text" name="nom" placeholder="Rechercher un utilisateur">
    <button type="submit">Rechercher</button>
</form>
<table border="1">
<tr><th>Identifiant</th><th>Adresse</th><th>Date de naissance</th></tr>
<?php foreach ($resultats as $r): ?>
    <tr>
        <td><?= htmlspecialchars($r['identifiant']) ?></td>
        <td><?= htmlspecialchars($r['adresse']) ?></td>
        <td><?= htmlspecialchars($r['date_naissance']) ?></td>
    </tr>
<?php endforeach; ?>
</table>
</body>
</html>