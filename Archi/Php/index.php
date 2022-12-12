<html>
<head>
    <!-- Title -->
    <title>Site de playlist</title>
    <!-- Custom styles for this template -->
    <link href="../css/index.css" rel="stylesheet">
</head>
<body>
    <header>
        <a href="index.php">
            <strong>Site de playlist</strong>
        </a>
    </header>
    <main>
        <p>
            Ce site permet d'afficher des playlists de musique en fonction de l'utilisateur sélectionné.<br>
            Sélectionnez un utilisateur dans la liste ci-dessous pour afficher sa playlist.
        </p>
        <div class="container">
            <form action="playlist.php" method="post">
                <label for="name">Utilisateur</label>
                <?php
                $path = "../BD";
                $db = new PDO("sqlite:$path");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = "SELECT * FROM Users";
                $result = $db->query($query);
                echo "<select name='name'>";
                foreach ($result as $row) {
                    echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                }
                echo "</select>";


                ?>
                <input type="submit" class="btn btn-primary" value="Playlist">
            </form>

        </div>
    </main>
</body>

</html>