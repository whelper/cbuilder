<?
$listnum = 10;
$_career = $this->config->item('career');
$keyname = $this->input->get("keyname",true);
$keyword = $this->input->get("keyword",true);

$page = ($this->input->get("page",true)) ? $this->input->get("page",true) : 1;

$_where[] = " language IN('".$this->language."') AND open_yn='Y'";

if($keyword){
	if($keyname){
		$_where[] = $keyname." LIKE  '%".$keyword."%'";
	}else{
		$_where[] = "(title LIKE  '%".$keyword."%' OR content LIKE  '%".$keyword."%')";
	}
}

$where = implode(' AND ',$_where);

$offset = $listnum *($page-1);
$count = $this->db->where($where)->count_all_results('thd_recruit');

$this->db->order_by('seq DESC');
$this->db->where($where);
$query = $this->db->get('thd_recruit',$listnum,$offset);


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
<div id="section" pgCode="0405">
    <!-- 내용 -->
    <!-- 검색바 start -->
    <div class="bd_search_bar">
        <div class="bd_sc_con">
            <form name="frm">
			<ul>
                <li class="selectType searchTopSel">
                <select name="keyname" id="keyname" class="selectCus">
				<option value="">전체</option>
                <option value="title" <?=($keyname == 'title') ? 'selected' : null?>>모집부문</option>
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

    <!--게시판 리스트(채용정보) start-->
    <div class="pc_board">

        <div class="board_list3">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <thead>
            <tr class="custb_title">
                <th scope="col" class="bdt01" >모집부문</th>
                <th scope="col" class="bdt02">경력</th>
                <th scope="col" class="bdt03" >지역</th>
                <th scope="col" class="bdt04">접수기간</th>
                <th scope="col" class="bdt05">상태</th>
            </tr>
            </thead>
            <tbody>
            <?
			if($query->num_rows() > 0){
				$j = 0;
				foreach($query->result() as $row){
					
			?>
			<tr>
                <td class="bdt01 bd_tt">
                    <p class="title">
                    <a href="recruit_view?seq=<?=$row->seq?>&page=<?=$page?><?=$querystring ?>" ><?=$row->title?></a>
                    </p>
                    <p class="mobile_date">
                    <span>
					<?
						if($row->start_date && $row->end_date){
							echo $row->start_date .' ~ '.$row->end_date;
						}else{
							echo '상시';
						}
					?>
					</span>
                    </p>
                </td>
                <td class="bdt02">
                    <?=$_career[$row->career]?>
                </td>
                <td class="bdt03"><?=$row->area?></td>
                <td class="bdt04">
                <?
					if($row->start_date && $row->end_date){
						echo $row->start_date .' ~ '.$row->end_date;
					}else{
						echo '상시';
					}
				?>
                </td>
                <td class="bdt05"><?=($row->ing_yn == 'y') ? '<p class="st_on">진행중</p>' : '<p class="st_off">종료</p>'?></td>
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
    <!--게시판 리스트(채용정보) end-->

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