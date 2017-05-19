<?php
class THD_Board extends CI_Model{
	private $outter;
	private $table_name;
	private $skin_list;
	private $skin_write;
	private $skin_view;
	private $skin_passwd;
	private $config;
	private $theme_skin;
	private $language;
	private $CI;

	
	function __construct($param) {	
		 
		$this->config = $param['config'];
		$this->table_name = $param['table_name'];
		$this->load->model('board_model');
		
		if(!array_key_exists('mobile',$param)){
			$param['mobile'] = 'N';
		}
		
		$CI =& get_instance();
		$this->CI = $CI;
		$this->language = $param['language'];
		$this->theme_skin = '/theme/'.$CI->config->item('theme').'/'.$param['language'].$param['folder'].'/board/'.$param['skin'];
		$skin = ($param['mobile'] == 'Y') ? 'skin_mobile.html' : 'skin.html';	
		$sval = file_get_contents(convert_path('/theme/'.$CI->config->item('theme').'/'.$param['language'].$param['folder'].'/board/'.$param['skin'].'/'.$skin));
		list($sval,$this->skin_list) = $this->cutSkinTag($sval,'board_list');
		list($sval,$this->skin_write) = $this->cutSkinTag($sval,'templ_write');
		list($sval,$this->skin_view) = $this->cutSkinTag($sval,'templ_view');
		list($sval,$this->skin_passwd) = $this->cutSkinTag($sval,'templ_passwd');
		$this->outter =  $sval;
		
	}
	
	function getOutter(){
		return $this->outter;
	}
	
	//@스킨에서 특정범위 태그 배열로 가져오기
	function cutSkinTag($contents,$tag,$replace=null){
		if(is_null($replace)){
			$replace="[##_{$tag}_##]";
		}
		$tagSize=strlen($tag)+4;
		$begin=strpos($contents,"<s_$tag>");
		if($begin===false)
			return array($contents,NULL);
		$end=strpos($contents,"</s_$tag>",$begin+4);
		if($end===false)
			return array($contents,NULL);
		$inner=substr($contents,$begin+$tagSize,$end-$begin-$tagSize);
		$outter=substr($contents,0,$begin).$replace.substr($contents,$end+$tagSize+1);
		return array($outter,$inner);
	}
	
	//@tag replace
	function dress($tag,$value,&$contents){
		if(preg_match("@\\[##_{$tag}_##\\]@iU",$contents)){
			$contents=str_replace("[##_{$tag}_##]",$value,$contents);
			return true;
		}else{
	
			return false;
		}
	}
	
	/**
	 * tag clean up
	 *
	 * @access	public
	 * @param   template
	 * @return	string
	 */
	function removeAllTags($contents){
		$contents=preg_replace('/\[#M_[^|]*\|[^|]*\|/Us','',str_replace('_M#]','',preg_replace('/\[##_.+_##\]/Us','',$contents)));
		$contents=preg_replace('@(<s_|</s_)[0-1a-zA-Z_]+>@','',$contents);
		return $contents;
	}
	
	/**
	 * 선택 태그범위 지움
	 *
	 * @access	public
	 * @param   tag,value,template
	 * @return	string
	 */
	function removeTagSelected($tag,$value,$content){
		//$tag = "button_1";
		$tagSize=strlen($tag)+4;
		$begin=strpos($content,"<s_$tag>");
		$end=strpos($content,"</s_$tag>",$begin+4);
		if($begin)
			return str_replace(substr($content,$begin+$tagSize,$end-$begin-$tagSize),$value,$content);
		else
			return $content;
	}
	
	/**
	 * 선택 태그범위 가져오기
	 *
	 * @access	public
	 * @param   tag,template
	 * @return	string
	 */
	function getTagSelected($tag,$content){
		//$tag = "button_1";
		$tagSize=strlen($tag)+4;
		$begin=strpos($content,"<s_$tag>");
		$end=strpos($content,"</s_$tag>",$begin+4);
		if($begin)
			return substr($content,$begin+$tagSize,$end-$begin-$tagSize);
		else
			return $content;
	}
	
