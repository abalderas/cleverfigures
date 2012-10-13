<!--FUNCTIONS
	function draw_content_evolution(){}
	function draw_activity(){}
   	function draw_users(){}
   	function draw_pages(){}
   	function draw_categories(){}
   	function draw_tag_cloud(){}
-->

<?php

include("libraries/charts/pChart/class/pData.class.php");
include("libraries/charts/pChart/class/pDraw.class.php");
include("libraries/charts/pChart/class/pImage.class.php");
include("classes/tagcloud.php");

class Charts_model extends CI_Model{
   function Charts_model(){
      	parent::__construct();
      	
      	/*[1]*/
   }
   
//Para pasar los datos a dibujar en los gráficos de lineas se usará una matriz de tres dimensiones de puntos $points_matrix
   
function draw_line_chart($points_matrix, $line_labels, $axis_label, $abscissa_labels, $chart_title){
	if(count($points_matrix) != count($line_labels)) die("draw_line_chart(): Bad arguments.");
	
   	$myData = new pData();
   	
   	for($i = 0, $i < count($points_matrix); i++){
   		$myData->addPoints($points_matrix[$i], $line_labels[$i]);
		$myData->setSerieDescription($line_labels[$i], $line_labels[$i]);
		$myData->setSerieOnAxis($line_labels[$i],0);
   	}
	
	$myData->addPoints($abscissa_labels,"Absissa");
	$myData->setAbscissa("Absissa");
	
	$myData->setAxisPosition(0,AXIS_POSITION_LEFT);
	$myData->setAxisName(0,$axis_label);
	$myData->setAxisUnit(0,"");
	
	$myPicture = new pImage(700,400,$myData,TRUE);
	$myPicture->setFontProperties(array("FontName"=>"libraries/charts/pChart/fonts/advent_light.ttf","FontSize"=>14));
	$TextSettings = array("Align"=>TEXT_ALIGN_MIDDLEMIDDLE
	, "R"=>0, "G"=>0, "B"=>0);
	$myPicture->drawText(250,25,$chart_title, $TextSettings);
	
	$myPicture->setGraphArea(50,50,675,360);
	$myPicture->setFontProperties(array("R"=>0,"G"=>0,"B"=>0,"FontName"=>"libraries/charts/pChart/fonts/pf_arma_five.ttf","FontSize"=>10));
	$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>50,"G"=>50,"B"=>50,"Alpha"=>20));
	
	$Settings = array("Pos"=>SCALE_POS_LEFTRIGHT
	, "Mode"=>SCALE_MODE_FLOATING
	, "LabelingMethod"=>LABELING_ALL
	, "GridR"=>0, "GridG"=>0, "GridB"=>0, "GridAlpha"=>50, "TickR"=>0, "TickG"=>0, "TickB"=>0, "TickAlpha"=>50, "LabelRotation"=>0, "CycleBackground"=>1, "DrawXLines"=>1, 	"DrawSubTicks"=>1, "SubTickR"=>255, "SubTickG"=>0, "SubTickB"=>0, "SubTickAlpha"=>50, "DrawYLines"=>ALL);
	$myPicture->drawScale($Settings);

	$Config = "";
	$myPicture->drawLineChart($Config);
	
	$Config = array("FontR"=>0, "FontG"=>0, "FontB"=>0, "FontName"=>"libraries/charts/pChart/fonts/pf_arma_five.ttf", "FontSize"=>9, "Margin"=>6, "Alpha"=>30, "BoxSize"=>5, "Style"=>LEGEND_NOBORDER
	, "Mode"=>LEGEND_HORIZONTAL
	, "Family"=>LEGEND_FAMILY_CIRCLE
	);
	$myPicture->drawLegend(432,16,$Config);
	
	$myPicture->stroke();
   }
   
