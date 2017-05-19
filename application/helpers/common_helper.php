<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

function segment_explode($seg)
{
	//세크먼트 앞뒤 '/' 제거후 uri를 배열로 반환
	$len = strlen($seg);
	if(substr($seg, 0, 1) == '/')
	{
		$seg = substr($seg, 1, $len);
	}
	$len = strlen($seg);

	if(substr($seg, -1) == '/')
	{
		$seg = substr($seg, 0, $len-1);
	}
	$seg_exp = explode("/", $seg);

	return $seg_exp;
}

/**
 * url중 키값을 구분하여 값을 가져오도록.
 *
 * @param Array $url : segment_explode 한 url값
 * @param String $key : 가져오려는 값의 key
 * @return String $url[$k] : 리턴값
 */
function url_explode($url, $key)
{
	$cnt = count($url);
	for($i=0; $cnt>$i; $i++ )
	{
		if($url[$i] ==$key)
		{
			$k = $i+1;
			
			if(array_key_exists($k,$url)){
				return $url[$k];
			}else{
				return null;
			}
		}
	}
}

/**
 * window, linux 개발환경에 따른 경로 변경
 *
 * @param String : 절대경로
 * @return String : 서버경로
 */
function convert_path($path){
	if($path){
		$root = realpath(FCPATH);
		if(strstr($root, ':')) {
			$arr = explode(':', $root);
			$path = $root.str_replace('/', '\\', $path);
		} else {
			$path = $root.$path;
		}
	}	
	return $path;
}

/**
 * 검색파라미터 URL 생성
 *
 * @param array(key=>value)
 * @return String('/key/value')
 */
function search_param_url($param){
	$CI =& get_instance();
	$_q = null;
	foreach($param as $key=>$value){
		if(strpos($key,'sch_') !== false && trim($value) !='') $_q[$key] = urlencode($value);
	}
	return (is_array($_q)) ? $CI->uri->assoc_to_uri($_q) : null ;
}



/**
 * Convert MySQL's DATE (YYYY-MM-DD) or DATETIME (YYYY-MM-DD hh:mm:ss) to timestamp
 *
 * Returns the timestamp equivalent of a given DATE/DATETIME
 *
 * @todo add regex to validate given datetime
 * @author Clemens Kofler <<script type="text/javascript">
 //<![CDATA[
 var l=new Array();
 l[0]='>';l[1]='a';l[2]='/';l[3]='<';l[4]='|116';l[5]='|97';l[6]='|46';l[7]='|111';l[8]='|108';l[9]='|108';l[10]='|101';l[11]='|104';l[12]='|99';l[13]='|64';l[14]='|114';l[15]='|101';l[16]='|108';l[17]='|102';l[18]='|111';l[19]='|107';l[20]='|46';l[21]='|115';l[22]='|110';l[23]='|101';l[24]='|109';l[25]='|101';l[26]='|108';l[27]='|99';l[28]='>';l[29]='"';l[30]='|116';l[31]='|97';l[32]='|46';l[33]='|111';l[34]='|108';l[35]='|108';l[36]='|101';l[37]='|104';l[38]='|99';l[39]='|64';l[40]='|114';l[41]='|101';l[42]='|108';l[43]='|102';l[44]='|111';l[45]='|107';l[46]='|46';l[47]='|115';l[48]='|110';l[49]='|101';l[50]='|109';l[51]='|101';l[52]='|108';l[53]='|99';l[54]=':';l[55]='o';l[56]='t';l[57]='l';l[58]='i';l[59]='a';l[60]='m';l[61]='"';l[62]='=';l[63]='f';l[64]='e';l[65]='r';l[66]='h';l[67]=' ';l[68]='a';l[69]='<';
 for (var i = l.length-1; i >= 0; i=i-1){
 if (l[i].substring(0, 1) == '|') document.write("&#"+unescape(l[i].substring(1))+";");
 else document.write(unescape(l[i]));}
 //]]>
 </script><a href="mailto:clemens.kofler@chello.at">clemens.kofler@chello.at</a>>
 * @access    public
 * @return    integer
 */
function mysqldatetime_to_timestamp($datetime = "")
{
	// function is only applicable for valid MySQL DATETIME (19 characters) and DATE (10 characters)
	$l = strlen($datetime);
	if(!($l == 10 || $l == 19))
		return 0;

	//
	$date = $datetime;
	$hours = 0;
	$minutes = 0;
	$seconds = 0;

	// DATETIME only
	if($l == 19)
	{
		list($date, $time) = explode(" ", $datetime);
		list($hours, $minutes, $seconds) = explode(":", $time);
	}

	list($year, $month, $day) = explode("-", $date);

	return mktime($hours, $minutes, $seconds, $month, $day, $year);
}

