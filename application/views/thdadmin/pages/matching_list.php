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
						<col width="8%"/>
						<col width="12%"/>
						<col width="12%" />
						<col />
						<col width="8%"/>
						<col width="12%"/>
					</colgroup>
					<thead class="tb-header">
						<tr>
							<th><input type="checkbox" class="all-check"></th>
							<th>번호</th>
							<th>구분</th>
							<th>도시</th>
							<th>제목</th>
							<th>승인여부</th>
							<th>등록일</th>
						</tr>
					</thead>
					<tbody class="tb-body">
						<?php
							$_approval = $this->config->item('approval');
							if ($_query->num_rows() > 0){
								foreach($_query->result() as $row){
									
						?>
						<tr>
							<td><input type="checkbox" class="list-check"></td>
							<td><?=$_list_no?></td>
							<td><?=$row->country?></td>
							<td><?=$row->city?></td>
							<td class="title"><a href="/thdadmin/matching_view?language=<?=$_language?>&seq=<?=$row->seq?>&page=<?=$_page?>"><?=$row->title?></a></td>
							<td><?=$_approval[$row->approval]?></td>
							<td><?=date('Y.m.d',strtotime($row->reg_date))?></td>
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