<?php

$FICHIER_BD = ".\BDs\BD";
$db = new PDO('sqlite:'.$FICHIER_BD);

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

# test de la connexion
try {
    $db->query("SELECT 1");
    echo "Connexion à la BD établie <br>";
} catch (PDOException $e) {
    echo "Erreur de connexion à la BD";
    exit;
}

# selectionne toute les tables
$result = $db->query("SELECT name FROM sqlite_master WHERE type='table'");
$tables = $result->fetchAll(PDO::FETCH_ASSOC);

# Affichage des tables
foreach($tables as $table) {
    echo $table['name']; // Affiche le nom de la table
    echo "<br>";
}

# Selection de tous les elements dans la tables QUESTION
$result = $db->query("SELECT * FROM QUESTION");
$questions = $result->fetchAll(PDO::FETCH_ASSOC);

# Affichage des questions
foreach($questions as $question) {
    echo $question['id_question']; // Affiche l'ID de la question
    echo "<br>";
    echo $question['titre_question']; // Affiche la question
    echo "<br>";
    echo $question['difficulte']; // Affiche la réponse
    echo "<br>";
}


?>