<html lang="fr">
<head>
    <link rel="stylesheet/less" type="text/css" href="../../scss/deposerQuestion.scss"/>
    <script src="https://cdn.jsdelivr.net/npm/less@4.1.1"></script>
</head>

<body>
    <!-- Inclure la template header -->
    <?php include '../../template/header.php';
    session_start();
    include '../estConnecte.php';


    ?>

<main>
    <section>
        <h1>Liste des dépots de question dont vous avez accès</h1>
        <!-- Affiche sous la forme de petite patate tous les dépots dont il a acces -->
        <article>
            <?php
                #Connexion à la base de données
                $FICHIER_BD = "../../../BDs/BD";
                $db = new PDO('sqlite:'.$FICHIER_BD);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                #Requete : jointure entre la table etudiant, depot et acceder
                #parametre a recuperer : titre du depot, description du depot, date d'ouverture, date de fermeture
                $requete = "SELECT idDepot, titre, description, date_ouverture, date_fermeture FROM DEPOT join ACCEDER on DEPOT.id_depot = ACCEDER.idDepot join ETUDIANT on ACCEDER.idEtudiant = ETUDIANT.id_etudiant WHERE ETUDIANT.id_etudiant = :idEtudiant AND ACCEDER.aAcces = 1";
                $stmt = $db->prepare($requete);
                #On récupère l'id de l'etudiant dans les cookies
                $stmt->bindParam(':idEtudiant', $_SESSION['idEtudiant']);

                $stmt->execute();
                $depots = $stmt->fetchAll();

                #Affichage des dépots
                foreach($depots as $depot){
                    echo "<div class='depot'>";
                    echo "<h2>".$depot['titre']."</h2>";
                    echo "<p>".$depot['description']."</p>";;
                    $dateOuverture = date("d/m/Y", strtotime($depot['date_ouverture']));
                    echo "<p>Date d'ouverture : ".$dateOuverture."</p>";
                    $dateFermeture = date("d/m/Y", strtotime($depot['date_fermeture']));
                    echo "<p>Date de fermeture : ".$dateFermeture."</p>";
                    // Bouton qui envoie vers la page creerQuestion.php avec comme parametre l'id du depot et le titre du depot
                    echo "<button class='btn' onclick='window.location.href = \"creerQuestion2Type.php?idDepot=".$depot['idDepot']."&titreDepot=".$depot['titre']."\"'>Créer une question</button>";
                    echo "</div>";
                }

            ?>
        </article>
    </section>


</main>

</body>
</html>