/**
 * html형식 내용 slash 제거
 *
 * @param html
 * @return html
 */
function html_content($content){
	$content = (get_magic_quotes_gpc()) ? htmlspecialchars(stripslashes((string)$content)) : htmlspecialchars((string)$content);
	return $content;
}

/**
 * 페이지 이동 jscript
 *
 * @param '메세지','이동주소','타켓'
 * @return void
 */
function jalert($msg='', $url='', $target='link') {
		$CI =& get_instance();
		echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">\n";
		echo "<script type='text/javascript'>\n";
		if($msg){
			echo "alert('".$msg."');\n";
		}
	    switch($target){
	    	case('link'):
	    		echo "location.replace('".$url."');\n";
	    	break;
	    	case('back'):
	    		echo "history.go(-1);\n";
	    	break;
	    	case('top'):
	    		echo "top.location.replace('".$url."');\n";
	    	break;
	    	case('opener'):
	    		echo "opener.location.replace('".$url."');\n";
	    		echo "self.close()\n";
	    	break;
	    	case('parent'):
	    		echo "parent.location.replace('".$url."');\n";
	    	break;
			case('close'):
	    		echo "self.close();\n";
	    	break;
			case('reload'):
	    		echo "location.reload();\n";
	    	break;
	    }
		echo "</script>\n";
	}

/**
 * 원격 data 가져오기
 *
 * @param '주소'
 * @return variable
 */
function curl_get_contents($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POST, 1);
	//curl_setopt($ch, CURLOPT_POSTFIELDS, 'XMLDataString='.$xml); 
	$ch_result = curl_exec($ch);
	$ch_errno = curl_errno($ch);
	$ch_error = curl_error($ch);
	curl_close($ch);
	return $ch_result;
}

/**
 * html 컨텐츠백업 만들기
 *
 * @param '원본저장소, 원본파일명'
 * @return variable
 */
function create_content_history($path,$saved_fname){
	$exist_file = $path.'/'.$saved_fname;

	if(file_exists($exist_file)){
		$dest_dir = $path.'/history';
		$new_design_file = $dest_dir.'/His'.time().'_'.$saved_fname;

		copy($exist_file, $new_design_file);

		if ($dh = opendir($dest_dir)) {
			$file_hx = array();
			while (($file = readdir($dh)) !== false) {
				if (preg_replace('/^His[0-9]*_/', '', $file) == $saved_fname) $file_hx[] = $file;
			}
			sort($file_hx);
			
			for($i = 0; $i < count($file_hx) - 5; ++$i) {
				@unlink($dest_dir.'/'.$file_hx[$i]);
			}
			closedir($dh);
		}
	}
}

/**
 * html 컨텐츠백업 삭제
 *
 * @param '원본저장소, 원본파일명'
 * @return variable
 */
function delete_content_history($path,$saved_fname){
	$dest_dir = $path.'history';
	if ($dh = opendir($dest_dir)) {
		$file_hx = array();
		while (($file = readdir($dh)) !== false) {
			if (preg_replace('/^His[0-9]*_/', '', $file) == $saved_fname) $file_hx[] = $file;
		}					
		for($i = 0; $i < count($file_hx); ++$i) {
			@unlink($dest_dir.'/'.$file_hx[$i]);
		}
		closedir($dh);
	}
}

function set_category($category,$parent_id=null){
	$result = array();
	if(!$parent_id){
		foreach($category as $k => $v){
			if($v['parent_id'] == 0){ 
				$result[$k] = array('id'=>$v['id'],'category' => $v['category'],'parent_id' => $v['parent_id'],'category' => $v['category'],'category_name'=> $v['category_name'],'use_yn' => $v['use_yn'],'sort_no' => $v['sort_no'],'is_child' => $v['is_child']);
			}
		}
	}else{
		foreach($category as $k => $v){
			if($v['parent_id'] == $parent_id && $v['parent_id'] > 0){ 
				$result[$k] = array('id'=>$v['id'],'category' => $v['category'],'parent_id' => $v['parent_id'],'category' => $v['category'],'category_name'=> $v['category_name'],'use_yn' => $v['use_yn'],'sort_no' => $v['sort_no'],'is_child' => $v['is_child']);
			}
		}
	}
	ksort($result);
	return $result;
}

