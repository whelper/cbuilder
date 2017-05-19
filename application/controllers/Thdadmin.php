<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Thdadmin extends CI_Controller {

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
	var $view_page = '';
	function __construct() {
		parent::__construct();
		if($this->input->get_post('language',true)) $this->language = $this->input->get_post('language',true);
		$this->load->helper(array('form', 'url','file','common','directory','cookie','login_helper'));
		$this->load->model(array('menu_model','member_model','board_model','product_model','dashboard_model','enquiry_model','popup_model','code_model','visual_model','common_model'));
		$this->load->library(array('email','user_agent','form_validation','alert','encrypt','session'));
		/*if(!$this->session->userdata('userid')){
			if($this->uri->uri_string() != 'thdadmin' && $this->uri->uri_string() != 'thdadmin/login_process'){
				redirect(base_url('/thdadmin/?return_url='.urlencode($this->uri->uri_string())));
				exit;
			}
		}*/
		if($this->uri->uri_string() != 'thdadmin' && $this->uri->uri_string() != 'thdadmin/login_process'){
			login_admin();
		}

		$this->view_page = $this->uri->segment(2); //view이름
	}
	
	public function index()
	{
		/*if($this->session->userdata('userid')){
			redirect(base_url('/thdadmin/dashboard'));
			exit;
		}*/
		$return_url = ($this->input->get('return_url')) ? $this->input->get('return_url') :  '/thdadmin/dashboard';
		$data = array('_title'=>$this->config->item('title'),'_return_url'=>$return_url);
		$this->load->view('thdadmin/index.php',$data);
		
	}

	/**
	 * 회원 로그아웃
	 *
	 * @access	public
	 * @return	result
	 */
	function logout(){
		//$uri_array = segment_explode($this->uri->uri_string());
		$return_url = ($this->input->get('return_url')) ? $this->input->get('return_url') :  '/front/main';
		
		$this->session->set_userdata(array('username' => '', 'userid' => '','admin_yn'=>'', 'logged_time' => '','logged_in'=>''));
		$this->session->sess_destroy();
		$this->alert->jalert(null, base_url($return_url));
		exit;
	}

	/**
	 * 회원 로그인 처리
	 *
	 * @access	public
	 * @return	result
	 */
	
	function login_process(){
		$this->form_validation->set_rules('userid', 'userid', 'required');
		$this->form_validation->set_rules('passwd', 'passwd', 'required');
		$msg = null;
		
		//로그인 실패시
		$return_url = (strpos($this->input->server('HTTP_REFERER'),'/thdadmin') === false) ? '/member/login' : '/thdadmin/dashboard';
		if ($this->form_validation->run()) {								// validation ok
			
			$query = $this->member_model->login();
			if($query->num_rows() > 0){ //login ok
				$row = $query->row_array();

				$session_info = array(
                    'userno'  => $row['seq'],
					'username'  => $row['name'],
                    'userid'     => $row['user_id'],
					'membership'     => $row['membership'],
                    'logged_time' =>  time()  ,
					'logged_in' => TRUE
                );
				
				$this->session->set_userdata($session_info);
				
				//최근 로그인 시간 저장
				$this->member_model->member_modify(array('seq'=>$row['seq'],'data'=>array('login_date'=>date("Y-m-d H:i:s"))));
				
				//아이디저장
				$this->load->helper('cookie');
				if($this->input->post('save_userid') == 'Y'){
					//set_cookie('save_userid',$this->input->post('userid'), $this->config->item('autologin_cookie_life'));
					set_cookie(array(
						'name' 		=> 'save_userid',
						'value'		=> $this->input->post('userid'),
						'expire'	=> $this->config->item('autologin_cookie_life')
					));
				}else if(!$this->input->post('save_userid') && get_cookie('save_userid')){ //쿠키삭제
					delete_cookie("save_userid");
				}

				$return_url = ($this->input->post("return_url")) ? $this->input->post("return_url") : '/front/main';
			}else{
				$msg = '아이디 또는 패스워드를 확인해주세요';
			}
		}else{
			$msg = '잘못된 접근입니다.';
		}

		
		$this->alert->jalert($msg, base_url($return_url));
		exit;
	}

	public function frame()
	{
		$data = array('_language' => $this->language);
		$this->load->view('thdadmin/frame.php',$data);
	}

	public function dashboard(){
		$_ga = array();
		if($this->config->item('ga')){
			//ga 데이터 정보 수신 begin
			$ch = curl_init();
			curl_setopt ($ch, CURLOPT_URL,$this->config->item('ga')); //접속할 URL 주소
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 인증서 체크같은데 true 시 안되는 경우가 많다.
			curl_setopt ($ch, CURLOPT_SSLVERSION,3); // SSL 버젼 (https 접속시에 필요)
			curl_setopt ($ch, CURLOPT_HEADER, 0); // 헤더 출력 여부
			curl_setopt ($ch, CURLOPT_TIMEOUT, 30); // TimeOut 값
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); // 결과값을 받을것인지
			$result = curl_exec ($ch);
			curl_close ($ch);
			$json =  json_decode($result,true);
			
			foreach($json['rows'] as $k => $v){
				$_ga[]= "{period: '".substr($v[0],0,4).'-'.substr($v[0],-2)."',iphone: ".$v[1]."}";
			}
			//ga 데이터 정보 수신 end
		}
		
		$data = array(
			'_title' => 'Dashboard',
			'_content' => 'thdadmin/pages/dashboard',
			'_language' => $this->language,
			'_board' => $this->dashboard_model->recently_board(),
			'_enquiry' => $this->dashboard_model->recently_enquiry(),
			'_GA' => implode(',',$_ga),
		);

		$this->common_v->admin_view($data);
	}

	public function menu(){
		$query = $this->menu_model->menu_list(array('language' => $this->language));
		$_menu = array();
		foreach($query->result() as $row){
			$url = $this->menu_model->menu_create_url($row->menu_id); 
			$_menu[$row->menu_id] = array('menu_type' => $row->menu_type,'parent_id' => $row->parent_id,'title' => $row->title,'etc_yn' => $row->etc_yn,'single_yn' => $row->single_yn,'url'=> $url,'sort_no' => $row->sort_no,'use_yn'=>$row->use_yn);
		}

		$data = array(
			'_title' => '메뉴관리',
			'_content' => 'thdadmin/pages/menu',
			'_language' => $this->language,
			'menu' => $_menu,
		);
		$this->common_v->admin_view($data);
	}

	public function menu_form(){
		$single_yn = $this->input->get('single_yn',true);
		if(!$single_yn) $single_yn = 'N';
		$parent_id = $this->input->get('parent_id',true);
		if(!$parent_id) $parent_id = 0;
		$menu_id = $this->input->get('menu_id',true);
		
		$member_group = $this->member_model->list_group_member(); //회원 그룹
		$data = array(
			'_title' => '메뉴관리',
			'_content' => 'thdadmin/pages/menu_form',
			'_language' => $this->language,
			'_member_group' => $member_group,
		);
		
		$arr = $this->menu_model->menu_select(array('menu_id' => $menu_id));
		$data = array_merge($data,$arr);
		if(!$arr['menu_id']){ //순서 바꾸면 않됨
			$data = array_merge($data,array('parent_id' => $parent_id,'single_yn' => $single_yn,'dbjob'=>'i'));
		}else{
			$page_url = base_url();
			//$page_url .= ($this->language !='kr') ? 'en/' : '';
			
			switch($arr['menu_type']){
			case('HTML'):
				$page_url .= ($this->language !='kr') ? 'en/' : '';
				$page_url .= 'front/html/id/'.$menu_id;
			break;
			case('BOARD'):
				$page_url .= ($this->language !='kr') ? 'en/' : '';
				$page_url .= 'front/board/list/id/'.$menu_id;
			break;
			case('LINK'):
				$page_url .= $arr['link'];
			break;
			}
			
			

			$data = array_merge($data,array('dbjob'=>'u','page_url'=>$page_url));
			
		}

		$this->common_v->admin_view($data);
	}

	/**
	 * 설치 모듈 정보
	 *
	 * @access	public
	 * @return	void
	 */
	function plugin_info(){
		$plugin = $this->input->post('plugin');
		$xml = read_file(APPPATH.'/modules/'.$plugin.'/module.xml');
		if($xml){
			$parser = new XMLParser($xml);
			$parser->Parse();
			
			$json['module_name'] = $plugin;
			$json['controller'] = $parser->document->controller[0]->tagData;
			$json['function'] = $parser->document->function[0]->tagData;
		}
		return $json;
	}

	public function menu_dbjob(){
		$menu_id = $this->input->post('menu_id',true);
		$sort_no = $this->input->post('sort_no',true);
		$dbjob = $this->input->post('dbjob',true);
		$etc_yn = $this->input->post('etc_yn',true);
		$single_yn = $this->input->post('single_yn',true);
		$use_yn = $this->input->post('use_yn',true);
		$parent_id = $this->input->post('parent_id',true);
		$menu_type = $this->input->post('menu_type',true);
		$title = $this->input->post('title',true);
		$keyword = $this->input->post('keyword',true);
		$description = $this->input->post('description',true);
		$url_alias = $this->input->post('url_alias',true);
		$link= $this->input->post('link');	
		$target = $this->input->post('target');
		$include_top = $this->input->post('include_top');
		$include_bottom = $this->input->post('include_bottom');
		$add_parameter = $this->input->post('add_parameter');
	
		$content = $this->input->post('content');
		$content_mobile = $this->input->post('content_mobile',true);
			

		$data = array(
			'language' => $this->language,
			'etc_yn' => $etc_yn,
			'single_yn' => $single_yn,
			'use_yn' => $use_yn,
			'parent_id' => $parent_id,
			'menu_type' => $menu_type,
			'title' => $title,
			'keyword' => $keyword,
			'description' => $description,
			'url_alias' => $url_alias,
			'link' => $link,
			'target' => $target,
			'include_top' => $include_top,
			'include_bottom' => $include_bottom,
			'add_parameter' => $add_parameter,
			'content' => $content,
			'content_mobile' => $content_mobile,	
		);

		switch($dbjob){
			case('d'):
				$count = $this->menu_model->valid_sub_total(array('parent_id'=>$menu_id));
				if($count > 0){
					$this->alert->jalert('하위메뉴가 존재합니다.\n\n먼저 하위메뉴를 삭제해주세요', '/thdadmin/menu');
					exit;
				}
			break;
			case('up'):
				$data['sort_no'] = $sort_no;
			break;
			case('down'):
				$data['sort_no'] = $sort_no;
			break;
		}



		$json = null;
		$settings = null;
		switch($menu_type){
		case('BOARD'):
			$json['cate'] = $this->input->post('cate');
			$json['comment_yn'] = $this->input->post('comment_yn');
			$json['board_type'] = $this->input->post('board_type');
			$json['board_skin'] = $this->input->post('board_skin');
			$json['limit_title'] = $this->input->post('limit_title');
			$json['list_cnt'] = $this->input->post('list_cnt');
			$json['attache_cnt'] = $this->input->post('attache_cnt');
			$json['thumb_w'] = $this->input->post('thumb_w');
			$json['thumb_h'] = $this->input->post('thumb_h');
			$json['secret_yn'] = $this->input->post('secret_yn');
			$json['auth_list'] = $this->input->post('auth_list');
			$json['auth_write'] = $this->input->post('auth_write');
			$json['auth_view'] = $this->input->post('auth_view');
			$json['auth_reply'] = $this->input->post('auth_reply');
			$json['auth_comment'] = $this->input->post('auth_comment');
			$json['cols'] = $this->input->post('cols');
			$json['rows'] = $this->input->post('rows');
			$settings = json_encode($json);
		break;
		case('PLUGIN'):
			$json = $this->plugin_info();
			$settings = json_encode($json);
		break;
		}



		if($settings) $data = array_merge($data,array('settings'=>$settings));	

		
		//데이터 처리
		$this->menu_model->menu_dbjob($data);
		
		if($menu_type == 'HTML'){ //분류가 HTML 파일로 생성
			if($dbjob != 'd' ){
				if(!$menu_id) $menu_id = $this->db->insert_id();
				create_content_history($this->config->item('thd_path_html'),$menu_id.'.html');				
				write_file($this->config->item('thd_path_html').$menu_id.'.html', $content);
				if($content_mobile){
					create_content_history($this->config->item('thd_path_html_mobile'),$menu_id.'.html');
					write_file($this->config->item('thd_path_html_mobile').$menu_id.'.html', $content_mobile);
				}else{
					if(file_exists($this->config->item('thd_path_html_mobile').$menu_id.'.html')){
						@unlink($this->config->item('thd_path_html_mobile').$menu_id.'.html');
					}
				}
			}else{
				
				//Delete PC html
				if(file_exists($this->config->item('thd_path_html').$menu_id.'.html')){
					@unlink($this->config->item('thd_path_html').$menu_id.'.html');
					//Delete PC html history
					delete_content_history($this->config->item('thd_path_html'),$menu_id.'.html');
				}
				
				//Delete Mobile html
				if(file_exists($this->config->item('thd_path_html_mobile').$menu_id.'.html')){
					@unlink($this->config->item('thd_path_html_mobile').$menu_id.'.html');
					//Delete Mobile html history
					delete_content_history($this->config->item('thd_path_html_mobile'),$menu_id.'.html');
				}
			}
		}
		
		//메뉴 xml 생성
		$this->menu_model->menu_create_xml(array('language' => $this->language));

		$msg = '';
		$this->alert->jalert($msg, '/thdadmin/menu?language='.$this->language);
		exit;
	}

	function ajax_history(){
		$history_file = $this->input->get('history_file');
		$contents = read_file($this->config->item('thd_path_html').'/history/'.$history_file);
		$data = array('contents'=> $contents);
		$this->load->view('thdadmin/pages/ajax_history',$data);
	 }

	public function menu_board(){
		$page = ($this->input->get('page',true)) ? $this->input->get('page',true) : 1;
		$arr = array('page'=>$page,'listnum'=>10,'language' => $this->language);
		
		$query = $this->menu_model->menu_board($arr);
		$count = $this->menu_model->menu_count(array('menu_type'=>'BOARD','language'=>$this->language));

		$this->load->library('pagination');
		//$config['base_url'] = '/thdadmin/menu_board';
		
		$config['listnum'] = 10;
		$config['total_rows'] = $count;
		$config['block'] = 10;
		$config['page'] = $page;
		$this->pagination->initialize($config);
		
		$data = array(
			'_title' => '게시판관리',
			'_content' => 'thdadmin/pages/menu_board',
			'_language' => $this->language,
			'_query' => $query,
			'_paging'=> $this->pagination->create_links_admin(),
		);

		$this->common_v->admin_view($data);
	}

	public function enquiry_list(){
		$page = ($this->input->get("page",true)) ? $this->input->get("page",true) : 1;
		$p_cate = ($this->input->get("p_cate",true)) ? $this->input->get("p_cate",true) : '01';
		$query = $this->enquiry_model->enquiry_list(array('p_cate'=>$p_cate));
		$count = $this->enquiry_model->list_total(array('p_cate'=>$p_cate));
		$listnum = 10;
		$total_page = ceil($count / $listnum);
		$list_no = $count - $listnum * ($page-1);
		
		$this->load->library('pagination');		
		$config['listnum'] = 10;
		$config['total_rows'] = $count;
		$config['block'] = 10;
		$config['page'] = $page;
		$this->pagination->initialize($config);
		
		//문의별 페이지분기
		$this->view_page = $this->view_page.$p_cate;
		$title = ($p_cate == '01') ? '가격문의' : '기술문의';

		$data = array(
			'_title' => $title,
			'_content' => 'thdadmin/pages/'.$this->view_page,
			'_language' => $this->language,
			'_query' => $query,
			'_list_no' => $list_no,
			'_page' => $page,
			'_paging'=> $this->pagination->create_links_admin(),

		);
		$this->common_v->admin_view($data);
	}

	public function enquiry_view(){
		$seq = $this->input->get('seq',true);
		$page = $this->input->get('page',true);
		
		$arr = $this->enquiry_model->enquiry_select(array('seq' => $seq));
		$title = ($arr['p_cate'] == '01') ? '가격문의' : '기술문의';
		//문의별 페이지분기
		$this->view_page = $this->view_page.$arr['p_cate'];
		
		$data = array(
			'_title' => $title,
			'_content' => 'thdadmin/pages/'.$this->view_page,
			'_language' => $this->language,
			'_page' => $page,
		);
		

		
		
		
		$data = array_merge($data,$arr);
		$this->common_v->admin_view($data);
	}

	public function enquiry_dbjob(){
		$seq = $this->input->post('seq',true);
		$p_cate = $this->input->post('p_cate',true);
		$reply = $this->input->post('reply',true);
		$proc_step = $this->input->post('proc_step',true);
		$page = $this->input->post('page',true);
		$dbjob = $this->input->post('dbjob',true);
		$data = null;
		switch($dbjob){
			case('u'):
				$msg = ' 수정 되었습니다.';
				$data = array('proc_step' => $proc_step);
			break;
			case('r'):
				$msg = '답변이 등록되었습니다.';
				$data = array('proc_step' => 2,'reply' => $reply);
				$this->db->where(array('seq' => $seq));
				$query = $this->db->get('thd_enquiry');
				if($query->num_rows() > 0){
					$row = $query->row_array();
					$phone = $row['phone'];
					/*SMS 전송 begin*/
					$tel = explode('-',$this->config->item('tel'));
					
					$sms = array(
						'msg' => $reply,
						'smsType' => null,
						'subject' => null,
						'rphone' => $phone,
						'sphone1' => $tel[0],
						'sphone2' => $tel[1],
						'sphone3' => $tel[2],
						'rdate' => null,
						'rtime' => null,
						'returnurl' => null,
						'testflag' => null,
						'destination' => null,
						'repeatFlag' => null,
						'repeatNum' => null,
						'repeatTime' => null,
						'destination' => null,
						'nointeractive' => null,
					);
					$rst = sms_send($sms);
					/*SMS 전송 end*/
				}
			break;
			case('d'):
				$msg = '삭제 되었습니다.';
				$data = null;
			break;
		
		}
		
		$this->enquiry_model->enquiry_dbjob($data);
		jalert($msg, base_url('/thdadmin/enquiry_list?language='.$this->language.'&p_cate='.$p_cate));	
	}


	public function popup_list(){
		$page = ($this->input->get("page",true)) ? $this->input->get("page",true) : 1;
		$where = array('language' => "'{$this->language}'");
		$query = $this->popup_model->popup_list($where);
		$count = $this->popup_model->list_total($where);
		$listnum = 10;
		$total_page = ceil($count / $listnum);
		$list_no = $count - $listnum * ($page-1);
		
		$this->load->library('pagination');		
		$config['listnum'] = 10;
		$config['total_rows'] = $count;
		$config['block'] = 10;
		$config['page'] = $page;
		$this->pagination->initialize($config);

		$data = array(
			'_title' => '팝업관리',
			'_content' => 'thdadmin/pages/'.$this->view_page,
			'_language' => $this->language,
			'_query' => $query,
			'_list_no' => $list_no,
			'_page' => $page,
			'_paging'=> $this->pagination->create_links_admin(),

		);
		$this->common_v->admin_view($data);
	}

	public function popup_form(){
		$id = $this->input->get("id",true);
		$page = $this->input->get("page",true);
		$arr = ($id) ? array('id'=>$id) : null;
		$_dbjob =($arr == null) ? 'i' : 'u';

		$data = array(
			'_title' => '팝업관리',
			'_content' => 'thdadmin/pages/'.$this->view_page,
			'_language' => $this->language,
			'_dbjob' => $_dbjob,
			'_page' => $page,
		);
		
		$data = array_merge($data,$this->popup_model->popup_select($arr));
		$this->common_v->admin_view($data);
	}

	public function popup_dbjob(){
		$data = null;
		$msg = '';
		$dbjob = $this->input->post('dbjob',true);
		$title = $this->input->post('title',true);
		$start_date = $this->input->post('start_date',true);
		$end_date = $this->input->post('end_date',true);
		$layer_yn = $this->input->post('layer_yn',true);
		if(!$layer_yn) $layer_yn = 'N';
		$use_yn = $this->input->post('use_yn',true);
		$popup_style = $this->input->post('popup_style',true);
		$popup_template = $this->input->post('popup_template',true);
		$content = $this->input->post('content',true);
		$popup_top = $this->input->post('popup_top',true);
		$popup_left = $this->input->post('popup_left',true);
		$popup_height = $this->input->post('popup_height',true);
		$popup_width = $this->input->post('popup_width',true);
		
		switch($dbjob){
		case('i'):
			$msg = '저장되었습니다.';
			$data = array(
					'title' => $title ,
					'start_date' => $start_date ,
					'end_date' => $end_date ,
					'layer_yn' => $layer_yn ,
					'use_yn' => $use_yn ,
					'popup_style' => $popup_style ,
					'popup_template' => $popup_template ,
					'popup_content' => $content ,
					'popup_top' => $popup_top ,
					'popup_left' => $popup_left ,
					'popup_height' => $popup_height ,
					'popup_width' => $popup_width ,
					'reg_date' => date("Y-m-d H:i",time())
			);
		break;
		case('u'):
			$msg = '수정되었습니다.';
			$data = array(
					'title' => $title ,
					'start_date' => $start_date ,
					'end_date' => $end_date ,
					'layer_yn' => $layer_yn ,
					'use_yn' => $use_yn ,
					'popup_style' => $popup_style ,
					'popup_template' => $popup_template ,
					'popup_content' => $content ,
					'popup_top' => $popup_top ,
					'popup_left' => $popup_left ,
					'popup_height' => $popup_height ,
					'popup_width' => $popup_width 
			);
		break;
		case('d'):
			$msg = '삭제 되었습니다.';
		break;
		}
		
		$this->popup_model->popup_dbjob($data);
		jalert($msg, base_url('/thdadmin/popup_list?language='.$this->language));

	}

	public function member_group(){
		$query = $this->member_model->list_group_member(); //회원 그룹
		$data = array(
			'_title' => '회원그룹관리',
			'_content' => 'thdadmin/pages/member_group',
			'_language' => $this->language,
			'_query' => $query,
		);
		$this->common_v->admin_view($data);
	}

	public function member_group_dbjob(){
		$dbjob = $this->input->post('dbjob',true);
		$group_id = $this->input->post('group_id',true);
		$form_group_id = $this->input->post('form_group_id',true);
		$title = $this->input->post('title',true);

		switch($dbjob){
			case('i'):
				$msg = '저장되었습니다.';
				$data = array(
						'group_id' => $group_id,
						'title' => $title
				);
			break;
			case('u'):
				$msg = '수정되었습니다.';
				$data = array(
						'group_id' => $group_id,
						'title' => $title
				);
				break;
			case('d'):
				$msg = '삭제 되었습니다.';
				$data = null;
				break;
		
		}
		
		$this->member_model->group_dbjob($data);
		jalert($msg, base_url('/thdadmin/member_group?language='.$this->language));	
	}

	public function download(){
		$name = $this->input->get('name');
		$file_info = $this->input->get('file_info');
		$data = file_get_contents($file_info); 
		$this->load->helper('download');
		force_download($name, $data); 
	}


	public function board_list(){
	
		$page = ($this->input->get('page')) ? $this->input->get('page') : 1;
		$menu_id = $this->input->get('menu_id');	
		$board_info = $this->menu_model->menu_select(array('menu_id'=>$menu_id));
		$listnum = ($board_info['list_cnt']) ? $board_info['list_cnt'] : 10 ;
		$board_name = 'thd_board';
		$param = array('menu_id'=>$menu_id,'page'=>$page,'language' => $this->language);
		/*$param['sch_keyname'] = urldecode($this->security->xss_clean(url_explode($uri_array, 'sch_keyname')));
		$param['sch_keyword'] = urldecode($this->security->xss_clean(url_explode($uri_array, 'sch_keyword')));
		$sch_url_pattern = search_param_url($param);	
		$param = array_merge($param,array('page'=>$page,'id'=>$id,'board_name'=>$board_name));*/
		$param = array_merge($param,array('config'=>array('list_cnt'=>$listnum)));

		$count = $this->board_model->list_total($param);
		$query = $this->board_model->board_list($param);
		$total_page = ($count > 0) ? ceil($count / $listnum) : 1;
		$list_no = $count - $listnum * ($page-1);

		$this->load->library('pagination');
		$querystring = '&menu_id='.$menu_id.'&language='.$this->language;
		
		$config['listnum'] = $listnum;
		$config['total_rows'] = $count;
		$config['block'] = 10;
		$config['page'] = $page;
		$config['querystring'] = $querystring;
		

		$this->pagination->initialize($config);
		$data = array(
			'_title' => $board_info['title'],
			'_content' => 'thdadmin/pages/'.$this->view_page,
			'_language' => $this->language,
			'_list_no'=> $list_no,
			'_query' => $query,
			'_page' => $page,
			'_paging'=> $this->pagination->create_links_admin(),
		);
		$data = array_merge($data,$board_info);
		$this->common_v->admin_view($data);
	}

	/**
	 * 게시물 등록/수정/삭제
	 *
	 * @access	public
	 * @return	void
	 */
	public function board_form()
	{
		$page = ($this->input->get('page')) ? $this->input->get('page') : 1;
		$menu_id = $this->input->get('menu_id');
		$id = $this->input->get('id');
		
		$dbjob = ($this->input->post('dbjob')) ? $this->input->post('dbjob') : 'i';
		$board_info = $this->menu_model->menu_select(array('menu_id'=>$menu_id));

		$data = array(
			'_title' =>  $board_info['title'],
			'_content' => 'thdadmin/pages/board_form',
			'_language' => $this->language,
			'_settings' => $board_info,
			'page' => $page,
			'dbjob' => $dbjob,
			
		);
		
		$attach_delete = null;
		//$query = $this->board_model->board_view(array('id'=> $id));
		
		//$data = array_merge($data,$this->board_model->board_select(array('id'=> $id)));
		$arr = ($id) ? array('id'=>$id) : null;
		$data = array_merge($data,$this->board_model->board_select($arr));
		if($dbjob == 'u'){
			
			$query = $this->board_model->board_file_list(array('menu_id'=>$menu_id,'board_no'=>$id));
			$view_file = null;
			$_fnum = 0;
			foreach ($query->result() as $row){
				$attach_delete .= '<span><input type="checkbox" name="fdelete[]" value="'.$_fnum.'" /> '.$row->file_orinal.'</span>';
				$_fnum++;
			}
			$query->free_result(); //free result
			
		}

		$data['attach_delete'] = $attach_delete;
		$data['menu_id'] = $menu_id;
		$this->common_v->admin_view($data);
	}

	/**
	 * 게시물 상세
	 *
	 * @access	public
	 * @return	void
	 */
	public function board_view()
	{
		$page = ($this->input->get('page')) ? $this->input->get('page') : 1;
		$menu_id = $this->input->get('menu_id');
		$id = $this->input->get('id');

		$board_name = 'thd_board';
		$board_info = $this->menu_model->menu_select(array('menu_id'=>$menu_id));
		
		$data = array(
			'_title' =>  $board_info['title'],
			'_content' => 'thdadmin/pages/board_view',
			'_language' => $this->language,
		);

		$data['board_name']  = $board_name;
		$data['page']  = $page;
		$data['menu_id']  = $menu_id;

		$query = $this->board_model->board_view(array('id'=> $id,'board_name'=>$board_name));
		if($query->num_rows() > 0){
			$row = $query->row_array();	
			$data['id']  = $row['id'];
			$data['title'] = $row['title'];
			$data['writer'] = $row['writer'];
			$data['content'] = $row['content'];
			$data['register_date'] = $row['register_date'];

			$query = $this->board_model->board_file_list(array('menu_id'=>$menu_id,'board_no'=>$id));
			$view_file = null;
			$_fnum = 0;
			
			$attach = null;
			foreach ($query->result() as $row){
				$download_link = '/board/download/id/'.$row->menu_id.'/no/'.$row->board_no.'/order/'.$row->order_no;
				$attach .='<li>- 첨부파일 : <a href="'.$download_link.'"><i class="fa fa-file "></i> '.$row->file_orinal.'</a></li>';
			}
			$data['attach'] = $attach;
			$query->free_result(); //free result
		}

		$this->common_v->admin_view($data);
	}

	/**
	 * 게시물 db처리
	 *
	 * @access	public
	 * @return	void
	 */
	public function board_dbjob(){
		$menu_id = $this->input->post('menu_id',true);
		$title = $this->input->post('title',true);
		$notice = $this->input->post('notice',true);
		if(!$notice) $notice = 'N';
		$main_yn = $this->input->post('main_yn',true);
		if(!$main_yn) $main_yn = 'n';
		$cate = $this->input->post('cate',true);
		$writer = $this->input->post('writer',true);
		$content = $this->input->post('content');
		$passwd = $this->input->post('passwd');
		
		$dbjob = ($this->input->post('dbjob')) ? $this->input->post('dbjob',true) : 'i';
	
		switch($dbjob){
			case('i'):
				$msg = '저장되었습니다.';
				$data = array(
						'menu_id' => $menu_id ,
						'language' => $this->language ,
						'cate' => $cate ,
						'title' => $title ,
						'notice' => $notice ,
						'main_yn' => $main_yn ,
						'writer' => $writer ,
						'content' => $content ,
						'passwd' => $passwd ,
						'auth_uid' => $this->session->userdata('userid'),
						'depth' => 0,
						'ansnum'=> 0,
						'view_count'=> 0,
						'register_date'=>  date("Y-m-d H:i",time())
				);
				break;
			case('r'):
				$msg = '저장되었습니다.';
				$data = array(
						'menu_id' => $menu_id ,
						'language' => $this->language ,
						'cate' => $cate ,
						'main_yn' => $main_yn ,
						'title' => $title ,
						'writer' => $writer ,
						'content' => $content ,
						'passwd' => $passwd ,
						'auth_uid' => $this->session->userdata('userid'),
						'view_count'=> 0,
						'register_date'=>  date("Y-m-d H:i",time())
				);
				break;
			case('u'):
				$msg = '수정되었습니다.';
				$data = array(
						'cate' => $cate ,
						'title' => $title ,
						'notice' => $notice ,
						'main_yn' => $main_yn ,
						'writer' => $writer ,
						'content' => $content
	
				);
				break;
			case('d'):
				$msg = '삭제 되었습니다.';
				$data = null;
				break;
		}

		
		$settings = $this->menu_model->menu_select(array('menu_id'=>$menu_id));
		if(isset($_FILES['files'])){
			/*file upload begin*/
			$upload_path = FCPATH.'upload/board/'.$menu_id;
			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = 'jpg|gif|png|zip|rar|doc|hwp|pdf|ppt|xls|pptx|docx|xlsx';
			$config['max_size']	= '10240'; //10MB
			$config['encrypt_name'] = true;
			$config['remove_spaces'] = true;
			$this->load->library('upload',$config);
			$this->upload->mkdir($upload_path);
		}
	
		if($this->board_model->board_dbjob($data)){
			if(isset($_FILES['files'])){
				$file = $this->upload->do_multi_upload('files');
				
				if($settings['thumb_w'] && $settings['thumb_h']){ //썸네일
					isset($config);
					$config['image_library'] = 'gd2';
					$config['source_image'] = $file[0]['full_path'];
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['width'] = $settings['thumb_w'];
					$config['height'] = $settings['thumb_h'];
					$this->load->library('image_lib', $config); 
					$this->image_lib->resize();
				}	

				if($this->upload->display_errors()){
					$msg = $this->upload->display_errors('','');
				}else{
					$this->board_model->board_file($file);
				}
			}
			jalert($msg, base_url('/thdadmin/board_list?menu_id='.$menu_id.'&language='.$this->language));
		}else{
			jalert('에러', '','back');
		}
		exit;
	}

	function product_file_proc(){
		$thumb_size = $this->input->post('file_thumb_size'); 
		$fidx = $this->input->post('file_num',true); 
		$upload_path = FCPATH.'upload/'.$this->input->post('file_path',true);
		if(isset($_FILES['files']) && !$this->input->post("file_info")){
			$config['upload_path'] = $upload_path;
			//$config['allowed_types'] = 'jpg|gif|png|zip|rar|doc|hwp|pdf|ppt|xls|pptx|docx|xlsx|eot|woff|tff';
			$config['allowed_types'] = '*';
			$config['max_size']	= '20240'; //20MB
			$config['encrypt_name'] = true;
			$config['remove_spaces'] = true;
			$this->load->library('upload',$config);
			$this->upload->mkdir($upload_path);
			$file = $this->upload->do_multi_upload('files');
			
			if($thumb_size){
				isset($config);
				$_t = explode(',',$thumb_size);
				$config['image_library'] = 'gd2';
				$config['source_image'] = $file[0]['full_path'];
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = $_t[0];
				$config['height'] = $_t[1];
				$this->load->library('image_lib', $config); 
				$this->image_lib->resize();
			}	
			
			$fv = $file[0]['file_name'].'|'.$file[0]['orig_name'].'|'.$file[0]['full_path'];
			echo '<script>parent.attachefile.fileAdd('.$fidx.',\''.$fv.'\')</script>';
		}else if($this->input->post("file_info")){ //삭제
			$arr = explode('|',$this->input->post("file_info"));
			if(file_exists($arr[2])) unlink($arr[2]);
			
			if($thumb_size){ //썸네일삭제
				$_t = explode('.',$arr[0]);
				$thumb_path = $upload_path.'/'.$_t[0].'_thumb.'.$_t[1];
				if(file_exists($thumb_path)) unlink($thumb_path);
			}
			
			echo '<script>parent.attachefile.fildDeleteDone('.$fidx.')</script>';
		}else{
			echo '<script>alert("첨부된 파일이 없습니다.")</script>';
		}
		exit;	
	}
	
	
	/**
	 * 제품관리 > 카테고리 목록
	 *
	 * @access	public
	 * @return	void
	 */
	public function category(){
		
		$query = $this->product_model->category_list();
		$info = array();
		foreach($query->result() as $row){
			$info[$row->sort_no] = array('id'=>$row->id,'parent_id' => $row->parent_id,'category' => $row->category,'category_name' => $row->category_name,'use_yn' => $row->use_yn,'sort_no' => $row->sort_no,'is_child' => $row->is_child);
		}
		
		$now_cate = $this->input->get('now_cate');

		$data = array(
			'_title' => '카테고리관리',
			'_content' => 'thdadmin/pages/category',
			'_language' => $this->language,
			'_category' => $info,
			'_now_cate' => $now_cate,
		);
		
		//카테고리 수정
		if($this->input->post('category',true)){
			$data = array_merge($data,$this->product_model->category_select(array('category' => $this->input->post('category',true))));
			$data['_dbjob'] = 'u';
		}else{
			$data = array_merge($data,$this->product_model->category_select());
			$data['_dbjob'] = 'i';
		}

		$this->common_v->admin_view($data);
	}

	/**
	 * 제품관리 > ajax 카테고리 목록
	 *
	 * @access	public
	 * @return	void
	 */
	public function ajax_category_list(){
		
		$query = $this->product_model->category_list();
		$info = array();
		foreach($query->result() as $row){
			$info[$row->sort_no] = array('id'=>$row->id,'parent_id' => $row->parent_id,'category' => $row->category,'category_name' => $row->category_name,'use_yn' => $row->use_yn,'sort_no' => $row->sort_no,'is_child' => $row->is_child);
		}

		$now_cate = $this->input->get('now_cate');
		$data = array(
			'_title' => '카테고리관리',
			'_content' => 'thdadmin/pages/category',
			'_language' => $this->language,
			'_category' => $info,
			'_now_cate' => $now_cate,
		);
		
		//카테고리 수정
		if($this->input->post('category',true)){
			$data = array_merge($data,$this->product_model->category_select(array('category' => $this->input->post('category',true))));
			$data['_dbjob'] = 'u';
		}else{
			$data = array_merge($data,$this->product_model->category_select());
			$data['_dbjob'] = 'i';
		}

		$this->load->view('thdadmin/pages/ajax_category_list',$data);
		//$this->common_v->admin_view($data);
	}


	
	
	/**
	 * 제품관리 > 카테고리 DB처리
	 *
	 * @access	public
	 * @return	void
	 */
	function category_dbjob(){
		$dbjob = $this->input->post('dbjob',true);
		$sort_no = $this->input->post('sort_no',true);
		$id = $this->input->post('id',true);
		$parent_id = $this->input->post('parent_id',true);
		$category = $this->input->post('category',true);
		$parent_cate = $category;
		$category_name = $this->input->post('category_name',true);
		$use_yn = $this->input->post('use_yn',true);
		if(!$use_yn) $use_yn = 'N';

		if($dbjob == 'd'){
			$count = $this->product_model->valid_sub_total(array('LEFT(category,LENGTH(\''.$category.'\'))'=>$category,'LENGTH(category) > ' => strlen($category)));
			if($count > 0){
				$this->alert->jalert('하위카테고리가 존재합니다.\n\n먼저 하위카테고리를 삭제해주세요', '/thdadmin/category?language='.$this->language);
				exit;
			}
		}

		switch($dbjob){
			case('i'):
				$category = $this->product_model->category_create();
				
				$msg = '저장되었습니다.';
				$data = array(
						'parent_id' => 0 ,
						'category' => $category ,
						'category_name' => $category_name ,
						'use_yn' => $use_yn ,
				);
				break;
			case('r'):
				$category = $this->product_model->category_create($category);
				$msg = '저장되었습니다.';
				$data = array(
						'parent_id' => $parent_id ,
						'category' => $category ,
						'category_name' => $category_name ,
						'use_yn' => $use_yn ,
				);
				break;
			case('u'):
				$msg = '수정되었습니다.';
				$data = array(
						'category_name' => $category_name ,
						'use_yn' => $use_yn ,
				);
				break;
			case('up'):
				$msg = '수정되었습니다.';
				$data = array(
						'sort_no' => $sort_no ,
				);
				break;
			case('down'):
				$msg = '수정되었습니다.';
				$data = array(
						'sort_no' => $sort_no ,
				);
				break;
			case('d'):
				$msg = '삭제 되었습니다.';
				$data = null;
				break;
		}
		
		$this->product_model->category_dbjob($data);
		echo '{"msg" : "'.$msg.'","now_cate" : "'.$parent_cate.'","parent_id" : "'.$parent_id.'" }';
		exit;
		//jalert($msg, base_url('/thdadmin/category?language='.$this->language."&now_cate=".$category));			
	}

	function ajax_category(){
		$category = $this->input->get('category',true);
		//$len = strlen($category) / 2;
		$len = strlen($category);
		$w = array();
		for($i=0; $i <= $len; $i+=2){
			$w[] = substr($category,0,$i+2);	
		}
		
		
		$query = $this->product_model->category_child(implode("','",$w));
		$contents = '';
		$nav = array();
		foreach($query->result() as $row){
			$nav[] = $row->category_name;
		}
		
		$contents = implode(' &gt; ',$nav).' &gt; ';
		$data = array('contents'=> $contents);
		$this->load->view('thdadmin/pages/ajax_category',$data);
	 }

	 function ajax_code_group(){
		$query = $this->code_model->code_group_list();
		$data = array('_query'=> $query);
		$this->load->view('thdadmin/pages/ajax_code_group',$data);
	 }

	 function ajax_code_group_info(){
		 $master_id = $this->input->get('master_id',true);
		 $data = $this->code_model->code_group_select(array('del_yn !=' => '\'y\'','master_id'=>$master_id ));
		 $json = array('json' => json_encode($data));
		 $this->load->view('thdadmin/pages/ajax_code_group_info',$json);
	 }

	function ajax_code_list(){
		$master_id = $this->input->get('master_id',true); 
		$arr = array('del_yn !=' => '\'y\'' , 'master_id' => $master_id);	
		$query = $this->code_model->code_list($arr);
		$data = array('_query'=> $query);
		$this->load->view('thdadmin/pages/ajax_code_list',$data);
	}

	function ajax_code_info(){
		 $code_id = $this->input->get('code',true);
		 $data = $this->code_model->code_select(array('del_yn !=' => '\'y\'','code_id'=>$code_id ));
		 $json = array('json' => json_encode($data));
		 $this->load->view('thdadmin/pages/ajax_code_info',$json);
	 }
	 
	 function code_dbjob(){
		$codeType = $this->input->post('codeType',true);
		$dbjob = $this->input->post('dbjob',true);
		$master_id = $this->input->post('master_id',true);
		$title = $this->input->post('title',true);
		$open_yn = $this->input->post('open_yn',true);
		$etc1 = $this->input->post('etc1',true);
		$etc2 = $this->input->post('etc2',true);
		$etc3 = $this->input->post('etc3',true);
		
		if($codeType == 'GROUP'){
			switch($dbjob){
			case('i') :
				$msg = '저장되었습니다.';
				$data = array(
						'title' => $title ,
						'open_yn' => $open_yn ,
						'etc1' => $etc1 ,
						'etc2' => $etc2 ,
						'etc3' => $etc3 ,
						'del_YN' => 'n' ,
				);
				break;
			break;
			case('u') :
				$msg = '수정되었습니다.';
				$data = array(
						'title' => $title ,
						'open_yn' => $open_yn ,
						'etc1' => $etc1 ,
						'etc2' => $etc2 ,
						'etc3' => $etc3 ,
				);
				break;	
			break;
			case('d') :
				$msg = '삭제되었습니다.';
				$data = array(
						'del_yn' => 'y' ,
				);
				break;	
			break;
			}
		}else{
			switch($dbjob){
			case('i') :
				$msg = '저장되었습니다.';
				$data = array(
						'master_id' => $master_id ,
						'title' => $title ,
						'open_yn' => $open_yn ,
						'etc1' => $etc1 ,
						'etc2' => $etc2 ,
						'etc3' => $etc3 ,
						'del_YN' => 'n' ,
				);
				break;
			break;
			case('u') :
				$msg = '수정되었습니다.';
				$data = array(
						'title' => $title ,
						'open_yn' => $open_yn ,
						'etc1' => $etc1 ,
						'etc2' => $etc2 ,
						'etc3' => $etc3 ,
				);
				break;	
			break;
			case('d') :
				$msg = '삭제되었습니다.';
				$data = array(
						'del_yn' => 'y' ,
				);
			break;
			}
		}


		if($this->code_model->code_dbjob($data) == 1){
			//$this->alert->jalert($msg, '/thdadmin/code','parent');
			echo '<script type="text/javascript">'.chr(10);
			echo 'parent.setDbResult("'.$codeType.'","'.$dbjob.'");'.chr(10);
			echo '</script>'.chr(10);

				
		}else{
			$this->alert->jalert('에러가 발생하였습니다.', '/thdadmin/code','parent');
		}
		exit;
	 }

	public function member_list(){
		$membership = $this->input->get("membership",true);
		if(!$membership) $membership = 10;
		//$arr = array('membership '=>$membership,'user_id !=' => "'admin'");
		$arr = array('membership '=>$membership);
		$keyname = $this->input->get("keyname",true);
		$keyword = $this->input->get("keyword",true);
		if($keyname && $keyword){
			 $arr[$keyname.' LIKE'] = " '%".$keyword."%'";
		}

		$begin_date = $this->input->get("begin_date",true);
		$end_date = $this->input->get("end_date",true);
		if($begin_date && $end_date){
			$arr[' DATE_FORMAT(reg_date,\'%Y-%m-%d\') BETWEEN '] = "'{$begin_date}' AND '{$end_date}' ";
		}
		$p[] = 'keyname='.$keyname;
		$p[] = 'keyword='.urlencode($keyword);
		$param = implode('&',$p);

		$page = ($this->input->get("page",true)) ? $this->input->get("page",true) : 1;
		$query = $this->member_model->member_list($arr);
		
		$count = $this->member_model->list_total($arr,'thd_member');
		$listnum = 10;
		$total_page = ceil($count / $listnum);
		$list_no = $count - $listnum * ($page-1);
		
		$this->load->library('pagination');		
		$config['listnum'] = 10;
		$config['total_rows'] = $count;
		$config['block'] = 10;
		$config['page'] = $page;
		$config['querystring'] = "&language=".$this->language.'&membership='.$membership;
		
		$this->pagination->initialize($config);
		
		$mgp = $this->member_model->select_group_member($membership);

		$data = array(
			'_title' => $mgp['title'],
			'_content' => 'thdadmin/pages/member_list',
			'_language' => $this->language,
			'_list_no' => $list_no,
			'_query' => $query,
			'_page' => $page,
			'_paging'=> $this->pagination->create_links_admin(),
			'_membership' => $membership,
			'_param' => $param,
		);
		$this->common_v->admin_view($data);
	}

	public function member_form(){

		$seq = $this->input->get("seq",true);
		$page = $this->input->get("page",true);
		$arr = $this->member_model->select_member($seq);		
		$_dbjob =($arr['seq'] == null) ? 'i' : 'u';
		$query = $this->member_model->member_all(array('membership' => '2','open_yn' => '\'y\''));
		$agency = $this->member_model->member_all(array('membership' => '1','open_yn' => '\'y\''));
		$customer = $this->member_model->customer_all(array('member_seq' => $seq));
		
		$membership = ($arr['membership']) ? $arr['membership'] : $this->input->get("membership",true);

		$data = array(
			'_title' => '회원관리',
			'_content' => 'thdadmin/pages/member_form',
			'_language' => $this->language,
			'_dbjob' => $_dbjob,
			'_query' => $query,
			'_membership' => $membership,
			'_agency' => $agency,
			'_customer' => $customer,
		);
		$data = array_merge($data,$arr);
		$this->common_v->admin_view($data);
	}

	public function member_dbjob(){
		$membership = $this->input->post('membership',true);
		$customer = $this->input->post('customer',true);
		$dbjob = $this->input->post('dbjob',true);
		$user_id = $this->input->post('user_id',true);
		$email = $this->input->post('email',true);
		$hp = $this->input->post('hp',true);
		$name = $this->input->post('name',true);		
		$passwd = $this->input->post('passwd',true);
		$chkpasswd = $this->input->post('chkpasswd',true);
		$passwd_yn = $this->input->post('passwd_yn',true); //패스워드 변경여부
		$biz_no = $this->input->post('biz_no',true);
		$corp_post = $this->input->post('corp_post',true);
		$corp_addr1 = $this->input->post('corp_addr1',true);
		$corp_addr2 = $this->input->post('corp_addr2',true);
		$corp_tel = $this->input->post('corp_tel',true);
		$corp_fax = $this->input->post('corp_fax',true);
		$corp_division = $this->input->post('corp_division',true);
		$corp_name = $this->input->post('corp_name',true);
		$salesman = $this->input->post('salesman',true);
		$open_yn = $this->input->post('open_yn',true);
				
		$email= (is_array($email)) ? implode('@',$email) : null;
		$hp= (is_array($hp)) ? implode('-',$hp) : null;
		$biz_no= (is_array($biz_no)) ? implode('-',$biz_no) : null;
		$corp_tel= (is_array($corp_tel)) ? implode('-',$corp_tel) : null;
		$corp_fax= (is_array($corp_fax)) ? implode('-',$corp_fax) : null;
			
		$return_url = $this->input->post('return_url',true);
		
		$this->form_validation->set_error_delimiters('<div style="color:red">', '</div>');
		
		if($dbjob == 'i'){
			$this->form_validation->set_rules('membership', '＊회원분류', 'required');
			$this->form_validation->set_rules('user_id', '＊아이디', 'required|is_unique[thd_member.user_id]');
		}
		
		if($passwd_yn == 'y' || $dbjob == 'i'){
			$this->form_validation->set_rules('passwd', '＊비밀번호', 'required');
			$this->form_validation->set_rules('chkpasswd', '＊비밀번호 확인', 'required|matches[passwd]');
		}
		
		$this->form_validation->set_rules('name', '＊이름', 'required');
		
		if ($this->form_validation->run() == FALSE){
			return $this->member_form();
		}
	
		$data = null;
		switch($dbjob){
			case('i'):				
				$data = array(
					'membership' => $membership,
					'open_yn' => $open_yn,
					'user_id' => $user_id,
					'name' => $name,
					'passwd' => md5($passwd),
					'email' => $email,
					'hp' => $hp,
					'biz_no' => $biz_no,
					'corp_post' => $corp_post,
					'corp_addr1' => $corp_addr1,
					'corp_addr2' => $corp_addr2,
					'corp_tel' => $corp_tel,
					'corp_fax' => $corp_fax,
					'corp_division' => $corp_division,
					'corp_name' => $corp_name,
					'salesman' => $salesman,
					'reg_date' => date("Y-m-d H:i",time()),
				);
				
				$msg = '저장되었습니다.';
				
			break;
			case('u'):
				$msg = '수정되었습니다.';
				$data = array(
					'open_yn' => $open_yn,	
					'name' => $name,
					'email' => $email,
					'hp' => $hp,
					'biz_no' => $biz_no,
					'corp_post' => $corp_post,
					'corp_addr1' => $corp_addr1,
					'corp_addr2' => $corp_addr2,
					'corp_tel' => $corp_tel,
					'corp_fax' => $corp_fax,
					'corp_division' => $corp_division,
					'corp_name' => $corp_name,
					'salesman' => $salesman,
					'mod_date' => date("Y-m-d H:i",time()),
				);
				
				if($passwd && $passwd_yn == 'y'){
					$data = array_merge($data,array('passwd' => md5($passwd)));
				}

			break;
			case('md'):
				$msg = '삭제 되었습니다.';
				$data = null;
			break;
			case('d'):
				$msg = '삭제 되었습니다.';
				$data = null;
			break;
		}
		$seq = $this->member_model->member_dbjob($data);
		
		if($customer){
			$this->member_model->customer_dbjob(array('dbjob' => $dbjob,'seq' => $seq, 'customer'=>$customer));
		}

		jalert($msg, base_url('/thdadmin/member_list?language='.$this->language.'&membership='.$membership));	
	}

	function ajax_agency(){
		$agency = $this->input->post('agency');
		$data = array('membership' => '1','open_yn' => '\'y\'');
		if($agency){
			$data = array_merge($data,array('name LIKE' => ' \'%'.$agency.'%\''));
		}
		$query = $this->member_model->member_all($data);
		
		$_agency = array();
		$rst = null;
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$ar = '['.$row->seq.',"'.$row->name.'"]';
				$rst .= ($rst)  ? ','.$ar : $ar;
			
			}
		}
		echo '{"rst" : ['.$rst.']}';
		exit;
	}

	

	

	function ajax_user_id(){
		$user_id = $this->input->post("user_id",true);
		$count = $this->member_model->valid_userid_total(array('user_id' => $user_id));
		if($count > 0){
			$msg = '중복된 아이디 입니다.';
			$rst = '1';
		}else{
			$msg = '사용가능한 아이디 입니다.';
			$rst = '0';
		}
		echo '{"msg" : "'.$msg.'","rst" : "'.$rst.'"}';
		exit;
	}



	

	public function board_auth(){
		$data = array(
			'_title' => '자료실 비밀번호관리',
			'_content' => 'thdadmin/pages/board_auth',
			'_language' => $this->language,
			
		);
		
		$data = array_merge($data,$this->board_model->board_auth());
		$this->common_v->admin_view($data);
	}

	public function board_auth_dbjob(){
		$menu_id = $this->input->post('menu_id',true);		
		$dbjob = $this->input->post('dbjob',true);
		$passwd = $this->input->post('passwd',true);
		$data = array('menu_id'=>$menu_id,'passwd'=>$passwd);	
		$this->board_model->board_auth_dbjob($data);
		
		$msg = ($menu_id) ? '정상적으로 수정되었습니다.' : '정상적으로 등록되었습니다.';
	
		jalert($msg, base_url('/thdadmin/board_auth?language='.$this->language));
	}

	public function code()
	{
		$data = array(
			'_title' => '코드관리',
			'_content' => 'thdadmin/pages/code',
			'_language' => $this->language,
			
		);
		$this->common_v->admin_view($data);
	}
	
	/*
	name :  배너관리
	*/
	
	public function visual_list(){
		$page = ($this->input->get("page",true)) ? $this->input->get("page",true) : 1;
		$where = array('language' => "'{$this->language}'");
		$query = $this->visual_model->visual_list($where);
		$count = $this->visual_model->list_total($where);

		$listnum = 10;
		$total_page = ceil($count / $listnum);
		$list_no = $count - $listnum * ($page-1);
		
		$this->load->library('pagination');		
		$config['listnum'] = 10;
		$config['total_rows'] = $count;
		$config['block'] = 10;
		$config['page'] = $page;
		$config['querystring'] = "&language=".$this->language;
		$this->pagination->initialize($config);

		$data = array(
			'_title' => '메인관리',
			'_content' => 'thdadmin/pages/visual_list',
			'_language' => $this->language,
			'_query' => $query,
			'_list_no' => $list_no,
			'_page' => $page,
			'_paging'=> $this->pagination->create_links_admin(),
		);
		
		$this->common_v->admin_view($data);
	}

	public function visual_form(){
		$seq = $this->input->get('seq',true);
		$page = $this->input->get('page',true);
		$arr = $this->visual_model->visual_select(array('seq' => $seq));
		$_dbjob =($arr['seq'] == null) ? 'i' : 'u';
		$data = array(
			'_menucd' => '0101',
			'_title' => '메인관리',
			'_content' => 'thdadmin/pages/visual_form',
			'_language' => $this->language,
			'_dbjob' => $_dbjob,
			'_page' => $page,
		);
		
		$data = array_merge($data,$arr);
		$this->common_v->admin_view($data);
	}

	public function visual_dbjob(){
		$seq = $this->input->post('seq',true);
		$seqs = $this->input->post('seqs',true);
		$page = $this->input->post('page',true);
		$dbjob = $this->input->post('dbjob',true);
		$title = $this->input->post('title',true);
		$title_sub = $this->input->post('title_sub',true);
		$link_url = $this->input->post('link_url',true);
		$site = $this->input->post('site',true);
		$yearofmanu = $this->input->post('yearofmanu',true);
		$summary = $this->input->post('summary',true);
		$font_yn = $this->input->post('font_yn',true);
		$open_yn = $this->input->post('open_yn',true);
		$sort_no = $this->input->post('sort_no',true);
		$speed = $this->input->post('speed',true);
		$color_bg = $this->input->post('color_bg',true);
		$color_font = $this->input->post('color_font',true);
		$file_visual = $this->input->post('file_visual',true);

		$data = null;
		switch($dbjob){
			case('i'):
				$msg = '저장되었습니다.';
				$data = array(
						'language' => $this->language ,
						'site' => $site ,
						'title' => $title ,
						'title_sub' => $title_sub ,
						'yearofmanu' => $yearofmanu,
						'summary' => $summary,
						'font_yn' => $font_yn,
						'speed' => $speed,
						'color_bg' => $color_bg,
						'color_font' => $color_font,
						'file_visual' => $file_visual,
						'open_yn' => $open_yn,
						'link_url' => $link_url,
				);
			break;
			case('u'):
				$msg = '수정되었습니다.';
				$data = array(
						'language' => $this->language ,
						'site' => $site ,
						'title_sub' => $title_sub ,
						'title' => $title ,
						'yearofmanu' => $yearofmanu,
						'summary' => $summary,
						'font_yn' => $font_yn,
						'speed' => $speed,
						'color_bg' => $color_bg,
						'color_font' => $color_font,
						'file_visual' => $file_visual,
						'open_yn' => $open_yn,
						'link_url' => $link_url,
				);
			break;
			case('md'):
				$msg = '삭제 되었습니다.';
				$data = null;
			break;
			case('d'):
				$msg = '삭제 되었습니다.';
				$data = null;
			break;
			case('up'):
				$msg = '';
				$data = array(
					'sort_no' => $sort_no ,
				);
			break;
			case('down'):
				$msg = '';
				$data = array(
						'sort_no' => $sort_no ,
				);
			break;
		}

		$this->visual_model->visual_dbjob($data);
		jalert($msg, base_url('/thdadmin/visual_list?language='.$this->language));			
	}

	public function main_contents(){
		$config['where'] = array('language'=>$this->language);
		$config['table'] = 'thd_main_contents';
		$arr = $this->common_model->default_select($config);
		$_dbjob =($arr['seq'] == null) ? 'i' : 'u';

		$data = array(
			'_title' => '메인켄텐츠관리',
			'_content' => 'thdadmin/pages/'.$this->view_page,
			'_language' => $this->language,
			'_dbjob' => $_dbjob,
		);
		$data = array_merge($data,$arr);
		$this->common_v->admin_view($data);
	}

	public function main_contents_dbjob(){
	
		$title = $this->input->post('title',true);
		$stat = $this->input->post('stat',true);
		$dbjob = $this->input->post('dbjob',true);
		
		$content = array_merge(array('title' => $title),array('stat' => $stat));
		$content = json_encode($content);
		
		$data['where'] = array('language'=>$this->language);
		$data['table'] = 'thd_main_contents';
		$data['dbjob'] = $dbjob;
		switch($dbjob){
			case('i'):
				$msg = '저장되었습니다.';
				$data['data'] = array(
						'language' => $this->language ,
						'content' => $content ,
				);
			break;
			case('u'):
				$msg = '수정되었습니다.';
				$data['data'] = array(
						'content' => $content ,
				);
			break;
		}

		$this->common_model->common_dbjob($data);
		jalert($msg, base_url('/thdadmin/main_contents?language='.$this->language));
	}

	public function matching_list(){
		$page = ($this->input->get("page",true)) ? $this->input->get("page",true) : 1;

		$config['page'] = $page;
		$config['where'] = array('language'=>"'".$this->language."'");
		$config['table'] = 'thd_tech_matching';
			
		$query = $this->common_model->default_list($config);
		$count = $this->common_model->list_total($config);

		$listnum = 10;
		$total_page = ceil($count / $listnum);
		$list_no = $count - $listnum * ($page-1);
		
		isset($config);
		$this->load->library('pagination');		
		$config['listnum'] = 10;
		$config['total_rows'] = $count;
		$config['block'] = 10;
		$config['page'] = $page;
		$config['querystring'] = "&language=".$this->language;
		$this->pagination->initialize($config);

		$data = array(
			'_title' => '기술매칭',
			'_content' => 'thdadmin/pages/'.$this->view_page,
			'_language' => $this->language,
			'_query' => $query,
			'_list_no' => $list_no,
			'_page' => $page,
			'_paging'=> $this->pagination->create_links_admin(),
		);
		
		$this->common_v->admin_view($data);
	}

	public function matching_view(){
		$seq = $this->input->get('seq',true);
		$page = $this->input->get('page',true);
		
		$config['where'] = array('seq'=>$seq);
		$config['table'] = 'thd_tech_matching';
		
		$arr = $this->common_model->default_select($config);
		$_dbjob =($arr['seq'] == null) ? 'i' : 'u';
		$data = array(
			'_title' => '메인관리',
			'_content' => 'thdadmin/pages/'.$this->view_page,
			'_language' => $this->language,
			'_dbjob' => $_dbjob,
			'_page' => $page,
		);
		
		$data = array_merge($data,$arr);
		$this->common_v->admin_view($data);
	}

	public function matching_dbjob(){
		$seq = $this->input->post('seq',true);
		$approval = $this->input->post('approval',true);
		
		$dbjob = $this->input->post('dbjob',true);
		
		$config['where'] = array('seq'=>$seq);
		$config['table'] = 'thd_tech_matching';
		$config['dbjob'] = $dbjob;
	
		switch($dbjob){
			case('u'):
				$msg = ' 수정 되었습니다.';
				$config['data'] = array('approval' => $approval);
			break;
		
			case('d'):
				$msg = '삭제 되었습니다.';
				$data = null;
			break;
		}
		
		$this->common_model->common_dbjob($config);
		if($dbjob == 'u'){
			jalert($msg, $this->agent->referrer(),'parent');	
		}else{
			jalert($msg, base_url('/thdadmin/matching_list?language='.$this->language));	
		}
	}

	public function seminar_list(){
		$page = ($this->input->get("page",true)) ? $this->input->get("page",true) : 1;
		$config['page'] = $page;
		$config['where'] = array('language'=>"'".$this->language."'");
		$config['table'] = 'thd_seminar';
		
		$keyname = $this->input->get("keyname",true);
		$keyword = $this->input->get("keyword",true);
		if($keyname && $keyword){
			 $config['where'] = array_merge($config['where'],array($keyname.' LIKE' => " '%".$keyword."%'"));
		}
		$p[] = 'keyname='.$keyname;
		$p[] = 'keyword='.urlencode($keyword);
		$param = implode('&',$p);
				
		$query = $this->common_model->default_list($config);
		$count = $this->common_model->list_total($config);

		$listnum = 10;
		$total_page = ceil($count / $listnum);
		$list_no = $count - $listnum * ($page-1);
		
		isset($config);
		$this->load->library('pagination');		
		$config['listnum'] = 10;
		$config['total_rows'] = $count;
		$config['block'] = 10;
		$config['page'] = $page;
		$config['querystring'] = "&language=".$this->language.$param;
		$this->pagination->initialize($config);

		$data = array(
			'_title' => '세미나&행사',
			'_content' => 'thdadmin/pages/'.$this->view_page,
			'_language' => $this->language,
			'_query' => $query,
			'_list_no' => $list_no,
			'_page' => $page,
			'_paging'=> $this->pagination->create_links_admin(),
		);
		
		$this->common_v->admin_view($data);
	}

	public function seminar_form(){
		$seq = $this->input->get('seq',true);
		$page = $this->input->get('page',true);
		$config['where'] = array('seq'=>$seq);
		$config['table'] = 'thd_seminar';
		
		$arr = $this->common_model->default_select($config);
		$_dbjob =($arr['seq'] == null) ? 'i' : 'u';
		$data = array(
			'_title' => '세미나&행사',
			'_content' => 'thdadmin/pages/'.$this->view_page,
			'_language' => $this->language,
			'_dbjob' => $_dbjob,
			'_page' => $page,
		);
		
		$data = array_merge($data,$arr);
		$this->common_v->admin_view($data);
	}

	public function seminar_dbjob(){
		$msg = '';
		$seq = $this->input->post('seq',true);
		$seqs = $this->input->post('seqs',true);
		$dbjob = $this->input->post('dbjob',true);
		$title = $this->input->post('title',true);
		$start_date = $this->input->post('start_date',true);
		$end_date = $this->input->post('end_date',true);
		$open_yn = $this->input->post('open_yn',true);
		$ing_yn = $this->input->post('ing_yn',true);
		$country = $this->input->post('country',true);
		$attache_file1 = $this->input->post('attache_file1',true);
		$content = $this->input->post('content',true);
		$ampm = $this->input->post('ampm',true);
		$hh = $this->input->post('hh',true);
		$location = $this->input->post('location',true);
		$summary = $this->input->post('summary',true);
		
		$config['where_in'] = 'seq';
		if($seqs){
			$config['where'] = $seqs;
		}else{
			$config['where'] = array('seq'=>$seq);
		}
		$config['table'] = 'thd_seminar';
		$config['dbjob'] = $dbjob;
			
		switch($dbjob){
		case('i'):
			$msg = '저장되었습니다.';
			$config['data'] = array(
					'language' => $this->language ,
					'title' => $title ,
					'start_date' => $start_date ,
					'end_date' => $end_date ,
					'ing_yn' => $ing_yn ,
					'open_yn' => $open_yn ,
					'attache_file1' => $attache_file1 ,
					'ampm' => $ampm ,
					'hh' => $hh ,
					'location' => $location ,
					'summary' => $summary ,
					'content' => $content ,
					'reg_date' => date("Y-m-d H:i",time())
			);
		break;
		case('u'):
			$msg = '수정되었습니다.';
			$config['data'] = array(
					'language' => $this->language ,
					'title' => $title ,
					'start_date' => $start_date ,
					'end_date' => $end_date ,
					'ing_yn' => $ing_yn ,
					'open_yn' => $open_yn ,
					'attache_file1' => $attache_file1 ,
					'ampm' => $ampm ,
					'hh' => $hh ,
					'location' => $location ,
					'summary' => $summary ,
					'content' => $content ,
			);
		break;
		case('d'):
			$msg = '삭제 되었습니다.';
		break;
		case('md'):
			$msg = '삭제 되었습니다.';
			$data = null;
		break;
		}
		
		$this->common_model->common_dbjob($config);
		jalert($msg, base_url('/thdadmin/seminar_list?language='.$this->language));
	}

	public function recruit_list(){
		$page = ($this->input->get("page",true)) ? $this->input->get("page",true) : 1;
		$config['page'] = $page;
		$config['where'] = array('language'=>"'".$this->language."'");
		$config['table'] = 'thd_recruit';
		
		$keyname = $this->input->get("keyname",true);
		$keyword = $this->input->get("keyword",true);
		if($keyname && $keyword){
			 $config['where'] = array_merge($config['where'],array($keyname.' LIKE' => " '%".$keyword."%'"));
		}
		$p[] = 'keyname='.$keyname;
		$p[] = 'keyword='.urlencode($keyword);
		$param = implode('&',$p);
				
		$query = $this->common_model->default_list($config);
		$count = $this->common_model->list_total($config);

		$listnum = 10;
		$total_page = ceil($count / $listnum);
		$list_no = $count - $listnum * ($page-1);
		
		isset($config);
		$this->load->library('pagination');		
		$config['listnum'] = 10;
		$config['total_rows'] = $count;
		$config['block'] = 10;
		$config['page'] = $page;
		$config['querystring'] = "&language=".$this->language.$param;
		$this->pagination->initialize($config);

		$data = array(
			'_title' => '채용정보',
			'_content' => 'thdadmin/pages/'.$this->view_page,
			'_language' => $this->language,
			'_query' => $query,
			'_list_no' => $list_no,
			'_page' => $page,
			'_paging'=> $this->pagination->create_links_admin(),
		);
		
		$this->common_v->admin_view($data);
	}

	public function recruit_form(){
		$seq = $this->input->get('seq',true);
		$page = $this->input->get('page',true);
		$config['where'] = array('seq'=>$seq);
		$config['table'] = 'thd_recruit';
		
		$arr = $this->common_model->default_select($config);
		$_dbjob =($arr['seq'] == null) ? 'i' : 'u';
		$data = array(
			'_title' => '채용정보',
			'_content' => 'thdadmin/pages/'.$this->view_page,
			'_language' => $this->language,
			'_dbjob' => $_dbjob,
			'_page' => $page,
		);
		
		$data = array_merge($data,$arr);
		$this->common_v->admin_view($data);
	}

	public function recruit_dbjob(){
		$msg = '';
		$seq = $this->input->post('seq',true);
		$seqs = $this->input->post('seqs',true);
		$dbjob = $this->input->post('dbjob',true);
		$title = $this->input->post('title',true);
		$start_date = $this->input->post('start_date',true);
		$end_date = $this->input->post('end_date',true);
		$open_yn = $this->input->post('open_yn',true);
		$ing_yn = $this->input->post('ing_yn',true);
		$country = $this->input->post('country',true);
		$attache_file1 = $this->input->post('attache_file1',true);
		$attache_file2 = $this->input->post('attache_file2',true);
		$attache_file3 = $this->input->post('attache_file3',true);
		$content = $this->input->post('content',true);
		
		$area = $this->input->post('area',true);
		$career = $this->input->post('career',true);
		
		$config['where_in'] = 'seq';
		if($seqs){
			$config['where'] = $seqs;
		}else{
			$config['where'] = array('seq'=>$seq);
		}
		$config['table'] = 'thd_recruit';
		$config['dbjob'] = $dbjob;
			
		switch($dbjob){
		case('i'):
			$msg = '저장되었습니다.';
			$config['data'] = array(
					'language' => $this->language ,
					'title' => $title ,
					'start_date' => $start_date ,
					'end_date' => $end_date ,
					'ing_yn' => $ing_yn ,
					'open_yn' => $open_yn ,
					'attache_file1' => $attache_file1,
					'attache_file2' => $attache_file2,
					'attache_file3' => $attache_file3,			
					'area' => $area ,
					'career' => $career ,
					'content' => $content ,
					'reg_date' => date("Y-m-d H:i",time())
			);
		break;
		case('u'):
			$msg = '수정되었습니다.';
			$config['data'] = array(
					'language' => $this->language ,
					'title' => $title ,
					'start_date' => $start_date ,
					'end_date' => $end_date ,
					'ing_yn' => $ing_yn ,
					'open_yn' => $open_yn ,
					'attache_file1' => $attache_file1,
					'attache_file2' => $attache_file2,
					'attache_file3' => $attache_file3,
					'ampm' => $ampm ,
					'hh' => $hh ,
					'area' => $area ,
					'career' => $career ,
					'content' => $content ,
			);
		break;
		case('d'):
			$msg = '삭제 되었습니다.';
		break;
		case('md'):
			$msg = '삭제 되었습니다.';
			$data = null;
		break;
		}
		
		$this->common_model->common_dbjob($config);
		jalert($msg, base_url('/thdadmin/recruit_list?language='.$this->language));
	}

	public function newsletter_list(){
		$page = ($this->input->get("page",true)) ? $this->input->get("page",true) : 1;
		$config['page'] = $page;
		$config['where'] = array('language'=>"'".$this->language."'");
		$config['table'] = 'thd_newsletter';
		
		$keyname = $this->input->get("keyname",true);
		$keyword = $this->input->get("keyword",true);
		if($keyname && $keyword){
			 $config['where'] = array_merge($config['where'],array($keyname.' LIKE' => " '%".$keyword."%'"));
		}
		$p[] = 'keyname='.$keyname;
		$p[] = 'keyword='.urlencode($keyword);
		$param = implode('&',$p);
				
		$query = $this->common_model->default_list($config);
		$count = $this->common_model->list_total($config);

		$listnum = 10;
		$total_page = ceil($count / $listnum);
		$list_no = $count - $listnum * ($page-1);
		
		isset($config);
		$this->load->library('pagination');		
		$config['listnum'] = 10;
		$config['total_rows'] = $count;
		$config['block'] = 10;
		$config['page'] = $page;
		$config['querystring'] = "&language=".$this->language.$param;
		$this->pagination->initialize($config);

		$data = array(
			'_title' => '뉴스레터 구독신청',
			'_content' => 'thdadmin/pages/'.$this->view_page,
			'_language' => $this->language,
			'_query' => $query,
			'_list_no' => $list_no,
			'_page' => $page,
			'_paging'=> $this->pagination->create_links_admin(),
		);
		
		$this->common_v->admin_view($data);
	}

	public function newsletter_dbjob(){
		$msg = '';
		$seq = $this->input->post('seq',true);
		$seqs = $this->input->post('seqs',true);
		$dbjob = $this->input->post('dbjob',true);
		$title = $this->input->post('title',true);
		$start_date = $this->input->post('start_date',true);
		$end_date = $this->input->post('end_date',true);
		$open_yn = $this->input->post('open_yn',true);
		$ing_yn = $this->input->post('ing_yn',true);
		$country = $this->input->post('country',true);
		$attache_file1 = $this->input->post('attache_file1',true);
		$attache_file2 = $this->input->post('attache_file2',true);
		$attache_file3 = $this->input->post('attache_file3',true);
		$content = $this->input->post('content',true);
		
		$area = $this->input->post('area',true);
		$career = $this->input->post('career',true);
		
		$config['where_in'] = 'seq';
		if($seqs){
			$config['where'] = $seqs;
		}else{
			$config['where'] = array('seq'=>$seq);
		}
		$config['table'] = 'thd_newsletter';
		$config['dbjob'] = $dbjob;
			
		switch($dbjob){
		case('i'):
			$msg = '저장되었습니다.';
			$config['data'] = array(
					'language' => $this->language ,
					'title' => $title ,
					'start_date' => $start_date ,
					'end_date' => $end_date ,
					'ing_yn' => $ing_yn ,
					'open_yn' => $open_yn ,
					'attache_file1' => $attache_file1,
					'attache_file2' => $attache_file2,
					'attache_file3' => $attache_file3,			
					'area' => $area ,
					'career' => $career ,
					'content' => $content ,
					'reg_date' => date("Y-m-d H:i",time())
			);
		break;
		case('u'):
			$msg = '수정되었습니다.';
			$config['data'] = array(
					'language' => $this->language ,
					'title' => $title ,
					'start_date' => $start_date ,
					'end_date' => $end_date ,
					'ing_yn' => $ing_yn ,
					'open_yn' => $open_yn ,
					'attache_file1' => $attache_file1,
					'attache_file2' => $attache_file2,
					'attache_file3' => $attache_file3,
					'ampm' => $ampm ,
					'hh' => $hh ,
					'area' => $area ,
					'career' => $career ,
					'content' => $content ,
			);
		break;
		case('d'):
			$msg = '삭제 되었습니다.';
		break;
		case('md'):
			$msg = '삭제 되었습니다.';
			$data = null;
		break;
		}
		
		$this->common_model->common_dbjob($config);
		jalert($msg, base_url('/thdadmin/newsletter_list?language='.$this->language));

	}


}
