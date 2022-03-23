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
                    echo "Error: " . $query . "<br>" . mysqli_error($connexion)."<br>" ;
                }
                mysqli_close($connexion);
            }
        }
    } else{
        echo "Error: " . $fichier["error"];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Televersement de fichiers</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <form action="index.php" method="POST" enctype="multipart/form-data">
            <h2>Televersement fichier</h2>
            <label for="fileselect">Fichier :</label>
            <input type="file" name="fichier" id="fileselect">
            <input type="submit" name="submit" value="upload">
            <p><strong>Attention :</strong> On n'accepte que les formats .jpg, .jpeg, .png, la taille maximale est 8 Mo</p>
        </form>
        <h2>Les images</h2>
        <?php
        include "bd-connect.php";
        // Calculer le nombre total de lignes dans la table
        $result = mysqli_query($connexion, 'SELECT * FROM coordonnees');
        $total_rows = mysqli_num_rows($result);

        // Fixer la limit et la page
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 4;

        // Calculer le nombre total de page et la 1ere ligne de la page
        // Le nombre total de page
        $total_page = ceil($total_rows / $limit);

        if ($current_page > $total_page){
            $current_page = $total_page;
        }
        else if ($current_page < 1){
            $current_page = 1;
        }

        // La 1ere ligne de la page
        $start = ($current_page - 1) * $limit;

        // Acces a la liste de donnees
        $result = mysqli_query($connexion, "SELECT * FROM coordonnees LIMIT $start, $limit");
        ?>
        <div class="grille">
            <?php
            // Afficher la liste de donnees
            while ($row = mysqli_fetch_array($result)) : ?>
                <div class="a">
                    <div><img src="upload/<?php echo $row['nom']; ?>" width="300px" height="200px" alt=""></div>
                    <div class="name"><?php echo $row['nom']; ?></div>
                </div>
            <?php endwhile;?>
        </div>

        <div class="pagination">
            <?php
            // Pagination
            // Nombre de pages '$range' que vous souhaitez afficher
            $range = 4;

            // Calculer page de début '$min' et page de fin '$max'
            $middle = ceil($range/2);
            // si $total_page < $range, on affiche tous les pages
            if($total_page < $range) {
                $min = 1;
                $max = $total_page;
                //sinon
            } else {
                $min = $current_page - $middle + 1;
                $max = $current_page + $middle;
                if ($min < 1){
                    $min = 1;
                    $max = $range;
                }
                elseif ($max > $total_page)
                {
                    $max = $total_page;
                    $min = $total_page - $range + 1;
                }
            }

            // Si current_page > 1 et total_page > 1, on affiche 'Prev'
            if ($current_page > 1 && $total_page > 1){
                echo '<button><a href="index.php?page='.($current_page-1).'">Prev</a></button>';
            }

            // Afficher les buttons de pages dans [min,max]
            for ($i = $min; $i <= $max; $i++)
            {
                if ($current_page == $i){
                    $p .= '<button><span>'.$i.'</span></button>';
                }
                else{
                    $p .= '<button><a href="index.php?page='.$i.'">'.$i.'</a></button>';
                }
            }

            echo $p;

            // Si current_page < $total_page et total_page > 1, on affiche 'Next
            if ($current_page < $total_page && $total_page > 1){
                echo '<button><a href="index.php?page='.($current_page+1).'">Next</a></button>';
            }
            ?>
        </div>
    </body>
</html>