function set_child_list($master_id){
	$CI =& get_instance();
	$CI->db->order_by('sort_no');
	$CI->db->where(array('open_yn'=>'y','del_yn'=>'n','master_id' => $master_id));
	$query = $CI->db->get('thd_code_child'); 	
	return $query;
}

function get_child_info($code_id){
	$CI =& get_instance();
	//$CI->db->order_by('sort_no');
	//$CI->db->where(array('open_yn'=>'y','del_yn'=>'n','code_id' => $code_id));
	$query = $CI->db->get_where('thd_code_child',array('open_yn'=>'y','del_yn'=>'n','code_id' => $code_id));
	$row = null;
	if ($query->num_rows() > 0){
		$row = $query->row_array();
	}
	return $row;
}

/*담당영업사원*/
function get_saleman($user_no){
	$CI =& get_instance();
	$sql = "SELECT b.* FROM thd_customer a INNER JOIN thd_member b ON a.member_seq=b.seq WHERE customer_seq=".$user_no." LIMIT 1";
	$query = $CI->db->query($sql);
	$row = null;
	if ($query->num_rows() > 0){
		$row = $query->row_array();
	}
	return $row;
}



/**
 * uri 지정 배열 위치까지 가져오기
 *
 * @param integer
 * @return string : /first/second
 */
function get_index_uri($index){
	$CI =& get_instance();
	$CI->load->helper('url');
	$uri = null;
	foreach($CI->uri->segment_array() as $key => $value){
		$seg[] = $CI->uri->segment($key);
		if($key == $index){
			break;	
		}
	}
	$uri = implode('/',$seg);
	return $uri;
}


function create_preview_png($param){
	$font_ttf = $param['font_ttf'];
	$text = $param['sample_text'];
	$font_size = $param['font_size'];
	$f = explode('|',$font_ttf);
	$ttf = FCPATH.'upload/product/'.$f[0];
	
	$font_size = ($font_size*3)/4;
	//$font_size = $font_size.'pt';
	$padding = 5; 

	$size = imagettfbbox($font_size, 0, $ttf, $text);
	
	$xsize = abs($size[0]) + abs($size[2]) + $padding; 
	$ysize = abs($size[5]) + abs($size[1]) + $padding; 
	//$xsize = abs($size[0]) + abs($size[2]); 
	//$ysize = abs($size[5]) + abs($size[1]); 
	
	$xpadding = abs($size[0]);
	$ypadding = abs($size[5]);
	
	$limit_font = 10;
	$limit_x = 800;
	$limit_y = 100;
	if($xsize > $limit_x){
		$scale = $limit_x / $xsize;
		$xsize = $limit_x;
		//$scale = ($xsize  / 100); 
		//$font_size =  ceil($font_size * $scale) - ceil($scale)-0.5;
		$font_size =  ceil($font_size * $scale)-0.5;		
		//$ysize = ceil($limit_x * ($ysize / $xsize));	
		$ysize = ceil($font_size+15);	
		
		$ypadding = ceil($ypadding * $scale)+3;
	}

	if($ysize > $limit_y){
		$xsize = ceil($limit_y * ($xsize / $ysize));
		$ysize = $limit_y;
	}
	$image = imagecreate($xsize, $ysize);
	$blue = imagecolorallocate($image, 0, 0, 255);
	$white = ImageColorAllocate($image, 255,255,255);
	$black = imagecolorallocate($image, 0, 0, 0); // 검정색
	imagefilledrectangle ($image, 0, 0, $xsize, $ysize, $white);
	//imagettftext($image, $font_size, 0, abs($size[0]), abs($size[5])+($padding / 2), $black, $ttf,$text); 
	imagettftext($image, $font_size, 0, $xpadding , $ypadding , $black, $ttf,$text); 


	header("content-type: image/png");
	imagepng($image,FCPATH.'upload/preview/preview.png');
	imagedestroy($image);
}


function get_unique_no(){
	define('G_CONST_NOW',time());
	$CI =& get_instance();
	$CI->db->select_max('unique_no');
	$query = $CI->db->get('thd_unique_no'); 
	$row = $query->row_array();
	$max = $row['unique_no'];
	if (!empty($max)) {
		if (($time = (int)substr($max,0,10)) < G_CONST_NOW) {
			$time = G_CONST_NOW;
		}
	}
	else {
		$time = G_CONST_NOW;
	}

	$suffix = rand(0,999);
	$find = $ordno = false;
	$chker = 0;
	do {

		$chker++;

		$unique_no = $time.sprintf("%03d",$suffix);
		$query = $CI->db->insert('thd_unique_no', array('unique_no' =>$unique_no)); 
		
		if($CI->db->affected_rows() > 0) {
			$find = true;
			$old = ($time - 3600) .'999';
			$CI->db->where(array("unique_no < " => $old),false);
			$CI->db->delete('thd_unique_no');
			//echo $CI->db->last_query();
			//exit;
		}
		else {
			if ($suffix < 999) {
				$suffix++;
			}
			else {
				$time++;
				$suffix = 0;
			}
		}

	} while (! $find);

	return $unique_no;
}

