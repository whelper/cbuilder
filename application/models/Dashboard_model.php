<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class dashboard_model extends CI_Model {
	//모델 생성자 호출
	var $language  = 'kr';
	function __construct(){
		parent::__construct();
		if($this->input->get_post('language',true)) $this->language = $this->input->get_post('language',true);
		$this->load->helper('file');
		$this->load->library('encrypt');
	}
	
	//dashboard > 최근 게시글
	function recently_board(){
		/*$sql = 'SELECT id,menu_id,title,writer,register_date , ';
		$sql .= '(SELECT title FROM thd_config_contents WHERE menu_id=thd_board.menu_id) AS board_name ';
		$sql .= 'FROM thd_board ORDER BY id DESC LIMIT 5 ';*/
		
		$sql = 'SELECT a.id,a.menu_id,a.title,a.writer,a.register_date ,b.title AS board_name FROM thd_board a INNER JOIN (SELECT menu_id,title from thd_config_contents WHERE language=\''.$this->language.'\' AND menu_type=\'BOARD\') b ON a.menu_id=b.menu_id ORDER BY a.id DESC LIMIT 5';
		$query = $this->db->query($sql);
		return $query; 
	}

	//dashboard > 최근 온라인문의
	function recently_enquiry(){
		$this->db->order_by('seq DESC');
		$query = $this->db->get('thd_enquiry',5,0);
		return $query; 
	}

	function recently_alim(){
		$q = "SELECT DATE_FORMAT(CURRENT_TIMESTAMP,'%Y.%m.%d') AS TODAY, COUNT(*) AS CNT, '주문이' AS TITLE, '/order/orderList' AS LINK FROM thd_order WHERE 
				DATE_FORMAT(reg_date,'%Y%m%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y%m%d') UNION 
	          SELECT DATE_FORMAT(CURRENT_TIMESTAMP,'%Y.%m.%d') AS TODAY ,  COUNT(*) AS CNT, '프로젝트 의뢰가' AS TITLE, '/typoadmin/enquiry_list' AS LINK FROM thd_enquiry WHERE 
				p_cate='01' AND DATE_FORMAT(regist_date,'%Y%m%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y%m%d') UNION 
			  SELECT DATE_FORMAT(CURRENT_TIMESTAMP,'%Y.%m.%d') AS TODAY ,  COUNT(*) AS CNT, '회원가입이' AS TITLE, '/typoadmin/member_list' AS LINK FROM thd_member WHERE 
				membership < 10 AND DATE_FORMAT(reg_date,'%Y%m%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y%m%d') ";
		$query = $this->db->query($q);
		//echo $this->db->last_query();
		return $query; 

	}
	
	
}
?>