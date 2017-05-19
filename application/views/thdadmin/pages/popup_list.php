<div class="row">
	<div class="col-lg-12">
		<div class="wrap-tab-lang">
			<ul class="nav nav-tabs view-lang">
				<?
				foreach($this->config->item('view_languge') as $k => $v){
					$_css= ($this->language==$k) ? 'active' : '';
					echo '<li lang="'.$k.'" class="'.$_css.'"><a href="?language='.$k.'">'.$v.'</a></li>'.chr(10);
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
						<col width="5%"/>
						<col width="5%"/>
						<col width="20%"/>
						<col />
						
					</colgroup>
					<thead class="tb-header">
						<tr>
							<th>번호</th>
							<th>표시</th>
							<th>기간</th>
							<th>제목</th>
						</tr>
					</thead>
					<tbody class="tb-body">
						<?php
							if ($_query->num_rows() > 0){
								foreach($_query->result() as $row){
						?>
						<tr>
							<td><?=$_list_no?></td>
							<td><?=$row->use_yn?></td>
							<td><?=$row->start_date.' ~ '.$row->end_date?></td>
							<td class="title"><a href="/thdadmin/popup_form?language=<?=$_language?>&id=<?=$row->id?>&page=<?=$_page?>"><?=$row->title?></a></td>
						</tr>
						<?php
									$_list_no--;
								}
							}else{
								echo '<tr><td colspan="5" align="center" style="background:#fff">등록된 데이터가 없습니다.</td></tr>';
							}
						?>
						
					</tbody>
				</table>
				<div class="row">
					<div class="col-md-6">
						<a class="btn btn-primary" href="/thdadmin/popup_form?language=<?=$_language?>" style="margin:20px 0;">팝업등록</a>
					</div>
					<div class="col-md-6" align="right">
						<ul class="pagination">
							<?=$_paging?>
						</ul>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>