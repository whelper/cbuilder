<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class popup_model extends CI_Model {
	//모델 생성자 호출
	function __construct(){
		parent::__construct();
		$this->load->helper('file');
	}
	
	
	/**
	 * 팝업 목록 검색조건
	 *
	 * @access	public
	 * @return	query where절 구문
	 */
	function popup_list_where($param){
		$keyname = $param['keyname'];
		$keyword = $param['keyword'];
		
		if($keyname && $keyword){
			$array_keyname = explode(',',$keyname);
			foreach($array_keyname as $key){
				$_where[] = "{$key} LIKE '%{$keyword}%'";
			}
			$where = implode(' OR ', $_where);
			return $this->db->where($where);
		}else{
			return null;
		}
	}
	
	function list_total($arr = null){
		if($arr) $this->db->where($arr,null,false);
		$count = $this->db->count_all_results('thd_popup');
		return $count;
	}
	
	function popup_list($arr = null){
		$page = ($this->input->get("page",true)) ? $this->input->get("page",true) : 1;
		$listnum = 10;
		$offset = $listnum *($page-1);
		if($arr) $this->db->where($arr,null,false);		
		$this->db->order_by('id DESC');
		$query = $this->db->get('thd_popup',$listnum,$offset);
		//echo $this->db->last_query();
		return $query;
	}
	
	function popup_dbjob($data=null){
		$dbjob = $this->input->post('dbjob');
		$id = $this->input->post('id');
		switch($dbjob){
			case('i'):
				$this->db->insert('thd_popup', $data);
			break;
			case('u'):
				$this->db->where('id',$id);
				$this->db->update('thd_popup',$data);
			break;
			case('d'):
				$this->db->where('id', $id);
				$this->db->delete('thd_popup');
			break;
		}
	}

	function list_front(){
		$query = $this->db->query("SELECT * FROM thd_popup WHERE use_yn='Y' AND (now() between start_date AND end_date) ORDER BY id DESC");
		return $query;
	}
	
	function popup_select($arr = null){
		if(is_array($arr)){
			$this->db->select("*");
			$this->db->where($arr);
			$query = $this->db->get('thd_popup');
			//echo $this->db->last_query();
			$row = $query->row_array();
			$data = $row;
		}else{
			$fields = $this->db->list_fields('thd_popup');
			foreach ($fields as $field){
			   $data[$field] = null;
			}
		}
		return $data;
	}
	
	
}
?>