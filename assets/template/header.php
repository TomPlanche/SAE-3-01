<?php

    # Template header


    echo "
        <nav class = \"header\">
            <img src=\"../../Images/auto-qcm-low-resolution-logo-white-on-black-background.png\" alt=\"logo\"></img>
            <ul>
                <li><a href='../../../Acceuil.php'>Accueil</a></li>
            </ul>
        </nav>
        
        <style type='text/css' >
            *{
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0 2rem;
                background-color: #1e1e1e;
                color: white;
                font-size: 1.5rem;
            }
            
            .header > img {
                width: 5rem;
                height: 5rem;
                border-radius: 50%;
            }
            .header > ul {
                display: flex;
                list-style: none;
            }
            .header > ul > li {
                margin: 0 1rem;
            }
            .header > ul > li > a {
                text-decoration: none;
                color: white;
            }
            .header > ul > li > a:hover {
                border-bottom: 2px solid white;
            }
        </style>
        
    ";