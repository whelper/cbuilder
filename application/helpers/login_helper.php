<?php 
/**
 * 관리자 로그인 쿠키값 여부 체크
 *
 * @param Array 
 * @param String $key : 가져오려는 값의 key
 * @return void
 */
function login_admin($param=null){
	$CI =& get_instance();
	$CI->load->library('session');
	$path = ($param['admin_controller']) ? $param['admin_controller'] : 'thdadmin';
	if(!$CI->session->userdata('userid') || $CI->session->userdata('membership') < 2){
		redirect(base_url('/'.$path.'/?return_url='.urlencode($CI->uri->uri_string())));
		exit;
	}
	
}


/**
 * 사용자 로그인 쿠키값
 *
 * @param Array 
 * @param String $key : 가져오려는 값의 key
 * @return void
 */
function login_member($return_url=null){
	$CI =& get_instance();
	if(!$CI->session->userdata('userid') ){
		$return_url = ($return_url) ? $return_url : $CI->uri->uri_string();
		redirect(base_url('/btob?return_url='.urlencode($return_url)));
		//redirect(base_url('/member/login?return_url='.urlencode($return_url)));
		exit;
	}
	
}

?>