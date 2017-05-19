<div class="row">
	<div class="col-lg-12">
		<div class="wrap-tab-lang">
			<ul class="nav nav-tabs view-lang">
				<?
				foreach($this->config->item('view_languge') as $k => $v){
					$_css= ($this->language==$k) ? 'active' : '';
					echo '<li lang="'.$k.'" class="'.$_css.'"><a href="?language='.$k.'&menu_id='.$menu_id.'">'.$v.'</a></li>'.chr(10);
				}
				?>
			</ul>
		</div>
		<div class="panel panel-default">
			<!-- <div class="panel-heading">
				Basic Form Elements
			</div> -->
			<div class="panel-body">
				 <table class="table table-striped table-bordered table-hover">
					<colgroup>
						<col width="8%"/>
						<col width="8%"/>
						<col />
						<col width="8%" />
						<col width="8%"/>
						<col width="8%"/>
					</colgroup>
					<thead class="tb-header">
						<tr>
							<th>번호</th>
							<th>메인표시</th>
							<th>제목</th>
							<th>작성자</th>
							<th>조회수</th>
							<th>작성일</th>
						</tr>
					</thead>
					<tbody class="tb-body">
						<?php
							if ($_query->num_rows() > 0){
								foreach($_query->result() as $row){
									$icon_attach = null;
									$query_file = $this->board_model->board_file_list(array('menu_id'=>$menu_id,'board_no'=>$row->id));
									if($query_file->num_rows() > 0){
										$icon_attach = '<i class="fa-download fa"></i>';
									}
																	
									$reply_css = null;
									$reply_icon = null;
									if($row->depth > 0){ 
										$reply_css = "reply".$row->depth;
										$reply_icon = '<i class="fa-arrow-right fa"></i> ';
									}
									
									
									$p = array('menu_id='.$row->menu_id,'language='.$_language,'id='.$row->id,'page='.$_page);
									$p = implode('&',$p);
						?>
						<tr class="<?=($row->notice > 0)? 'notice':''?>">
							<td><?=($row->notice > 0) ? '<i class="fa  fa-volume-up "></i>' : $_list_no?></td>
							<td><?=$row->main_yn?></td>
							<td class="title"><a href="/thdadmin/board_view?<?=$p?>" class="<?php echo $reply_css;?>"><?php echo $reply_icon;?><?php if($row->cate) echo '['.$row->cate.'] ';?><?=$row->title?></a></td>
							<td><?=$row->writer?></td>
							<td><?=$row->view_count?></td>
							<td><?=date('Y.m.d',strtotime($row->register_date))?></td>
						</tr>
						<?php
									$_list_no--;
								}
							}else{
								echo '<tr><td colspan="10" align="center" style="background:#fff">등록된 데이터가 없습니다.</td></tr>';
							}
						?>
						
					</tbody>
				</table>
				<div class="row">
					<div class="col-md-6">
						<a class="btn btn-primary" href="/thdadmin/board_form?menu_id=<?=$menu_id?>&language=<?=$_language?>" style="margin:20px 0;">글쓰기</a>
					</div>
					<div class="col-md-6" align="right">
						<ul class="pagination">
							<?=$_paging?>
						</ul>
					</div>
				</div>
				<!-- <div style="text-align:right;border:1px solid red;">
					<ul class="pagination">
						<?=$_paging?>
					</ul>
				</div> -->
			</div>
			
		</div>
	</div>
</div>