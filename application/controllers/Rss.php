<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rss extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	var $language  = 'kr';
	var $folder  = '/btob';
	function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url','xml','text'));
		$this->load->model(array('menu_model','board_model','popup_model','member_model','product_model','visual_model'));
		$this->load->library(array('email','user_agent','form_validation','alert','session','encryption'));

		$uri_array = segment_explode($this->uri->uri_string());
		$language = urldecode($this->security->xss_clean(url_explode($uri_array, 'language')));
		if($language) $this->language = $language; 
	}

	
	public function index()
	{	
	
        
		$query = $this->board_model->board_all(array('where' => array('menu_id' => 17)));
		
		$data['feed_name'] = '삼진타이어판매';
        $data['encoding'] = 'utf-8';
        $data['feed_url'] = 'http://www.samjintyre.com/rss';
        $data['page_description'] = '타이어판매,유통,트럭,트레일러,덤프 등 대형타이어, 악세서리 취급 전문업체,도.소매';
        $data['page_language'] = 'ko-KR';
        $data['creator_email'] = $this->config->item('email');
		$data['posts'] = $query;	

		header("Content-Type: application/rss+xml");
		$this->load->view('rss', $data);
	}

	
}