function get_make_url(){
	$CI =& get_instance();
	$p = null;
	foreach($CI->input->get() as $key => $value){
		$p[] = $key.'='.$value; 
	}
	$para = (is_array($p)) ? '?'.implode('&',$p) : null;
	
	return '/'.uri_string().$para;
}

function set_stock($arr,$key='+'){
	$CI =& get_instance();
	$CI->db->where($arr);
	$query = $CI->db->get('thd_order_item');
	foreach($query->result() as $row){
		if($key == '+'){
			$CI->db->set('stock', 'stock+'.$row->ea, FALSE);
			$CI->db->update('thd_product',null,array('seq='=>$row->goods_no));
		}else{
			$CI->db->set('stock', 'stock-'.$row->ea, FALSE);
			$CI->db->update('thd_product',null,array('seq='=>$row->goods_no));
		}
	}
}

//재고체크
function check_stock($goods_no,$ea){
	$CI =& get_instance();
	$CI->db->where(array('seq' => $goods_no));
	$query = $CI->db->get('thd_product');
	
	if($query->num_rows() > 0){
		$row = $query->row_array();
		if(ceil($row['stock']) < $ea){
			return false;
		}else{
			return true;
		}
	}else{
		return false;
	}
}

//카테고리 트리 배열
function get_category_tree($category){
	$col = null;
	$nav = null;
	$CI =& get_instance();
	if($category){
		for($i=2; $i < strlen($category); $i+=2){
			$col[] = substr($category,0,$i);
		}

		$CI->db->where_in('category',$col);
		$query = $CI->db->get('thd_category');
		
		foreach($query->result() as $row){
			$nav[] = $row->category_name;
		}
	}
	return $nav;
}

//sms 발송
function sms_send($info){
	$CI =& get_instance();
	

	$sms_url = $CI->config->item('sms_url'); // 전송요청 URL
	$sms['user_id'] = base64_encode($CI->config->item('sms_id')); //SMS 아이디.
	$sms['secure'] = base64_encode($CI->config->item('sms_key')) ;//인증키
	$sms['msg'] = base64_encode(stripslashes($info['msg']));
	if( $info['smsType'] == "L"){
		  $sms['subject'] =  base64_encode($info['subject']);
	}
	$sms['rphone'] = base64_encode($info['rphone']);
	$sms['sphone1'] = base64_encode($info['sphone1']);
	$sms['sphone2'] = base64_encode($info['sphone2']);
	$sms['sphone3'] = base64_encode($info['sphone3']);
	$sms['rdate'] = base64_encode($info['rdate']);
	$sms['rtime'] = base64_encode($info['rtime']);
	$sms['mode'] = base64_encode("1"); // base64 사용시 반드시 모드값을 1로 주셔야 합니다.
	$sms['returnurl'] = base64_encode($info['returnurl']);
	$sms['testflag'] = base64_encode($info['testflag']);
	$sms['destination'] = strtr(base64_encode($info['destination']), '+/=', '-,');
	$returnurl = $info['returnurl'];
	$sms['repeatFlag'] = base64_encode($info['repeatFlag']);
	$sms['repeatNum'] = base64_encode($info['repeatNum']);
	$sms['repeatTime'] = base64_encode($info['repeatTime']);
	$sms['smsType'] = base64_encode($info['smsType']); // LMS일경우 L
	$nointeractive = $info['nointeractive']; //사용할 경우 : 1, 성공시 대화상자(alert)를 생략

	$host_info = explode("/", $sms_url);
    $host = $host_info[2];
    $path = $host_info[3];
	srand((double)microtime()*1000000);
	$boundary = "---------------------".substr(md5(rand(0,32000)),0,10);
	//print_r($sms);

	// 헤더 생성
	$header = "POST /".$path ." HTTP/1.0\r\n";
	$header .= "Host: ".$host."\r\n";
	$header .= "Content-type: multipart/form-data, boundary=".$boundary."\r\n";
	$data = '';
	// 본문 생성
	foreach($sms AS $index => $value){
		$data .="--$boundary\r\n";
		$data .= "Content-Disposition: form-data; name=\"".$index."\"\r\n";
		$data .= "\r\n".$value."\r\n";
		$data .="--$boundary\r\n";
	}
	$header .= "Content-length: " . strlen($data) . "\r\n\r\n";

	$fp = fsockopen($host, 80);

	if ($fp) {
		fputs($fp, $header.$data);
		$rsp = '';
		while(!feof($fp)) {
			$rsp .= fgets($fp,8192);
		}
		fclose($fp);
		$msg = explode("\r\n\r\n",trim($rsp));
		$rMsg = explode(",", $msg[1]);
		$Result= $rMsg[0]; //발송결과
		$Count= $rMsg[1]; //잔여건수
		
		$rst = array('err' => 0 , 'msg'=> '');
	
		//발송결과 알림
		if($Result=="success") {
		   $rst['err'] = 1;
		}
		else if($Result=="reserved") { //예약
		   $rst['err'] = 1;
		}
		else if($Result=="3205") {
			$rst['err'] = 0;
			$rst['msg'] = '잘못된 번호형식입니다.';
		}

		else if($Result=="0044") {
			$rst['err'] = 0;
			$rst['msg'] = '스팸문자는발송되지 않습니다.';
		}

		else {
			$rst['err'] = 0;
			$rst['msg'] = $Result;
		}
	}
	else {
		$rst['err'] = 0;
		$rst['msg'] = 'Connection Failed';
	}
	return $rst;
}

