<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<?php

	if (!empty($ent))
	{
		$tot_e = count($ent);

		for ($i=0; $i < $tot_e; $i++)
			echo $id[$i] . ":" . $ent[$i] . "<br />";
	}
?>
