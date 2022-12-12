<?php
if(!isset($_POST['name'])){
    header("Location: index.php");
    exit();
}else {
    $name = $_POST['name'];
}
?>
<html>
<head>
    <!-- Title -->
    <title>Liste de musique</title>
    <!-- Custom styles for this template -->
    <link href="../css/playlist.css" rel="stylesheet">
</head>
<body>
    <header>
        <a href="index.php">
            <strong>Site de playlist</strong>
        </a>
    </header>
    <div class="container">
        <h1>Liste de musique à <?php echo $name; ?></h1>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Titre</th>
                        <th>Artiste</th>
                        <th>Durée</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $path = "../BD";
                    $db = new PDO("sqlite:$path");
                    $query = "SELECT Musiques.name, Musiques.artist, Musiques.duration from contenir JOIN Musiques ON contenir.musique_id = Musiques.id JOIN Playlist ON contenir.playlist_id = Playlist.id JOIN Users ON Playlist.id = Users.playlist_id WHERE Users.name = '$name'";
                    
                    $result = $db->query($query);
                    for ($i = 1; $row = $result->fetch(); $i++) {
                        echo "<tr>";
                        echo "<td>" . $i . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['artist'] . "</td>";
                        echo "<td>" . $row['duration'] . "</td>";
                        echo "</tr>";
                    }


                    ?>
                </tbody>
            </table>
        </div>
    </div>
</html>