<?php
// app-vulnerable/config/db.php

$host    = 'localhost';
$dbname  = 'ehapp'; // <--- Changé de 'app_vulnerable' vers 'ehapp'
$user    = 'root';
$pass    = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}