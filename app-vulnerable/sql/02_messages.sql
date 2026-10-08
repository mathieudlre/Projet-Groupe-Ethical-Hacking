-- =====================================================================
-- Table des messages du formulaire de contact
-- Brique : Membre 2 (formulaire & XSS)
-- =====================================================================
-- Les champs sont stockés tels quels (aucun filtrage anti-XSS) :
-- c'est volontaire pour la version vulnérable.
-- =====================================================================

CREATE TABLE IF NOT EXISTS messages (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nom         VARCHAR(100)  NOT NULL,
    email       VARCHAR(150)  NOT NULL,
    sujet       VARCHAR(200)  NOT NULL,
    message     TEXT          NOT NULL,
    date_envoi  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Jeu de données de démonstration (messages légitimes)
INSERT INTO messages (nom, email, sujet, message) VALUES
('Jean Dupont',  'jean.dupont@example.com',  'Question facturation', 'Bonjour, je souhaite une copie de ma facture du mois dernier.'),
('Marie Martin', 'marie.martin@example.com', 'Probleme de connexion', 'Je n arrive plus a me connecter a mon compte depuis hier.');
