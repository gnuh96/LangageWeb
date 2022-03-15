<?php
$connexion = mysqli_connect('localhost', 'root', 'root', 'pagination');
// Check connection
if (mysqli_connect_error()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error().'<br/';
}
$sql = "SELECT * FROM coordonnees ORDER by id ASC";
if ($resultat = mysqli_query($connexion, $sql)) {
    while ($row = mysqli_fetch_row($resultat)) {
        printf("%s, %s, %s\n", $row[0], $row[1], $row[2]);
    }
    mysqli_free_result($resultat);
}
mysqli_close($connexion);
?>