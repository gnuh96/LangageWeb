
<P>
<B>DEBUTTTTTT DU PROCESSUS :</B>
<BR>
<?php echo " ", date ("h:i:s"); ?>
</P>
<?php

// Limiter le temps d'exécution du script
set_time_limit (500);
$path= "docs";

// Fonction pour parcourir tous les fichiers dans un repertoire
explorerDir($path);

function explorerDir($path)
{
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
                echo $path."<br>";
				// Parcourir les fichiers dans sous-repertoire (fonction recursive)
				explorerDir($path);
				// Reprendre l'ancienne adresse pour pacourir les fichiers restes dans la repertoire au debut
				$path = $sav_path;
			}
			else
			{
				// L'adresse de fichier actuel
				$path_source = $path."/".$entree;
                echo $path_source."<br>";
				//Si c'est un .png ou un .jpeg		
				//Alors je ferais quoi ? Devinez !
				//Afficher les fichier .png et .jpeg
//                $pass = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
//                // Vérifier l'extension du fichier
//                $ext = pathinfo($path_source, PATHINFO_EXTENSION);
//                if(array_key_exists($ext, $pass)) {
//                    echo $path_source."<br>";
//                }
			}
		}
	}
	closedir($folder);
}
?>
<P>
<B>FINNNNNN DU PROCESSUS :</B>
<BR>
<?php echo " ", date ("h:i:s"); ?>
</P>
