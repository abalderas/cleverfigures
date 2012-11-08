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

<!--Stats view-->

<?	
echo "<h1>".lang('i18n_check_results')."</h1></br>";

echo "<h3>".lang('i18n_content_evolution')."</h3>";
echo $content_evolution_chart;
echo "</br>";

echo "<h3>".lang('i18n_activity')."</h3>";
echo $activity_chart;
echo "</br>";

echo "<h3>".lang('i18n_users')."</h3>";
echo $users_chart;
echo "</br>";

echo "<h3>".lang('i18n_pages')."</h3>";
echo $pages_chart;
echo "</br>";

echo "<h3>".lang('i18n_categories')."</h3>";
echo $categories_chart;
echo "</br>";

echo "<h3>".lang('i18n_tag_cloud')."</h3>";
echo $tag_cloud;
echo "</br>";

echo open_form('generate_pdf');
echo form_submit('generate_pdf_submit', lang('i18n_generate_pdf')); 
// [2] www.christophermonnat.com/2008/08/generating-pdf-files-using-codeigniter
echo close_form();

echo open_form('back_home_form');
echo form_submit('go_home_submit', lang('i18n_come_back'));
echo close_form();
?>

<!--[1] TO_DO: add more charts-->
<!--[2] TO_DO: generate pdf-->