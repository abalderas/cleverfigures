<?
class MY_Language extends CI_Lang
{
    
    
    function MY_Language()
    {
        parent::__construct();
    }
    
    function switch_to($idiom)
    {
        $CI =& get_instance();
        $CI->config->set_item('language',$idiom);
        $loaded = $this->is_loaded;
        echo $loaded;
	$this->is_loaded = array();
        
	foreach($loaded as $lang)
	{
		$this->load->lang($lang);    
	}
    }
    
}   
?>