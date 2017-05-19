<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<!-- <div class="panel-heading">
				Basic Form Elements
			</div> -->
			<div class="panel-body">
				 <table class="table table-striped table-bordered table-hover">
					<colgroup>
						<col width="10%"/>
						<col />
						<col width="15%"/>
						<col width="15%"/>
					</colgroup>
					<thead>
						<tr>
							<th>번호</th>
							<th>제목</th>
							<th>이름</th>
							<th>등록일</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach($_query->result() as $row){
						?>
						<tr>
							<td><?=$_list_no?></td>
							<td><a href="/thdadmin/enquiry_view?language=<?=$_language?>&id=<?=$row->id?>&page=<?=$_page?>"><?=$row->title?></a></td>
							<td><?=$row->name?></td>
							<td><?=date('Y.m.d H:i',strtotime($row->regist_date))?></td>
						</tr>
						<?php
								$_list_no--;
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