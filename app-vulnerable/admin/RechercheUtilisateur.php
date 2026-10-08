<<?php
require_once '../includes/auth.php';
require_once '../config/db.php';

$resultats = [];
$erreur_sql = null;

if (isset($_GET['nom'])) {
    $nom = $_GET['nom'];
    $conn = get_connection(); // mysqli, PAS PDO

    // !!! VULNÉRABLE (volontaire) : concaténation directe de l'entrée utilisateur
    $sql = "SELECT identifiant, adresse, date_naissance FROM users WHERE identifiant LIKE '%$nom%'";
    $result = $conn->query($sql);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $resultats[] = $row;
        }
    } else {
        // utile pour l'attaque UNION-based : voir l'erreur MySQL (ex. étape ORDER BY)
        $erreur_sql = $conn->error;
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

<?php if ($erreur_sql): ?>
    <p style="color:red;">Erreur SQL : <?= $erreur_sql ?></p>
<?php endif; ?>

<table border="1">
<tr><th>Identifiant</th><th>Adresse</th><th>Date de naissance</th></tr>
<?php foreach ($resultats as $r): ?>
    <tr><td><?= $r['identifiant'] ?></td><td><?= $r['adresse'] ?></td><td><?= $r['date_naissance'] ?></td></tr>
<?php endforeach; ?>
</table>
</body>
</html>