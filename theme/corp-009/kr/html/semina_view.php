<?
$keyname = $this->input->get("keyname",true);
$keyword = $this->input->get("keyword",true);
$_country = $this->config->item('country');
$_week = $this->config->item("week");

$querystring = '&language='.$this->language.'&keyname='.$keyname.'&keyword='.urlencode($keyword);
$seq = $this->input->get("seq");
$arr = array('seq' => $seq);

$query_prev =  $this->db->where(array(' seq > '=>$seq))->order_by('seq')->get('thd_seminar',1);
$query_next =  $this->db->where(array(' seq < '=>$seq))->order_by('seq DESC')->get('thd_seminar',1);

$this->db->select("*");
$this->db->where($arr);
$query = $this->db->get('thd_seminar');
$row = $query->row_array();

?>
<div id="section" pgCode="0402">
    <!-- 내용 -->
    <!--게시판 상세 start-->
    <div class="board_view">
        <div class="event_top">
            <ul onclick="location.href='semina_view.php'">
                <li class="sum">
                <div class="sum_img">
				<?
				if($row['attache_file1']){
					$f = explode('|',$row['attache_file1']);
					$t = explode('.',$f[0]);
					echo '<img src="/upload/seminar/'.($t[0].'_thumb.'.$t[1]).'" />';
				}
				?>
				</div>
                </li>
                <li class="ex">
                <p class="<?=($row['ing_yn'] == 'y') ? 'st_on' : 'st_off'?>"><?=($row['ing_yn'] == 'y') ? '진행중' : '종료'?></p>
                <p class="tt"><?=($row['country']) ? '['.$_country[$row['country']].']' : null?><?=$row['title']?></p>
                <dl>
                <dt>일정</dt>
                <dd>
				<?
				if($row['start_date'] && $row['end_date']){
					echo $row['start_date'] .'('.$_week[date('w',strtotime($row['start_date']))].') ~ '.$row['end_date'].'('.$_week[date('w',strtotime($row['end_date']))].') ';
				}else{
					echo '상시';
				}

				if($row['hh']){
					echo ($row['ampm'] == 'am') ? '오전' : '오후';
					echo $row['hh'].'시';
				}
				?>
				</dd>
                <dt>장소</dt>
                <dd><?=$row['location']?></dd>
                <dt>개요</dt>
                <dd><?=$row['summary']?></dd>
                </dl>
                </li>
            </ul>
        </div>

        <div class="view_con">
            <?=$row['content']?>
        </div>
    </div>
    <!--게시판 상세 end-->

    <div class="btnArea">
        <a class="btnNormal" href="semina?<?=$querystring?>"><span>목록</span></a>
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
