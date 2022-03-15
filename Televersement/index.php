<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Televersement de fichiers</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <h2>Televersement fichier</h2>
            <label for="fileselect">Fichier :</label>
            <input type="file" name="fichier" id="fileselect">
            <input type="submit" name="submit" value="upload">
            <p><strong>Attention :</strong> On n'accepte que les formats .jpg, .jpeg, .png, la taille maximale est 8 Mo</p>
        </form>
    </body>
</html>