<?php
/* =====================================================================
 * app-secure/admin/RechercheUtilisateur.php  —  VERSION CORRIGÉE (SQLi)
 * ---------------------------------------------------------------------
 * Correctifs par rapport à la version vulnérable :
 *   1. Requête PRÉPARÉE (PDO) : l'entrée n'est plus concaténée dans le SQL
 *      -> l'injection UNION ne fonctionne plus.
 *   2. Validation d'entrée (liste blanche de caractères) : défense en profondeur.
 *   3. Sortie échappée (htmlspecialchars).
 *   4. Aucune erreur SQL affichée à l'utilisateur.
 * ===================================================================== */

require_once __DIR__ . '/../includes/auth.php';     // require_admin()
require_admin();
require_once __DIR__ . '/../config/database.php';   // $pdo

$resultats = [];

if (isset($_GET['nom'])) {
    $nom = trim($_GET['nom']);

    // Défense en profondeur : on n'accepte qu'un identifiant plausible.
    if (preg_match('/^[a-zA-Z0-9._-]{0,50}$/', $nom)) {
        // Requête PRÉPARÉE : la valeur est transmise comme paramètre, jamais
        // interprétée comme du SQL.
        $stmt = $pdo->prepare(
            "SELECT identifiant, adresse, date_naissance
             FROM users
             WHERE identifiant LIKE :nom"
        );
        $stmt->execute([':nom' => '%' . $nom . '%']);
        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    <table border="1" cellpadding="10" style="margin-top: 20px; border-collapse: collapse; width: 100%;">
        <tr><th>Identifiant</th><th>Adresse</th><th>Date de naissance</th></tr>
        <?php if (!empty($resultats)): ?>
            <?php foreach ($resultats as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['identifiant'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($r['adresse'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($r['date_naissance'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3" style="text-align: center;">Aucun résultat</td></tr>
        <?php endif; ?>
    </table>
</main>
</body>
</html>
