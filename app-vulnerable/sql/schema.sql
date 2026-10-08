CREATE DATABASE IF NOT EXISTS ehapp CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE ehapp;

DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS users;


-- Table des utilisateurs (contient les données sensibles)

CREATE TABLE users (
    id                   INT AUTO_INCREMENT PRIMARY KEY,
    identifiant          VARCHAR(50)  NOT NULL UNIQUE,
    mot_de_passe         VARCHAR(255) NOT NULL,        -- en clair (version vulnérable, volontaire)
    role                 ENUM('user','admin') NOT NULL DEFAULT 'user',
    adresse              VARCHAR(255),
    date_naissance       DATE,
    num_securite_sociale VARCHAR(20)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Table des messages du formulaire de contact (public, non authentifié)

CREATE TABLE messages (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nom         VARCHAR(100)  NOT NULL,
    email       VARCHAR(150)  NOT NULL,
    sujet       VARCHAR(200)  NOT NULL,
    message     TEXT          NOT NULL,
    date_envoi  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;