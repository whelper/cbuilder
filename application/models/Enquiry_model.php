<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Enquiry_model extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->dbforge();
	}

	function enquiry_list($arr = null){
		$page = ($this->input->get("page",true)) ? $this->input->get("page",true) : 1;
		$listnum = 10;
		$offset = $listnum *($page-1);
		$this->db->order_by('seq DESC');
		if($arr) $this->db->where($arr,null,true);
		$query = $this->db->get('thd_enquiry',$listnum,$offset);
		//echo $this->db->last_query();
		return $query;
	}
	
	function enquiry_select($arr = null){
		$this->db->select("*");
		$this->db->where($arr);
		$query = $this->db->get('thd_enquiry');
		//echo $this->db->last_query();
		$row = $query->row_array();
		if($row){
			$data = $row;
		}else{
			$fields = $this->db->list_fields('thd_enquiry');
			foreach ($fields as $field){
			   $data[$field] = null;
			}
	  	}
	
	  	return $data;
	}

	/**
	 * °Ô½Ã¹° ÃÑ°¹¼ö
	 *
	 * @access	public
	 * @return	integer
	 */
	function list_total($arr=null){
		if($arr) $this->db->where($arr,null,true);
		$count = $this->db->count_all_results('thd_enquiry');
		//echo $this->db->last_query();
		return $count;
	}
	
	function enquiry_dbjob($data){
		$dbjob = $this->input->post('dbjob');
		$seqs= $this->input->post('seqs');
		$seq = $this->input->post('seq');
		switch($dbjob){
			case('i'):
				$this->db->insert('thd_enquiry',$data);
			break;
			case('u'):
				$this->db->where('seq',$seq);
				$this->db->update('thd_enquiry',$data);
			break;
			case('r'): //´äº¯¼öÁ¤
				$this->db->where('seq',$seq);
				$this->db->update('thd_enquiry',$data);
			break;
			case('md'):
				$this->db->query('DELETE FROM thd_enquiry WHERE seq IN('.$seqs.')');
			break;
			case('d'):
				$this->db->where('seq', $seq);
				$this->db->delete('thd_enquiry');
			break;
		}

		$result = $this->db->affected_rows();
		return $result;
	}

}