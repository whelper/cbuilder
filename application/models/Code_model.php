<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Code_model extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->dbforge();
	}

	function code_group_list(){
		$arr = array('del_yn !=' => "'y'");	
		$this->db->order_by('master_id');
		if($arr) $this->db->where($arr,null,false);
		$query = $this->db->get('thd_code_master');
		//echo $this->db->last_query();
		return $query;
	}

	function code_group_select($arr){
		if(is_array($arr)){
			$this->db->select("*");
			$this->db->where($arr);
			$query = $this->db->get('thd_code_master');
			//echo $this->db->last_query();
			$row = $query->row_array();
			$data = $row;
		}else{
			$fields = $this->db->list_fields('thd_code_master');
			foreach ($fields as $field){
			   $data[$field] = null;
			}
		}
		return $data;
	}

	function code_list($arr){
		$this->db->order_by('sort_no');
		if($arr) $this->db->where($arr,null,false);
		$query = $this->db->get('thd_code_child');
		//echo $this->db->last_query();
		return $query;
	}

	function code_select($arr){
		if(is_array($arr)){
			$this->db->select("*");
			$this->db->where($arr);
			$query = $this->db->get('thd_code_child');
			//echo $this->db->last_query();
			$row = $query->row_array();
			$data = $row;
		}else{
			$fields = $this->db->list_fields('thd_code_child');
			foreach ($fields as $field){
			   $data[$field] = null;
			}
		}
		return $data;
	}

	function code_dbjob($data){
		$codeType = $this->input->post('codeType');
		$master_id = $this->input->post('master_id');
		$code_id = $this->input->post('code_id');
		$dbjob = $this->input->post('dbjob');
		if($codeType == 'GROUP'){
			switch($dbjob){
			case('i'):
				$this->db->insert('thd_code_master', $data);
			break;
			case('u'):
				$this->db->where('master_id', $master_id);
				$this->db->update('thd_code_master',$data);
			break;
			case('d'):
				$this->db->where(array('del_yn' => '\'n\'','master_id'=> $master_id),null,false);
				$this->db->from('thd_code_child');
				
				if($this->db->count_all_results() > 0){
					return 2; //하위코드존재
				}
				
				$this->db->where('master_id', $master_id);
				$this->db->update('thd_code_master',$data);
			break;
			}
		
		}else{
			switch($dbjob){
			case('i'):
				$this->db->select_max('sort_no');
				$query = $this->db->get('thd_code_child');
				$row = $query->row_array();
				$sort_no = is_null($row['sort_no']) ? 1 : $row['sort_no']+1;
				$data['sort_no'] = $sort_no;	
				

				$this->db->insert('thd_code_child', $data);
			break;
			case('u'):
				$this->db->where('code_id', $code_id);
				$this->db->update('thd_code_child',$data);
			break;
			case('d'):
				$this->db->where('code_id', $code_id);
				$this->db->update('thd_code_child',$data);
				/*echo $this->db->last_query();
				exit;*/
			break;
			case('up'):
				$where = ($data['master_id']) ? " AND master_id=".$data['master_id'] : null; 
				$query = $this->db->query('SELECT code_id,sort_no FROM thd_code_child WHERE sort_no > '.$data['sort_no'].' '.$where.' ORDER BY sort_no LIMIT 1');
				
				$row = $query->row_array();
				if(is_array($row)){
					$this->db->where('code_id',$code_id);
					$this->db->update('thd_code_child',array('sort_no'=>$row['sort_no']));

					$this->db->where('code_id',$row['code_id']);
					$this->db->update('thd_code_child',array('sort_no'=>$data['sort_no']));
				}
				break;
			case('down'):
				$where = ($data['category']) ? " AND category='".$data['category']."'" : null; 
				$query = $this->db->query('SELECT code_id,sort_no FROM thd_code_child WHERE sort_no < '.$data['sort_no'].' '.$where.' ORDER BY sort_no DESC LIMIT 1');
				$row = $query->row_array();
				
				if(is_array($row)){
					$this->db->where('code_id',$code_id);
					$this->db->update('thd_code_child',array('sort_no'=>$row['sort_no']));

					$this->db->where('code_id',$row['code_id']);
					$this->db->update('thd_code_child',array('sort_no'=>$data['sort_no']));
				}
			break;
			}
		}
		return 1;
	}


}