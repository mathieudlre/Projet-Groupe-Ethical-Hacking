-- =====================================================================
-- Schéma COMPLET de la base — Projet Ethical Hacking (version vulnérable)
-- Crée la base + les tables + les données de test, en un seul fichier.
-- Import :  mysql -u root -p < schema.sql
--      ou : via phpMyAdmin -> Importer -> ce fichier
-- =====================================================================

CREATE DATABASE IF NOT EXISTS ehapp CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE ehapp;

DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS users;

-- ---------------------------------------------------------------------
-- Utilisateurs (contient les données sensibles ciblées par la SQLi)
-- Mots de passe EN CLAIR : volontaire (version vulnérable).
-- ---------------------------------------------------------------------
CREATE TABLE users (
    id                   INT AUTO_INCREMENT PRIMARY KEY,
    identifiant          VARCHAR(50)  NOT NULL UNIQUE,
    mot_de_passe         VARCHAR(255) NOT NULL,
    role                 ENUM('user','admin') NOT NULL DEFAULT 'user',
    adresse              VARCHAR(255),
    date_naissance       DATE,
    num_securite_sociale VARCHAR(20)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- Messages du formulaire de contact (public, sans authentification)
-- ---------------------------------------------------------------------
CREATE TABLE messages (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nom         VARCHAR(100)  NOT NULL,
    email       VARCHAR(150)  NOT NULL,
    sujet       VARCHAR(200)  NOT NULL,
    message     TEXT          NOT NULL,
    date_envoi  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- Données de test
-- Compte admin  :  admin    / Adm1n!Pass2024
-- Comptes users :  jdupont  / password123   (et autres ci-dessous)
-- ---------------------------------------------------------------------
INSERT INTO users (identifiant, mot_de_passe, role, adresse, date_naissance, num_securite_sociale) VALUES
('admin',    'Adm1n!Pass2024', 'admin', '12 rue de la Paix, 75002 Paris',        '1985-04-12', '1850475123456'),
('jdupont',  'password123',     'user',  '5 avenue des Lilas, 69003 Lyon',        '1992-09-30', '2920969234567'),
('mmartin',  'azerty2023',      'user',  '8 impasse du Moulin, 33000 Bordeaux',   '1998-01-22', '2980133345678'),
('plefevre', 'soleil!45',       'user',  '21 boulevard Victor Hugo, 44000 Nantes','1990-07-05', '1900744456789');

INSERT INTO messages (nom, email, sujet, message) VALUES
('Jean Dupont',  'jean.dupont@example.com',  'Question facturation',  'Bonjour, je souhaite une copie de ma facture du mois dernier.'),
('Marie Martin', 'marie.martin@example.com', 'Probleme de connexion', 'Je n arrive plus a me connecter a mon compte depuis hier.');
