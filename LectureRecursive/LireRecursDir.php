
<P>
<B>DEBUTTTTTT DU PROCESSUS :</B>
<BR>
<?php echo " ", date ("h:i:s"); ?>
</P>
<?php

//
set_time_limit (500);
$path= "docs";

//
explorerDir($path);

function explorerDir($path)
{
	//
	$folder = opendir($path);
	
	//
	while($entree = readdir($folder))
	{		
		//
		if($entree != "." && $entree != "..")
		{
			//
			if(is_dir($path."/".$entree))
			{
				//
				$sav_path = $path;
				//
				$path .= "/".$entree;
				//			
				explorerDir($path);
				//
				$path = $sav_path;
			}
			else
			{
				//
				$path_source = $path."/".$entree;				
				
				//Si c'est un .png ou un .jpeg		
				//Alors je ferais quoi ? Devinez !
				//...
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
