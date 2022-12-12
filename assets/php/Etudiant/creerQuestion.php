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
                    echo "<ul id='listeTagsRecherche' display='block'></ul>";

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
                // On récupère les données du formulaire
                $tagsArray = explode(',', $_POST['tags']);
                // On le stocke dans une variable de session
                $_SESSION['tags'] = $tagsArray;
                // On récupère le type de question
                $typeQuestion = $_POST['typeQuestion'];
                // On le stocke dans une variable de session
                $_SESSION['typeQuestion'] = $typeQuestion;


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
                        div.innerHTML = '<input type=\"checkbox\" name=\"uneReponse\" id=\"reponse\" value=\"reponse\"> <input type=\"text\" name=\"reponse[]\" id=\"reponse\" placeholder=\"Saisissez votre réponse\"> <boutton class=\"btn\" type=\"button\" name=\"ajoutReponse\" id=\"ajoutReponse\" onclick=\"ajoutReponse(this)\">Add</boutton> <boutton class=\"btn\" type=\"button\" name=\"suppReponse\" id=\"suppReponse\" onclick=\"suppReponse(this)\">Supp</boutton>';
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
                // Récupération des réponses ayant été cochées
                $reponses = array();
                if(isset($_POST['reponse'])){
                    foreach($_POST['reponse'] as $reponse){
                        if($reponse != 'reponse'){
                            array_push($reponses, $reponse);
                        }
                    }
                }
                // Ajout dans une variable de session
                $_SESSION['reponses'] = $reponses;;
                // Ajout dans une variable de session
                $_SESSION['question'] = $_POST['question'];
                // Ajout dans une variable de session
                $_SESSION['difficulte'] = $_POST['difficulte'];


                // Suppression des 2 forms et affichage du form suivant
                echo "<script>document.forms['choixTypeQuestion'].style.display = 'none';</script>";
                echo "<script>document.forms['choixQuestion'].style.display = 'none';</script>";

                // Affichage d'un récap
                echo "<form method='post' name='recap'>";
                echo "<h3>Récapitulatif</h3>";
                echo "<p>Titre du dépôt : ".$_GET['titreDepot']."</p>";
                echo "<p>Tags choisis : ";
                foreach ($_SESSION['tags'] as $tag) {
                    echo $tag.", ";
                }
                echo "</p>";
                echo "<p>Type de question : ".$_SESSION['typeQuestion']."</p>";
                echo "<p>Question : ".$_POST['question']."</p>";
                // Afficher toute les réponses
                echo "<p>Réponses : ";
                echo "<ul>";
                foreach ($_SESSION['reponses'] as $reponse) {
                    echo "<li>".$reponse."</li>";
                }
                // Récupére la sessions['reponses'][0] et l'affiche

                echo "</ul>";
                echo "<p>Difficulté : ";
                switch ($_POST['difficulte']) {
                    case 1:
                        echo "Facile";
                        break;
                    case 2:
                        echo "Moyen";
                        break;
                    case 3:
                        echo "Difficile";
                        break;
                }
                echo "</p>";
                // Afficher tous ce qui a été ajouté dans la variable de session
                echo "<h1>Variable de session</h1>";
                foreach ($_SESSION as $key => $value) {
                    // si c'est une liste
                    if (is_array($value)) {
                        echo "<p>".$key." : ";
                        echo "<ul>";
                        if (is_array($value)) {
                            foreach ($value as $key2 => $value2) {
                                echo "<li>".$value2."</li>";
                            }
                        }
                        else{
                            foreach ($value as $valeur) {
                                echo "<li>".$valeur."</li>";
                            }
                        }

                        echo "</ul>";
                        echo "</p>";
                    }else{
                        echo "<p>".$key." : ".$value."</p>";
                    }
                }
                echo "<h1>-----------</h1>";

                echo "<button class='btn' type='submit' name='envoyer' >Envoyer</button>";
                echo "<button class='btn' type='submit' name='retour' >Retour</button>";
                echo "</form>";

            }else if(isset($_POST['Suivant2']) && (empty($_POST['question']) || empty($_POST['reponse']) || empty($_POST['difficulte']))){
                echo "<script>alert('Veuillez remplir tous les champs');</script>";

            }

            if (isset($_POST['envoyer'])) {
                // Ajout de la question dans la base de données
                $question = $_POST['question'];
                $reponses = $_POST['reponse'];
                $difficulte = $_POST['difficulte'];
                $typeQuestion = $_SESSION['typeQuestion'];
                $idDepot = $_SESSION['idDepot'];
                $idEtudiant = $_SESSION['idEtudiant'];

                // Connexion à la base de données
                $FICHIER_BD = "../../../BDs/BD";
                $db = new PDO('sqlite:'.$FICHIER_BD);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Ajout de la question : id_question, etat_question, titre_question, id_type,difficulte, id_etudiant, id_depot
                $db->exec("INSERT INTO question (etat_question, titre_question, id_type, difficulte, id_etudiant, id_depot) VALUES ('En attente', '$question', '$typeQuestion', '$difficulte', '$idEtudiant', '$idDepot')");
                // Récupération de l'id de la question
                $idQuestion = $db->lastInsertId();

                // Ajout des réponses : si elle existe déjà, on récupère son id sinon on l'ajoute
                // pour chaque réponse
                foreach ($reponses as $reponse) {
                    // Vérifier si la réponse existe déjà
                    $result = $db->query("SELECT * FROM reponse WHERE label_reponse = '$reponse'");
                    $result = $result->fetch();
                    if ($result) {

                    }else{
                        // Ajout de la réponse : id_reponse, titre_reponse
                        $db->exec("INSERT INTO reponse (label_reponse) VALUES ('$reponse')");
                        // Récupération de l'id de la réponse
                        $idReponse = $db->lastInsertId();
                        // ajout dans la table question_a_reponse l'id de la question et l'id de la réponse et son etat (correcte/fausse)
                    }
                    if ($reponse == $reponses[0]) {
                        $db->exec("INSERT INTO question_a_reponse (id_question, id_reponse, etat_veritee) VALUES ('$idQuestion', '$idReponse', 'Fausse')");
                    }else{
                        $db->exec("INSERT INTO question_a_reponse (id_question, id_reponse, etat_veritee) VALUES ('$idQuestion', '$idReponse', 'Correcte')");
                    }
                }

                // lier les tags à la question tag_lie_a_question : id_question et nom_tag
                foreach ($_SESSION['tags'] as $tag) {
                    $db->exec("INSERT INTO tag_lie_a_question (id_question, nom_tag) VALUES ('$idQuestion', '$tag')");
                }





                // Suppression des variables de session
                unset($_SESSION['tags']);
                unset($_SESSION['typeQuestion']);
                unset($_SESSION['idDepot']);

                // Redirection vers la page d'accueil
                header('Location: accueil.php');
            }

            if (isset($_POST['retour'])) {
                // Affichage du form précédent
                echo "<script>document.forms['choixTypeQuestion'].style.display = 'none';</script>";
                echo "<script>document.forms['choixQuestion'].style.display = 'block';</script>";
                // Suppression du form récap
                echo "<script>document.forms['recap'].style.display = 'none';</script>";
            }




            ?>




        </section>
    </main>

</body>


</html>