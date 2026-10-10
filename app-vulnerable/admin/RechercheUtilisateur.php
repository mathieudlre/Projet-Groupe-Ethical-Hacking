<?php
<<<<<<< HEAD
require_once '../includes/auth.php';
require_once '../config/database.php'; // Utilisation du $pdo global
=======
/* =====================================================================
 * app-vulnerable/admin/RechercheUtilisateur.php
 * Brique : Membre 3   —   *** POINT VULNÉRABLE À L'INJECTION SQL ***
 * ---------------------------------------------------------------------
 * Recherche d'utilisateur réservée à l'admin. L'entrée $_GET['nom'] est
 * concaténée DIRECTEMENT dans la requête -> injection SQL (volontaire).
 *
 * Localisation de la faille pour le rapport :
 *   - fichier : app-vulnerable/admin/RechercheUtilisateur.php
 *   - param.  : "nom" (GET)
 *   - ligne   : voir le commentaire "<<< FAILLE SQLi"
 * ===================================================================== */
>>>>>>> caa65dd59013646168dfec579d410b101dd24e85

require_once __DIR__ . '/../includes/auth.php';   // Membre 1 : doit définir require_admin()
require_admin();                                  // réserve la page à l'administrateur
require_once __DIR__ . '/../config/db.php';       // fournit get_connection() (mysqli)

$resultats  = [];
$erreur_sql = null;

if (isset($_GET['nom'])) {
<<<<<<< HEAD
    $nom = $_GET['nom'];

    try {
        // !!! VULNÉRABLE (volontaire) : Concaténation directe pour l'injection SQL UNION-based
        $sql = "SELECT identifiant, adresse, date_naissance FROM users WHERE identifiant LIKE '%$nom%'";
        $stmt = $pdo->query($sql);
        $resultats = $stmt->fetchAll();
    } catch (PDOException $e) {
        // Utile pour l'attaque UNION-based (affichage des erreurs SQL)
        $erreur_sql = $e->getMessage();
=======
    $nom  = $_GET['nom'];
    $conn = get_connection();   // mysqli, PAS PDO

    // <<< FAILLE SQLi : l'entrée utilisateur est injectée telle quelle.
    // 3 colonnes sélectionnées -> l'attaque UNION se cale sur 3 colonnes.
    $sql    = "SELECT identifiant, adresse, date_naissance FROM users WHERE identifiant LIKE '%$nom%'";
    $result = $conn->query($sql);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $resultats[] = $row;
        }
    } else {
        // On affiche l'erreur MySQL : indispensable pour l'étape ORDER BY
        // (repérage du nombre de colonnes) du scénario d'attaque.
        $erreur_sql = $conn->error;
>>>>>>> caa65dd59013646168dfec579d410b101dd24e85
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

<<<<<<< HEAD
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
=======
<table border="1" cellpadding="6">
<tr><th>Identifiant</th><th>Adresse</th><th>Date de naissance</th></tr>
<?php foreach ($resultats as $r): ?>
    <!-- Sortie NON échappée (version vulnérable) : laisse voir le résultat brut de l'injection -->
    <tr>
        <td><?= $r['identifiant'] ?></td>
        <td><?= $r['adresse'] ?></td>
        <td><?= $r['date_naissance'] ?></td>
    </tr>
<?php endforeach; ?>
</table>
>>>>>>> caa65dd59013646168dfec579d410b101dd24e85
</body>
</html>
