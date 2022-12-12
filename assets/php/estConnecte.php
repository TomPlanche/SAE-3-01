<?php

    if (isset($_SESSION['idEtudiant']) || isset($_SESSION['idEnseignant']))
    {
        return true;
    }
    else
    {
        // envoie sur la page d'accueil situé sur localhost en fonction du pc sur lequel on est
        // Situé dans SAE-3-01/Acceuil.php

        // On récupère le localhost
        $host = $_SERVER['HTTP_HOST'];
        // On redirige vers la page d'accueil
        header("Location: http://$host/SAE-3-01/Acceuil.php");
    }
?>