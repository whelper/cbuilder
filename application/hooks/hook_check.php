<?php

function device() {
	
	if ( preg_match('/(iPhone|Android|iPod|iPad|BlackBerry|IEMobile|HTC|Server_KO_SKT|SonyEricssonX1|SKT)/',$_SERVER['HTTP_USER_AGENT']) && !array_key_exists('device',$_COOKIE) )
    {
        if($_SERVER['QUERY_STRING'] == 'pc' && !array_key_exists('device',$_COOKIE)){
			setcookie('device',$_SERVER['QUERY_STRING'],0,'/');
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
 
?>