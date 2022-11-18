<!DOCTYPE html>
<html lang="en">
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
            <li><a href='../../Accueil.php'>Accueil</a></li>
            <li><a href='../php/Gérer étudiant/index.php'>Gérer étudiant</a></li>
        </ul>
    </nav>


    <main>
        <section>
            <h1>Connexion</h1>
            <form>
                <!-- Login et mdp -->
                <label for="login">Login</label>
                <input type="text" name="login" id="login" placeholder="Login" required>
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" placeholder="Mot de passe" required>
                <input type="submit" value="Connexion" name="seConnecter">
            </form>
        </section>
    </main>

    <?php
    # Recupere le type de l'utilisateur
    $type = $_POST['type'];
    echo $type;
        if(isset($_POST['seConnecter'])){


            # Recupere le login et le mdp
            $login = $_POST['login'];
            $password = $_POST['password'];
            # Connexion a la BD
            $FICHIER_BD = "..\..\BDs\BD";
            $db = new PDO('sqlite:'.$FICHIER_BD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            # En fonction du type de l'utilisateur
            if($type == "etudiant"){
                # Requete pour verifier si l'utilisateur existe
                $result = $db->query("SELECT * FROM ETUDIANT WHERE nom_etudiant = '$login' ");
                $etudiant = $result->fetchAll(PDO::FETCH_ASSOC);
                # Si l'utilisateur existe
                if($etudiant){
                    # Redirige vers la page d'accueil de l'etudiant
                    echo "Test";
                    #header("Location: ./Etudiant/index.php");
                }
                # Si l'utilisateur n'existe pas
                else{
                    # Redirige vers la page de connexion
                    header("Location: ../../Accueil.php");
                }
            }
            else if($type == "professeur"){
                # Requete pour verifier si l'utilisateur existe
                $result = $db->query("SELECT * FROM ENSEIGNANT WHERE nom_enseignnat = '$login' ");
                $professeur = $result->fetchAll(PDO::FETCH_ASSOC);
                # Si l'utilisateur existe
                if($professeur){
                    # Redirige vers la page d'accueil du professeur
                    header("Location: ./Enseignant/index.php");
                }
                # Si l'utilisateur n'existe pas
                else{
                    # Redirige vers la page de connexion
                    header("Location: ../../Accueil.php");
                }
            }
            else if($type == "admin"){
                # Requete pour verifier si l'utilisateur existe
                $result = $db->query("SELECT * FROM ENSEIGNANT WHERE nom_enseignnat = '$login' ");
                $administrateur = $result->fetchAll(PDO::FETCH_ASSOC);
                # Si l'utilisateur existe
                if($administrateur){
                    # Redirige vers la page d'accueil de l'administrateur
                    header("Location: ./Admin/index.php");
                }
                # Si l'utilisateur n'existe pas
                else{
                    # Redirige vers la page de connexion
                    header("Location: ../../Accueil.php");
                }
            }





        }


    ?>
</body>

<style>

</style>
</html>