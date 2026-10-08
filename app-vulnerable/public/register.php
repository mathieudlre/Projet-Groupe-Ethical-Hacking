<?php

require_once "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    echo "Username : " . $username . "<br>";
    echo "Email : " . $email . "<br>";
    echo "Mot de passe reçu !";
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="register-page"></body>

<h1>Inscription</h1>

<form method="POST">
    <input type="text" name="username" placeholder="Nom" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Mot de passe" required><br><br>
    <button type="submit">S'inscrire</button>
</form>

<a href="login.html">Connexion</a>

</body>
</html>