	/**
	 * 게시판 목록
	 *
	 * @access	public
	 * @return	buffer
	 */
	function boardList($param){
		$view='';
		
		$param = array_merge($param,array('config'=>$this->config));
		$json = json_decode($param['config']['settings'],true);
		
		$list_cnt = $json['list_cnt'];
		if($json['board_type'] == 2){ //갤러리
			$list_cnt = ceil($json['cols']) * ceil($json['rows']);
		}
		if(!$list_cnt) $list_cnt = $param['config']['list_cnt'];
		$param['config']['list_cnt'] = $list_cnt; 

		$query = $this->board_model->board_list($param);
		$list_no = $param['count'] - $param['config']['list_cnt']*($param['page']-1); //게시물 넘버링
		
		$querystring = null;
		$querystring .= ($param['cate']) ? '/cate/'.urlencode($param['cate']) : null;

		$view_url = (array_key_exists('view_url',$param)) ? $param['view_url'] : '/front/board/view'; 
		if($query->result()){
			ob_start(); //출력버퍼시작
			foreach ($query->result() as $row)
			{
				$view = $this->skin_list;
				$replyCss = null;
				$replyIcon = null;
				if($row->depth > 0){ 
					$replyCss = "reply".$row->depth;
					$replyIcon = '<img src="'.$this->theme_skin.'/images/icon_re.gif"  />';
				}
				
				$ext_image = array('jpg','jpeg','gif','png');

				$query_file = $this->board_model->board_file_list(array('menu_id'=>$param['menu_id'],'board_no'=>$row->id));
				if($query_file->num_rows() > 0){
					$this->dress('brd_list_icon_file','<img src="'.$this->theme_skin.'/images/file.gif" alt="첨부"  />' ,$view);
					foreach ($query_file->result() as $frow){
						//$ext = preg_replace('/^.*\.([^.]+)$/D', '$1', $frow->file_name);
						$fileinfo = pathinfo($frow->file_name);
						$ext = $fileinfo['extension'];
						if(in_array($ext,$ext_image)){
							$thumb = $fileinfo['filename'].'_thumb.'.$fileinfo['extension'];
							if(file_exists($frow->file_path.$thumb)){
								$this->dress('brd_list_thumb','<img src="/upload/board/'.$frow->board_no.'/'.$thumb.'">' ,$view);
							}else{
								$this->dress('brd_list_thumb','<img src="/upload/board/'.$frow->board_no.'/'.$frow->file_name.'">' ,$view);
							}
						}else{
							$this->dress('brd_list_thumb','' ,$view);
						}

						
						$attach_file = $frow->file_path.$frow->file_name;
						$download_link = '/board/download/id/'.$frow->menu_id.'/no/'.$frow->board_no.'/order/'.$frow->order_no;
						$this->dress('brd_list_down_file','<a href="'.$download_link.'" class="ico add-file">첨부파일</a>' ,$view);
						break;
					}	
				}
				
		
				if(strtotime($row->register_date) >= (time() - (24 * 3600)*7)) {
					$this->dress('brd_list_new','<img src="'.$this->theme_skin.'/images/new.gif" alt="new"  />' ,$view);
				}
				
				//게시물번호				
				if($row->notice > 0){
					$num = '공지';
					$this->dress('brd_list_notice','notice' ,$view);	
				}else{
					$num = $list_no;
					$this->dress('brd_list_notice','' ,$view);
				} 

				
				//비밀글
				if($json['secret_yn'] == 'Y'){
					$this->dress('brd_css_lock','lock' ,$view);	
					$this->dress('brd_list_lock','<img src="'.$this->theme_skin.'/images/icon_lock.png" class="board-icon-lock" />' ,$view);	

				}
				
				$this->dress('brd_list_cate',$row->cate ,$view);			
				$this->dress('brd_list_icon_reply',$replyIcon ,$view);
				$this->dress('brd_list_css_reply',$replyCss,$view);
				$this->dress('brd_list_no',$num,$view);
				$this->dress('brd_list_title',character_limiter($row->title,$param['config']['limit_title']),$view);
				$this->dress('brd_list_content',$row->content,$view);
				$this->dress('brd_list_writer',$row->writer,$view);
				$this->dress('brd_list_view_link',$view_url.'/id/'.$param['menu_id'].'/no/'.$row->id.$querystring,$view);
				$this->dress('brd_list_date',date('Y.m.d',strtotime($row->register_date)),$view);
				$this->dress('brd_list_visited',$row->view_count,$view);
				$list_no--;
				print $view;
				
			}
			$view = ob_get_contents(); //출력버퍼내용
			ob_end_clean(); //출력버퍼내용 초기화
		}
			
		return $view;
	}
	
