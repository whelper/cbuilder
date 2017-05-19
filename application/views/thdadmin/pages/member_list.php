<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<!-- <div class="panel-heading">
				Basic Form Elements
			</div> -->
			<div class="panel-body">
				<div>
					<form name="frmSearch">
					<input type="hidden" name="language" value="<?=$_language?>">
					<input type="hidden" name="membership" value="<?=$_membership?>">
					
					<select  name="keyname" class="form-control" style="width:150px;display:inline">
						<option value="">----------</option>
						<option value="name">이름</option>
						<option value="user_id">아이디</option>
					</select>
					<input type="text" class="form-control" name="keyword" style="width:300px;display:inline" value="" placeholder="검색어"/>
					<input type="submit" class="btn btn-primary" style="margin-top:-5px" value="검 색"/>
					</form>
				</div>
			</div>
			<div class="panel-body">
				 <table class="table table-striped table-bordered table-hover">
					<colgroup>
						<col width="5%"/>
						<col width="10%"/>
						<col width="15%"/>
						<col />
						<col width="15%"/>
						<col width="15%"/>
					</colgroup>
					<thead class="tb-header">
						<tr>
							<th>번호</th>
							<th>사용여부</th>
							<th>아이디</th>
							<th>이름</th>
							<th>연락처</th>
							<th>등록일</th>
						</tr>
					</thead>
					<tbody class="tb-body">
						<?php
							foreach($_query->result() as $row){
						?>
						<tr>
							<td><?=$_list_no?></td>
							<td><?=$row->open_yn?></td>
							<td><?=$row->user_id?></td>
							<td><a href="/thdadmin/member_form?language=<?=$_language?>&seq=<?=$row->seq?>&page=<?=$_page?>&<?=$_param?>"><?=$row->name?></a></td>
							<td><?=$row->hp?></td>
							<td><?=date('Y.m.d H:i',strtotime($row->reg_date))?></td>
						</tr>
						<?php
								$_list_no--;
							}
						?>
						
					</tbody>
				</table>
				<div class="row">
					<div class="col-md-6">
						<a class="btn btn-primary" href="/thdadmin/member_form?language=<?=$_language?>&membership=<?=$_membership?>" style="margin:20px 0;">등록</a>
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