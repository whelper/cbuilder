<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class product_model extends CI_Model {
	//모델 생성자 호출
	function __construct(){
		parent::__construct();
		$this->load->helper('file');
		$this->load->library('encrypt');
	}

	function product_category($arr = null){
		$this->db->order_by('seq DESC');
		if($arr) $query = $this->db->where($arr);
		$query = $this->db->get('thd_product_category');
		//echo $this->db->last_query();
		return $query;
	}
	
	function category_list($arr = null){
		$this->db->order_by('sort_no');
		if($arr) $query = $this->db->where($arr);
		$this->db->select("* , (SELECT COUNT(*) FROM thd_category where LEFT(category,LENGTH(a.category)) = a.category AND LENGTH(category) > LENGTH(a.category) AND use_yn='Y') AS is_child ");
		$query = $this->db->get('thd_category a');
		//echo $this->db->last_query();
		return $query;
	}

	function category_create($category = null){
		$w[] = (!$category) ? ' LENGTH(category)=2 ' : "LEFT(category,LENGTH('$category'))='$category' AND LENGTH(category)='".(strlen($category)+2)."'";
		$where = ' WHERE '.implode(' AND ',$w);
		$query = $this->db->query('SELECT RIGHT(concat(0,cast(right(category,2) as UNSIGNED)+1),2) AS category FROM thd_category '.$where.' ORDER BY category DESC LIMIT 1');
		$row = $query->row_array();
		$category .= ($row['category']) ? $row['category'] : '01';
		//echo $this->db->last_query();
		return $category;
	}

	function category_child($c){
		$query = $this->db->query("SELECT * FROM thd_category WHERE category IN('".$c."') ORDER BY category");
		return $query;
	
	}

	function category_select($arr = null){
		if(is_array($arr)){
			$this->db->select("*");
	  		$this->db->where($arr);
	  		$query = $this->db->get('thd_category');
			$row = $query->row_array();
			$data = $row;
		  
		}else{
			$fields = $this->db->list_fields('thd_category');
			foreach ($fields as $field){
			   $data[$field] = null;
			}
	  	}
	
	  	return $data;
	}

	function category_dbjob($data){
		$dbjob = $this->input->post('dbjob');
		$category = $this->input->post('category');
		switch($dbjob){
			case('i'):
				$this->db->select_max('sort_no');
				$query = $this->db->get('thd_category');
				$row = $query->row_array();
				$sort_no = is_null($row['sort_no']) ? 1 : $row['sort_no']+1;
				$data['sort_no'] = $sort_no;

				$this->db->insert('thd_category', $data);
				break;
			case('r'):
				$this->db->select_max('sort_no');
				$query = $this->db->get('thd_category');
				$row = $query->row_array();
				$sort_no = is_null($row['sort_no']) ? 1 : $row['sort_no']+1;
				$data['sort_no'] = $sort_no;

				$this->db->insert('thd_category', $data);
				break;
			case('u'):
				$this->db->where('category', $category);
				$this->db->update('thd_category',$data);
			break;
			case('d'):
				$this->db->where('category', $category);
				$this->db->delete('thd_category');
			break;
			case('up'):
				$query = $this->db->query('SELECT category,sort_no FROM thd_category WHERE sort_no < '.$data['sort_no'].' AND LENGTH(category) = LENGTH(\''.$category.'\')  ORDER BY sort_no DESC LIMIT 1');
				if($query->num_rows() > 0){
					$row = $query->row_array();
					$this->db->where('category',$category);
					$this->db->update('thd_category',array('sort_no'=>$row['sort_no']));

					$this->db->where('category',$row['category']);
					$this->db->update('thd_category',array('sort_no'=>$data['sort_no']));
				}
				break;
			case('down'):
				$query = $this->db->query('SELECT category,sort_no FROM thd_category WHERE sort_no > '.$data['sort_no'].' AND LENGTH(category) = LENGTH(\''.$category.'\')  ORDER BY sort_no LIMIT 1');
				if($query->num_rows() > 0){
					$row = $query->row_array();
					$this->db->where('category',$category);
					$this->db->update('thd_category',array('sort_no'=>$row['sort_no']));

					$this->db->where('category',$row['category']);
					$this->db->update('thd_category',array('sort_no'=>$data['sort_no']));
				}
				
			break;
			
		}
	}

	function valid_sub_total($arr){
		$this->db->where($arr);
		$count = $this->db->count_all_results('thd_category');
		//echo $this->db->last_query();
		return $count;
	}
	

	function goods_list($arr=null){
		$page = ($this->input->get("page",true)) ? $this->input->get("page",true) : 1;
		$listnum = 10;
		$offset = $listnum *($page-1);
		$this->db->order_by('sort_no DESC');
		if($arr) $this->db->where($arr,null,false);
		$query = $this->db->get('thd_product_group',$listnum,$offset);
		//echo $this->db->last_query();
		return $query;
	}

	function goods_other_view($arr){
		$this->db->where($arr['other']);
		$this->db->order_by($arr['orderby']);
		$query = $this->db->get('thd_product_group',1);
		//echo $this->db->last_query();
		return $query;
	}
	
	function product_list($arr=null,$orderby=null,$listnum = 10){
		$page = ($this->input->get("page",true)) ? $this->input->get("page",true) : 1;
		//$listnum = 10;
		$offset = $listnum *($page-1);
		$orderby = ($orderby) ? $orderby : 'sort_no DESC';
		$this->db->order_by($orderby);
		if($arr) $this->db->where($arr,null,false);
		//$query = $this->db->get('thd_product_group',$listnum,$offset);
		$query = $this->db->get('thd_product',$listnum,$offset);
		//echo $this->db->last_query();
		return $query;
	}

	function font_list($arr=null){
		$page = ($this->input->get("page",true)) ? $this->input->get("page",true) : 1;
		$listnum = 100;
		$offset = $listnum *($page-1);
		$this->db->order_by('sort_no DESC');
		if($arr) $this->db->where($arr,null,false);
		$query = $this->db->get('thd_product',$listnum,$offset);
		//echo $this->db->last_query();
		return $query;
	}

	
	function font_all($arr=null){
		$this->db->order_by('sort_no DESC');
		if($arr) $this->db->where($arr,null,false);
		$query = $this->db->get('thd_product');
		//echo $this->db->last_query();
		return $query;
	}

	function product_all($arr=null,$orderby=null){
		$orderby = ($orderby) ? $orderby : 'sort_no DESC';
		$this->db->order_by($orderby);
		if($arr) $this->db->where($arr,null,false);
		$query = $this->db->get('thd_product');
		//echo $this->db->last_query();
		return $query;
	}


	function product_select($arr){
		if(is_array($arr)){
			$this->db->select("*");
			$this->db->where($arr);
			$query = $this->db->get('thd_product');
			//echo $this->db->last_query();
			$row = $query->row_array();
			$data = $row;
		}else{
			$fields = $this->db->list_fields('thd_product');
			foreach ($fields as $field){
			   $data[$field] = null;
			}
		}
		return $data;
	}

	function goods_select($arr){
		if(is_array($arr)){
			$this->db->select("*");
			$this->db->where($arr);
			$query = $this->db->get('thd_product_group');
			//echo $this->db->last_query();
			$row = $query->row_array();
			$data = $row;
		}else{
			$fields = $this->db->list_fields('thd_product_group');
			foreach ($fields as $field){
			   $data[$field] = null;
			}
		}
		return $data;
	}

	function product_dbjob($data){
		$dbjob = $this->input->post('dbjob');
		$seq = $this->input->post('seq');
		$seqs= $this->input->post('seqs');
		switch($dbjob){
			case('i'):
				$this->db->select_max('sort_no');
				$query = $this->db->get('thd_product');
				$row = $query->row_array();
				$sort_no = is_null($row['sort_no']) ? 1 : $row['sort_no']+1;
				$data['sort_no'] = $sort_no;	
			
				$this->db->insert('thd_product', $data);
				$seq = $this->db->insert_id();
			break;
			case('u'):
				$this->db->where('seq', $seq);
				$this->db->update('thd_product',$data);
			break;
			case('md'):
				$this->db->query('DELETE FROM thd_product WHERE seq IN('.$seqs.')');
				$seq = $seqs;
			break;
			case('d'):
				$this->db->where('seq', $seq);
				$this->db->delete('thd_product');
			break;
			case('up'):
				$where = ($data['category']) ? " AND seq IN (SELECT product_seq FROM thd_product_category WHERE LEFT(category,LENGTH('".$data['category']."'))='".$data['category']."' )" : null; 
				$query = $this->db->query('SELECT seq,sort_no FROM thd_product WHERE sort_no > '.$data['sort_no'].' '.$where.' ORDER BY sort_no LIMIT 1');
				
				$row = $query->row_array();
				if(is_array($row)){
					$this->db->where('seq',$seq);
					$this->db->update('thd_product',array('sort_no'=>$row['sort_no']));

					$this->db->where('seq',$row['seq']);
					$this->db->update('thd_product',array('sort_no'=>$data['sort_no']));
				}
				break;
			case('down'):
				$where = ($data['category']) ? " AND seq IN (SELECT product_seq FROM thd_product_category WHERE LEFT(category,LENGTH('".$data['category']."'))='".$data['category']."' )" : null; 
				$query = $this->db->query('SELECT seq,sort_no FROM thd_product WHERE sort_no < '.$data['sort_no'].' '.$where.' ORDER BY sort_no DESC LIMIT 1');
				//echo $this->db->last_query();
				//exit;
				
				
				if($query->num_rows() > 0){
					$row = $query->row_array();
					$this->db->where('seq',$seq);
					$this->db->update('thd_product',array('sort_no'=>$row['sort_no']));

					$this->db->where('seq',$row['seq']);
					$this->db->update('thd_product',array('sort_no'=>$data['sort_no']));
				}
			break;
		}
		//echo $this->db->last_query();
		return $seq;
	}

	function product_category_dbjob($data){
		if( $data['seq']){
			switch($data['dbjob']){
			case('d'):
				$this->db->where(array('product_seq' => $data['seq']));
				$this->db->delete('thd_product_category');
			break;
			case('md'):
				$this->db->query('DELETE FROM thd_product_category WHERE product_seq IN('.$data['seq'].')');
			break;
			
			default:
				$cate_input = explode(',',$data['category']);
				$this->db->where(array('product_seq' => $data['seq']));
				$query = $this->db->get('thd_product_category');
				
				$cate_db = array();
				foreach($query->result() as $row){
					$cate_db[] = $row->category; 
				}
				
				$add = array_diff($cate_input,$cate_db);
				$del = array_diff($cate_db,$cate_input);
				if(sizeof($add) > 0){ //카테고리 등록
					foreach($cate_input as $key => $value){ //최상위 카테고리찾기
						$v[] = substr($value,0,2);
					}
					
					$this->db->where(array('parent_id' => 0));
					$this->db->where_in('category', $v);
					$query = $this->db->get('thd_category');
					$c = null;
					foreach($query->result() as $row){
						$c[$row->category] = $row->id;
					}
					
					foreach($add as $key => $value){
						$cdata = array('product_seq' => $data['seq'],'parent_id' =>$c[substr($value,0,2)] , 'category'=> $value );
						$this->db->insert('thd_product_category',$cdata);	
					}

				}

				if(sizeof($del) > 0){ //카테고리 삭제
					foreach($del as $key => $value){
						$this->db->where(array('product_seq' => $data['seq'], 'category' => $value));
						$this->db->delete('thd_product_category');
					}
				}
			
			break;
			}
		}
	}
	
	/**
	 * 게시물 총갯수
	 *
	 * @access	public
	 * @return	integer
	 */
	function list_total($arr=null,$table = 'thd_product' ){
		if($arr) $this->db->where($arr,null,false);
		$count = $this->db->count_all_results($table);
		//echo $this->db->last_query();
		return $count;
	}
	

	function setting_category($data){
		$this->db->where($data);
		$query = $this->db->get('thd_product_category',1);
		$row = $query->row();
		//echo $this->db->last_query();
		$category = null;
		if ($query->num_rows() > 0){
			$category = $row->category;
		}
		//echo $this->db->last_query();
		$data = null;
		if($category){
			$arr = array('category' => $category);
			$data = $this->category_select($arr);
			$_nav[] = $data['category_name'];
			if($data['parent_id'] > 0){
				$this->db->where(array('id' => $data['parent_id']));
				$query = $this->db->get('thd_category');
				$row = $query->row_array();
				$_nav[] = $row['category_name'];
				if($row['parent_id'] > 0){
					$this->db->where(array('id' => $row['parent_id']));
					$query = $this->db->get('thd_category');
					$row = $query->row_array();
					$_nav[] = $row['category_name'];
				}
			}
			$data = array_merge($data,array('nav' => $_nav));
		}
		return $data;
	}

	function group_list($arr=null){
		$page = ($this->input->get("page",true)) ? $this->input->get("page",true) : 1;
		$listnum = 10;
		$offset = $listnum *($page-1);
		$this->db->order_by('sort_no DESC');
		if($arr) $this->db->where($arr,null,false);
		$query = $this->db->get('thd_product_group',$listnum,$offset);
		//echo $this->db->last_query();
		return $query;
	}

	function group_select($arr){
		$this->db->select("*");
		$this->db->where($arr);
		$query = $this->db->get('thd_product_group');
		//echo $this->db->last_query();
		$row = $query->row_array();
		if($row){
			$data = $row;
		}else{
			$fields = $this->db->list_fields('thd_product_group');
			foreach ($fields as $field){
			   $data[$field] = null;
			}
	  	}
	
	  	return $data;
	}

	function group_dbjob($data){
		$dbjob = $this->input->post('dbjob');
		$seq = $this->input->post('seq');
		$seqs= $this->input->post('seqs');
		switch($dbjob){
			case('i'):
				$this->db->select_max('sort_no');
				$query = $this->db->get('thd_product_group');
				$row = $query->row_array();
				$sort_no = is_null($row['sort_no']) ? 1 : $row['sort_no']+1;
				$data['sort_no'] = $sort_no;	
			
				$this->db->insert('thd_product_group', $data);
			break;
			case('u'):
				$this->db->where('seq', $seq);
				$this->db->update('thd_product_group',$data);
			break;
			case('md'):
				$this->db->query('DELETE FROM thd_product_group WHERE seq IN('.$seqs.')');
			break;
			case('d'):
				$this->db->where('seq', $seq);
				$this->db->delete('thd_product_group');
			break;
			case('up'):
				$where = null;
				$query = $this->db->query('SELECT seq,sort_no FROM thd_product_group WHERE sort_no > '.$data['sort_no'].' '.$where.' ORDER BY sort_no LIMIT 1');
				
				$row = $query->row_array();
				if(is_array($row)){
					$this->db->where('seq',$seq);
					$this->db->update('thd_product_group',array('sort_no'=>$row['sort_no']));

					$this->db->where('seq',$row['seq']);
					$this->db->update('thd_product_group',array('sort_no'=>$data['sort_no']));
				}
				break;
			case('down'):
				$where = null;
				$query = $this->db->query('SELECT seq,sort_no FROM thd_product_group WHERE sort_no < '.$data['sort_no'].' '.$where.' ORDER BY sort_no DESC LIMIT 1');
				$row = $query->row_array();
				
				if(is_array($row)){
					$this->db->where('seq',$seq);
					$this->db->update('thd_product_group',array('sort_no'=>$row['sort_no']));

					$this->db->where('seq',$row['seq']);
					$this->db->update('thd_product_group',array('sort_no'=>$data['sort_no']));
				}
			break;
		}
		//echo $this->db->last_query();
		
	}

}
?>