function draw_stacked_bar_chart($points_matrix, $line_labels, $axis_label, $abscissa_labels, $chart_title){
	if(count($points_matrix) != count($line_labels)) die("draw_line_chart(): Bad arguments.");
	
   	$myData = new pData();
   	
   	for($i = 0, $i < count($points_matrix); i++){
   		$myData->addPoints($points_matrix[$i], $line_labels[$i]);
		$myData->setSerieDescription($line_labels[$i], $line_labels[$i]);
		$myData->setSerieOnAxis($line_labels[$i],0);
   	}
   	
   	$myData->addPoints($abscissa_labels,"Absissa");
	$myData->setAbscissa("Absissa");
	
	$myData->setAxisPosition(0,AXIS_POSITION_LEFT);
	$myData->setAxisName(0,$axis_label);
	$myData->setAxisUnit(0,"");
	
	$myPicture = new pImage(700,400,$myData,TRUE);
	$myPicture->drawRectangle(0,0,699,399,array("R"=>0,"G"=>0,"B"=>0));

	$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>50,"G"=>50,"B"=>50,"Alpha"=>20));
	
	$myPicture->setFontProperties(array("FontName"=>"libraries/charts/pChart/fonts/advent_light.ttf","FontSize"=>14));
	$TextSettings = array("Align"=>TEXT_ALIGN_MIDDLEMIDDLE
	, "R"=>0, "G"=>0, "B"=>0);
	$myPicture->drawText(350,25,$chart_title, $TextSettings);
	
	$myPicture->setShadow(FALSE);
	$myPicture->setGraphArea(50,50,675,360);
	$myPicture->setFontProperties(array("R"=>0,"G"=>0,"B"=>0,"FontName"=>"libraries/charts/pChart/fonts/pf_arma_five.ttf","FontSize"=>6));
	
	$Settings = array("Pos"=>SCALE_POS_LEFTRIGHT
	, "Mode"=>SCALE_MODE_ADDALL
	, "LabelingMethod"=>LABELING_ALL
	, "GridR"=>0, "GridG"=>0, "GridB"=>0, "GridAlpha"=>50, "TickR"=>0, "TickG"=>0, "TickB"=>0, "TickAlpha"=>50, "LabelRotation"=>0, "CycleBackground"=>1, "DrawXLines"=>1, 	"DrawSubTicks"=>1, "SubTickR"=>255, "SubTickG"=>0, "SubTickB"=>0, "SubTickAlpha"=>50, "DrawYLines"=>ALL);	
	$myPicture->drawScale($Settings);
	
	$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>50,"G"=>50,"B"=>50,"Alpha"=>10));
	
	$Config = array("AroundZero"=>1);
	$myPicture->drawStackedBarChart($Config);
	
	$Config = array("FontR"=>0, "FontG"=>0, "FontB"=>0, "FontName"=>"libraries/charts/pChart/fonts/pf_arma_five.ttf", "FontSize"=>10, "Margin"=>6, "Alpha"=>30, "BoxSize"=>5, "Style"=>LEGEND_NOBORDER
	, "Mode"=>LEGEND_HORIZONTAL
	, "Family"=>LEGEND_FAMILY_CIRCLE
	);
	$myPicture->drawLegend(516,16,$Config);
	
	$myPicture->stroke();
}

