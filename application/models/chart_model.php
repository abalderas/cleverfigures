<!--FUNCTIONS
	function draw_content_evolution(){}
	function draw_activity(){}
   	function draw_users(){}
   	function draw_pages(){}
   	function draw_categories(){}
   	function draw_tag_cloud(){}
-->

<?php

class Charts_model extends CI_Model{
   function Charts_model(){
      	parent::__construct();
      	/*[1]*/
   }
   
   //Para pasar los datos a dibujar en los gráficos se usará una matriz de tres dimensiones de puntos con la siguiente estructura:
   //$["EtiquetaLínea"]["NombrePuntoEjeY"]["NombrePuntoEjeX"] = valor
   
function draw_line_chart($points_matrix, $axis_label, $chart_title){
   	$myData = new pData();
   	
   	for($i = 0, $k = 0; $i < count($points_matrix); i++)
   		for($j = 0; $j < count($points_matrix[$i]); j++)
   			for($k = 0; $k < count($points_matrix[$i][$j]; k++){
   				
   			}
	$myData->addPoints(array(0,5,10,80,83,750,771,790),"Serie1");
	$myData->setSerieDescription("Serie1","All Pages");
	$myData->setSerieOnAxis("Serie1",0);
	
	$myData->addPoints(array(0,4,7,62,63,722,740,752),"Serie2");
	$myData->setSerieDescription("Serie2","Articles");
	$myData->setSerieOnAxis("Serie2",0);
		
	$myData->addPoints(array(0,1,3,18,20,28,31,38),"Serie3");
	$myData->setSerieDescription("Serie3","Articles Talks");
	$myData->setSerieOnAxis("Serie3",0);
	
	$myData->addPoints(array("January","February","March","April","May","June","July","August"),"Absissa");
	$myData->setAbscissa("Absissa");
	
	$myData->setAxisPosition(0,AXIS_POSITION_LEFT);
	$myData->setAxisName(0,"Bytes");
	$myData->setAxisUnit(0,"");
	
	$myPicture = new pImage(700,400,$myData,TRUE);
	$myPicture->setFontProperties(array("FontName"=>"fonts/advent_light.ttf","FontSize"=>14));
	$TextSettings = array("Align"=>TEXT_ALIGN_MIDDLEMIDDLE
	, "R"=>0, "G"=>0, "B"=>0);
	$myPicture->drawText(250,25,"Content Evolution",$TextSettings);
	
	$myPicture->setGraphArea(50,50,675,360);
	$myPicture->setFontProperties(array("R"=>0,"G"=>0,"B"=>0,"FontName"=>"fonts/pf_arma_five.ttf","FontSize"=>10));
	
	$Settings = array("Pos"=>SCALE_POS_LEFTRIGHT
	, "Mode"=>SCALE_MODE_FLOATING
	, "LabelingMethod"=>LABELING_ALL
	, "GridR"=>0, "GridG"=>0, "GridB"=>0, "GridAlpha"=>50, "TickR"=>0, "TickG"=>0, "TickB"=>0, "TickAlpha"=>50, "LabelRotation"=>0, "CycleBackground"=>1, "DrawXLines"=>1, 	"DrawSubTicks"=>1, "SubTickR"=>255, "SubTickG"=>0, "SubTickB"=>0, "SubTickAlpha"=>50, "DrawYLines"=>ALL);
	$myPicture->drawScale($Settings);

	$Config = "";
	$myPicture->drawLineChart($Config);
	
	$Config = array("FontR"=>0, "FontG"=>0, "FontB"=>0, "FontName"=>"fonts/pf_arma_five.ttf", "FontSize"=>9, "Margin"=>6, "Alpha"=>30, "BoxSize"=>5, "Style"=>LEGEND_NOBORDER
	, "Mode"=>LEGEND_HORIZONTAL
	, "Family"=>LEGEND_FAMILY_CIRCLE
	);
	$myPicture->drawLegend(432,16,$Config);
	
	$myPicture->stroke();
   }
   function draw_activity(){}
   function draw_users(){}
   function draw_pages(){}
   function draw_categories(){}
   function draw_tag_cloud(){}
   
   /*[2]*/
}

?> 

<!--[1] TO_DO: must add helpers-->

<!--[2] TO_DO: add more charts--> 
