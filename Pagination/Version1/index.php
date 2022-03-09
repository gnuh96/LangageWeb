<!DOCTYPE html>
<html>
    <head>
        <title>Pagination avec PHP</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php 
        // Traitement des requêtes de base de données et algorithme de pagination
        // Connection a la BD
        $conn = mysqli_connect('localhost', 'root', 'root', 'pagination');
        // Check connection
        if (mysqli_connect_error()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error().'<br/';
        }
        // Calculer le nombre total de lignes dans la table
        $result = mysqli_query($conn, 'SELECT * FROM Perso');
        $total_records = mysqli_num_rows($result);
        // echo $total_records;
        // Fixer la limit et la page
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 5;
        
        // Calculer le nombre total de page et la 1ere ligne de la page
        // Le nombre total de page
        $total_page = ceil($total_records / $limit);
        
        if ($current_page > $total_page){
            $current_page = $total_page;
        }
        else if ($current_page < 1){
            $current_page = 1;
        }
        
        // La 1ere ligne de la page
        $start = ($current_page - 1) * $limit;
        
        // Acces a la liste de donnees
        $result = mysqli_query($conn, "SELECT * FROM Perso LIMIT $start, $limit"); 
        ?>
        <div>
            <table class="table table-striped table-condensed table-bordered table-rounded">
                <thead>
                    <tr>
                        <th>Numero</th>
                        <th width="20%">Nom</th>
                        <th width="20%">Prenom</th>
                        <th width="25%">DateNaiss</th>
                    </tr>
                    </thead>
                    <tbody align="center">
                        <?php 
                        // Afficher la liste de donnees
                        while ($row = mysqli_fetch_array($result)) : ?>
                            <tr>
                                <td><?php echo $row['Numero'];?> </td>
                                <td><?php echo $row['Nom'];?> </td>
                                <td><?php echo $row['Prenom'];?> </td>
                                <td><?php echo $row['DateNaiss'];?> </td>
                            </tr>
                        <?php endwhile?>
                    </tbody>
                </table>
        </div>
        <div class="pagination">
           <?php 
            // Pagination
            // Si current_page > 1 et total_page > 1, afficher 'Prev'
            if ($current_page > 1 && $total_page > 1){
                echo '<button><a href="index.php?page='.($current_page-1).'">Prev</a></button>';
            }
            // Si current_page < $total_page et total_page > 1, afficher 'Next
            if ($current_page < $total_page && $total_page > 1){
                echo '<button><a href="index.php?page='.($current_page+1).'">Next</a></button>';
            }
           ?>
        </div>
    </body>
</html>