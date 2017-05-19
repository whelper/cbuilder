<?
$_career = $this->config->item('career');
$keyname = $this->input->get("keyname",true);
$keyword = $this->input->get("keyword",true);

$querystring = '&language='.$this->language.'&keyname='.$keyname.'&keyword='.urlencode($keyword);
$seq = $this->input->get("seq");
$arr = array('seq' => $seq);

$query_prev =  $this->db->where(array(' seq > '=>$seq))->order_by('seq')->get('thd_recruit',1);
$query_next =  $this->db->where(array(' seq < '=>$seq))->order_by('seq DESC')->get('thd_recruit',1);

$this->db->select("*");
$this->db->where($arr);
$query = $this->db->get('thd_recruit');
$row = $query->row_array();

?>
<div id="section" pgCode="0405">
    <!-- 내용 -->
    <!--게시판 상세 start-->
    <div class="board_view">
        <div class="rec_top">
            <!-- PC버전 -->
            <div class="rec_pc">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center" bgcolor="#f0f8fa" class="tt">모집부문</td>
                    <td colspan="3"><?=$row['title']?></td>
                </tr>
                <tr>
                    <td width="15%" align="center" bgcolor="#f0f8fa" class="tt">접수기한</td>
                    <td width="35%">
					<?
						if($row['start_date'] && $row['end_date']){
							echo $row['start_date'] .' ~ '.$row['end_date'];
						}else{
							echo '상시';
						}
					?>
					</td>
                    <td width="15%" align="center" bgcolor="#f0f8fa" class="tt">지역</td>
                    <td width="35%"><?=$row['area']?></td>
                </tr>
                <tr>
                    <td align="center" bgcolor="#f0f8fa" class="tt">경력</td>
                    <td><?=$_career[$row['career']]?></td>
                    <td align="center" bgcolor="#f0f8fa" class="tt">상태</td>
                    <td><?=($row['ing_yn'] == 'y') ? '진행중' : '종료'?></td>
                </tr>
                </table>
            </div>

            <!-- 모바일버전 -->
            <div class="rec_m">
                <div class="view_top">
                    <p><?=$row['title']?></p>
                    <ul>
                        <li>
						<?
							if($row['start_date'] && $row['end_date']){
								echo $row['start_date'] .' ~ '.$row['end_date'];
							}else{
								echo '상시';
							}
						?>
						</li>
                    </ul>
                </div>
                <div class="state">
                    <dl>
                    <dt>경력</dt>
                    <dd><?=$_career[$row['career']]?></dd>
                    <dt>지역</dt>
                    <dd><?=$row['area']?></dd>
                    <dt>상태</dt>
                    <dd><?=($row['ing_yn'] == 'y') ? '진행중' : '종료'?></dd>
                    </dl>
                </div>
            </div>
        </div>
        <!-- rec_top -->
        <div class="attach">
            <dl>
            <dt><img src="<?=$this->theme_path?>/images/board/file.gif" alt="파일" /></dt>
            <?
			for($i=1; $i<=3; $i++){
				if($row['attache_file'.$i]){
					$f = explode('|',$row['attache_file1']);
					echo '<dd><a href="/front/download?fpath='.$f[2].'&fname='.$f[1].'">'.$f[1].'</a></dd>'.chr(10); 
				}
				
			}
			?>
            </dl>
        </div>
        <div class="view_con">
            <?=$row['content']?>

        </div>
    </div>
    <!--게시판 상세 end-->

    <div class="btnArea">
        <a class="btnNormal" href="recruit?<?=$querystring?>"><span>목록</span></a>
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
