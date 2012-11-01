<?php

// <<Copyright 2013 Alvaro Almagro Doello>>
// 
// This file is part of CleverFigures.
// 
// CleverFigures is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
// 
// CleverFigures is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with CleverFigures.  If not, see <http://www.gnu.org/licenses/>.



class Charts_model extends CI_Model{
   function Charts_model(){
      	parent::__construct();
   	$this->load->database();
      	
      	$id = 0;
   }

//TABLES
function draw_users($id_analisis, $filter_category => 'total', $filter_page => 'total'){
	
	//Tomamos los nombres de las cabeceras de la tabla según idioma.
	$titles = array('#', $i18n_username, $i18n_edits, $i18n_edits_per, $i18n_edits_art, $i18n_edits_art_per, $i18n_bytes, $i18n_bytes_per, $i18n_bytes_art, $i18n_bytes_art_per, $i18n_uploads, $i18n_uploads_per, $i18n_neval, $i18n_average_mark, $i18n_replies_in, $i18n_replies_out);
	
	//Tomamos variables de filtrado.
	if($filter_category == 'total'){
		if($filter_page == 'total'){
			$type = 'total';
			$name = 'total';
		}
		else{
			$type = 'page';
			$name = $filter_page;
		}
	}
	else{
		$type = 'category';
		$name = $filter_category;
	}
	
	//Abrimos la tabla y pintamos las cabeceras.
	echo "<table>";
	echo "<tr>"
	for($i = 0; $i < count($titles); $i++)
		echo "<th>".$titles[$i]."</th>";
	echo "</tr>";
	
	//Seleccionamos todos los campos de las filas de la tabla de datos de usuario aplicando los filtros obtenidos anteriormente.
	$this->bd->select('wuser.*');
	$this->bd->from('wuser');
	$this->bd->where('wu_analisis_id', $id_analisis);
	$this->bd->where('wu_type', $type);
	$this->bd->where('wu_name', $name);
	
	//Y ordenamos por orden descendente de ediciones.
	$this->db->order_by('wu_edits', 'asc'); 
	
	//Tomamos el resultado.
	$query = $this->db->get();
	$result = $query->result();
	
	//Y pintamos el resto de la tabla.
	$totals = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
	$count = 0;
	
	foreach($result as $row){
		echo "<tr><td>".$count+1."</td><td>".$row->wu_name."</td><td>".$row->wu_edits."</td><td>".$row->wu_edits_per."</td><td>".$row->wu_edits_art."</td><td>".$row->wu_edits_art_per."</td><td>".$row->wu_bytes."</td><td>".$row->wu_bytes_per."</td><td>".$row->wu_bytes_art."</td><td>".$row->wu_bytes_art_per."</td><td>".$row->wu_uploads."</td><td>".$row->wu_uploads_per."</td><td>".$row->wu_neval."</td><td>".$row->wu_avg_mark."</td><td>".$row->wu_replies_in."</td><td>".$row->wu_replies_out."</td></tr>";
		
		//Vamos calculando los totales para la última fila.
		$totals[0] += $row->wu_id;
		$totals[1] += $row->wu_name;
		$totals[2] += $row->wu_edits;
		$totals[3] += $row->wu_edits_per;
		$totals[4] += $row->wu_edits_art;
		$totals[5] += $row->wu_edits_art_per;
		$totals[6] += $row->wu_bytes;
		$totals[7] += $row->wu_bytes_per;
		$totals[8] += $row->wu_bytes_art;
		$totals[9] += $row->wu_bytes_art_per;
		$totals[10] += $row->wu_uploads;
		$totals[11] += $row->wu_uploads_per;
		$totals[12] += $row->wu_neval;
		$totals[13] += $row->wu_avg_mark;
		$totals[14] += $row->wu_replies_in;
		$totals[15] += $row->wu_replies_out;
		$count++;
	}
	
	//Hacemos la media aritmética a la nota.
	$totals[13] /= $count;
	
	//Pintamos la última fila con los totales y cerramos la tabla.
	echo "<tr>"
	for($i = 0; $i < count($totals); $i++)
		echo "<td>".$totals[$i]."</td>";
	echo "</tr>";
	
	echo "</table>";
}

function draw_pages($id_analisis, $filter_category => 'total', $filter_user => 'total'){

	//Tomamos los nombres de las cabeceras de la tabla según idioma.
	$titles = array('#', $i18n_name, $i18n_namespace, $i18n_edits, $i18n_edits_per, $i18n_bytes, $i18n_bytes_per, $i18n_visits, $i18n_visits_per, $i18n_neval, $i18n_average_mark, $i18n_replies_in);
	
	//Tomamos variables de filtrado.
	if($filter_category == 'total'){
		if($filter_user == 'total'){
			$type = 'total';
			$name = 'total';
		}
		else{
			$type = 'user';
			$name = $filter_user;
		}
	}
	else{
		$type = 'category';
		$name = $filter_category;
	}
	
	//Abrimos la tabla y pintamos las cabeceras.
	echo "<table>";
	echo "<tr>"
	for($i = 0; $i < count($titles); $i++)
		echo "<th>".$titles[$i]."</th>";
	echo "</tr>";
	
	//Seleccionamos todos los campos de las filas de la tabla de datos de usuario aplicando los filtros obtenidos anteriormente.
	$this->bd->select('wpage.*');
	$this->bd->from('wpage');
	$this->bd->where('wp_analisis_id', $id_analisis);
	$this->bd->where('wp_type', $type);
	$this->bd->where('wp_name', $name);
	
	//Y ordenamos por orden descendente de ediciones.
	$this->db->order_by('wp_edits', 'asc'); 
	
	//Tomamos el resultado.
	$query = $this->db->get();
	$result = $query->result();
	
	//Y pintamos el resto de la tabla.
	$totals = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
	$count = 0;
	
	foreach($result as $row){
		echo "<tr><td>".$row->wp_id."</td><td>".$row->wp_name."</td><td>".$row->wp_namespace."</td><td>".$row->wp_edits."</td><td>".$row->wp_edits_per."</td><td>".$row->wp_bytes."</td><td>".$row->wp_bytes_per."</td><td>".$row->wp_visits."</td><td>".$row->wp_visits_per."</td><td>".$row->wp_neval."</td><td>".$row->wp_avg_mark."</td><td>".$row->wp_replies."</td></tr>";
		
		//Vamos calculando los totales para la última fila.
		$totals[0] += $row->wp_id;
		$totals[1] += $row->wp_name;
		$totals[2] += $row->wp_namespace;
		$totals[3] += $row->wp_edits;
		$totals[4] += $row->wp_edits_per;
		$totals[5] += $row->wp_bytes;
		$totals[6] += $row->wp_bytes_per;
		$totals[7] += $row->wp_visits;
		$totals[8] += $row->wp_visits_per;
		$totals[9] += $row->wp_neval;
		$totals[10] += $row->wp_avg_mark;
		$totals[11] += $row->wp_replies_in;
		$count++;
	}
	
	//Hacemos la media aritmética a la nota.
	$totals[10] /= $count;
	
	//Pintamos la última fila con los totales y cerramos la tabla.
	echo "<tr>"
	for($i = 0; $i < count($totals); $i++)
		echo "<td>".$totals[$i]."</td>";
	echo "</tr>";
	
	echo "</table>";
}

function draw_categories($id_analisis, $filter_page => 'total', $filter_user => 'total'){
	
	//Tomamos los nombres de las cabeceras de la tabla según idioma.
	$titles = array('#', $i18n_name, $i18n_pages, $i18n_pages_per, $i18n_edits, $i18n_edits_per, $i18n_bytes, $i18n_bytes_per, $i18n_visits, $i18n_visits_per, $i18n_neval, $i18n_average_mark, $i18n_replies_in);
	
	//Tomamos variables de filtrado.
	if($filter_user != 'total'){
		$type = 'user';
		$name = $filter_user;
	}
	else if($filter_page != 'total'){
		$type = 'page';
		$name = $filter_page;
	}
	
	//Abrimos la tabla y pintamos las cabeceras.
	echo "<table>";
	echo "<tr>"
	for($i = 0; $i < count($titles); $i++)
		echo "<th>".$titles[$i]."</th>";
	echo "</tr>";
	
	//Seleccionamos todos los campos de las filas de la tabla de datos de usuario aplicando los filtros obtenidos anteriormente.
	$this->bd->select('wcategory.*');
	$this->bd->from('wcategory');
	$this->bd->where('wc_analisis_id', $id_analisis);
	$this->bd->where('wc_type', $type);
	$this->bd->where('wc_name', $name);
	
	//Y ordenamos por orden descendente de ediciones.
	$this->db->order_by('wc_pages', 'asc'); 
	
	//Tomamos el resultado.
	$query = $this->db->get();
	$result = $query->result();
	
	//Y pintamos el resto de la tabla.
	$totals = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
	$count = 0;
	
	foreach($result as $row){
		echo "<tr><td>".$row->wc_id."</td><td>".$row->wc_name."</td><td>".$row->wc_pages."</td><td>".$row->wc_pages_per."</td><td>".$row->wc_edits."</td><td>".$row->wc_edits_per."</td><td>".$row->wc_bytes."</td><td>".$row->wc_bytes_per."</td><td>".$row->wc_visits."</td><td>".$row->wc_visits_per."</td><td>".$row->wc_neval."</td><td>".$row->wc_avg_mark."</td><td>".$row->wc_replies."</td></tr>";
		
		//Vamos calculando los totales para la última fila.
		$totals[0] += $row->wc_id;
		$totals[1] += $row->wc_name;
		$totals[2] += $row->wc_pages;
		$totals[3] += $row->wc_pages_per;
		$totals[4] += $row->wc_edits;
		$totals[5] += $row->wc_edits_per;
		$totals[6] += $row->wc_bytes;
		$totals[7] += $row->wc_bytes_per;
		$totals[8] += $row->wc_visits;
		$totals[9] += $row->wc_visits_per;
		$totals[10] += $row->wc_neval;
		$totals[11] += $row->wc_avg_mark;
		$totals[12] += $row->wc_replies;
		$count++;
	}
	
	//Hacemos la media aritmética a la nota.
	$totals[11] /= $count;
	
	//Pintamos la última fila con los totales y cerramos la tabla.
	echo "<tr>"
	for($i = 0; $i < count($totals); $i++)
		echo "<td>".$totals[$i]."</td>";
	echo "</tr>";
	
	echo "</table>";
}

function draw_general_stats(){
	$labels = array($i18n_total_views, $i18n_total_edits, $i18n_good_articles, $i18n_total_pages, $i18n_users, $i18n_active_users, $i18n_admins, $i18n_images);
	
	$query = $this->db->query("SELECT * FROM wgeneral LIMIT 1");
	$result = $this->db->result();
	foreach($result as $row){
		$data[0] = $row->wgen_total_views;
		$data[1] = $row->wgen_total_edits;
		$data[2] = $row->wgen_good_articles;
		$data[3] = $row->wgen_total_pages;
		$data[4] = $row->wgen_users;
		$data[5] = $row->wgen_active_users;
		$data[6] = $row->wgen_admins;
		$data[7] = $row->wgen_images;
	}
	
	echo "<table>";
	for($i=0; $i < count($labels); $i++) {
 		echo "<tr><th>".$labels[$i]."</th><td>".$data[$i]."</td></tr>";
	}
	echo "</table>";
}

//TAG CLOUD

function draw_tag_cloud($tags){
	$cloud = new tagcloud();
	$cloud->addTags($tags);
	echo $cloud->render();
}

//CONTENT CHARTS

function draw_content_evolution_chart($analisis){
	$datasource = $analisis."contentevolution";
	$query = $this->db->query("SELECT * FROM data WHERE da_id == \"$datasource\" ORDER BY da_s1 ASC");
	
	echo "
		var datace = google.visualization.arrayToDataTable([";
			echo "[".lang('date').",".lang('bytes').",".lang('average_mark')."]";
			foreach($query->result() as $row)
				echo "[".$row->da_s1.",".$row->da_s2.",".$row->da_s3."]";
		echo "]);

		var acce = new google.visualization.ComboChart(document.getElementById('content_evolution'));
		acce.draw(datace, {
			title : ".lang('content_evolution').",
			width: 600,
			height: 400,
			vAxis: {title: ".lang('bytes')."},
			hAxis: {title: ".lang('date')."},
			seriesType: \"bars\",
			series: {1: {type: \"line\"}}
			});
		}";
	return "<div id=\"content_evolution\" style=\"width: 600px; height: 400px;\"></div>";
}

function draw_activity_hour_chart($analisis, $unit, $filter_user => 'default', $filter_page => 'default', $filter_category => 'default'){
	
} //stacked bars, units: Y, M, W, D, H

function draw_evaluation_evolution($filter_user => 'default', $filter_page => 'default', $filter_category => 'default'){} //linea de evolucion + barras de valores por dia

function draw_quality_evolution($filter_user => 'default', $filter_page => 'default', $filter_category => 'default'){} //spline
function draw_quality_average_hour_chart($filter_user => 'default', $filter_page => 'default', $filter_category => 'default'){} //bars
function draw_quality_average_day_chart($filter_user => 'default', $filter_page => 'default', $filter_category => 'default'){}
function draw_quality_average_week_chart($filter_user => 'default', $filter_page => 'default', $filter_category => 'default'){}
function draw_quality_average_year_chart($filter_user => 'default', $filter_page => 'default', $filter_category => 'default'){}

function draw_work_distribution($filter_user => 'default', $filter_page => 'default', $filter_category => 'default'){} //accumulative

}