<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<!-- <div class="panel-heading">
				Basic Form Elements
			</div> -->
			<div class="panel-body">
				 <table class="table table-striped table-bordered table-hover">
					<colgroup>
						<col/>
						<col width="8%" />
						<col width="8%" />
						<col width="8%"/>
						<col width="8%"/>
					</colgroup>
					<thead class="tb-header">
						<tr>
							<th>게시판명</th>
							<th>보기</th>
							<th>총게시물</th>
							<th>사용여부</th>
							<th>미리보기</th>
						</tr>
					</thead>
					<tbody class="tb-body">
						<?php
							foreach($_query->result() as $row){
								$url = $this->menu_model->menu_create_url($row->menu_id); 
								$json = json_decode($row->settings,true);
						?>
						<tr>
							<td><a href="/thdadmin/menu_form?menu_id=<?=$row->menu_id?>&language=<?=$_language?>"><?=$row->title?></a></td>
							<td><?=($json['board_type'] == 1) ? '일반' : '갤러리형'?></td>
							<td><?=$row->cnt?></td>
							<td><?=$row->use_yn?></td>
							<td align="center"><a href="<?=$url?>" target="_blank"><i class="fa fa-eye"></i></a></td>
						</tr>
						<?php
							}
						?>
						
					</tbody>
				</table>
				<div style="text-align:right">
					<ul class="pagination">
						<?=$_paging?>
					</ul>
				</div>
			</div>
			
		</div>
	</div>
</div>