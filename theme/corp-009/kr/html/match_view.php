<?
$country = $this->input->get("country",true);
$keyname = $this->input->get("keyname",true);
$keyword = $this->input->get("keyword",true);
$_country = $this->config->item('country');
$_stage_of_develop = $this->config->item('stage_of_develop');

$querystring = '&language='.$this->language.'&country='.$country.'&keyname='.$keyname.'&keyword='.urlencode($keyword);
$seq = $this->input->get("seq");
$arr = array('seq' => $seq);

$query_prev =  $this->db->where(array(' seq > '=>$seq))->order_by('seq')->get('thd_tech_matching',1);
$query_next =  $this->db->where(array(' seq < '=>$seq))->order_by('seq DESC')->get('thd_tech_matching',1);

$this->db->select("*");
$this->db->where($arr);
$query = $this->db->get('thd_tech_matching');
$row = $query->row_array();

?>
<div id="section" pgCode="0203">
    <!-- 내용 -->

    <!--게시판 상세(기술매칭) start-->
    <div class="tec_tb" style="margin:0;">
        <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr>
            <td width="30%;">Country</td>
            <td width="70%;"><?=($row['country']) ? $_country[$row['country']] : null?></td>
        </tr>
        <tr>
            <td>City</td>
            <td><?=$row['city']?></td>
        </tr>
        <tr>
            <td>Subject</td>
            <td><?=$row['title']?></td>
        </tr>
        <tr>
            <td>Keywords</td>
            <td><?=$row['keywords']?></td>
        </tr>
        <tr>
            <td>Summary</td>
            <td><?=$row['summary']?></td>
        </tr>
        <tr>
            <td>Description</td>
            <td><?=$row['description']?></td>
        </tr>
        <tr>
            <td>Advantages and Innovations</td>
            <td><?=$row['advantages']?></td>
        </tr>
        <tr>
            <td>Attachments</td>
            <td class="att_txt">
			<?
			if($row['attache_file1']){
				$f = explode('|',$row['attache_file1']);
				echo '<a href="/front/download?fpath='.$f[2].'&fname='.$f[1].'">'.$f[1].'</a>';
			}
			?>
        </tr>
        <tr>
            <td>IPR status </td>
            <td><?=$row['ipr_status']?></td>
        </tr>
        <tr>
            <td>Stage of Development </td>
            <td><?=($row['stage_of_develop']) ? $_stage_of_develop[$row['stage_of_develop']] : null?></td>
        </tr>
        <tr>
            <td>Partner sought</td>
            <td><?=$row['partner_sought']?></td>
        </tr>
        </table>

    </div>
    <!--게시판 상세(기술매칭) end-->

    <div class="btnArea">
        <a class="btnNormal" href="match?<?=$querystring?>"><span>목록</span></a>
    </div>

    <!--이전/다음글  start-->
    <div class="pageNavigation">
        <dl class="prev">
        <dt>이전글</dt>
        <dd>
		<?
		if($query_prev->num_rows() > 0){
			foreach($query_prev->result() as $row){
				echo '<a href="?seq='.$row->seq.$querystring.'">'.$row->title.'</a>';
			}
		}else{
			echo '이전 글이 없습니다.';
		}
		?>
		</dd>
        </dl>
        <dl class="next">
        <dt>다음글</dt>
        <dd>
		<?
		if($query_next->num_rows() > 0){
			foreach($query_next->result() as $row){
				echo '<a href="?seq='.$row->seq.$querystring.'">'.$row->title.'</a>';
			}
		}else{
			echo '다음 글이 없습니다.';
		}
		?>
		</dd>
        </dl>
    </div>
    <!--이전/다음글  end-->

</div>
<!-- section -->
