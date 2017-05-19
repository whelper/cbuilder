<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default  forms">
			<!-- <div class="panel-heading">
				Basic Form Elements
			</div> -->
			<div class="panel-body">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
					<tbody>
						<tr>
							<th width="150">제목</th>
							<td colspan="3"><?=$title?></td>
						</tr>
						<tr>
							<th width="150">작성자</th>
							<td><?=$writer?></td>
							<th width="150">작성일</th>
							<td><?=date('Y.m.d H:i',strtotime($register_date))?></td>
						</tr>
						<tr>
							<td colspan="4">
								<div class="span12">
									<ul class="attach-file">
										<?php echo $attach;?>
									</ul>
								</div>
								<?php echo $content;?>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="row">
					<div class="col-md-6">
						<a class="btn btn-default" onclick="javascript:history.back();">목 록</a>
					</div>
					<div class="col-md-6" align="right">
						<a class="btn btn-primary" onclick="javascript:board('u');">수 정</a>
						<a class="btn btn-primary" onclick="javascript:board('r');">답 변</a>
						<a class="btn btn btn-danger" onclick="javascript:board('d');">삭 제</a>
					</div>
				</div>
			</div>
		
		</div>
	</div>
</div>

<form name="frm" method="post">
	<input type="hidden" name="dbjob" value="">
	<input type="hidden" name="id" value="<?php echo $id;?>">
	<input type="hidden" name="menu_id" value="<?php echo $menu_id;?>">
</form>

<script type="text/javascript">
	//<![CDATA[  
	function board(db){ //게시판 상세 액션별 페이지 분기
			var submit_url = '/thdadmin/board_dbjob';
			if(db == 'd'){
				if(!confirm("삭제 하시겠습니까?")) return;
			}else{
				submit_url = '/thdadmin/board_form?menu_id=<?=$menu_id?>&language=<?=$_language?>&id=<?=$id?>';
			}
			
			with(document.frm){
				dbjob.value = db;
				action = submit_url;
				submit();
			}
		}
	//]]>
</script>
