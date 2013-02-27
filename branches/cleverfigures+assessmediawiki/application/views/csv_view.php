<?php

	if (!empty($entregables))
	{
		echo "rev";
		$tot_e = count($entregables);

		for ($i=0; $i < $tot_e; $i++)
			echo ":" . $entregables[$i] ;
	}

	if (!empty($revisions))
	{
		$tot = count($revisions);

		for ($i=0; $i < $tot; $i++)
		{
			echo  "<br />" . $revisions[$i];
			if (!empty($notas[$listado[$i]]))
			{	
				$j = $listado[$i];
				// Mostramos notas para la revisión $listado[$i]
				for ($k=0; $k < $tot_e; $k++)
				{
					echo ":";
					if (isset($notas[$j][$listado[$k]]))
						echo $notas[$j][$listado[$k]];
				}
			}
			else
			{
				for ($k=0; $k < $tot_e; $k++)
				{
					echo ":";
				}
			}
		}
	}
?>
