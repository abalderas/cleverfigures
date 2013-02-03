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

<script> YUI().use('tabview', function (Y) {
	var tabview = new Y.TabView({srcNode:'#tabs'});
	tabview.render();
}); </script>

<div class = "yui3-skin-sam">
	<div id = "tabs">
		<ul>
			<?
				foreach($names as $name)
					echo "<li><a href = \"#".$name."\">".$name."</a></li>";
			?>
		</ul>
		
		<div>
			<?
				$view = "content/".$type."analisis_view";
				$item = $type."name";
				
				foreach($names as $name)
					echo "<div id = \"".$name."\">";
					$this->view($view, array('data' => $data, "$item" => $name));
					echo "</div>";
			?>
		</div>
	</div>
</div>