function draw_users($rows, $th_titles, $totals){
	if(count($rows) != count($th_titles) || count($rows) != count($totals) || count($totals) != count($th_titles)) 
		die("draw_users(): Bad arguments.");
	echo "<table>";
	echo "<tr>"
	for($i = 0; $i < count($th_titles); $i++)
		echo "<th>".$th_titles[$i]."</th>";
	echo "</tr>";
	
	foreach($rows as $row){
		echo "<tr><td>".$row->us_name."</td><td>".$row->us_page_edits."</td><td>".$row->us_page_edits_percentage."</td><td>".$row->us_article_edits."</td><td>".$row->us_article_edits_percentage."</td><td>".$row->us_page_bytes."</td><td>".$row->us_page_bytes_percentage."</td><td>".$row->us_article_bytes."</td><td>".$row->us_article_bytes_percentage."</td><td>".$row->us_uploads."</td><td>".$row->us_uploads_percentage."</td><td>".$row->us_eval_average_mark."</td><td>".$row->us_eval_possitive_comments."</td><td>".$row->us_eval_neutral_comments."</td><td>".$row->us_eval_negative_comments."</td></tr>";
	}
	
	echo "<tr>"
	for($i = 0; $i < count($totals; $i++)
		echo "<td>".$totals[$i]."</td>";
	echo "</tr>";
	
	echo "</table>";
}

function draw_pages($rows, $th_titles, $totals){
	if(count($rows) != count($th_titles) || count($rows) != count($totals) || count($totals) != count($th_titles)) 
		die("draw_users(): Bad arguments.");
	echo "<table>";
	echo "<tr>"
	for($i = 0; $i < count($th_titles); $i++)
		echo "<th>".$th_titles[$i]."</th>";
	echo "</tr>";
	
	foreach($rows as $row){
		echo "<tr><td>".$row->pg_name."</td><td>".$row->pg_namespace."</td><td>".$row->pg_edits."</td><td>".$row->pg_edits_percentage."</td><td>".$row->pg_bytes."</td><td>".$row->pg_bytes_percentage."</td><td>".$row->pg_visits."</td><td>".$row->pg_visits_percentage."</td><td>".$row->pg_eval_average_mark."</td><td>".$row->pg_eval_positive_comments."</td><td>".$row->pg_eval_negative_comments."</td><td>";
	}
	
	echo "<tr>"
	for($i = 0; $i < count($totals; $i++)
		echo "<td>".$totals[$i]."</td>";
	echo "</tr>";
	
	echo "</table>";
}

function draw_categories($rows, $th_titles, $totals){
	if(count($rows) != count($th_titles) || count($rows) != count($totals) || count($totals) != count($th_titles)) 
		die("draw_users(): Bad arguments.");
	echo "<table>";
	echo "<tr>"
	for($i = 0; $i < count($th_titles); $i++)
		echo "<th>".$th_titles[$i]."</th>";
	echo "</tr>";
	
	foreach($rows as $row){
		echo "<tr><td>".$row->ct_name."</td><td>".$row->ct_npages."</td><td>".$row->ct_npages_percentage."</td><td>".$row->ct_edits."</td><td>".$row->ct_edits_percentage."</td><td>".$row->ct_bytes."</td><td>".$row->ct_bytes_percentage."</td><td>".$row->ct_visits."</td><td>".$row->ct_visits_percentage."</td><td>".$row->ct_eval_average_mark."</td><td>".$row->pg_eval_positive_comments."</td><td>".$row->pg_eval_negative_comments."</td><td>";
	}
	
	echo "<tr>"
	for($i = 0; $i < count($totals; $i++)
		echo "<td>".$totals[$i]."</td>";
	echo "</tr>";
	
	echo "</table>";
}

function draw_tag_cloud($tags){
	$cloud = new tagcloud();
	$cloud->addTags($tags);
	echo $cloud->render();
}

function content_evolution_chart($filter_user, $filter_page, $filter_category){}

function activity_hour_chart($filter_user, $filter_page, $filter_category){}
function activity_day_chart($filter_user, $filter_page, $filter_category){}
function activity_week_chart($filter_user, $filter_page, $filter_category){}
function activity_month_chart($filter_user, $filter_page, $filter_category){}
function activity_year_chart($filter_user, $filter_page, $filter_category){}

function evaluation_evolution($filter_user, $filter_page, $filter_category){}

function quality_evolution($filter_user, $filter_page, $filter_category){}
function quality_average_hour_chart($filter_user, $filter_page, $filter_category){}
function quality_average_day_chart($filter_user, $filter_page, $filter_category){}
function quality_average_week_chart($filter_user, $filter_page, $filter_category){}
function quality_average_year_chart($filter_user, $filter_page, $filter_category){}

}

?>
