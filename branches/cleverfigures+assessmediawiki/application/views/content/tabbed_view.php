<!--
<<Copyright 2013 Alvaro Almagro Doello>>

This file is part of CleverFigures.

CleverFigures is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

CleverFigures is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with CleverFigures.  If not, see <http://www.gnu.org/licenses/>.
-->

<script type="text/javascript" src="application/libraries/tabpane.js"></script>
<link type="text/css" rel="StyleSheet" href="css/tab.webfx.css" />


<div class="tab-pane" id="tab-pane-1">
	<?
		$view = "content/".$type."analisis_view";
		$item = $type."name";
		
		foreach($names as $name){
			echo "<div class = \"tab-page\">";
				echo "<h2 class = \"tab\">".$name."</h2>";
				$this->load->view($view, array('data' => $data, "$item" => $name));
			echo "</div>";
		}
	?>
</div>