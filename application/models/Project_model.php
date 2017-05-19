<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Project_model extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->dbforge();
	}

	function project_list($arr = null){
		$page = ($this->input->get("page",true)) ? $this->input->get("page",true) : 1;
		$listnum = 10;
		$offset = $listnum *($page-1);
		$this->db->order_by('sort_no DESC');
		if($arr) $this->db->where($arr,null,false);
		$query = $this->db->get('thd_portfolio',$listnum,$offset);
		//echo $this->db->last_query();
		return $query;
	}
	
	function project_select($arr = null){
		$this->db->select("*");
		$this->db->where($arr);
		$query = $this->db->get('thd_portfolio');
		//echo $this->db->last_query();
		$row = $query->row_array();
		if($row){
			$data = $row;
		}else{
			$fields = $this->db->list_fields('thd_portfolio');
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
	function list_total($arr=null,$table = 'thd_portfolio' ){
		if($arr) $this->db->where($arr,null,false);
		$count = $this->db->count_all_results($table);
		//echo $this->db->last_query();
		return $count;
	}
	
	function project_dbjob($data){
		$dbjob = $this->input->post('dbjob');
		$seq = $this->input->post('seq');
		$seqs= $this->input->post('seqs');
		switch($dbjob){
			case('i'):
				$this->db->select_max('sort_no');
				$query = $this->db->get('thd_portfolio');
				$row = $query->row_array();
				$sort_no = is_null($row['sort_no']) ? 1 : $row['sort_no']+1;
				$data['sort_no'] = $sort_no;	
			
				$this->db->insert('thd_portfolio', $data);
			break;
			case('u'):
				$this->db->where('seq',$seq);
				$this->db->update('thd_portfolio',$data);
			break;
			case('md'):
				$this->db->query('DELETE FROM thd_portfolio WHERE seq IN('.$seqs.')');
			break;
			case('d'):
				$this->db->where('seq', $seq);
				$this->db->delete('thd_portfolio');
			break;
			case('up'):
				$query = $this->db->query('SELECT seq,sort_no FROM thd_portfolio WHERE sort_no > '.$data['sort_no'].' ORDER BY sort_no LIMIT 1');
				
				$row = $query->row_array();
				if(is_array($row)){
					$this->db->where('seq',$seq);
					$this->db->update('thd_portfolio',array('sort_no'=>$row['sort_no']));

					$this->db->where('seq',$row['seq']);
					$this->db->update('thd_portfolio',array('sort_no'=>$data['sort_no']));
				}
				break;
			case('down'):
				$query = $this->db->query('SELECT seq,sort_no FROM thd_portfolio WHERE sort_no < '.$data['sort_no'].' ORDER BY sort_no DESC LIMIT 1');
				$row = $query->row_array();
				
				if(is_array($row)){
					$this->db->where('seq',$seq);
					$this->db->update('thd_portfolio',array('sort_no'=>$row['sort_no']));

					$this->db->where('seq',$row['seq']);
					$this->db->update('thd_portfolio',array('sort_no'=>$data['sort_no']));
				}
			break;
		}
		//echo $this->db->last_query();
	}

	function project_other_view($arr){
		$this->db->where($arr['other']);
		$this->db->order_by($arr['orderby']);
		$query = $this->db->get('thd_portfolio',1);
		//echo $this->db->last_query();
		return $query;
	}

}