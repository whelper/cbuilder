<?
$listnum = 5;
$_country = $this->config->item("country");
$_week = $this->config->item("week");

$keyname = $this->input->get("keyname",true);
$keyword = $this->input->get("keyword",true);
$page = ($this->input->get("page",true)) ? $this->input->get("page",true) : 1;

$_where[] = " language IN('".$this->language."') AND open_yn='y'";

if($keyword){
	if($keyname){
		$_where[] = $keyname." LIKE  '%".$keyword."%'";
	}else{
		$_where[] = "(title LIKE  '%".$keyword."%' OR content LIKE  '%".$keyword."%')";
	}
}

$where = implode(' AND ',$_where);

$offset = $listnum *($page-1);
$count = $this->db->where($where)->count_all_results('thd_seminar');

$this->db->order_by('seq DESC');
$this->db->where($where);
$query = $this->db->get('thd_seminar',$listnum,$offset);


$list_no = $count - $listnum * ($page-1);

$querystring = '&language='.$this->language.'&keyname='.$keyname.'&keyword='.urlencode($keyword);
$this->load->library('pagination');		
$config['listnum'] = $listnum ;
$config['total_rows'] = $count;
$config['block'] = 10;
$config['page'] = $page;
$config['querystring'] = $querystring;
$config['theme'] = $this->theme_path;

$this->pagination->initialize($config);
?>
<div id="section" pgCode="0402">
    <!-- 내용 -->
    <!-- 검색바 start -->
    <div class="bd_search_bar">
        <div class="bd_sc_con">
            <form name="frm">
			<ul>
                <li class="selectType searchTopSel">
                <select name="keyname" id="keyname" class="selectCus">
				<option value="">전체</option>
                <option value="title" <?=($keyname == 'title') ? 'selected' : null?>>제목</option>
                <option value="content" <?=($keyname == 'content') ? 'selected' : null?>>내용</option>
                </select>
                </li>
                <li class="inp_sc">
                <input type="text" name="keyword" id="keyword" value="<?=$keyword?>" placeholder=" 검색어를 입력하세요" >
                </li>
                <li class="btn_sc">
                <a class="btnNormal" href="javascript:searchGo();"><span>검색</span></a>
                </li>
            </ul>
			</form>
		</div>
    </div>
    <!-- 검색바 end-->

    <!--이벤트 리스트 start-->
    <div class="event_list">
        <?
		if($query->num_rows() > 0){
			$j = 0;
			foreach($query->result() as $row){
				$thumb = null;
				if($row->attache_file1){
					$f = explode('|',$row->attache_file1);
					$t = explode('.',$f[0]);
					$thumb = '<img src="/upload/seminar/'.($t[0].'_thumb.'.$t[1]).'" />';
				}
				
			?>
		<ul onclick="location.href='semina_view?seq=<?=$row->seq?>&page=<?=$page?><?=$querystring ?>'">
            <li class="sum">
            <div class="sum_img"><?=$thumb?></div>
            </li>
            <li class="ex">
            <p class="<?=($row->ing_yn == 'y') ? 'st_on' : 'st_off'?>"><?=($row->ing_yn == 'y') ? '진행중' : '종료'?></p>
            <p class="tt"><?=($row->country) ? '['.$_country[$row->country].']' : null?><?=$row->title?></p>
            <dl>
            <dt>일정</dt>
            <dd>
			<?
			if($row->start_date && $row->end_date){
				echo $row->start_date .'('.$_week[date('w',strtotime($row->start_date))].') ~ '.$row->end_date.'('.$_week[date('w',strtotime($row->end_date))].') ';
			}else{
				echo '상시';
			}

			if($row->hh){
				echo ($row->ampm == 'am') ? '오전' : '오후';
				echo $row->hh.'시';
			}
			?>
			</dd>
            <dt>장소</dt>
            <dd><?=$row->location?></dd>
            <dt>개요</dt>
            <dd><?=$row->summary?></dd>
            </dl>
            </li>
        </ul>
		<?
			$list_no--;
			}
		}
		?>
       
    <!--이벤트 리스트 end-->

    <!--페이징 start-->
    <div class="paging_all c_box mt10">
        <div class="paging">
            <?=$this->pagination->create_links()?>
        </div>
    </div>
    <!--페이징 end-->
</div>
<!-- section -->
<script type="text/javascript">
//<![CDATA[
	function searchGo(){
		with(document.frm){
			submit();
		}
	}

	
//]]>
</script>
