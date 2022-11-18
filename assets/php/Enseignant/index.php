<html lang="fr">
    <head>
        <title>Enseignant</title>
        <link rel="stylesheet/less" type="text/css" href="../../scss/EnIndex.scss"/>
        <script src="https://cdn.jsdelivr.net/npm/less@4.1.1"></script>
    </head>

    <body>
        <!-- Inclure la template header -->
        <?php include '../../template/header.php'; ?>

    <main>
        <section class="GererDepot">
            <h1>Gérer ses dépots</h1>
            <!-- Tableau des dépots -->
            <table>
                <tr>
                    <th>Titre</th>
                    <th>Etat</th>
                    <th>Date d'ouverture</th>
                    <th>Date de fermeture</th>
                    <th>Actions</th>
                </tr>
                <?php
                    #Connexion à la base de données
                    $FICHIER_BD = "../../../BDs/BD";
                    $db = new PDO('sqlite:'.$FICHIER_BD);
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    #Récupération des dépots de l'enseignant
                    $requete = "SELECT * FROM DEPOT WHERE id_enseignant = :idEnseignant";
                    $stmt = $db->prepare($requete);
                    #On récupère l'id de l'enseignant dans les cookies
                    $stmt->bindParam(':idEnseignant', $_COOKIE['enseignant']);
                    #On affiche l'id de l'enseignant dans les cookies

                    $stmt->execute();
                    $depots = $stmt->fetchAll();

                    #Affichage des dépots
                    foreach($depots as $depot){
                        echo "<tr>";

                        echo "<td>".$depot['titre']."</td>";
                        echo "<td>".$depot['statut_b']."</td>";
                        $dateOuverture = date("d/m/Y", strtotime($depot['date_ouverture']));
                        echo "<td>".$dateOuverture."</td>";
                        $dateFermeture = date("d/m/Y", strtotime($depot['date_fermeture']));
                        echo "<td>".$dateFermeture."</td>";
                        echo "<td>
                                <button onclick='modifier()'>Modifier</button>
                                <button onclick='cloturer()'>Clôturer</button>
                                <button onclick='supprimer()'>Supprimer</button>
                            </td>";

                        echo "</tr>";
                    }

                    #Fermeture de la connexion à la base de données
                    $db = null;
                    ?>
            </table>

            <!-- Bouton pour créer un nouveau dépôt -->
            <button onclick="creerDepot()">Créer un nouveau dépôt</button>


        </section>
        <section class="ListeQCM">
            <h1>Votre liste de QCM</h1>
            <!-- Tableau des QCMs -->
            <table>
                <tr>
                    <th>Intitulé</th>
                    <th>Description</th>
                    <th>Etat</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
                <?php
                    #Connexion à la base de données
                    $FICHIER_BD = "../../../BDs/BD";
                    $db = new PDO('sqlite:'.$FICHIER_BD);
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    #Récupération des QCMs de l'enseignant
                    $requete = "SELECT * FROM QCM WHERE id_enseignant = :idEnseignant";
                    $stmt = $db->prepare($requete);
                    #On récupère l'id de l'enseignant dans les cookies
                    $stmt->bindParam(':idEnseignant', $_COOKIE['enseignant']);
                    #On affiche l'id de l'enseignant dans les cookies

                    $stmt->execute();
                    $qcms = $stmt->fetchAll();

                    #Affichage des QCMs
                    foreach($qcms as $qcm){
                        echo "<tr>";

                        echo "<td>".$qcm['titre']."</td>";
                        echo "<td>".$qcm['description']."</td>";
                        echo "<td>".$qcm['etat_b']."</td>";
                        echo "<td>".$qcm['type']."</td>";
                        echo "<td>
                                <button onclick='modifier()'>Visualiser</button>                                
                                <button onclick='modifier()'>Modifier</button>
                                <button onclick='supprimer()'>Supprimer</button>
                            </td>";

                        echo "</tr>";
                    }

                    #Fermeture de la connexion à la base de données
                    $db = null;
                    ?>

            </table>

            <!-- Bouton pour créer un nouveau QCM -->
            <button onclick="creerQCM()">Créer un nouveau QCM</button>

        </section>
    </main>
    
    </body>


    <script>
        function modifier(idDepot){
            // On redirige vers la page de modification
            window.prompt("Modifier", idDepot);
        }

        function cloturer(id){
            // Boite de dialogue pour confirmer la cloture
            window.location.href = "cloturer.php?id="+id;
        }

        function supprimer(id){
            // Boite de dialogue pour confirmer la suppression
            window.location.href = "supprimer.php?id="+id;
        }
</html>