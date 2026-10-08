<?php
// app-vulnerable/public/contact.php

// 1. Inclusion du fichier de connexion à la BDD
require_once __DIR__ . '/../config/database.php';

$message_status = "";

// 2. Vérification si le formulaire a été soumis en POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération brute des données du formulaire
    $nom     = $_POST['nom']     ?? '';
    $email   = $_POST['email']   ?? '';
    $sujet   = $_POST['sujet']   ?? '';
    $message = $_POST['message'] ?? '';

    if (!empty($nom) && !empty($email) && !empty($sujet) && !empty($message)) {
        try {
            // Insertion brute en base de données (nom, email, sujet, message, date_envoi)
            $stmt = $pdo->prepare("INSERT INTO messages (nom, email, sujet, message, date_envoi) VALUES (:nom, :email, :sujet, :message, NOW())");
            $stmt->execute([
                ':nom'     => $nom,
                ':email'   => $email,
                ':sujet'   => $sujet,
                ':message' => $message
            ]);

            $message_status = "<p style='color: green;'>Votre message a été envoyé avec succès !</p>";
        } catch (PDOException $e) {
            $message_status = "<p style='color: red;'>Erreur BDD : " . $e->getMessage() . "</p>";
        }
    } else {
        $message_status = "<p style='color: red;'>Veuillez remplir tous les champs.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact - Support</title>
    <link rel="stylesheet" href="public/assets/css/style.css">
</head>
<body>
    <h1>Nous contacter</h1>

    <!-- Affichage du message de confirmation ou d'erreur -->
    <?php if (!empty($message_status)) echo $message_status; ?>

    <!-- Le formulaire renvoie les données vers lui-même (contact.php) en POST -->
    <form action="contact.php" method="POST">
        <div>
            <label for="nom">Nom :</label><br>
            <input type="text" id="nom" name="nom" required>
        </div>
        <br>
        <div>
            <label for="email">Email :</label><br>
            <input type="email" id="email" name="email" required>
        </div>
        <br>
        <div>
            <label for="sujet">Sujet :</label><br>
            <input type="text" id="sujet" name="sujet" required>
        </div>
        <br>
        <div>
            <label for="message">Message :</label><br>
            <textarea id="message" name="message" rows="5" required></textarea>
        </div>
        <br>
        <button type="submit">Envoyer</button>
    </form>
</body>
</html>