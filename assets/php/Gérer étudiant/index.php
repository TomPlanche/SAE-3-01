<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet/less" type="text/css" href="../../scss/style.scss"/>
    <script src="https://cdn.jsdelivr.net/npm/less@4.1.1"></script>
    <title>Accueil</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.html">Liste des elements</a></li>
        </ul>
    </nav>

    <main>
        <div class="tableauEtudiant">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>TD</th>
                        <th>TP</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    #Liste des ETUDIANT
                    $FICHIER_BD = "..\..\..\BDs\BD";
                    $db = new PDO('sqlite:'.$FICHIER_BD);
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $result = $db->query("SELECT * FROM ETUDIANT");
                    $etudiants = $result->fetchAll(PDO::FETCH_ASSOC);
                    # id_etudiant, nom_etudiant, prenom_etudiant, td, tp
                    foreach($etudiants as $etudiant) {
                        echo "<tr>";
                        echo "<td>".$etudiant['id_etudiant']."</td>";
                        echo "<td>".$etudiant['nom_etudiant']."</td>";
                        echo "<td>".$etudiant['prenom_etudiant']."</td>";
                        echo "<td>".$etudiant['td']."</td>";
                        echo "<td>".$etudiant['tp']."</td>";
                        #Bouton supprimé et modifier
                        echo "<td><a href='./supprimer.php?id=".$etudiant['id_etudiant']."'>Supprimer</a> 
                                    <a href='./modifier.php?id=".$etudiant['id_etudiant']."'>Modifier</a></td>";

                        echo "</tr>";
                    }

                    # Fermeture de la connexion
                    $db = null;
                    ?>


                </tbody>
            </table>
        </div>

        <br>
        <h1>
            Formulaire de creation d'étudiant
        </h1>
        <br>

        <form  >
            <label for="id">ID</label>
            <input type="text" name="id" id="id">
            <br>
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom">
            <br>
            <label for="prenom">Prenom</label>
            <input type="text" name="prenom" id="prenom">
            <br>
            <label for="td">TD</label>
            <input type="number" name="td" id="td">
            <br>
            <label for="tp">TP</label>
            <input type="number" name="tp" id="tp">
            <br>
            <input type="submit" name="AjoutEtudiant" />
        </form>

        <!-- Ajout de l'étudiant dans la base de données -->
        <?php

            # Quand on appuie sur le bouton envoyer
            if ( isset( $_GET['AjoutEtudiant'] ) && empty($_GET['nom']) == false && empty($_GET['prenom']) == false && empty($_GET['td']) == false && empty($_GET['tp']) == false ) {
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

                # Ajout de l'étudiant dans la BD
                $id = $_GET['id'];
                $nom = $_GET['nom'];
                $prenom = $_GET['prenom'];
                $td = $_GET['td'];
                $tp = $_GET['tp'];

                # Savoir si l'étudiant existe déjà
                $result = $db->query("SELECT nom_etudiant FROM ETUDIANT WHERE id_etudiant = '$id'");
                $etudiants = $result->fetchAll(PDO::FETCH_ASSOC);
                if (empty($etudiants)) {
                    $db->query("INSERT INTO ETUDIANT (id_etudiant, nom_etudiant, prenom_etudiant, td, tp) VALUES ('$id', '$nom', '$prenom', $td, $tp)");
                    echo "L'étudiant a bien été ajouté";
                }
                else {
                    echo "L'étudiant existe déjà";
                }



                # Fermeture de la connexion
                $db = null;
                header("Location: .\index.php");

            }
            elseif ( isset( $_GET['AjoutEtudiant'] ) ) {
                echo "Veuillez remplir tous les champs";

            }
        ?>



    </main>
    
</body>
</html>