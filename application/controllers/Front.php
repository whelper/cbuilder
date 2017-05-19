<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends CI_Controller {

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
	var $folder  = '';
	var $is_mobile = 0;
	var $theme_path = '';
	function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url','file','ckeditor_helper','text'));
		$this->load->model(array('menu_model','board_model','popup_model','member_model','product_model','visual_model','common_model'));
		$this->load->library(array('email','user_agent','form_validation','alert','session','encryption'));

		$uri_array = segment_explode($this->uri->uri_string());		
		if(is_array($uri_array)){ //언어별 분기
			switch($uri_array[0]){
				case('en'):
					$this->language = $uri_array[0];
				break;
				case('jp'):
					$this->language = $uri_array[0];
				break;
				case('cn'):
					$this->language = $uri_array[0];
				break;
				default:
				break;
			}
		}
		
		/*if(DEVICE_TYPE == 'M'){
			$this->is_mobile = 1;
			$this->folder .= '/m';
		}*/
		//테마경로
		$this->theme_path = '/theme/'.$this->config->item('theme').'/'.$this->language.$this->folder;
	
	}

	
	public function index()
	{	
		$param['page'] = 1;
		$param['menu_id'] = 2;
		$param['language'] = $this->language;
		$param['config']['list_cnt'] = 4;
		$news = $this->board_model->board_list($param);
		
		$param['menu_id'] = 36;
		$sample = $this->board_model->board_list($param);
		

		$data = array(
				'_title' => '',
				'_skin' => 'main',
				'_news' => $news,
				'_sample' => $sample,
				'_meun' => null,
				'_language' => $this->language,
				'_folder' => $this->folder,
		);
		$this->load->view('masterpage',$data);
	}

	/**
	 * front html page
	 *
	 * @access	public
	 * @return	array
	 */
	function html(){
		$url = get_index_uri(2);
		$uri_array = segment_explode($this->uri->uri_string());
		$id = urldecode($this->security->xss_clean(url_explode($uri_array, 'id')));
		$alias = urldecode($this->security->xss_clean(url_explode($uri_array, 'html')));
		
		/*if($alias && $alias !='id'){
			$content = $this->menu_model->select_alias($alias);
			$id =  $content['menu_id'];
		}
		
		$menu = $this->menu_model->setting_page($id);
		*/
		
		$html = 'html/'.$alias;
		$data = array(
				'_title' => null,
				'_contents' => 'view',
				'_skin' => 'sub',
				'_language' => $this->language,
				'_menu' => null,
				'_view' => $html,
				'_folder' =>$this->folder,
		);
		
		$this->load->view('masterpage',$data);	
		
	}

	function popup(){
		$url = get_index_uri(2);
		$uri_array = segment_explode($this->uri->uri_string());
		$id = urldecode($this->security->xss_clean(url_explode($uri_array, 'id')));
		$data = array(
				'_title' => '',
				'_skin' => 'sub',
				'_language' => $this->language,
		);

		$data = array_merge($data,$this->popup_model->popup_select(array('id'=>$id)));
		$this->load->view('/front/popup',$data);
	}

	function ajax_preview_font(){
		$url = get_index_uri(2);
		$font_no =  $this->encryption->decrypt($this->input->post('font'));
		$size = $this->input->post('size');
		$sample_text = $this->input->post('sample_text');
		$data = $this->product_model->product_select(array('seq'=>$font_no));
		$data =  array_merge($data,array('font_size'=>$size,'sample_text'=>$sample_text));
		
		create_preview_png($data);
		$imgData = base64_encode(file_get_contents(FCPATH.'upload/preview/preview.png'));
		$data['image'] = 'data:image/png;base64,'.$imgData;
		$this->load->view($url,$data);
	}
	
	function ajax_preview_text(){
		$url = get_index_uri(2);
		$font_no =  $this->encryption->decrypt($this->input->post('font'));
		$data = $this->product_model->product_select(array('seq'=>$font_no));
		$this->load->view($url,$data);
	}

	function ajax_project(){
		$url = get_index_uri(2);
		if($this->session->userdata('userno')){
			$arr = $this->member_model->select_member($this->session->userdata('userno'));
			$data = array(
				'userno'=> $this->encryption->encrypt($arr['id']),
				'name' => $arr['name'],
				'email' => $arr['email'],
				'hp' => $arr['hp'],
			);
		}else{
			$data = array('userno'=> null,'name' =>  null,'email' => null,'hp' => null);
		}
		
		$data = array_merge($data,array('return_url' => $this->input->get('return_url')));
		$this->load->view($url,$data);
	}

	function ajax_popup(){
		$url = get_index_uri(2);
		$data = array(
				'_title' => '',
				'_contents' => $url,
				'_skin' => 'sub',
				'_language' => $this->language,
		);

		$query = $this->popup_model->list_front();
		$json_data = null;
		if($query->num_rows() > 0){
			$json = null;
			foreach ($query->result() as $row){
				$json['id'][] = $row->id;
				$json['layer_yn'][] = $row->layer_yn;
				$json['popup_top'][] = $row->popup_top;
				$json['popup_left'][] = $row->popup_left;
				$json['popup_width'][] = $row->popup_width;
				$json['popup_height'][] = $row->popup_height;
			}
			$json_data =json_encode($json);
		}
		$data = array_merge($data,array('json_data'=>$json_data));
		
		$this->load->view($url,$data);	
	}

	public function captcha_check(){
       
        //get verify response data
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret='.$this->config->item('google_recaptcha_secret').'&response='.$this->input->post('g-recaptcha-response'); 
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$verifyResponse = curl_exec($ch);
		
		$responseData = json_decode($verifyResponse);
		
		if(!$responseData->success){
			$this->form_validation->set_message('captcha_check', '%s 입력값이 잘못되었습니다');
			return false;
		}else{
			return true;
		}
	 }

	public function inquiry_send(){
		$company = $this->input->post('company',true);
		$email = $this->input->post('email',true);
		$name = $this->input->post('name',true);
		$phone = $this->input->post('phone',true);
		$title = $this->input->post('title',true);
		$homepage = $this->input->post('homepage',true);
		$content = $this->input->post('content',true);
		
		$this->lang->load('form_validation', 'ko');
		//$this->load->library('form_validation');


		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		$this->form_validation->set_rules('name', '＊성명', 'required');
		$this->form_validation->set_rules('phone', '＊연락처', 'required');
		$this->form_validation->set_rules('email', '＊이메일', 'required|valid_email');
		$this->form_validation->set_rules('content', '＊내용', 'required');
		$this->form_validation->set_rules('recaptcha_response_field', '＊자동방지', 'callback_captcha_check');

		if ($this->form_validation->run() == false){
			return $this->index();
		}else{
			$data = array(
						'company' => $company,
						'title' => $title,
						'email' => $email,
						'name' => $name,
						'phone' => $phone,
						'homepage' => $homepage,
						'content' => $content,
						'ua' => $this->agent->agent_string(),
						'ip'=> $this->input->ip_address(),
						'regist_date'=>  date("Y-m-d H:i",time())
				);
			$msg = '견적문의가 등록 되었습니다.';
			
			if(isset($_FILES['files'])){
				/*file upload begin*/
				$upload_path = './upload/inquiry/';
				$config['upload_path'] = $upload_path;
				$config['allowed_types'] = 'jpg|gif|png|zip|rar|doc|hwp|pdf|ppt|xls|pptx|docx|xlsx';
				$config['max_size']	= '20240'; //20MB
				//$config['max_width']  = '1024';
				//$config['max_height']  = '768';
				$config['encrypt_name'] = true;
				$config['remove_spaces'] = true;
				$this->load->library('upload', $config);
				$this->upload->mkdir($upload_path);

				$file = $this->upload->do_multi_upload('files');
				if($this->upload->display_errors()){
					$msg = $this->upload->display_errors('','');
				}else{
					if(is_array($file)){
						$data = array_merge($data,array('files' => json_encode($file)));
					}
				}
			}

			$this->inquiry_model->inquiry_dbjob($data);


			//이메일 전송 begin
			$config['mailtype'] = 'html';
			$config['charset'] = 'utf-8';
			//$config['newline'] = "\r\n";
			$template = read_file('./template/mail/contact.html');
		
			$mbody = str_replace('{FORM_NAME}','문의하기', $template);
			$mbody = str_replace('{COMPANY}',$company, $mbody);
			$mbody = str_replace('{NAME}',$name, $mbody);
			$mbody = str_replace('{PHONE}',$phone, $mbody);
			$mbody = str_replace('{EMAIL}',$email, $mbody);
			$mbody = str_replace('{HOMEPAGE}',$homepage, $mbody);
			$mbody = str_replace('{CONSULTING_YN}','Y', $mbody);
			$mbody = str_replace('{CONTENT}',nl2br($content), $mbody);
			$mbody = str_replace('{UA}',$this->agent->agent_string(), $mbody);
			$mbody = str_replace('{URL}',base_url(), $mbody);

			$this->email->initialize($config);			
			$this->email->from($email, $name);
			$this->email->to($this->config->item('email'), $this->config->item('email_name'));
			$this->email->subject('[쓰리데이즈] 문의하기 등록');
			$this->email->message($mbody);
			$this->email->send();
			//echo $this->email->print_debugger();
			//이메일 전송 end


			$this->alert->jalert($msg, $this->input->server('HTTP_REFERER'));
			exit;
		}
	}

	/*
	 @게시판 관리
	*/
	public function board(){
	
		$uri_array = segment_explode($this->uri->uri_string());
		$array_segment = array_keys($this->uri->segment_array(), "page");
		$page = in_array('page', $uri_array) ? urldecode($this->security->xss_clean(url_explode($uri_array, 'page'))) : 1;
		$id = in_array('id', $uri_array) ? urldecode($this->security->xss_clean(url_explode($uri_array, 'id'))) : null;
		$no = in_array('no', $uri_array) ? urldecode($this->security->xss_clean(url_explode($uri_array, 'no'))) : null;
		$cate = in_array('cate', $uri_array) ? urldecode($this->security->xss_clean(url_explode($uri_array, 'cate'))) : null;
		$action = in_array('board', $uri_array) ? urldecode($this->security->xss_clean(url_explode($uri_array, 'board'))) : null;

		$uri_segment = in_array('page', $uri_array) ? $array_segment[0]+1 : 0;
		$url = get_index_uri(3);
		$this->load->library('pagination');
		$board_info = $this->menu_model->menu_select(array('menu_id'=>$id));
		$board_name = 'thd_board';
		
		
		$this->load->library('THD_Board',array('config'=>$board_info,'table_name'=>$board_name,'skin'=>$board_info['board_skin'],'language'=>$this->language,'folder'=>$this->folder));
		$view = $this->thd_board->getOutter();
		
		//에디터
		$ckeditor = array('path'=> '/common/assets/ckeditor/standard','id'=>'textarea_id','config'=>array('filebrowserImageUploadUrl'=>'/common/assets/ckeditor/standard/upload.php?type=Images'));
		
		//by korustec
		switch($id){
		case('1'):
			$pgcode = ($cate == '러시아') ? '020103' : '020203';
		break;
		case('2'):
			$pgcode = '0301';
		break;
		case('3'):
			$pgcode = '0401';
		break;
		case('4'):
			$pgcode = '0403';
		break;
		default:
			$pgcode = '0101';
		break;
		}	
		

		$cfg = array(
				'skin' => $board_info['board_skin'],
				'page' =>$page,
				'menu_id' =>$id,
				'id' =>$no,
				'board_name' =>$board_name,
				'secret_yn' =>$board_info['secret_yn'],
				'auth_list' =>$board_info['auth_list'],
				'auth_write' =>$board_info['auth_write'],
				'auth_view' =>$board_info['auth_view'],
				'auth_reply' =>$board_info['auth_reply'],
				'auth_comment' =>$board_info['auth_comment'],
				'_ckeditor' => $ckeditor,
				'pgcode' => $pgcode,
		);

		$json = json_decode($board_info['settings'],true);
		//게시판 스킨 경로
		$skin = '/theme/'.$this->config->item('theme').'/'.$this->language.$this->folder.'/board/'.$board_info['board_skin'];	
		//echo $skin;
		switch($action){
			case('list'):
				if($board_info['auth_list'] > $this->session->userdata('membership')){
					$this->alert->jalert('접근 권한이 없습니다.', '','back');
					exit;
				}
				$param['folder'] = $this->folder;
				$param['sch_keyname'] = $this->input->get('sch_keyname',true);
				$param['sch_keyword'] = $this->input->get('sch_keyword',true);
				//$sch_url_pattern = search_param_url($param);
				
				$param = array_merge($param,array('page'=>$page,'menu_id'=>$id,'language'=> $this->language));
				$count = $this->board_model->list_total(array('page'=>$page,'menu_id'=>$id,'board_name'=>$board_name,'language'=> $this->language,'cate'=> $cate));
				
				$param = array_merge($param,array('count'=>$count,'cate'=>$cate)); //목록 번호를 위한 카운트
				
				if($board_info['cate']){
					$_cate = explode(',',$board_info['cate']);
					$c = '';
					foreach($_cate as $key => $value){
						$c .= ' <li><a href="/front/board/list/id/'.$id.'">'.$value.'</a></li>';
					}
					$this->thd_board->dress('cate',$c,$view);
				}
		
				$this->thd_board->dress('board_list',$this->thd_board->boardlist($param),$view);
				
				$listnum = $json['list_cnt'];
				if($json['board_type'] == 2){ //갤러리
					$listnum = ceil($json['cols']) * ceil($json['rows']);
				}
				if(!$listnum) $listnum = 10;
				
				$querystring = null;
				$querystring .= ($cate) ? '/cate/'.urlencode($cate) : null;

				//@paging
				$config['listnum'] = $listnum;
				$config['url'] = '/front/board/list/id/'.$id;
				$config['total_rows'] = $count;
				$config['block'] = ($this->is_mobile == 0) ? 10 : 5;
				$config['page'] = $page;
				$config['theme'] = $skin; 
				$config['querystring'] = $querystring;

				$this->pagination->initialize($config);
				
				
				$this->thd_board->dress('PAGING',$this->pagination->create_links(),$view);
				
				$this->thd_board->dress('id',$id,$view);
				$this->thd_board->dress('board_name',$board_name,$view);
				$this->thd_board->dress('language',$this->language,$view);
				$this->thd_board->dress('count',$count,$view);
				
				if($board_info['auth_write'] > $this->session->userdata('membership')){
					if($board_info['auth_write'] == 10){ //관리자 전용
						$view = $this->thd_board->removeTagSelected('btn_write','',$view);
					}else{
						$warning_message = ($this->session->userdata('membership')) ? '쓰기권한이 없습니다.' : '로그인 해주세요';
						$this->thd_board->dress('brd_btn_write','javascript:alert(\''.$warning_message.'\');',$view);
					}
				}else{
					$this->thd_board->dress('brd_btn_write','/front/board/write/id/'.$id,$view);
				}
				
				if($count > 0){ //게시물이 없는경우 표시
					$view =$this->thd_board->removeTagSelected('no_data','',$view);
				}

				break;
			case('write'):
				if($board_info['auth_write'] > $this->session->userdata('membership')){
					$this->alert->jalert('접근 권한이 없습니다.', '','back');
					exit;
				}

				$view = $this->thd_board->boardWrite($cfg);
				break;
			case('reply'):
				$view = $this->thd_board->boardReply($cfg);
				break;
			case('view'):
				$cfg = array_merge($cfg,array('cate'=>$cate));
				$view = $this->thd_board->boardView($cfg);
				$this->thd_board->dress('theme_skin',$skin,$view);
				break;
			case('passwd'):
				$view = $this->thd_board->boardPasswd($cfg);
				$this->thd_board->dress('theme_skin',$skin,$view);
				break;
		}
		
		$this->thd_board->dress('pgcode',$pgcode,$view);
		$this->thd_board->dress('theme_skin',$skin,$view);
		$view = $this->thd_board->removeAllTags($view);

		$data = array(
				'_title' => $board_info['title'],
				'_group' => 'homepage',
				'_contents' => $url,
				'_view' => $view,
				'_skin' => 'sub',
				'_language' => $this->language,
				'_menu' =>$this->menu_model->setting_page($id),
				'_folder' => $this->folder,
		);
	
		//echo $view;
		//$data = array_merge($data,$this->contents_model->setting_page($id));
		//return $data;
		$this->load->view('masterpage',$data);			
	}
	
	function checkPasswd(){
		$this->load->library('encrypt');
		$menu_id = $this->input->post('menu_id',true);
		$no = $this->input->post('no',true);
		$dbjob = $this->input->post('dbjob',true);
		$passwd = $this->input->post('passwd');
		
		$where['menu_id'] = $menu_id;
		$where['id'] = $no;
	
		$data = $this->board_model->board_auth($where);
		
		if($this->encrypt->decode($data['passwd']) == $passwd){
			$this->session->set_userdata(array('brdId'=>$data['menu_id'],'brdNo'=>$data['id']));
			if($dbjob == 'u'){
				echo '<form name="frmReg" method="post" action="/front/board/write/id/'.$menu_id.'/no/'.$no.'">';
				echo '<input type="hidden" name="dbjob" value="u">';
				echo '<input type="hidden" name="board_name" value="thd_board">';
				echo '</form>';
				echo '<script type="text/javascript">document.frmReg.submit();</script>';
				exit;
			}else if($dbjob == 'd'){
				echo '<form name="frmReg" method="post" action="/front/boardDbjob">';
				echo '<input type="hidden" name="dbjob" value="d">';
				echo '<input type="hidden" name="menu_id" value="'.$menu_id.'">';
				echo '<input type="hidden" name="no" value="'.$no.'">';
				echo '<input type="hidden" name="board_name" value="thd_board">';
				echo '</form>';
				echo '<script type="text/javascript">document.frmReg.submit();</script>';
				exit;
			}else{
				$this->alert->jalert('', '/front/board/view/id/'.$menu_id.'/no/'.$no,'link');
			}
			exit;
		}else{
			$this->alert->jalert('비밀번호를 다시 확인해주세요', '','back');	
			exit;
		}
	}

	function boardDbjob(){
		$this->load->library('encrypt');
		$menu_id = $this->input->post('menu_id',true);
		$title = $this->input->post('title',true);
		$writer = $this->input->post('writer',true);
		$content = $this->input->post('content',true);
		$dbjob = ($this->input->post('dbjob')) ? $this->input->post('dbjob',true) : 'i';
		$auth_uid = ($this->session->userdata('userid')) ? $this->session->userdata('userid') : null;
		$passwd = ($this->input->post('passwd')) ? $this->encrypt->encode($this->input->post('passwd')) : null;
		
		switch($dbjob){
			case('i'):
				if(!$this->captcha_check()){
					$this->alert->jalert('자동등록 인증에 실패했습니다.', '','back');	
					exit;
				}
			
				$msg = '저장되었습니다.';
				$data = array(
						'menu_id' => $menu_id ,
						'is_mobile' => $this->is_mobile,
						'title' => $title ,
						'writer' => $writer ,
						'content' => $content ,
						'passwd' => $passwd ,
						'auth_uid' => $auth_uid,
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
						'is_mobile' => $this->is_mobile,
						'title' => $title ,
						'writer' => $writer ,
						'content' => $content ,
						'passwd' => $passwd ,
						'auth_uid' => $auth_uid,
						'view_count'=> 0,
						'register_date'=>  date("Y-m-d H:i",time())
				);
				break;
			case('u'):
				$msg = '수정되었습니다.';
				$data = array(
						'title' => $title ,
						'is_mobile' => $this->is_mobile,
						'writer' => $writer ,
						'content' => $content,
	
				);
				
				if($passwd) $data = array_merge($data,array('passwd' => $passwd));

				break;
			case('d'):
				$msg = '삭제 되었습니다.';
				$data = null;
				break;
			
		}
	
		if(isset($_FILES['files'])){
			/*file upload begin*/
			$upload_path = convert_path('/upload/board/'.$menu_id);
			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = 'jpg|gif|png|zip|rar|doc|hwp|pdf|ppt|xls|pptx|docx|xlsx';
			$config['max_size']	= '10240'; //10MB
			//$config['max_width']  = '1024';
			//$config['max_height']  = '768';
			$config['encrypt_name'] = true;
			$config['remove_spaces'] = true;
			$this->load->library('upload', $config);
			$this->upload->mkdir($upload_path);
		}
	
		if($this->board_model->board_dbjob($data)){
			if(isset($_FILES['files'])){
				$file = $this->upload->do_multi_upload('files');
				if($this->upload->display_errors()){
					$msg = $this->upload->display_errors('','');
				}else{
					$this->board_model->board_file($file);
				}
			}
			$this->alert->jalert($msg, base_url('/front/board/list/id/'.$menu_id));
		}else{
			$this->alert->jalert('에러', '','back');
		}
		exit;
	}

	function boardCommentDbjob(){
		$menu_id = $this->input->post('board_id',true);
		$board_no = $this->input->post('board_no',true);
		$b_comment = $this->input->post('b_comment',true);
		$user_id = $this->input->post('user_id',true);
		$name = $this->input->post('name',true);
		$content = $this->input->post('content',true);
		$dbjob = ($this->input->post('dbjob')) ? $this->input->post('dbjob',true) : 'i';
	
		switch($dbjob){
			case('i'):
				$msg = '저장되었습니다.';
				$data = array(
						'menu_id' => $menu_id ,
						'board_id' => $board_no ,
						'user_id' => $user_id ,
						'name' => $name ,
						'b_comment' => $b_comment,
						'register_ip'=> $this->input->ip_address(),
						'register_date'=>  date("Y-m-d H:i",time())
				);
				break;
			case('u'):
				$msg = '수정되었습니다.';
				$data = array(
						'b_comment' => $b_comment
				);
				break;
			case('d'):
				$data = null;
				$msg = '삭제 되었습니다.';
				break;
		}
	
		$this->board_model->board_comment_dbjob($data);
		$this->alert->jalert($msg, $this->input->server('HTTP_REFERER'));
	}

	function download(){
		$this->load->helper('download');
		
		$fpath =  $this->input->get('fpath');
		$data = file_get_contents($fpath);
		$fname = $this->input->get('fname');
		force_download($fname, $data);
	}

	public function ajax_child_category(){
		$category = $this->input->get("category",true);
		$arr = array('use_yn'=>'Y','LEFT(category,LENGTH(\''.$category.'\'))' => $category,'LENGTH(category)' => strlen($category)+2);
		$query = $this->product_model->category_list($arr);
		$info = array();
		foreach($query->result() as $row){
			$info['category'][] = $row->category;
			$info['category_name'][] =  $row->category_name;
		}
		//$data['contents'] = json_encode($info);
		echo json_encode($info);
		exit;
		//$this->load->view('thdadmin/pages/ajax_category',$data);
	}

	public function match_dbjob(){
		$msg = '';
		$dbjob = $this->input->post('dbjob',true);
		$title = $this->input->post('title',true);
		$name = $this->input->post('name',true);
		$mail = $this->input->post('mail',true);
		$email = (is_array($mail)) ?  implode('@',$mail) : null;
		
		$tel = $this->input->post('tel',true);
		$tel = (is_array($tel)) ?  implode('-',$tel) : null;

		$organ = $this->input->post('organ',true);
		$country = $this->input->post('country',true);
		$city = $this->input->post('city',true);
		$position = $this->input->post('position',true);
		$keywords = $this->input->post('keywords',true);
		$summary = $this->input->post('summary',true);
		$description = $this->input->post('description',true);
		$advantages = $this->input->post('advantages',true);
		$attache_file1 = $this->input->post('attache_file1',true);
		$ipr_status = $this->input->post('ipr_status',true);
		$stage_of_develop = $this->input->post('stage_of_develop',true);
		$partner_sought = $this->input->post('partner_sought',true);

		$config['table'] = 'thd_tech_matching';
		$config['dbjob'] = $dbjob;
			
		$msg = '저장되었습니다.';
		$config['data'] = array(
				'language' => $this->language ,
				'title' => $title ,
				'name' => $name ,
				'email' => $email ,
				'tel' => $tel ,
				'organ' => $organ ,
				'country' => $country ,
				'city' => $city ,
				'position' => $position,
				'keywords' => $keywords,			
				'summary' => $summary ,
				'description' => $description ,
				'advantages' => $advantages ,
				'attache_file1' => $attache_file1,
				'ipr_status' => $ipr_status ,
				'stage_of_develop' => $stage_of_develop ,
				'partner_sought' => $partner_sought ,
				'approval' => '00',
				'reg_date' => date("Y-m-d H:i",time())
		);
		
		$this->common_model->common_dbjob($config);
		jalert($msg, base_url('/'.$this->language.'/front/html/match_write'));
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
			echo '<script>parent.fileAdd('.$fidx.',\''.$fv.'\')</script>';
		}else if($this->input->post("file_info")){ //삭제
			$arr = explode('|',$this->input->post("file_info"));
			if(file_exists($arr[2])) unlink($arr[2]);
			
			if($thumb_size){ //썸네일삭제
				$_t = explode('.',$arr[0]);
				$thumb_path = $upload_path.'/'.$_t[0].'_thumb.'.$_t[1];
				if(file_exists($thumb_path)) unlink($thumb_path);
			}
			
			echo '<script>parent.fildDeleteDone('.$fidx.')</script>';
		}else{
			echo '<script>alert("첨부된 파일이 없습니다.")</script>';
		}
		exit;	
	}

	public function newsletter_dbjob(){
		$msg = '';
		$dbjob = $this->input->post('dbjob',true);
		$name = $this->input->post('name',true);
		$mail = $this->input->post('mail',true);
		$email = (is_array($mail)) ?  implode('@',$mail) : null;
		$organ = $this->input->post('organ',true);
		$config['table'] = 'thd_newsletter';
		$config['dbjob'] = $dbjob;
		$_POST['email'] = $email;
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', '＊이메일', 'required|valid_email|is_unique[thd_newsletter.email]');
		
		if ($this->form_validation->run() == FALSE){
			jalert('이미 등록된 이메일 주소 또는 주소형식 오류 입니다.', '','');
		}else{
			$msg = '저장되었습니다.';
			$config['data'] = array(
					'language' => $this->language ,
					'name' => $name ,
					'email' => $email ,
					'organ' => $organ ,
					'reg_date' => date("Y-m-d H:i",time())
			);
			
			$this->common_model->common_dbjob($config);
			jalert($msg, $this->input->server('HTTP_REFERER'),'parent');
		}
	}
}