	/**
	 * 게시판 쓰기
	 *
	 * @access	public
	 * @return	buffer
	 */
	function boardWrite($param){
		
		$dbjob = ($this->input->post('dbjob')) ? $this->input->post('dbjob') : 'i'; 
		

		ob_start(); //출력버퍼시작
		$view = $this->skin_write;
		if($dbjob == 'u'){
			$view =$this->removeTagSelected('no_passwd','',$view);
		}
		//google rechptch 코드	
		$this->dress('google_recaptcha_sitekey',$this->CI->config->item('google_recaptcha_sitekey'),$view);

		$this->dress('skin_name',$this->config['board_skin'],$view);
		$this->dress('hidden_dbjob',$dbjob,$view);
		$this->dress('hidden_id',$param['menu_id'],$view);
		$this->dress('hidden_no',$param['id'],$view);
		$this->dress('hidden_board_name',$param['board_name'],$view);
		$this->dress('ckeditor',display_ckeditor($param['_ckeditor']),$view);
		
		$query = $this->board_model->board_view($param);
		if($query->num_rows() > 0){
			$row = $query->row_array();
			
			$this->dress('hidden_ref_id',$row['ref_id'],$view);
			$this->dress('hidden_depth',$row['depth'],$view);
			$this->dress('hidden_ansnum',$row['ansnum'],$view);
			
			$this->dress('title',$row['title'],$view);
			if($dbjob == 'u'){
				$this->dress('writer',$row['writer'],$view);
				$this->dress('content',$row['content'],$view);
				
				$query = $this->board_model->board_file_list(array('menu_id'=>$param['menu_id'],'board_no'=>$param['id']));
				$view_file = null;
				$_fnum = 0;
				foreach ($query->result() as $row){
					$this->dress('file_info'.($_fnum+1),'<span style="font-size:9pt;"><input type="checkbox" name="fdelete[]" value="'.$_fnum.'" /> 삭제</span> ',$view);
					$_fnum++;
				}
				$query->free_result(); //free result
			}
		}else{
			//로그인된 경우
			$this->dress('writer',$this->session->userdata('username'),$view);
		}
		
		print $view;
		$view=ob_get_contents(); //출력버퍼내용
		ob_end_clean(); //출력버퍼내용 초기화
		return $view;
		
	}
	
