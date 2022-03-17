<?php
// Connection a la BD
$connexion = mysqli_connect('localhost', 'root', 'root', 'storage');
// Check connection
if (mysqli_connect_error()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error().'<br/';
}
?>