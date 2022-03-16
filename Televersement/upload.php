<?php
// Vérifier si le formulaire a été soumis
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Vérifier si le fichier a été téléversé sans erreurs
    if(isset($_FILES["fichier"]) && $_FILES["fichier"]["error"] == 0){
        $pass = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
        $fichier = $_FILES["fichier"];
        
        // echo '<pre>';
        // print_r($fichier);
        
        $name = $fichier["name"];
        $type = $fichier["type"];
        $size = $fichier["size"];
    
        // Vérifier l'extension du fichier
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $pass)) die("Error: Veuillez choisir le bon format de fichier.");
    
        // Vérifier la taille du fichier - max 8 Mo
        $maxsize = 8 * 1024 * 1024;
        if($size > $maxsize) die("Error: la taille du fichier depasse 8 Mo.");
        
        $repertoire = "upload";
        // Vérifier le type du fichier
        if(in_array($type, $pass)){
            // Vérifier si le fichier existe avant de le téléverser
            if(file_exists("$repertoire/$name")){
                echo "Fichier " . $name . " existe déjà.";
            } else{
                move_uploaded_file($fichier["tmp_name"], "$repertoire/$name");
                // Ajouter des informations du fichier au BD
                include "bd-connect.php";
                // $sql = "SELECT * FROM coordonnees ORDER by id ASC";
                // if ($resultat = mysqli_query($connexion, $sql)) {
                //     while ($row = mysqli_fetch_row($resultat)) {
                //         printf("%s, %s, %s\n", $row[0], $row[1], $row[2]);
                //     }
                //     mysqli_free_result($resultat);
                // }
                $query = "INSERT INTO coordonnees(nom,typeext,taille) VALUES ('$name', '$type', '$size')";
                if (mysqli_query($connexion, $query)) {
                    echo "Votre fichier a été téléversé avec succès."."<br>";
                } else {
                    echo "Error: " . $query . "<br>" . mysqli_error($conn)."<br>" ;
                }
                mysqli_close($connexion);
            } 
        }
    } else{
        echo "Error: " . $fichier["error"];
    }
}
?>