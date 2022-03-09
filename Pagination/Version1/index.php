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
        $conn = mysqli_connect('localhost', 'root', 'root', 'paging_example');
 
        // Calculer le nombre total de lignes dans la table
        $result = mysqli_query($conn, 'select count(id) as total from news');
        $row = mysqli_fetch_assoc($result);
        $total_records = $row['total'];
        
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
        $result = mysqli_query($conn, "SELECT * FROM news LIMIT $start, $limit"); 
        ?>
        <div>
            <?php 
            // Afficher la liste de donnees
            ?>
        </div>
        <div class="pagination">
           <?php 
            // Pagination
           ?>
        </div>
    </body>
</html>