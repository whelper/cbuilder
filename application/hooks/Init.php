<?
class Init {
	private $CI;

	function __construct()
    {
        $this->CI =& get_instance();
 
        if(!isset($this->CI->session)){  //Check if session lib is loaded or not
              $this->CI->load->library('session');  //If not loaded, then load it here
        }
    }
 
 
    public function device(){
     
        $CI =& get_instance();
        $CI->load->library('session');    
        echo $this->session->userdata('item');
		exit;
        if ( preg_match('/(iPhone|Android|iPod|iPad|BlackBerry|IEMobile|HTC|Server_KO_SKT|SonyEricssonX1|SKT)/',$_SERVER['HTTP_USER_AGENT']) &&  !array_key_exists('device',$_SESSION))
		{
			if($_SERVER['QUERY_STRING'] == 'pc' && !array_key_exists('device',$_SESSION)){
				//setcookie('device',$_SERVER['QUERY_STRING'],0,'/');
				$_SESSION['device'] = $_SERVER['QUERY_STRING'];
				echo '['.array_key_exists('device',$_SESSION).']';
				define('DEVICE_TYPE', 'W');
			}else{
				define('DEVICE_TYPE', 'M');
			}
		}
		else
		{
			define('DEVICE_TYPE', 'W');
		}
         
    }

}
?>