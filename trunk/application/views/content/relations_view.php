<?

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
?>

<html><body>

<head>
	<title><?=lang('voc.i18n_relations_graph')?></title>
</head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script><?include(base_url()."application/libraries/mbostock/protovis.js")?></script>
<style type="text/css">

#fig {
  width: 800;
  height: 800;
}

</style>

<div id="fig">
    <script type="text/javascript+protovis">
    
    var relations = {
  			nodes:[
  			
  			<?
  				switch($type){
					case "user":
						$counter = 0;
  				
						echo "{nodeName:\"user: ".$name."\",group:1},\n";
						$iden["user: ".$name] = $counter++;
				
						foreach(array_keys($data['pageedits']) as $page){
							if(isset($data['userpage'][$name][$page])){
								echo "{nodeName:\"page: ".$page."\",group:2},\n";
								$iden["page: ".$page] = $counter++;
							}
						}
				
						foreach(array_keys($data['catedits']) as $cat){
							if(isset($data['usercat'][$name][$cat])){
								echo "{nodeName:\"category: ".$cat."\",group:3}";
								$iden["category: ".$cat] = $counter++;
								if(!($cat == end(array_keys($data['catedits']))))
									echo ",\n";
							}
						}
						
						break;
						
					case "page":
					
						$counter = 0;
  				
						foreach(array_keys($data['useredits']) as $user){
							if(isset($data['pageuser'][$name][$user])){
								echo "{nodeName:\"user: ".$user."\",group:1},\n";
								$iden["user: ".$user] = $counter++;
							}
						}
				
						echo "{nodeName:\"page: ".$name."\",group:2},\n";
						$iden["page: ".$name] = $counter++;
				
						foreach(array_keys($data['catedits']) as $cat){
							if(isset($data['catuser'][$name][$user])){
								echo "{nodeName:\"category: ".$cat."\",group:3}";
								$iden["category: ".$cat] = $counter++;
								if(!($cat == end(array_keys($data['catedits']))))
									echo ",\n";
							}
						}
						
						break;
						
					case "category":
					
						$counter = 0;
  				
						foreach(array_keys($data['useredits']) as $user){
							if(isset($data['catuser'][$name][$user])){
								echo "{nodeName:\"user: ".$user."\",group:1},\n";
								$iden["user: ".$user] = $counter++;
							}
						}
				
						foreach(array_keys($data['pageedits']) as $page){
							if(isset($data['pageuser'][$name][$user])){
								echo "{nodeName:\"page: ".$page."\",group:2},\n";
								$iden["page: ".$page] = $counter++;
							}
						}
				
						echo "{nodeName:\"category: ".$name."\",group:3}";
						
						break;
					default:
					
						$counter = 0;
  				
						foreach(array_keys($data['useredits']) as $user){
							echo "{nodeName:\"user: ".$user."\",group:1},\n";
							$iden["user: ".$user] = $counter++;
						}
				
						foreach(array_keys($data['pageedits']) as $page){
							echo "{nodeName:\"page: ".$page."\",group:2},\n";
							$iden["page: ".$page] = $counter++;
						}
				
						foreach(array_keys($data['catedits']) as $cat){
							echo "{nodeName:\"category: ".$cat."\",group:3}";
							$iden["category: ".$cat] = $counter++;
							if(!($cat == end(array_keys($data['catedits']))))
								echo ",\n";
						}
				}
			?>
			],
  			links:[
  			  <?
				foreach(array_keys($data['userpage']) as $user){
					foreach(array_keys($data['userpage'][$user]) as $page)
						if(isset($iden["user: ".$user]) and isset($iden["page: ".$page]))
							echo "{source:".$iden["user: ".$user].",target:".$iden["page: ".$page].", value:1},\n";
				}
				
				foreach(array_keys($data['usercat']) as $user){
					foreach(array_keys($data['usercat'][$user]) as $cat)
						if(isset($iden["user: ".$user]) and isset($iden["category: ".$cat]))
							echo "{source:".$iden["user: ".$user].",target:".$iden["category: ".$cat].", value:1},\n";
				}
				
				foreach(array_keys($data['pagecat']) as $page){
					foreach(array_keys($data['pagecat'][$page]) as $cat){
						if(isset($iden["page: ".$page]) and isset($iden["category: ".$cat])){
							echo "{source:".$iden["page: ".$page].",target:".$iden["category: ".$cat].", value:1}";
							if(!($page == end(array_keys($data['pagecat']))))
								echo ",\n";
						}
					}
				}
			?>
  			]
		};

var vis = new pv.Panel()
    .width(<?=($type == 'all')? '6000' : '800' ?>)
    .height(<?=($type == 'all')? '3000' : '400' ?>)
    .bottom(<?=($type == 'all')? '500' : '400' ?>);

var arc = vis.add(pv.Layout.Arc)
    .nodes(relations.nodes)
    .links(relations.links)
    .sort(function(a, b) a.group == b.group
        ? b.linkDegree - a.linkDegree
        : b.group - a.group);

arc.link.add(pv.Line);

arc.node.add(pv.Dot)
    .size(function(d) d.linkDegree + 4)
    .fillStyle(pv.Colors.category19().by(function(d) d.group))
    .strokeStyle(function() this.fillStyle().darker());

arc.label.add(pv.Label)

vis.render();

    </script>
  </div></div>
  </body></html>
