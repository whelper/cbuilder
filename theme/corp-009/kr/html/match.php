<?
$listnum = 10;
$_country = $this->config->item('country');
$country = $this->input->get("country",true);
$keyname = $this->input->get("keyname",true);
$keyword = $this->input->get("keyword",true);

$page = ($this->input->get("page",true)) ? $this->input->get("page",true) : 1;

$_where[] = " language IN('".$this->language."')";

if($keyword){
	if($keyname){
		$_where[] = $keyname." LIKE  '%".$keyword."%'";
	}else{
		$_where[] = "(title LIKE  '%".$keyword."%' OR summary LIKE  '%".$keyword."%' OR name LIKE  '%".$keyword."%')";
	}
}

if($country){
	" country IN('".$country."')";
}

$where = implode(' AND ',$_where);

$offset = $listnum *($page-1);
$count = $this->db->where($where)->count_all_results('thd_tech_matching');

$this->db->order_by('seq DESC');
$this->db->where($where);
$query = $this->db->get('thd_tech_matching',$listnum,$offset);


$list_no = $count - $listnum * ($page-1);

$querystring = '&language='.$this->language.'&country='.$country.'&keyname='.$keyname.'&keyword='.urlencode($keyword);
$this->load->library('pagination');		
$config['listnum'] = $listnum ;
$config['total_rows'] = $count;
$config['block'] = 10;
$config['page'] = $page;
$config['querystring'] = $querystring;
$config['theme'] = $this->theme_path;

$this->pagination->initialize($config);
?>
<div id="section" pgCode="0203">
    <!-- 내용 -->
    <!-- 검색바(기술매칭) start -->
    <div class="bd_search_bar2">
        <div class="bd_sc_con2">
            <form name="frm">
			<ul>
                <li class="selectType searchTopSel2">
                <select name="country" id="country" class="selectCus">
                <option value="">국가전체</option>
                <?
				foreach($_country as $k => $v){
					$_selected = ($this->input->get('country') == $k) ? 'selected' : null;
					echo '<option value="'.$k.'" '.$_selected.'>'.$v.'</option>'.chr(10);
				}
				?>
                </select>
                </li>
                <li class="selectType searchTopSel3">
                <select name="keyname" id="keyname" class="selectCus">
                <option value="">전체</option>
                <OPTION VALUE="name" <?=($keyname == 'name') ? 'selected' : null?>>작성자명</OPTION>
                <OPTION VALUE="title" <?=($keyname == 'title') ? 'selected' : null?>>제목</OPTION>
                <OPTION VALUE="summary" <?=($keyname == 'summary') ? 'selected' : null?>>내용</OPTION>
                </select>
                </li>
                <li class="inp_sc">
                <input type="text" name="keyword" id="keyword" value="<?=$keyword?>" placeholder=" 검색어를 입력하세요" >
                </li>
                <li class="btn_sc2">
                <a class="btnNormal2" href="javascript:searchGo();"><span>검색</span></a>
                </li>
            </ul>
			</form>
        </div>
    </div>
    <!-- 검색바(기술매칭) end-->

    <!--게시판 리스트(기술매칭) start-->
    <div class="pc_board">

        <div class="board_list2">

            <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <thead>
            <tr class="custb_title">
                <th scope="col" class="bdt01" >No</th>
                <th scope="col" class="bdt02">국가</th>
                <th scope="col" class="bdt03" >도시</th>
                <th scope="col" class="bdt04">제목</th>
                <th scope="col" class="bdt05">등록일</th>
            </tr>
            </thead>
            <tbody>
           	<?
			if($query->num_rows() > 0){
				$j = 0;
				foreach($query->result() as $row){
					$icon_new = null;
					if(strtotime($row->reg_date) >= (time() - (24 * 3600) * 7)) {
						$icon_new = '<img src="'.$this->theme_path.'/images/board/new.gif" alt="new" />';
					}
					
			?>
			<tr>
                <td class="bdt01"><?=$list_no?></td>

                <td class="bdt02">
                    <?=($row->country) ? $_country[$row->country] : null?>
                </td>
                <td class="bdt03"><?=$row->city?></td>
                <td class="bdt04 bd_tt">
                    <p class="title">
                    <a href="match_view?seq=<?=$row->seq?>&page=<?=$page?><?=$querystring?>" ><?=$row->title?></a><?=$icon_new?>
                    </p>
                    <p class="mobile_date">
                    <span class="nation"><?=($row->country) ? $_country[$row->country] : null?></span>
                    <img src="<?=$this->theme_path?>/images/board/mbd_line.gif" alt="" />
                    <span class="city"><?=$row->title?></span>
                    <span class="date"><?=date('Y-m-d',strtotime($row->reg_date))?></span>
                    </p>
                </td>
                <td class="bdt05"><?=date('Y-m-d',strtotime($row->reg_date))?></td>
            </tr>
			<?
				$list_no--;
				}
			}
			?>
          
            </tbody>
            </table>
        </div>
    </div>
    <!--게시판 리스트(기술매칭) end-->

    <div class="btnArea">
        <a class="btnNormal" href="match_write"><span>기술등록</span></a>
    </div>

    <!--페이징 start-->
    <div class="paging_all c_box">
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