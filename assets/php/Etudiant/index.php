<html lang="fr">
<head>
    <title>Enseignant</title>
    <link rel="stylesheet/less" type="text/css" href="../../scss/EtIndex.scss"/>
    <script src="https://cdn.jsdelivr.net/npm/less@4.1.1"></script>
</head>

<body>
    <!-- Inclure la template header -->
    <?php include '../../template/header.php'; ?>

    <main>
        <!--
        2 cas d'utilisation:
        - L'étudiant souhaite déposer une question dans un dépot auquel il a accès
        - Létudiant souhaite s'entrainer sur des QCM
        -->
        <section>
            <h1>Choisissez une action</h1>
            <div class="choix">
                <section class="depot">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32">
                        <path fill="#444444" d="M30 14c-1.105 0-2 0.896-2 2v12h-24v-12c0-1.104-0.894-2-2-2s-2 0.896-2 2v14c0 1.105 0.894 2 2 2h28c1.105 0 2-0.895 2-2v-14c0-1.104-0.895-2-2-2zM18 14v-12.244c0-0.97-0.895-1.756-2-1.756s-2 0.786-2 1.756v12.244h-6l8 8 8-8h-6z"></path>
                    </svg>
                    <h2>Déposer une question</h2>
                    <p>Vous pouvez déposer une question dans un dépot auquel vous avez accès.</p>
                    <button onclick="window.location.href='deposerQuestion.php'">Déposer</button>
                </section>
                <section class="entrainement">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="48" height="48" fill="white" fill-opacity="0.01"/>
                        <path d="M17 33.9502V42.1102" stroke="black" stroke-width="4" stroke-linecap="round"/>
                        <path d="M9 40V42.0556" stroke="black" stroke-width="4" stroke-linecap="round"/>
                        <path d="M25 27V42.0714" stroke="black" stroke-width="4" stroke-linecap="round"/>
                        <path d="M33 18.9614V42.0878" stroke="black" stroke-width="4" stroke-linecap="round"/>
                        <path d="M41 10.9707V42.0833" stroke="black" stroke-width="4" stroke-linecap="round"/>
                        <path d="M7 33L34 6" stroke="black" stroke-width="4" stroke-linecap="round"/>
                        <path d="M23.5 6H34" stroke="black" stroke-width="4" stroke-linecap="round"/>
                    </svg>
                    <h2>Entrainement</h2>
                    <p>Vous pouvez vous entrainer sur des QCM.</p>
                    <button onclick="entrainement()">Entrainement</button>
                </section>
            </div>
        </section>

    </main>

</body>

</html>
