<?php

    // Ajout du cookie type passé en parametre
    if ( isset( $_GET['type'] ) ) {
        $type = $_GET['type'];
        # Si le cookie n'existe pas
        setcookie('type', $type, time() + 3600, null, null, false, true);

    }

    // Envoie sur la page de connexion
    header('Location: connexion.php');