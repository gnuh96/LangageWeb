<?php
//Suppression d’une image
//Recuperation de l’id avec $_GET
if(isset($_GET['id'])) {
    $id = $_GET['id'];
	$connexion = mysqli_connect('localhost', 'root', 'root', 'storage');
	mysqli_query($connexion, "DELETE FROM dossier WHERE id = '$id'");
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Lecture Recursive de dossier</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div class="page">
            <div>
                <h2>Affichage de dossier </h2>
                <?php
                include 'LireRecursDir.php';
                ?>
            </div>
            <div>
                <h2>Les images</h2>
                <?php
                include "../../bd-connect.php";
                // Calculer le nombre total de lignes dans la table
                $result = mysqli_query($connexion, 'SELECT * FROM dossier');
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
                $result = mysqli_query($connexion, "SELECT * FROM dossier LIMIT $start, $limit");
                ?>
                <div class="grille">
                    <?php
                    // Afficher la liste de donnees
                    while ($row = mysqli_fetch_array($result)) : ?>
                        <div class="a">
                            <div><img src="<?php echo '../'.$row['path']; ?>" width="300px" height="200px" alt=""></div>
                            <div class="name"><?php echo $row['nom']; ?></div>
                            <div class="button"><button><?php echo '<a href = "?id=' . $row['id'] . '">Supprimer</a>';?></button></div>
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
            </div>
            <div>
                <button><a href="../index.php">User</a></button>
            </div>
        </div>
    </body>
</html>