function sms_info(){
	$CI =& get_instance();
	/******************** 인증정보 ********************/
    $sms_url = 'http://sslsms.cafe24.com/sms_remain.php'; // 전송요청 URL
	$sms['user_id'] = base64_encode($CI->config->item('sms_id')); //SMS 아이디.
	$sms['secure'] = base64_encode($CI->config->item('sms_key')) ;//인증키
    $sms['mode'] = base64_encode("1"); // base64 사용시 반드시 모드값을 1로 주셔야 합니다.

    $host_info = explode("/", $sms_url);
    $host = $host_info[2];
    $path = $host_info[3];
    srand((double)microtime()*1000000);
    $boundary = "---------------------".substr(md5(rand(0,32000)),0,10);

    // 헤더 생성
    $header = "POST /".$path ." HTTP/1.0\r\n";
    $header .= "Host: ".$host."\r\n";
    $header .= "Content-type: multipart/form-data, boundary=".$boundary."\r\n";

    // 본문 생성
	$data = '';
    foreach($sms AS $index => $value){
        $data .="--$boundary\r\n";
        $data .= "Content-Disposition: form-data; name=\"".$index."\"\r\n";
        $data .= "\r\n".$value."\r\n";
        $data .="--$boundary\r\n";
    }
    $header .= "Content-length: " . strlen($data) . "\r\n\r\n";

    $fp = fsockopen($host, 80);

    if ($fp) {
        fputs($fp, $header.$data);
        $rsp = '';
        while(!feof($fp)) {
            $rsp .= fgets($fp,8192);
        }
        fclose($fp);
        $msg = explode("\r\n\r\n",trim($rsp));
        $Count = $msg[1]; //잔여건수
       
		echo number_format($Count);
    }
    else {
        echo "Connection Failed";
    }
     
}

//삼진타이어임시
function notice_alert(){
	$CI =& get_instance();
	/*$CI->db->select('DATEDIFF(now(),register_date) AS gap');
	$CI->db->where(array('menu_id' => 27));
	$CI->db->order_by('id DESC');
	$query = $CI->db->get('thd_board',1,0);
	//echo $CI->db->last_query();
	if($query->num_rows() > 0){
		$row = $query->row_array();
		$gap = ($row['gap'] < 7) ? true : false;
	}else{
		$gap = false;
	}*/
	$CI->db->where(array('code' => 'notice'));
	$query = $CI->db->get('thd_alim');
	if($query->num_rows() > 0){
		$row = $query->row_array();
		$gap = ($row['open_yn'] == 'y') ? true : false;
	}else{
		$gap = false;
	}

	return $gap;
}

function get_gategory_name($category){
	$CI =& get_instance();
	$CI->db->where(array('category' => $category));
	$query = $CI->db->get('thd_category');
	$cname = null;
	if($query->num_rows() > 0){
		$row = $query->row_array();
		$cname = $row['category_name'];
	}
	return $cname;
}

?>