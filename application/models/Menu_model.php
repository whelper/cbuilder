<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Menu_model extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->dbforge();
	}

	function menu_count($arr){
		$this->db->where($arr);
		$count = $this->db->count_all_results('thd_config_contents');
		//echo $this->db->last_query();
		return $count; 
	}

	function menu_list($arr){
		//$this->db->order_by('menu_id');
		$this->db->order_by('etc_yn ,sort_no');
		$query = $this->db->where(array('language'=>$arr['language']));
		$query = $this->db->get('thd_config_contents');
		
		//echo $this->db->last_query();
		return $query;
	}
	
	//메뉴관리 > 게시판
	function menu_board($arr){
		$offset = $arr['listnum']*($arr['page']-1);
		$this->db->select('*,(SELECT COUNT(*) FROM thd_board WHERE menu_id=thd_config_contents.menu_id ) cnt');
		$this->db->order_by('menu_id');
		$this->db->where(array('menu_type'=>'BOARD','language'=>$arr['language']));
		$query = $this->db->get('thd_config_contents',$arr['listnum'],$offset);
		//echo $this->db->last_query();
		return $query;
	}

	function setting_page($menu_id){
		$arr = array('menu_id' => $menu_id);
		$data = $this->menu_select($arr);
		
		
		$_nav[] = $data['title'];
		if($data['parent_id'] > 0){
			$this->db->where(array('menu_id' => $data['parent_id']));
			$query = $this->db->get('thd_config_contents');
			$row = $query->row_array();
			$_nav[] = $row['title'];
			if($row['parent_id'] > 0){
				$this->db->where(array('menu_id' => $row->parent_id));
				$query = $this->db->get('thd_config_contents');
				$row = $query->row_array();
				$_nav[] = $row['title'];
			}
		}
		$data = array_merge($data,array('nav' => $_nav));
		//print_r($data);
		return $data;
	}

	function menu_select($arr){
	  	$this->db->select("*");
		$this->db->where($arr);
		$query = $this->db->get('thd_config_contents');
		//echo $this->db->last_query();
		$row = $query->row_array();
		$_settings = array('cate','comment_yn','board_type','board_skin','limit_title','list_cnt','secret_yn'
						,'auth_list','auth_write','auth_view','auth_reply','auth_comment','rows','cols','cols','module_name','controller','function','attache_cnt','thumb_w','thumb_h');
		
		if($row){
			$menu_id = $arr['menu_id'];
			$data = $row;
			$json = json_decode($row['settings'],true);

			//setting values
			foreach($_settings as $_k){
				if($json){
					$data[$_k] = (array_key_exists($_k,$json)) ? $json[$_k] : null;
				}else{
					$data[$_k] =  null;
				}
			}
		}else{
			//setting values
			foreach($_settings as $_k){
				$data[$_k] =  null;

			}

			$fields = $this->db->list_fields('thd_config_contents');
			foreach ($fields as $field){
			   $data[$field] = null;
			}
	  	}
	
	  	return $data;
	}

	function valid_sub_total($arr){
		$this->db->where($arr);
		$count = $this->db->count_all_results('thd_config_contents');
		//echo $this->db->last_query();
		return $count;
	}

	function menu_dbjob($data){
		$dbjob = $this->input->post('dbjob');
		$menu_id = $this->input->post('menu_id');
		switch($dbjob){
			case('i'):
				$this->db->select_max('sort_no');
				$query = $this->db->get('thd_config_contents');
				$row = $query->row_array();
				$sort_no = is_null($row['sort_no']) ? 1 : $row['sort_no']+1;
				$data['sort_no'] = $sort_no;

				$this->db->insert('thd_config_contents', $data);
				break;
			case('u'):
				$this->db->where('menu_id',$menu_id);
				$this->db->update('thd_config_contents',$data);
				break;
			case('d'):
				$this->db->where('menu_id', $menu_id);
				$this->db->delete('thd_config_contents');
			break;
			case('up'):
				
				$query = $this->db->query('SELECT menu_id,sort_no FROM thd_config_contents WHERE parent_id='.$data['parent_id'].' AND sort_no < '.$data['sort_no'].' ORDER BY etc_yn ,sort_no DESC LIMIT 1');
				$row = $query->row_array();
				
				if(is_array($row)){
					$this->db->where('menu_id',$menu_id);
					$this->db->update('thd_config_contents',array('sort_no'=>$row['sort_no']));

					$this->db->where('menu_id',$row['menu_id']);
					$this->db->update('thd_config_contents',array('sort_no'=>$data['sort_no']));
				}
			break;
			case('down'):
				$query = $this->db->query('SELECT menu_id,sort_no FROM thd_config_contents WHERE parent_id='.$data['parent_id'].' AND sort_no > '.$data['sort_no'].' ORDER BY etc_yn ,sort_no LIMIT 1');
				
				$row = $query->row_array();
				if(is_array($row)){
					$this->db->where('menu_id',$menu_id);
					$this->db->update('thd_config_contents',array('sort_no'=>$row['sort_no']));

					$this->db->where('menu_id',$row['menu_id']);
					$this->db->update('thd_config_contents',array('sort_no'=>$data['sort_no']));
				}
				break;
			
		}
		//echo $this->db->last_query();
		//exit;
	}


	function set_menu_array($array,$parent_id=null){
		$result = array();
		if(!$parent_id){
			foreach($array as $k => $v){
				if($v['parent_id'] == 0){ 
					$result[$k] = array('menu_id'=>$v['menu_id'],'menu_type' => $v['menu_type'],'parent_id' => $v['parent_id'],'etc_yn' => $v['etc_yn'],'title'=> $v['title'],'url_alias'=> $v['url_alias'],'sort_no' => $v['sort_no'],'target' => $v['target']);
				}
			}
		}else{
			foreach($array as $k => $v){
				if($v['parent_id'] == $parent_id && $v['parent_id'] > 0){ 
					$result[$k] = array('menu_id'=>$v['menu_id'],'menu_type' => $v['menu_type'],'parent_id' => $v['parent_id'],'etc_yn' => $v['etc_yn'],'title'=> $v['title'],'url_alias'=> $v['url_alias'],'sort_no' => $v['sort_no'],'target' => $v['target']);
				}
			}
		}

		ksort($result);
		return $result;
	}

	function menu_create_url($menu_id){
		$arr = $this-> menu_select(array('menu_id'=>$menu_id));
		switch($arr['menu_type']){
			case('HTML'):
				$link = ($arr['language'] != 'kr') ? '/'.$arr['language'] : null;
				$link .= ($arr['url_alias']) ? '/front/html/'.iconv('utf-8','euc-kr',$arr['url_alias']) : '/front/html/id/'.$arr['menu_id'];
				
			break;
			case('BOARD'):
				$link = ($arr['language'] != 'kr') ? '/'.$arr['language'] : null;
				$link .= '/front/board/list/id/'.$arr['menu_id'];
			break;
			case('LINK'):
				$link = $arr['link'];
			break;
			case('PLUGIN'):
				$link = '/'.$arr['controller'].'/'.$arr['function'].'/id/'.$arr['menu_id'];
			break;
			default:
				$link = ($arr['language'] != 'kr') ? '/'.$arr['language'] : null;
				$link .= '/front/html/id/'.$arr['menu_id'];
			break;
		}

		if($arr['add_parameter']){ //파라미터추가
			$link .= $arr['add_parameter'];
		}
		
		return $link;
	}

	function menu_create_xml($arr){
		$this->db->order_by('menu_id');
		$query = $this->db->where(array('language'=>$arr['language'],'use_yn'=>'Y','single_yn'=>'N'));
		$query = $this->db->get('thd_config_contents');
		//echo $this->db->last_query();
		$_menu = array();
		foreach ($query->result() as $row){
			$_menu[$row->sort_no] = array('menu_id'=>$row->menu_id,'menu_type' => $row->menu_type,'parent_id' => $row->parent_id,'etc_yn' => $row->etc_yn,'title'=> $row->title,'url_alias' => $row->url_alias,'sort_no' => $row->sort_no,'target' => $row->target);
		}
		$query->free_result();
		
		$_xml = null;
		$menu = $this->set_menu_array($_menu,null);
		foreach($menu as $k => $v){ //1depth
			
			
			$_xml1 = null;
			$_xml1 .='<menu1>'.chr(10);
			$_xml1 .= '<menuname><![CDATA['.$v['title'].']]></menuname>'.chr(10);
			$_xml1 .= '<hyperlink>'.$this->menu_create_url($v['menu_id']).'</hyperlink>'.chr(10);
			$_xml1 .= '<target>'.$v['target'].'</target>'.chr(10);
			$_xml1 .= '<id>'.$v['menu_id'].'</id>'.chr(10);
			$_xml1 .= '<group>'.$v['menu_id'].'</group>'.chr(10);
			$_xml1 .= '<etc_yn>'.$v['etc_yn'].'</etc_yn>'.chr(10);
			
			$_xml2 = null;
			$menu = $this->set_menu_array($_menu,$v['menu_id']);
			foreach($menu as $k => $v){ //2depth
				$_xml2 .= '	<menu2>'.chr(10);
				$_xml2 .= '	<menuname><![CDATA['.$v['title'].']]></menuname>'.chr(10);
				$_xml2 .= '	<hyperlink>'.$this->menu_create_url($v['menu_id']).'</hyperlink>'.chr(10);
				$_xml2 .= '	<target>'.$v['target'].'</target>'.chr(10);
				$_xml2 .= '	<id>'.$v['menu_id'].'</id>'.chr(10);
				$_xml2 .= '	<group>'.$v['parent_id'].'</group>'.chr(10);
				$_xml2 .= '	<etc_yn>'.$v['etc_yn'].'</etc_yn>'.chr(10);
				$_xml3 = null;
				$menu = $this->set_menu_array($_menu,$v['menu_id']);
				foreach($menu as $k => $v){ //2depth
					$_xml3 .= '		<menuitem>'.chr(10);
					$_xml3 .= '		<menuitemname><![CDATA['.$v['title'].']]></menuitemname>'.chr(10);
					$_xml3 .= '		<hyperlink>'.$this->menu_create_url($v['menu_id']).'</hyperlink>'.chr(10);
					$_xml3 .= '		<target>'.$v['target'].'</target>'.chr(10);
					$_xml3 .= '		<id>'.$v['menu_id'].'</id>'.chr(10);
					$_xml3 .= '		<group>'.$v['parent_id'].'</group>'.chr(10);
					$_xml3 .= '		<etc_yn>'.$v['etc_yn'].'</etc_yn>'.chr(10);
					$_xml3 .= '		</menuitem>'.chr(10);
				
				}
				$_xml2 .= $_xml3 .'	</menu2>'.chr(10);
			}
			$_xml1 .= $_xml2 .'</menu1>'.chr(10);
			$_xml .= $_xml1;
		}

		$query->free_result();
	
		$content = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$content .= "<root>\n";
		$content .= $_xml;
		$content .= "</root>\n";

		write_file($this->config->item('thd_path_html').'menu_'.$arr['language'].'.xml', $content);
		
		
	}

	function select_alias($alias){
		$data = null;
		if($alias){
			$this->db->select("*");
			$this->db->where('url_alias', $alias);
			$query = $this->db->get('thd_config_contents');
			if($query->num_rows() > 0){
		  		$row = $query->row_array();
				$data = $row;
			}
		}
		return $data;
	}

}