<?php

# Suppression de l'étudiant dans la base de données dont l'id
# est passé en paramètre
if ( isset( $_GET['id'] ) ) {

    $FICHIER_BD = "..\..\..\BDs\BD";
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

    # Suppression de l'étudiant dans la BD
    $id = $_GET['id'];
    $sql = "DELETE FROM etudiant WHERE id_etudiant = '$id'";
    $db->exec($sql);

    # Fermeture de la connexion
    $db = null;
    header("Location: .\index.php");
}
