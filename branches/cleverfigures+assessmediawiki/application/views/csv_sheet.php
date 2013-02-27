<?php

	if (!empty($competencies))
	{
		echo "id:user";
		$tot_e = count($competencies);

		for ($i=0; $i < $tot_e; $i++)
			echo ":" . $competencies[$i] ;
	}

	if (!empty($users))
	{
		$tot = count($users);

		for ($i=0; $i < $tot; $i++)
		{
			echo  "<br />" . $users[$i] . ":" . $wikiu[$users[$i]];
			if (isset($sumas[$users[$i]]))
			{
//echo "..:.." . $competencies[0] . "..:..";
				//$j = $competencies[0];
				// Mostramos notas para la revisión $listado[$i]
				for ($k=0; $k < $tot_e; $k++)
				{
					echo ":";
					if (isset($sumas[$users[$i]][$competencies[$k]]))
						echo $sumas[$users[$i]][$competencies[$k]];
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
