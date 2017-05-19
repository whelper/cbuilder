<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class common_model extends CI_Model {
	//모델 생성자 호출
	function __construct(){
		parent::__construct();
		$this->load->helper('file');
		$this->load->library('encrypt');
	}
	
	function list_total($config){
		if($config['where']) $this->db->where($config['where'],null,false);
		$count = $this->db->count_all_results($config['table']);
		//echo $this->db->last_query();
		return $count;
	}
	
	function default_list($config){
		
		$page = $config['page'];
		$listnum = (array_key_exists('listnum',$config)) ? $config['listnum'] : 10 ;
		$offset = $listnum *($page-1);
		if(!array_key_exists('orderby',$config)) $config['orderby'] = ' seq DESC'; 
		$this->db->order_by($config['orderby']);
		if($config['where']) $this->db->where($config['where'],null,false);
		$query = $this->db->get($config['table'],$listnum,$offset);
		//echo $this->db->last_query();
		return $query;
	}

	function default_select($config){
		$data = null;
		if(is_array($config['where'])){
			$this->db->select("*");
			$this->db->where($config['where']);
			$query = $this->db->get($config['table']);
			//echo $this->db->last_query();
			if($query->num_rows() > 0){
				$row = $query->row_array();
				$data = $row;
			}
		}
		
		if(!$data){
			$fields = $this->db->list_fields($config['table']);
			foreach ($fields as $field){
			   $data[$field] = null;
			}
		}
		return $data;
	}

	function common_dbjob($config){
		switch($config['dbjob']){
			case('i'):
				$this->db->insert($config['table'], $config['data']);
			break;
			case('u'):
				$this->db->where($config['where']);
				$this->db->update($config['table'], $config['data']);
			break;
			case('d'):
				$this->db->where($config['where']);
				$this->db->delete($config['table']);
			break;
			case('md'):
				$this->db->where_in($config['where_in'],$config['where']);
				$this->db->delete($config['table']);
			break;
		}
		//echo $this->db->last_query();
		
	}
	
}
?>