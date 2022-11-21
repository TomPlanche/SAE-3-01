<html>

<head>
    <link rel="stylesheet/less" type="text/css" href="../../scss/creerQuestion.scss"/>
    <script src="https://cdn.jsdelivr.net/npm/less@4.1.1"></script>

</head>

<body>
    <!-- Inclure la template header -->
    <?php include '../../template/header.php';
    session_start();
    ?>

    <main>
        <section>
            <h2><?php
                echo $_GET['titreDepot'];
                ?>
            </h2>
            <form method="post" name="choixTypeQuestion">
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
                    <option value="FlashCards">FlashCards</option>
                    <option value="Choix mutiples">Choix mutiples</option>
                    <option value="Vrai ou faux">Vrai ou faux</option>
                    <option value="Réponse courte">Réponse courte</option>
                </select>
                <!--Bouton suivant-->
                <button class="btn" type="submit" name="Suivant1" >Suivant</button>
            </form>

            <?php
            // Si on a cliqué sur le bouton suivant et que la liste des tags choisis n'est pas vide
            if(isset($_POST['Suivant1']) && $_POST['tags'] != ''){
                // Suppression du form et affichage du form suivant
                echo "<script>document.forms['choixTypeQuestion'].style.display = 'none';</script>";
                // Affichage du form suivant
                echo "<form method='post' name='choixQuestion'>";
                echo "<label for='question'>Saisissez votre question</label>";
                echo "<input type='text' name='question' id='question' placeholder='Saisissez votre question'>";

                // Affichage du form suivant en fonction du type de question
                if($_POST['typeQuestion'] == "FlashCards"){
                    echo "<label for='reponse'>Saisissez votre réponse</label>";
                    echo "<input type='text' name='reponse' id='reponse' placeholder='Saisissez votre réponse'>";
                }
                else if($_POST['typeQuestion'] == "Choix mutiples") {
                    echo "<div class='choixMultiple'>";
                    echo    "<div class='uneReponse'>";
                    echo        "<input type='checkbox' name='reponse[]' id='reponse' value='reponse'>";
                    echo        "<input type='text' name='reponse[]' id='reponse' placeholder='Saisissez votre réponse'>";
                    echo        "<boutton class='btn' type='button' name='ajoutReponse' id='ajoutReponse' onclick='ajoutReponse(this)'>Add</boutton>";
                    echo        "<boutton class='btn' type='button' name='suppReponse' id='suppReponse' onclick='suppReponse(this)'>Supp</boutton>";
                    echo    "</div>";
                    echo "</div>";
                }
                else if($_POST['typeQuestion'] == "Vrai ou faux") {
                    echo "<label for='reponse'>Saisissez votre réponse</label>";
                    echo "<input type='text' name='reponse' id='reponse' placeholder='Saisissez votre réponse'>";
                }
                else if($_POST['typeQuestion'] == "Réponse courte") {
                    echo "<label for='reponse'>Saisissez votre réponse</label>";
                    echo "<input type='text' name='reponse' id='reponse' placeholder='Saisissez votre réponse'>";
                }

                echo "<label for='difficulte'>Choisissez votre difficulté</label>";
                echo "<select name='difficulte' id='difficulte'>";
                echo "<option value='1'>Facile</option>";
                echo "<option value='2'>Moyen</option>";
                echo "<option value='3'>Difficile</option>";
                echo "</select>";



                echo "<button class='btn' type='submit' name='Suivant2' >Suivant</button>";
                echo "</form>";

                // Ajout du script pour ajouter une réponse
                echo "<script>
                
                
                function  ajoutReponse(){
                    // Vérifier si il y a déjà 4 réponses
                    if(document.getElementsByClassName('uneReponse').length < 4){
                        // Ajouter une réponse
                        var div = document.createElement('div');
                        div.className = 'uneReponse';
                        div.innerHTML = '<input type=\"checkbox\" name=\"reponse[]\" id=\"reponse\" value=\"reponse\"> <input type=\"text\" name=\"reponse[]\" id=\"reponse\" placeholder=\"Saisissez votre réponse\"> <boutton class=\"btn\" type=\"button\" name=\"ajoutReponse\" id=\"ajoutReponse\" onclick=\"ajoutReponse(this)\">Add</boutton> <boutton class=\"btn\" type=\"button\" name=\"suppReponse\" id=\"suppReponse\" onclick=\"suppReponse(this)\">Supp</boutton>';
                        document.getElementsByClassName('choixMultiple')[0].appendChild(div);
                    }
                }
                
                function  suppReponse(){
                    // Vérifier si il y a plus d'une réponse
                    if (document.getElementsByClassName('uneReponse').length > 1){
                        // Supprimer la réponse
                        
                        var divReponse = document.getElementsByClassName('uneReponse');
                        divReponse[divReponse.length-1].remove();
                    }
                }
                
                </script>";




            }else if(isset($_POST['Suivant1']) && (empty($_POST['typeQuestion']) || empty($_POST['ajoutTag']))){
                // Avant le bouton suivant ecrire : "Veuillez remplir tous les champs"
                echo "<script>alert('Veuillez remplir tous les champs');</script>";
            }


            if (isset($_POST['Suivant2']) && !empty($_POST['question']) && !empty($_POST['reponse']) && !empty($_POST['difficulte'])) {

                // Suppression des 2 forms et affichage du form suivant
                echo "<script>document.forms['choixTypeQuestion'].style.display = 'none';</script>";
                echo "<script>document.forms['choixQuestion'].style.display = 'none';</script>";

                // Affichage d'un récap
                echo "<form method='post' name='recap'>";
                echo "<h3>Récapitulatif</h3>";
                echo "<p>Titre du dépôt : ".$_GET['titreDepot']."</p>";
                echo "<p>Tags : ".$_POST['ajoutTag']."</p>";
                echo "<p>Type de question : ".$_POST['typeQuestion']."</p>";
                echo "<p>Question : ".$_POST['question']."</p>";
                echo "<p>Réponse : ".$_POST['reponse']."</p>";
                echo "<p>Difficulté : ".$_POST['difficulte']."</p>";
                echo "<button class='btn' type='submit' name='Suivant3' >Suivant</button>";
                echo "</form>";

            }else if(isset($_POST['Suivant2']) && (empty($_POST['question']) || empty($_POST['reponse']) || empty($_POST['difficulte']))){
                echo "<script>alert('Veuillez remplir tous les champs');</script>";

            }




            ?>




        </section>
    </main>

</body>


</html>