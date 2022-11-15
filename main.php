<?php

# TEST CONNEXION BD
$FICHIER_BD = "BDs/BD";
$BD = new SQLite3($FICHIER_BD);
$BD->busyTimeout(5000);

# Affichicher la liste des tables
$requete = "SELECT name FROM sqlite_master WHERE type='table' ORDER BY name;";
$resultat = $BD->query($requete);
while ($ligne = $resultat->fetchArray(SQLITE3_ASSOC)) {
    echo $ligne['name'] . "est une table de la base de données.<BR>";
}