	/**
	 * 게시판 상세
	 *
	 * @access	public
	 * @return	result
	 */
	function boardView($param){
		
		$msg = ($this->language == 'en') ? 'No authority': '읽기 권한이 없습니다.';
		
		if($param['auth_view'] > $this->session->userdata('membership')){
			$this->alert->jalert($msg, '','back');
			exit;
		}
		
		//임시 비밀글 연동
		if($param['secret_yn'] == 'Y'){
			/*$data = $this->board_model->board_auth();			
			if($data['passwd'] != $this->session->userdata('board_auth_passwd')){
				$this->alert->jalert($msg, '/front/board/passwd/id/'.$param['menu_id'].'/no/'.$param['id'],'link');
				exit;
			}*/
			//비밀글 세션체크

			if($this->session->userdata('brdNo') != $param['id'] || $this->session->userdata('brdId') != $param['menu_id']){
				$this->alert->jalert($msg, '','back');
				exit;
			}
		}

	
		//게시물 내용
		$this->board_model->board_counter(array('id'=>$param['id'],'board_name'=>$this->table_name));
		$query_prev = $this->board_model->board_other_view(array('other'=>array('id > '=> $param['id'],'menu_id'=>$param['menu_id']),'orderby'=>'id','board_name'=>$this->table_name));
		$query_next = $this->board_model->board_other_view(array('other'=>array('id < '=> $param['id'],'menu_id'=>$param['menu_id']),'orderby'=>'id DESC','board_name'=>$this->table_name));
		
		$query = $this->board_model->board_view(array('id'=>$param['id'],'board_name'=>$this->table_name,'page'=>$param['page']));
		$row = $query->row_array();
		$query->free_result();  //free result
		
		ob_start(); //출력버퍼시작
		$view = $this->skin_view;
		$this->dress('theme_skin',$this->theme_skin,$view);
		$this->dress('skin_name',$this->config['board_skin'],$view);
		$this->dress('hidden_id',$param['menu_id'],$view);
		$this->dress('hidden_no',$param['id'],$view);
		$this->dress('hidden_board_name',$param['board_name'],$view);
		
		$this->dress('view_writer',$row['writer'],$view);
		$this->dress('view_cate',$row['cate'],$view);
		$this->dress('view_title',$row['title'],$view);
		$this->dress('view_date',substr($row['register_date'],0,10),$view);
		$this->dress('view_content',$row['content'],$view);
		$this->dress('view_visited',$row['view_count'],$view);
		
		$this->dress('menu_id',$param['menu_id'],$view);
		$this->dress('board_no',$param['id'],$view);
		
		$this->dress('user_id',$this->session->userdata('userid'),$view);
		$this->dress('user_name',$this->session->userdata('username'),$view);

		//수정/삭제 버튼
		if(($param['auth_write'] > $this->session->userdata('membership') || $row['auth_uid'] != $this->session->userdata('userid')) && $this->session->userdata('membership') !=10){
			$view = $this->removeTagSelected('btn_modify','',$view);
			$view = $this->removeTagSelected('btn_delete','',$view);
		}
		
		//답변 버튼
		if($param['auth_reply'] > $this->session->userdata('membership')){
			$view = $this->removeTagSelected('btn_reply','',$view);
		}
		
		$querystring = null;
		$querystring .= ($param['cate']) ? '/cate/'.urlencode($param['cate']) : null;

		//이전글
		if($query_prev->num_rows() > 0){
			$prev = $query_prev->row_array();
			$query_prev->free_result();  //free result
			$this->dress('view_prev_link','/front/board/view/id/'.$param['menu_id'].'/no/'.$prev['id'].$querystring,$view);
			$this->dress('view_prev_title',$prev['title'],$view);
			$this->dress('view_prev_writer',$prev['writer'],$view);
			$this->dress('view_prev_date',substr($prev['register_date'],0,10),$view);
		}else{
			$this->dress('view_prev_link','javascript:void(0);',$view);
			$this->dress('view_prev_title','이전글이 없습니다.',$view);
		}
		//다음글
		if($query_next->num_rows() > 0){
			$next = $query_next->row_array();
			$query_next->free_result();  //free result
			$this->dress('view_next_link','/front/board/view/id/'.$param['menu_id'].'/no/'.$next['id'].$querystring,$view);
			$this->dress('view_next_title',$next['title'],$view);
			$this->dress('view_next_writer',$next['writer'],$view);
			$this->dress('view_next_date',substr($next['register_date'],0,10),$view);
		}else{
			$this->dress('view_next_link','javascript:void(0);',$view);
			$this->dress('view_next_title','다음글이 없습니다.',$view);
		}
		
		//첨부파일
		$query = $this->board_model->board_file_list(array('menu_id'=>$param['menu_id'],'board_no'=>$param['id']));
		$view_file = null;
		$view_image = null; //내용부분에 이미지 표시
		foreach ($query->result() as $row){
			$attach_file = $row->file_path.$row->file_name;
			if(preg_match('/[gif|jpe?g|png]/',$row->file_name) && file_exists($attach_file)){
				$width = null;
				$image_attr = getImageSize($attach_file);
				if(is_array($image_attr)){
					$width = ($image_attr[0] > 700) ? 700 : $image_attr[0]; //이미지 사이즈 700px 고정
					$width = 'width="'.$width.'"';
				}
				$view_image .= "<p style=\"text-align:center;\"><img src=\"/upload/board/".$row->menu_id."/".$row->file_name."\" {$width} /></p>\n";
			}	

			$download_link = '/board/download/id/'.$row->menu_id.'/no/'.$row->board_no.'/order/'.$row->order_no;
			$view_file .= '<dd><a href="'.$download_link.'">'.$row->file_orinal.'</a></dd>';  
		}
		if(!$view_file) $view_file = '<dd>&nbsp;</dd>';
	
		$query->free_result(); //free result
		$this->dress('view_file',$view_file,$view);
		$this->dress('view_image',$view_image,$view);
		
		//목록
		$this->dress('link_list','/front/board/list/id/'.$param['menu_id'].$querystring,$view);


		//댓글
		$query = $this->CI->board_model->board_comment_list(array('no'=>$param['id'],'menu_id'=>$param['menu_id']));
		$comment = '';
		foreach ($query->result() as $row){
			$comment .= $this->getTagSelected('comment_list',$view);
			if($row->user_id != $this->session->userdata('userid') && $this->session->userdata('admin_yn') <> 'Y'){ //본인글만 삭제
				$comment = $this->removeTagSelected('comment_delete','',$comment);
			}
			$this->dress('comment_no',$row->id,$comment);
			$this->dress('comment_name',$row->name,$comment);
			$this->dress('comment_date',substr($row->register_date,0,10),$comment);
			$this->dress('comment_content',nl2br(stripslashes($row->b_comment)),$comment);
			
			
		}

		$query->free_result(); //free result
		
		$view = $this->removeTagSelected('comment_list',$comment,$view);
		
		if($param['auth_comment'] > $this->session->userdata('membership')){
			if($param['auth_comment'] == 10){ //관리자 전용
				$view = $this->removeTagSelected('comment','',$view);	
			}else{
				$this->dress('comment_disabled','disabled',$view);
				$this->dress('comment_disabled_message','로그인후 입력 가능합니다.',$view);
			}
		}
		
					
		print $view;
		$view=ob_get_contents(); //출력버퍼내용
		ob_end_clean(); //출력버퍼내용 초기화
		return $view;
	
	}

	function boardPasswd($param){
		ob_start(); //출력버퍼시작
		$view = $this->skin_passwd;
		$this->dress('hidden_id',$param['menu_id'],$view);
		$this->dress('hidden_no',$param['id'],$view);
		print $view;
		$view=ob_get_contents(); //출력버퍼내용
		ob_end_clean(); //출력버퍼내용 초기화
		return $view;
	}
}
?>