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


<div class="tab-pane" id="tab-pane-<?=$panid?>">
	<?
		foreach($this->group_model->get_members($name) as $user){
			if(!(!$this->wiki_model->user_has_worked($user, $wiki))){
				echo "<div class = \"tab-page\">";
				echo "<h2 class = \"tab\">".$user."</h2>";
				$this->load->view('content/useranalisis_view', array('data' => $data, 'username' => $user));
				echo "</div>";
			}
			else{
				echo "<div class = \"tab-page\">";
				echo "<h2 class = \"tab\">".$user."</h2>";
				echo lang('voc.i18n_user_did_not_work');
				echo "</div>";
			}
		}
	?>
</div>