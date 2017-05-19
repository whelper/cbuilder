<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class board_model extends CI_Model {
	private $menu_id; //게시판 고유번호
	private $id; //게시물 고유번호
	
	function __construct(){
		//parent::__construct();
	}
	
	/*조건별 전체게시물*/	
	function board_all($arr){
		$listnum = (array_key_exists('list_cnt',$arr)) ? $arr['list_cnt'] : 10;
		$offset = 0;	
		if(array_key_exists('where',$arr)) $this->db->where($arr['where']);
		$this->db->order_by('notice DESC, ref_id DESC , ansnum');
		$query = $this->db->get('thd_board',$listnum,$offset);
		//echo $this->db->last_query();
		return $query;
	}
		
		
	/**
	 * 게시물 총갯수
	 *
	 * @access	public
	 * @return	integer
	 */
	function list_total($param){
		$this->list_where($param);
		$count = $this->db->count_all_results('thd_board');
		//echo $this->db->last_query();
		return $count;
	}
	
	/**
	 * 게시판 검색조건
	 *
	 * @access	public
	 * @return	query where절 구문
	 */
	function list_where($param){
		
		if(!isset($param['cate'])) $param['cate'] = null;
		if(!isset($param['sch_keyname'])) $param['sch_keyname'] = null;
		if(!isset($param['sch_keyword'])) $param['sch_keyword'] = null;
		
		$_where[] = " menu_id IN({$param['menu_id']}) AND language IN('{$param['language']}') ";				
		//키워드
		if($param['sch_keyname'] && $param['sch_keyword']){
			$array_keyname = explode(',',$param['sch_keyname']);
			foreach($array_keyname as $key){
				$_where[] = "{$key} LIKE '%{$param['sch_keyword']}%'";
			}
		}

		if($param['cate']){
			$_where[] = "cate='".$param['cate']."'";
		}
		
		$where = '';
		if(is_array($_where)){
			$where .= implode(' AND ', $_where);
		}

		//return  $this->db->where(array('menu_id'=>$param['id']));
		return ($where) ? $this->db->where(trim($where)) : null;
	}
	
	
	/**
	 * 게시판 리스트
	 *
	 * @access	public
	 * @return	result
	 */
	function board_list($param){
		$page = (is_array($param)) ? $param['page'] : 1 ;
		$listnum = $param['config']['list_cnt'];
		$offset = $listnum*($page-1);	
		$this->list_where($param);
		$this->db->order_by('notice DESC, ref_id DESC , ansnum');
		$query = $this->db->get('thd_board',$listnum,$offset);
		//echo $this->db->last_query();
		return $query;
	}
	
	/**
	 * 게시판 뷰
	 *
	 * @access	public
	 * @return	result
	 */
	function board_view($param){
		$this->db->where(array('id'=> $param['id']));
		$query = $this->db->get('thd_board');
		//echo $this->db->last_query();
		return $query;
	}
	

	function board_select($arr){
		if(is_array($arr)){
			$this->db->select("*");
			$this->db->where($arr);
			$query = $this->db->get('thd_board');
			//echo $this->db->last_query();
			$row = $query->row_array();
			$data = $row;
		}else{
			$fields = $this->db->list_fields('thd_board');
			foreach ($fields as $field){
			   $data[$field] = null;
			}
		}
		return $data;
	}


	/**
	 * 게시판 이전,다음글
	 *
	 * @access	public
	 * @return	result
	 */
	function board_other_view($param){
		$this->db->where($param['other']);
		$this->db->order_by($param['orderby']);
		$query = $this->db->get($param['board_name'],1);
		//echo $this->db->last_query();
		return $query;
	}
	

	/**
	 * 게시판 댓글
	 *
	 * @access	public
	 * @return	result
	 */
	function board_comment_list($param){
		$this->db->where(array('board_id'=> $param['no'],'menu_id'=>$param['menu_id']));
		$this->db->order_by('id ASC');
		$query = $this->db->get('thd_board_comment');
		//echo $this->db->last_query();
		return $query;
	}
	
	/**
	 * 게시판 댓글 내용 조회
	 *
	 * @access	public
	 * @return	result
	 */
	function board_comment_view(){
		$menu_id = $this->input->post("menu_id",true);
		$no = $this->input->post("no",true);
		$this->db->where(array('id'=>$no));
		$query = $this->db->get('thd_board_comment_'.$menu_id);
		//echo $this->db->last_query();
		$data = null;
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$data['b_comment'] = $row['b_comment']; 
		}
		return $data;
	}
	
	/**
	 * 게시판 조회수 처리
	 *
	 * @access	public
	 * @return	void
	 */
	function board_counter($param){
		$sql = 'UPDATE thd_board SET view_count=view_count+1 WHERE id='.$param['id'];
		$this->db->query($sql);
	}
	
	/**
	 * 게시판 DB 처리
	 *
	 * @access	public
	 * @return	integer
	 */
	function board_dbjob($data){
		$dbjob = $this->input->post('dbjob');
		$ref_id = $this->input->post('ref_id');
		$depth = $this->input->post('depth');
		$ansnum = $this->input->post('ansnum');
		
		$menu_id = $this->input->post('menu_id');
		$no = ($this->input->post('no')) ? $this->input->post('no') : $this->input->post('id');
		$board_name = 'thd_board';
		switch($dbjob){
			case('i'):
				$this->db->select_max('id');
				$query = $this->db->get($board_name);
				$row = $query->row_array();
				$no = is_null($row['id']) ? 1 : $row['id']+1;
				$data = array_merge($data,array('id'=> $no,'ref_id'=> $no));
				$this->db->insert($board_name, $data);
			break;
			case('r'):
				$this->db->where(array('ref_id'=>$ref_id,'depth > '=> $depth));
				$this->db->update($board_name,array('ansnum'=>'ansnum+1'));
				
				$this->db->select_max('id');
				$query = $this->db->get($board_name);
				$row = $query->row_array();
				$no = is_null($row['id']) ? 1 : $row['id']+1;
				$data = array_merge($data,array('id'=> $no,'ref_id'=>$ref_id,'depth'=> $depth+1,'ansnum'=> $ansnum+1));
				$this->db->insert($board_name, $data);
			break;	
			case('u'):
				$this->db->where('id',$no);
				$this->db->update($board_name,$data);
			break;
			case('d'):
				//파일 삭제
				$this->db->where(array('menu_id' => $menu_id, 'board_no' => $no));
				$this->db->delete('thd_upload_file');
				
				//댓글 삭제
				$comment_board_name = 'thd_board_comment_'.$no;
				if($this->db->table_exists($comment_board_name)){
					$this->db->where('board_no',$no);
					$this->db->delete($comment_board_name);
				}
				
				$this->db->where('id', $no);
				$this->db->delete($board_name);
			break;
		}
		$this->id = $no; //게시물 번호
		//echo $this->db->last_query();
		return true;
	}
	
	/**
	 * 게시판 댓글 DB 처리
	 *
	 * @access	public
	 * @return	boolean
	 */
	function board_comment_dbjob($data){
		$dbjob = $this->input->post('dbjob');
		$menu_id = $this->input->post('menu_id');
		$id = $this->input->post('no');
		$board_name = 'thd_board_comment';
		
		switch($dbjob){
			case('i'):
				$this->db->insert($board_name, $data);
				break;
			case('u'):
				$this->db->where('id',$id);
				$this->db->update($board_name,$data);
				break;
			case('d'):
				$this->db->where('id', $id);
				$this->db->delete($board_name,$data);
				break;
		}
		return true;
	}
	
	/**
	 * 게시판 파일 처리
	 *
	 * @access	public
	 * @return	integer
	 */
	function board_file($file){
		$dbjob = $this->input->post('dbjob');
		$menu_id = $this->input->post('menu_id');
		$fdelete = $this->input->post('fdelete');
		
		if($dbjob == 'd'){ //게시물 삭제
			$this->db->where(array('menu_id'=>$menu_id,'board_no'=>$this->id));
			$query = $this->db->get('thd_upload_file');
			foreach($query->result() as $row){
				@unlink(convert_path($row->file_path.$row->file_name));
			}
			return true;
		}
		
		if(is_array($file)){
			foreach($file as $k => $v){
				$this->db->where(array('menu_id'=>$menu_id,'board_no'=>$this->id,'order_no'=>$k));
				$query = $this->db->get('thd_upload_file');
				//echo $this->db->last_query();
				if($query->num_rows() > 0){
					$row = $query->row_array();
	
					$is_delete = false; //파일 삭제 체크 여부
					if(is_array($fdelete)){
						foreach($fdelete as $kk => $vv){
							if($vv == $k){
								@unlink(convert_path($row['file_path'].$row['file_name']));
								$is_delete = true;
								break;
							}
						}
					}
					
					if($is_delete){
						$this->db->where(array('menu_id' => $menu_id, 'board_no' => $this->id, 'order_no'=>$k));
						$this->db->delete('thd_upload_file');
					}
					
					if($file[$k]['file_name']){
						$this->db->where(array('menu_id' => $menu_id, 'board_no' => $this->id, 'order_no'=>$k));
						$data = array(
									'file_name' => $file[$k]['file_name'],
									'file_orinal' => $file[$k]['orig_name'],
									'file_type' => $file[$k]['file_type'],
									'file_size' => $file[$k]['file_size'],
									'file_path' => $file[$k]['file_path']
								);
						$this->db->update('thd_upload_file',$data);
					}
				}else if($file[$k]['file_name']){
					$data = array(
							'menu_id' => $menu_id,
							'board_no' => $this->id,
							'file_name' => $file[$k]['file_name'],
							'file_orinal' => $file[$k]['orig_name'],
							'file_type' => $file[$k]['file_type'],
							'file_size' => $file[$k]['file_size'],
							'file_path' => $file[$k]['file_path'],
							'order_no' => $k
					);
			
					$this->db->insert('thd_upload_file', $data);
				}
			}
		} // end if
		return true;
	}
	
	/**
	 * 게시판 파일 리스트 조회
	 *
	 * @access	public
	 * @return	result
	 */
	function board_file_list($param){
		$this->db->where(array('menu_id'=> $param['menu_id'],'board_no'=> $param['board_no']));
		$this->db->order_by('order_no ASC');
		$query = $this->db->get('thd_upload_file');
		//echo $this->db->last_query();
		return $query;
	}
	
	/**
	 * 게시판 파일 조회
	 *
	 * @access	public
	 * @return	result
	 */
	function board_file_select($param){
		$this->db->where(array('menu_id'=> $param['menu_id'],'board_no'=> $param['board_no'],'order_no'=> $param['order_no']));
		$query = $this->db->get('thd_upload_file');
		//echo $this->db->last_query();
		return $query;
	}


	/**
	 * 게시판 통합 조회
	 *
	 * @access	public
	 * @return	result
	 */
	function board_merge_list($param){
		$list_cnt = (isset($param['list_cnt'])) ? $param['list_cnt'] : 5;
		$sql = "SELECT menu_id,title FROM thd_config_contents WHERE page_type IN('BOARD') ORDER BY menu_id";
		$query = $this->db->query($sql);
		foreach($query->result() as $row){
			$menu_id[] = $row->menu_id;
		}
		$query->free_result();

		if(is_array($menu_id)) $this->db->where('menu_id IN('.implode(',',$menu_id).')');
		$this->db->order_by('register_date ASC');
		$this->db->select('* ,(SELECT title FROM thd_config_contents WHERE menu_id=thd_board.menu_id) AS menu_title');
		$this->db->limit($list_cnt);
		$query = $this->db->get('thd_board');
		//echo $this->db->last_query();
		return $query;
		
	}
	
	/**
	 * 자료실 비밀번호
	 *
	 * @access	public
	 * @return	result
	 */
	
	function board_auth($where){
		$this->db->limit(1);
		$this->db->where($where);
		$query = $this->db->get('thd_board');
		
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$data = $row;
		}else{
			$fields = $this->db->list_fields('thd_board');
			foreach ($fields as $field){
			   $data[$field] = null;
			}
		}
		
		/*$this->db->limit(1);
		$query = $this->db->get('thd_board_auth');
		
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$data = $row;
		}else{
			$fields = $this->db->list_fields('thd_board_auth');
			foreach ($fields as $field){
			   $data[$field] = null;
			}
		}*/
		return $data;
	}

	function board_auth_dbjob($data){
		$dbjob = $this->input->post('dbjob');
		$menu_id = $this->input->post('menu_id');
		switch($dbjob){
			case('i'):
				$this->db->insert('thd_board_auth', $data);
			break;
			case('u'):
				$this->db->where('menu_id', $menu_id);
				$this->db->update('thd_board_auth',$data);
			break;
		
		}
		//echo $this->db->last_query();
	}
}
?>