<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Board extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		//$this->load->helper(array('form', 'url','file'));
		$this->load->model(array('menu_model','board_model'));
		$this->load->library(array('email','user_agent','form_validation','alert','session'));
		//$this->load->model(array('board_model'));
	}

	/**
	 * 게시판 댓글 내용 조회
	 *
	 * @access	public
	 * @return	void
	 */
	function ajax_comment(){
		$url = $this->uri_church();
		$data = array(
				'_content' => $url
		);
		$data = array_merge($data,$this->board_model->board_comment_view());
		return $data ;
	}
	
	/**
	 * 게시판 첨부파일 다운로드
	 *
	 * @access	public
	 * @return	void
	 */
	function download(){
		$url = get_index_uri(2);
		$uri_array = segment_explode($this->uri->uri_string());
		$id = urldecode($this->security->xss_clean(url_explode($uri_array, 'id')));
		$no = urldecode($this->security->xss_clean(url_explode($uri_array, 'no')));
		$order = urldecode($this->security->xss_clean(url_explode($uri_array, 'order')));
		
		$query = $this->board_model->board_file_select(array('menu_id'=>$id,'board_no'=>$no,'order_no'=>$order));
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$this->load->helper('download');
			$data = file_get_contents($row['file_path'].$row['file_name']); // Read the file's contents
			force_download(iconv('utf-8', 'euc-kr',$row['file_orinal']), $data);
		}else{
			$this->alert->jalert('파일이 존재하지 않습니다.', $this->input->server('HTTP_REFERER'));
		}
		exit;
	}
}
?>