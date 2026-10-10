<?php
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

require_once __DIR__ . '/../includes/auth.php';   // Membre 1 : doit définir require_admin()
require_admin();                                  // réserve la page à l'administrateur
require_once __DIR__ . '/../config/db.php';       // fournit get_connection() (mysqli)

$resultats  = [];
$erreur_sql = null;

if (isset($_GET['nom'])) {
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
</body>
</html>
