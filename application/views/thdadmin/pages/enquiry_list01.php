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
						<!-- <col width="15%"/> -->
						<col />
						<col width="15%"/>
						<col width="8%"/>
						<col width="15%"/>
					</colgroup>
					<thead class="tb-header">
						<tr>
							<th>번호</th>
							<!-- <th>카테고리</th> -->
							<th>제품명</th>
							<th>연락처</th>
							<th>처리상태</th>
							<th>등록일</th>
						</tr>
					</thead>
					<tbody class="tb-body">
						<?php
							foreach($_query->result() as $row){
						?>
						<tr>
							<td><?=$_list_no?></td>
							<!-- <td><?=$row->c_cate?></td> -->
							<td><a href="/thdadmin/enquiry_view?language=<?=$_language?>&seq=<?=$row->seq?>&page=<?=$_page?>"><?=$row->title?></a></td>
							
							<td><?=$row->phone?></td>
							<td>
								<select class="form-control modify-proc" data-seq="<?=$row->seq?>">
								<option value="">---------</option>
								<?
								foreach($this->config->item('proc_step') as $key => $value){
									$selected = ($row->proc_step == $key) ? 'selected' : null;
									echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>'.chr(10);
								}
								?>
								</select>
							</td>
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
<form name="frm" action="enquiry_dbjob" method="post">
<input type="hidden" name="seq" value="" />
<input type="hidden" name="dbjob" value="u" />
<input type="hidden" name="proc_step" value="" />
</form>
<script type="text/javascript">
	$(function(){
		$(".modify-proc").change(function(){
			if($(this).val()){
				$("[name=seq]").val($(this).attr("data-seq"));
				$("[name=proc_step]").val($(this).val());
				$("[name=frm]").submit();
			}
		});
	});
</script>