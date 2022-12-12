<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet/less" type="text/css" href="../../scss/creerQuestion.scss"/>
    <script src="https://cdn.jsdelivr.net/npm/less@4.1.1"></script>
</head>

        <!-- Inclure la template header -->
        <?php include '../../template/header.php';
        session_start();

        include '../estConnecte.php';

        ?>

        <main>
            <section>
                <h2><?php
                    echo $_GET['titreDepot'];
                    ?>
                </h2>
                <form action="creerQuestionTitre.php"  name="choixTypeQuestion">
                    <!--liste des tags -->
                    <label for="ajoutTag">Saisir des tags (mots-clés qui définiront votre question)</label>
                    <?php
                    #Connexion à la base de données
                    $FICHIER_BD = "../../../BDs/BD";
                    $db = new PDO('sqlite:'.$FICHIER_BD);
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    #Requete : jointure entre la table etudiant, depot et acceder
                    #parametre a recuperer : titre du depot, description du depot, date d'ouverture, date de fermeture
                    $requete = "SELECT nom_tag FROM TAG";
                    $stmt = $db->prepare($requete);

                    $stmt->execute();
                    $tags = $stmt->fetchAll();

                    # Stockage des tags dans ul li
                    echo "<ul id='listeTags' style='display: none'>";
                    foreach($tags as $tag){
                        echo "<li>".$tag['nom_tag']."</li>";
                    }
                    echo "</ul>";

                    #Recherche des tags
                    echo "<input type='text' id='ajoutTag' name='ajoutTag' placeholder='Rechercher un tag' onkeyup='rechercheTags()'>";
                    echo "<ul id='listeTagsRecherche'></ul>";

                    echo "<label name='Erreur' id='Erreur'></label>";


                    echo "<ul id='listeTagsChoisis' display='block'>";
                    echo "<label for='listeTagsChoisis'>Tags choisis : </label>";
                    echo "</ul>";

                    echo "<input type='hidden' id='tags' name='tags' value=''>";

                    echo "<script>
                        // Fonction qui permet de rechercher des tags
                        
                        function rechercheTags(){
                            var input, filter, ul, li, a, i, txtValue;
                            input = document.getElementById('ajoutTag');
                            filter = input.value.toUpperCase();
                            ul = document.getElementById('listeTags');
                            li = ul.getElementsByTagName('li');
                            ulRecherche = document.getElementById('listeTagsRecherche');
                            // On vide la liste des tags recherchés
                            ulRecherche.innerHTML = '';
                            // Affichage des tags qui correspondent à la recherche                            
                            for (i = 0; i < li.length; i++) {
                                a = li[i];
                                txtValue = a.textContent || a.innerText;
                                // Si le tag correspond à la recherche, on l'affiche
                                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                    
                                    var liRecherche = document.createElement('li');
                                    liRecherche.innerHTML = txtValue;
                                    // On ajoute un event listener pour ajouter le tag à la liste des tags choisis
                                    liRecherche.onclick = function(){   
                                        // Si on a moins de 5 tags choisis, on ajoute le tag
                                        if(document.getElementById('listeTagsChoisis').getElementsByTagName('li').length > 4){
                                            document.getElementsByName('Erreur')[0].innerHTML = 'Vous ne pouvez pas choisir plus de 5 tags';
                                            return;
                                        }
                                        var ulChoisis = document.getElementById('listeTagsChoisis');
                                        var liChoisis = document.createElement('li');
                                        liChoisis.innerHTML = this.innerHTML;
                                        // On ajoute un event listener pour supprimer le tag de la liste des tags choisis
                                        liChoisis.onclick = function(){
                                            if(document.getElementById('listeTagsChoisis').getElementsByTagName('li').length > 0){
                                            document.getElementsByName('Erreur')[0].innerHTML = '';
                                        }
                                            this.remove();
                                            var tags = document.getElementById('tags').value;
                                            var tagsArray = tags.split(',');
                                            var index = tagsArray.indexOf(this.innerHTML);
                                            if (index > -1) {
                                                tagsArray.splice(index, 1);
                                            }
                                            document.getElementById('tags').value = tagsArray.join(',');
                                        }
                                        // On ajoute le tag à la liste des tags choisis
                                        ulChoisis.appendChild(liChoisis);
                                        // On ajoute le tag à la liste des tags
                                        var tags = document.getElementById('tags').value;                                        
                                        // Si la liste des tags est vide, on ajoute le tag
                                        if(tags == ''){
                                            document.getElementById('tags').value = this.innerHTML;
                                        }else{
                                            document.getElementById('tags').value = tags + ',' + this.innerHTML;
                                        }
                                        this.remove();
                                    }
                                    // Si on a plus de 5 tags qui correspondent à la recherche, on ne les affiche pas
                                    if(document.getElementById('listeTagsChoisis').innerHTML.indexOf(txtValue) == -1){
                                        ulRecherche.appendChild(liRecherche);
                                    }
                                    
                                }
                            }
                        }
                    </script>";
                    ?>


                    <label for="typeQuestion">Choisissez votre type de question</label>
                    <!-- Choix unique entre : FlashCards, Choix mutiples, etc...-->
                    <select name="typeQuestion" id="typeQuestion">
                        <?php
                        #Connexion à la base de données
                        $FICHIER_BD = "../../../BDs/BD";
                        $db = new PDO('sqlite:'.$FICHIER_BD);
                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // Pour tous les types disponibles, on les affiche dans la liste déroulante
                        $requete = "SELECT nom_type_question FROM TYPE_QUESTION";
                        $stmt = $db->prepare($requete);
                        $stmt->execute();
                        $types = $stmt->fetchAll();
                        foreach($types as $type){
                            echo "<option>".$type['nom_type_question']."</option>";
                        }
                        ?>
                    </select>
                    <!--Bouton suivant-->
                    <button class="btn" type="submit" name="Suivant1" >Suivant</button>
                </form>


                <?php
                if(isset($_GET['Suivant1'])){
                    $_SESSION['tags'] = explode(',', $_GET['tags']);
                    $_SESSION['typeQuestion'] = $_GET['typeQuestion'];

                }
                ?>

            </section>
        </main>

<body>

</body>
</html>