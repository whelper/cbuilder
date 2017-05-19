<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Member_model extends CI_Model {
	//모델 생성자 호출
	function __construct(){
		parent::__construct();
		$this->load->helper('file');
		$this->load->library('encrypt');
	}
	
	/**
	 * 회원 내용 조회
	 *
	 * @access	public
	 * @return	array
	 */
	function select_member($id){
		$this->db->select("*");
	  	$this->db->where('seq', $id);
	  	$query = $this->db->get('thd_member');
		//echo $this->db->last_query();
		$row = $query->row_array();
		if($row){
			$data = $row;
		}else{
			$fields = $this->db->list_fields('thd_member');
			foreach ($fields as $field){
			   $data[$field] = null;
			}
	  	}
	  	return $data;
	}
	
	/**
	 * 회원 검색조건
	 *
	 * @access	public
	 * @return	query where절 구문
	 */
	function list_where($param){
		$_where = null;
		$where = null;
		$_where[] = "user_id !='admin'"; //default 관리자 제외

		if(is_array($param)){

			if(!isset($param['sthd_keyname'])) $param['sthd_keyname'] = null;
			if(!isset($param['sthd_keyword'])) $param['sthd_keyword'] = null;
			if(!isset($param['sthd_gender'])) $param['sthd_gender'] = null;
			if(!isset($param['sthd_birth_start'])) $param['sthd_birth_start'] = null;
			if(!isset($param['sthd_birth_end'])) $param['sthd_birth_end'] = null;
			if(!isset($param['sthd_reg_start'])) $param['sthd_reg_start'] = null;
			if(!isset($param['sthd_reg_end'])) $param['sthd_reg_end'] = null;
				
			//키워드
			if($param['sthd_keyname'] && $param['sthd_keyword']){
				$array_keyname = explode(',',$param['sthd_keyname']);
				foreach($array_keyname as $key){
					$_where[] = "{$key} LIKE '%{$param['sthd_keyword']}%'";
				}
			}
			//성별
			if($param['sthd_gender']) $_where[] = " gender in('{$param['sthd_gender']}')";
			//생년월일
			if($param['sthd_birth_start'] || $param['sthd_birth_end']){
				if($param['sthd_birth_start'] && $param['sthd_birth_end']){
					$_where[] = " (birth_date BETWEEN '{$param['sthd_birth_start']}' AND '{$param['sthd_birth_end']}') ";
				}else if($param['sthd_birth_start']){
					$_where[] = " birth_date >= '{$param['sthd_birth_start']}' ";
				}else if($param['sthd_birth_end']){
					$_where[] = " birth_date <= '{$param['sthd_birth_end']}' ";
				}		
			}
			//등록일
			
			if($param['sthd_reg_start'] || $param['sthd_reg_end']){
				if($param['sthd_reg_start'] && $param['sthd_reg_end']){
					$_where[] = " (reg_date BETWEEN '{$param['sthd_reg_start']}' AND '{$param['sthd_reg_end']}') ";
				}else if($param['sthd_reg_start']){
					$_where[] = " reg_date >= '{$param['sthd_reg_start']}' ";
				}else if($param['sthd_reg_end']){
					$_where[] = " reg_date <= '{$param['sthd_reg_end']}' ";
				}		
			}
		}
		
		if(is_array($_where)){
			$where = implode(' OR ', $_where);
		}
			
		return ($where) ? $this->db->where(trim($where)) : null; 
	}
	
	/**
	 * 회원 총갯수
	 *
	 * @access	public
	 * @return	integer
	 */
	function list_total($arr=null,$table = 'thd_member' ){
		//$this->list_where($arr);
		$this->db->where($arr,null,false);
		$count = $this->db->count_all_results($table);
		//echo $this->db->last_query();
		return $count;
	}
	
	/**
	 * 회원 리스트
	 *
	 * @access	public
	 * @return	result
	 */
	function member_list($arr){
		$page = ($this->input->get("page",true)) ? $this->input->get("page",true) : 1;
		$listnum = ($this->config->item('thd_listnum')) ? $this->config->item('thd_listnum') : 10;
		$offset = $listnum*($page-1);
		if($arr) $this->db->where($arr,null,false);
		$this->db->select('* ',false);
		$this->db->order_by('seq DESC');
		$query = $this->db->get('thd_member',$listnum,$offset);
		//echo $this->db->last_query();
		return $query;
	}

	function member_all($arr){
		if($arr) $this->db->where($arr,null,false);
		$this->db->order_by('seq DESC');
		$query = $this->db->get('thd_member');
		//echo $this->db->last_query();
		return $query;
	}

	function customer_all($arr){
		if($arr) $this->db->where($arr,null,false);
		$this->db->order_by('seq DESC');
		$this->db->select(' * ,(SELECT name FROM thd_member WHERE seq=thd_customer.customer_seq) AS name ');
		$query = $this->db->get('thd_customer');
		//echo $this->db->last_query();
		return $query;
	}
	
	function member_leave($arr){
		$page = ($this->input->get("page",true)) ? $this->input->get("page",true) : 1;
		$listnum = ($this->config->item('thd_listnum')) ? $this->config->item('thd_listnum') : 10;
		$offset = $listnum*($page-1);
		if($arr) $this->db->where($arr,null,false);
	
		$query = $this->db->get('thd_member_leave',$listnum,$offset);
		//echo $this->db->last_query();
		return $query;
	}


	function customer_dbjob($data){
		if( $data['seq']){
			switch($data['dbjob']){
			case('d'):
				$this->db->where(array('member_seq' => $data['seq']));
				$this->db->delete('thd_customer');
			break;
			default:
				$cust_input = explode(',',$data['customer']);
				$this->db->where(array('member_seq' => $data['seq']));
				$query = $this->db->get('thd_customer');
				
				$cust_db = array();
				foreach($query->result() as $row){
					$cust_db[] = $row->customer_seq; 
				}
				
				$add = array_diff($cust_input,$cust_db);
				$del = array_diff($cust_db,$cust_input);
				if(sizeof($add) > 0){ //카테고리 등록
					foreach($add as $key => $value){
						$cdata = array('member_seq' => $data['seq'],'customer_seq' =>$value);
						$this->db->insert('thd_customer',$cdata);	
					}

				}

				if(sizeof($del) > 0){ //카테고리 삭제
					foreach($del as $key => $value){
						$this->db->where(array('member_seq' => $data['seq'], 'customer_seq' => $value));
						$this->db->delete('thd_customer');
					}
				}
			
			break;
			}
		}
	}
	
	
	/**
	 * 회원 관리자 메인 리스트
	 *
	 * @access	public
	 * @return	result
	 */
	function list_member_index($param){
		$this->db->where($param);
		$this->db->order_by('id DESC');
		$query = $this->db->get('thd_member',5,0);
		//echo $this->db->last_query();
		return $query->result();
	}
		
	/**
	 * 회원 아이디 유효성검사
	 *
	 * @access	public
	 * @return	integer
	 */
	function valid_userid_total($param){
		$this->db->where($param);
		$count = $this->db->count_all_results('thd_member');
		//echo $this->db->last_query();
		return $count;
	}
	
	/**
	 * 회원 db 처리
	 *
	 * @access	public
	 * @return	integer
	 */
	function member_dbjob($data){
		$seqs= $this->input->post('seqs');
		$dbjob = $this->input->post('dbjob');
		$seq = $this->input->post('seq');
		switch($dbjob){
			case('i'):
				$this->db->insert('thd_member', $data);
				$seq = $this->db->insert_id();
			break;
			case('u'):
				$this->db->where('seq',$seq);
				$this->db->update('thd_member',$data);
			break;
			case('d'):
				$this->db->where('seq', $seq);
				$this->db->delete('thd_member');
				//$result = $this->db->update('thd_member',$data);
			break;
			case('md'):
				$this->db->query('DELETE FROM thd_member WHERE seq IN('.$seqs.')');
			break;
		}
		return $seq;
		//echo $this->db->last_query();
		//exit;
	}
	
	/**
	 * 회원 약관 조회
	 *
	 * @access	public
	 * @return	array
	 */
	function select_member_terms(){
		$this->db->select("*");
		$query = $this->db->get('thd_terms_member');
		//echo $this->db->last_query();
		$row = $query->row_array();
		$data['dbjob'] = 'i';
		$data['id'] = null;
		$data['info_use'] = null;
		$data['info_personal'] = null;
		if($row){
			$data['dbjob'] = 'u';
			$data['id'] = $row['id'];
			$data['info_use'] = $row['info_use'];
			$data['info_personal'] = $row['info_personal'];
		}
		return $data;
	}
	
	/**
	 * 회원약관 db 처리
	 *
	 * @access	public
	 * @return	integer
	 */
	function member_term_dbjob($data){
		$dbjob = $this->input->post('dbjob');
		$id = $this->input->post('id');
		switch($dbjob){
			case('i'):
				$result = $this->db->insert('thd_terms_member', $data);
			break;
			case('u'):
				$this->db->where('id',$id);
				$result = $this->db->update('thd_terms_member',$data);
			break;
		
		}
	}
	
	/**
	 * 탈퇴회원 검색조건
	 *
	 * @access	public
	 * @return	query where절 구문
	 */
	function list_secede_where($param){
		$_where = null;
		$where = null;
		//등록일
		if($param['sthd_reg_start'] || $param['sthd_reg_end']){
			if($param['sthd_reg_start'] && $param['sthd_reg_end']){
				$_where[] = " (reg_date BETWEEN '{$param['sthd_reg_start']}' AND '{$param['sthd_reg_end']}') ";
			}else if($param['sthd_reg_start']){
				$_where[] = " reg_date >= '{$param['sthd_reg_start']}' ";
			}else if($param['sthd_reg_end']){
				$_where[] = " reg_date <= '{$param['sthd_reg_end']}' ";
			}
		}
		
		if(is_array($_where)){
			$where = implode(' OR ', $_where);
		}
		
		return ($where) ? $this->db->where(trim($where)) : null;
	}
	
	/**
	 * 탈퇴회원 총갯수
	 *
	 * @access	public
	 * @return	integer
	 */
	function list_secede_total($param){
		$this->list_secede_where($param);
		$count = $this->db->count_all_results('thd_secede_info');
		return $count;
	}
	
	/**
	 * 금일 탈퇴회원 총갯수
	 *
	 * @access	public
	 * @return	integer
	 */
	function list_secede_today(){
		$this->db->where('datediff(reg_date,now())',0);
		$count = $this->db->count_all_results('thd_secede_info');
		//echo $this->db->last_query();
		return $count;
	}
	
	/**
	 * 탈퇴회원 리스트
	 *
	 * @access	public
	 * @return	result
	 */
	function list_secede_member($param){
		$page = $param['page'];
		$listnum = $this->config->item('thd_listnum');
		$offset = $listnum*($page-1);
		$this->list_secede_where($param);
		$this->db->order_by('id DESC');
		$query = $this->db->get('thd_secede_info',$listnum,$offset);
		//echo $this->db->last_query();
		return $query->result();
	}

	/**
	 * 로그인
	 *
	 * @access	public
	 * @return	result
	*/
	 function login($arr = null){
		$userid = $this->input->post('userid',true);
		$passwd = $this->input->post('passwd',true);
		$passwd = md5($passwd);
		if(!is_array($arr)) $arr = array(); 
		$arr = array_merge($arr,array('user_id'=>$userid,'passwd'=>$passwd));
		$this->db->where($arr);
		$query = $this->db->get('thd_member');
		//echo $this->db->last_query();
		return $query;
	 }

	 /**
	 * 로그인 / 정보수정시 날짜 변경
	 *
	 * @access	public
	 * @return	result
	*/
	function member_modify($param){
		$this->db->where('seq',$param['seq']);
		$result = $this->db->update('thd_member',$param['data']);
	}


	/**
	 * 회원그룹 리스트
	 *
	 * @access	public
	 * @return	result
	 */
	function list_group_member(){
		$this->db->order_by('group_id');
		$query = $this->db->get('thd_config_group');
		//echo $this->db->last_query();
		return $query;
	}

	/**
	 * 회원그룹 상세
	 *
	 * @access	public
	 * @return	result
	 */
	function select_group_member($id){
		$data['dbjob'] = 'i';
		$data['group_id'] = null;
		$data['title'] = null;
		$data['info'] = null;
		
		$this->db->select("*");
		$this->db->where(array('group_id'=>$id));
		$query = $this->db->get('thd_config_group');
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$data['dbjob'] = 'u';
			$data['group_id'] = $row['group_id'];
			$data['title'] = $row['title'];
			$data['info'] = $row['info'];
		}
		return $data;
	}

	/**
	 * 회원그룹 db 처리
	 *
	 * @access	public
	 * @return	integer
	 */
	function group_dbjob($data){
		$dbjob = $this->input->post('dbjob');
		$group_id = $this->input->post('group_id');
		switch($dbjob){
			case('i'):
				$result = $this->db->insert('thd_config_group', $data);
			break;
			case('u'):
				$this->db->where('group_id',$group_id);
				$result = $this->db->update('thd_config_group',$data);
			break;
			case('d'):
				$this->db->where('group_id', $group_id);
				$result = $this->db->delete('thd_config_group');
			break;
		}
	}


	/**
	 * 회원정보 검색
	 *
	 * @access	public
	 * @return	array
	*/
	function find_info($param){
		$this->db->where($param);
		$query = $this->db->get('thd_member');
		//echo $this->db->last_query();
		return $query;
	}

	function leave($data){
		$this->db->where('id', $this->session->userdata('userno'));
		$result = $this->db->delete('thd_member');
		$result = $this->db->insert('thd_member_leave', $data);
	}

}
?>