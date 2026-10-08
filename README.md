# Projet Ethical Hacking 1 — XSS stocké + Injection SQL

Application web volontairement vulnérable, exploitation (XSS → vol de session admin → SQLi),
puis version corrigée. Projet de groupe (4 membres).

**Chaîne d'attaque :** formulaire de contact → XSS stocké → vol de session admin → accès admin → SQLi (UNION) → extraction de données.

> AVERTISSEMENT : ce dépôt contient du code volontairement vulnérable à but
> strictement pédagogique. À déployer uniquement dans un environnement isolé
> (VMs de lab, réseau fermé). Ne jamais exposer sur Internet.

## Stack

- PHP + MySQL
- Serveur web : Apache / PHP built-in server
- Attaque : serveur d'écoute PHP (exfiltration cookie), sqlmap

## Arborescence

```
projet-ethical-hacking/
├── app-vulnerable/     # Version vulnérable   -> VM cible
│   ├── config/         # Connexion BDD
│   ├── public/         # Racine web : index, login, logout, contact
│   │   └── assets/     # css / js
│   ├── admin/          # Back-office : messages (XSS), users, search (SQLi), export
│   ├── includes/       # auth / session / header
│   └── sql/            # schema.sql + seed.sql
│
├── app-secure/         # Version corrigée (miroir de app-vulnerable)
│
├── attack/             # Outils d'attaque        -> VM attaquante
│   ├── listener/       # Serveur d'écoute (vol de cookie)
│   ├── payloads/       # Charges XSS
│   └── sqli/           # Étapes UNION manuelles + commandes sqlmap
│
├── docs/               # Livrables
│   └── rapport/
│       └── captures/   # Screenshots : xss/ et sqli/
│
└── delivery/           # Zips finaux (hors Git, régénérés à la fin)
```

## Répartition des 2 VMs

| VM              | Contenu                                      |
|-----------------|----------------------------------------------|
| VM cible        | `app-vulnerable/` puis `app-secure/`         |
| VM attaquante   | `attack/`                                    |

## Installation (rapide)

```bash
# Base de données
mysql -u root -p < app-vulnerable/sql/schema.sql
mysql -u root -p < app-vulnerable/sql/seed.sql

# Configurer les accès BDD dans app-vulnerable/config/database.php

# Lancer l'appli (serveur PHP intégré, depuis app-vulnerable/)
php -S 0.0.0.0:8000 -t public
```

## Déroulé

1. **Semaine 1 — Build** : développer l'appli sur `app-vulnerable/`.
2. **Semaine 2 — Exploitation** : scénario XSS, puis SQLi avec la session volée. Captures à chaque étape.
3. **Semaine 3 — Remédiation** : corriger dans `app-secure/`, rejouer les attaques (elles doivent échouer), rapport + slides.

## Livrables

- Zip de `app-vulnerable/`
- Zip de `app-secure/`
- Rapport final (PDF/Word) dans `docs/rapport/`
- Support PowerPoint dans `docs/`
- Le tout dans un grand zip

```bash
# Génération des zips de livraison
zip -r delivery/app-vulnerable.zip app-vulnerable/
zip -r delivery/app-secure.zip app-secure/
```

## Membres

| Membre   | Rôle                                   |
|----------|----------------------------------------|
| Membre 1 | Infra & socle (VMs, auth, rôles, BDD)  |
| Membre 2 | Formulaire de contact & XSS            |
| Membre 3 | Injection SQL                          |
| Membre 4 | Intégration, rapport & oral            |
