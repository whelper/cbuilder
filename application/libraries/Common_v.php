<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Common_v{

	function __construct() {}
	
	function admin_view($data) {
		$CI =& get_instance();
		$CI->load->model(array('menu_model'));
		
		/*템플릿 좌측 게시판 목록 Begin*/
		$query = $CI->menu_model->menu_board(array('page'=>1,'listnum'=>1000,'language'=>$data['_language']));
		$menu_board = array();
		foreach($query->result() as $row){
			$menu_board[$row->menu_id] = array('title' => $row->title);
		}
		$data = array_merge($data,array('_menu_board'=>$menu_board));
		/*템플릿 좌측 게시판 목록 End*/
		
		$theme = 'thdadmin';
		if(array_key_exists('_admin_template',$data)){
			if($data['_admin_template']){
				$theme = $data['_admin_template'];
			}
		}

		$CI->load->view($theme.'/admin_template',$data);
	}

	function board_view($data) {
		$CI =& get_instance();
		$CI->load->library('Xmlparser');
		$CI->load->view('builder/board/board',$data);
	}
}
?>