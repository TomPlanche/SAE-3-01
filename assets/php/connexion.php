<!DOCTYPE html>
<html lang="en">
<?php


    session_start();
    if(isset($_GET['type'] )){
        if ($_GET['type'] == 'etudiant'){
            $_SESSION['type'] = 'etudiant';

        }
        else if ($_GET['type'] == 'enseignant'){
            $_SESSION['type'] = 'enseignant';
        }else{
            $_SESSION['type'] = 'admin';
        }
    }

?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet/less" type="text/css" href="../scss/connexion.scss"/>
    <script src="https://cdn.jsdelivr.net/npm/less@4.1.1"></script>
    <title>Document</title>
</head>
<body>
    <nav class ="header">
        <img src="../Images/auto-qcm-low-resolution-logo-white-on-black-background.png" alt="logo">
        <ul>
            <li><a href='../../Acceuil.php'>Accueil</a></li>
        </ul>
    </nav>


    <main>
        <section>
            <h1>Se connecter en tant que <?php echo $_SESSION['type']; ?></h1>
            <form>
                <!-- Login et mdp -->
                <label for="login">Login</label>
                <input type="text" name="login" id="login" placeholder="Login" required>
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" placeholder="Mot de passe" required>
                <?php

                if(isset($_GET['seConnecter'])){

                    #Récupération du cookie type
                    $type = $_SESSION['type'];

                    #Récupération des données du formulaire
                    $login = $_GET['login'];
                    $password = $_GET['password'];

                    #Connexion à la base de données
                    $FICHIER_BD = "../../BDs/BD";
                    $db = new PDO('sqlite:'.$FICHIER_BD);
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


                    switch ($type) {
                        case 'enseignant':
                            #Requête pour récupérer les informations de l'enseignant
                            $result = $db->query("SELECT * FROM ENSEIGNANT WHERE nom_enseignnat = '$login' ");
                            $enseignant = $result->fetchAll(PDO::FETCH_ASSOC);
                            if ($enseignant){
                                echo "Connexion réussie";
                                $_SESSION['idEnseignant'] = $enseignant[0]['id_enseignant'];
                                header("Refresh:1; url=./Enseignant/index.php");
                            }else{
                                echo "Mauvais login ou mot de passe";
                            }



                            break;
                        case 'etudiant':
                            #Requête pour récupérer les informations de l'étudiant
                            $result = $db->query("SELECT * FROM ETUDIANT WHERE nom_etudiant = '$login' ");
                            $etudiant = $result->fetchAll(PDO::FETCH_ASSOC);
                            if ($etudiant){
                                echo "Connexion réussie";
                                #Création du cookie étudiant avec l'id de l'étudiant
                                $_SESSION['idEtudiant'] = $etudiant[0]['id_etudiant'];
                                header("Refresh:1; url=./Etudiant/index.php");
                            }else{
                                echo "Mauvais login ou mot de passe";
                            }


                            break;
                        case 'admin':
                            echo "Connexion momentanément indisponible";
                            break;
                        default:
                            # code...
                            break;
                    }
                }

                ?>
                <input type="submit" value="Connexion" name="seConnecter">
            </form>
        </section>
    </main>


</body>

<style>

</style>
</html>