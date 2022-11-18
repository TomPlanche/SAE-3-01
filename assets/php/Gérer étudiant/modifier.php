<?php

# Récupération de l'id de l'etudiant passé en parametre
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

    # Récupération de l'étudiant dans la BD
    $id = $_GET['id']."";
    $sql = "SELECT * FROM etudiant WHERE id_etudiant = '$id'";
    # Récupération du nom, prenom, td, tp de l'etudiant
        $result = $db->query($sql);
        $etudiant = $result->fetch();

        $nom = $etudiant['nom_etudiant'];
        $prenom = $etudiant['prenom_etudiant'];
        $td = $etudiant['td'];
        $tp = $etudiant['tp'];

    # Création du formulaire de modification
    echo ">";
    echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";
    echo "Nom: <input type=\"text\" name=\"nom\" value=\"$nom\"><br>";
    echo "Prenom: <input type=\"text\" name=\"prenom\" value=\"$prenom\"><br>";
    echo "TD: <input type=\"text\" name=\"td\" value=\"$td\"><br>";
    echo "TP: <input type=\"text\" name=\"tp\" value=\"$tp\"><br>";
    echo "<input type=\"submit\" value=\"Modifier\" name=\"Modifier\">";
    echo "</form>";

    # Fermeture de la connexion
    $db = null;


}

    # Si il appuie sur le bouton modifier
    if ( isset( $_POST['Modifier'] ) ) {
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

        # Modification de l'étudiant dans la BD
        $id = $_POST['id']."";
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $td = $_POST['td'];
        $tp = $_POST['tp'];
        $sql = "UPDATE etudiant SET nom_etudiant = '$nom', prenom_etudiant = '$prenom', td = '$td', tp = '$tp' WHERE id_etudiant = '$id'";
        $db->exec($sql);

        # Fermeture de la connexion
        $db = null;
        header("Location: .\index.php");
    }

?>