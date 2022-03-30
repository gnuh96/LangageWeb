<?php

// Limiter le temps d'exécution du script
set_time_limit (500);
$path= "../docs";

// Fonction pour parcourir tous les fichiers dans un repertoire
$arbre = explorerDir($path);
echo '<p>';
echo $arbre;
echo '</p>';

function explorerDir($path)
{
	$arbre = "";
	// Ouvrir un descripteur de répertoire qui a l'adresse $path
	$folder = opendir($path);
	
	// Parcourir tous les fichiers et sous-repertoires dans $folder
	while($entree = readdir($folder))
	{
		// Verifier si $entree n'est pas "."(répertoire actuel) et pas ".."(répertoire parent)
		if($entree != "." && $entree != "..")
		{
			// Verifier si c'est un repertoire ou pas
			if(is_dir($path."/".$entree))
			{
				// Enregistrer l'adresse actuelle pour pacourir les autres fichiers
				$sav_path = $path;
				// Enregistrer l'adresse de sous-repertoire
				$path .= "/".$entree;
				$arbre .= $entree.'<br>';
				// echo $path."<br>";
				// Parcourir les fichiers dans sous-repertoire (fonction recursive)
				$arbre .= explorerDir($path);
				// Reprendre l'ancienne adresse pour pacourir les fichiers restes dans la repertoire au debut
				$path = $sav_path;
			}
			else
			{
				// L'adresse de fichier actuel
				$path_source = $path."/".$entree;
				$arbre .= $entree.'<br>';
                // echo $path_source."<br>";
				//Si c'est un .png ou un .jpeg		
				//Alors je ferais quoi ? Devinez !
				//Afficher les fichier .png et .jpeg
                $pass = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
                // Vérifier l'extension du fichier
                $ext = pathinfo($path_source, PATHINFO_EXTENSION);
                if(array_key_exists($ext, $pass)) {
                    // echo $path_source." have a size :".filesize($path_source)."<br>";
                    $nom = pathinfo($path_source, PATHINFO_BASENAME);
                    $size = filesize($path_source);
                    // Ajouter des informations du fichier au BD
                    include "../bd-connect.php";
                    $query = "INSERT INTO dossier(nom,ext,path,taille) SELECT * FROM (SELECT '$nom' AS nom, '$pass[$ext]' AS ext, '$path_source' AS path, '$size' AS taille) AS tmp WHERE NOT EXISTS ( SELECT nom FROM dossier WHERE nom = '$nom') LIMIT 1;";
                    mysqli_query($connexion, $query);
                    mysqli_close($connexion);
                }
			}
		}
	}
	closedir($folder);
	return $arbre;
}
?>
