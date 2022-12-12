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

<body>
<main>
    <section>
        <form>
            <?php
            // récupérer les tags
            $tags = $_GET['ajoutTag'];
            // récupérer le type de question
            $typeQuestion = $_GET['typeQuestion'];
            echo $tags;
            echo $typeQuestion;



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
                else if($_GET['typeQuestion'] == "Choix mutiples") {
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





            ?>

        </form>
    </section>
</main>
</body>