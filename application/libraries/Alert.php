<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Alert{
	function __construct() {}
	
	function jalert($msg='', $url='', $target='link') {
		$CI =& get_instance();
		echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">\n";
		echo "<script type='text/javascript'>\n";
		if($msg){
			echo "alert('".$msg."');\n";
		}
	    switch($target){
	    	case('link'):
	    		echo "location.replace('".$url."');\n";
	    	break;
	    	case('back'):
	    		echo "history.go(-1);\n";
	    	break;
	    	case('top'):
	    		echo "top.location.replace('".$url."');\n";
	    	break;
	    	case('opener'):
	    		echo "opener.location.replace('".$url."');\n";
	    		echo "self.close()\n";
	    	break;
	    	case('parent'):
	    		echo "parent.location.replace('".$url."');\n";
	    	break;
			default:
			break;
	    }
		echo "</script>\n";
	}
}
?>