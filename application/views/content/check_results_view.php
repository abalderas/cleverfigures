<!--
	INPUT: i18n_content_evolution, i18n_activity, i18n_users, i18n_pages, i18n_categories, i18n_tag_cloud, content_evolution_chart
		activity_chart, users_chart, pages_chart, categories_chart, tag_cloud, i18n_come_back
	OUTPUT: back_home_form(generate_pdf_submit, go_home_submit)
-->

<!--Stats view-->

<?	
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