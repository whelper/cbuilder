<?php
$useful_grade = null;
$_group = array();
foreach($_query->result() as $row){
	$useful_grade[] = $row->group_id;
	$_group[$row->group_id] = array('title' => $row->title);
}

?>
 <div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<!-- <div class="panel-heading">
				Basic Form Elements
			</div> -->
			<div class="panel-body forms">
				<form name="frm" class="stdform" action="/thdadmin/member_group_dbjob" method="post" onsubmit="return frmValid()">
				<input type="hidden" name="dbjob" value="i" />
				<p>
					<span class="field">
						<select name="group_id" style="width:100px;height:30px;">
							<?php 
								for($i=1; $i<=10; $i++): 
									if(in_array($i,$useful_grade)) continue;
									$selected = ($group_id == $i) ? 'selected' : null;
							?>
							<option value="<?php echo $i;?>" <?php echo $selected;?>><?php echo $i;?></option>
							<?php endfor;?>
						</select>
						<input type="text" name="title" class="input-large" placeholder="" style="width:50%;height:30px;">
						<button class="btn btn-primary btn-sm" type="submit">등 록</button>
					</span>
				</p>
				</form>

				<table class="table table-striped table-bordered table-hover">
					<colgroup>
						<col width="10%"/>
						<col />
						<col width="15%"/>
						<col width="15%"/>
					</colgroup>
					<thead>
						<tr>
							<th>등급</th>
							<th>그룹명</th>
							<th>설정</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ($_group as $k => $v){
						?>
						<tr>
							<td>
								<input type="hidden" name="list_form_group_id" value="<?=$k?>">
								<select name="list_group_id" style="height:26px;width:100px;">
								<?php 
									for($i=1; $i<=10; $i++): 
										if(in_array($i,$useful_grade) && $k != $i ) continue;
										$selected = ($k == $i) ? 'selected' : null;
								?>
								<option value="<?php echo $i;?>" <?php echo $selected;?>><?php echo $i;?></option>
								<?php endfor;?>
								</select>
							</td>
							<td>
								<input type="text" name="list_title" class="input-large" style="width:100%" placeholder="" value="<?=$v['title']?>" />
							</td>
							<td>
								<button class="btn btn-primary btn-sm btn-modify" type="button">수 정</button>
								<button class="btn btn-danger btn-sm btn-delete" type="button">삭 제</button>
							</td>
						</tr>
						<?php
							}
						?>
						<!-- <tr>
							<td>
								<select style="height:26px;width:100px;">
									<option>등급</option>
								</select>
							</td>
							<td>
								<input type="text" name="input3" class="input-large" style="width:100%" placeholder="">
							</td>
							<td>
								<button class="btn btn-primary btn-sm" type="button">수 정</button>
								<button class="btn btn-danger btn-sm" type="button">삭 제</button>
							</td>
						</tr> -->
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<form name="frmLIst" action="/thdadmin/member_group_dbjob" method="post">
	<input type="hidden" name="group_id" value="" />
	<input type="hidden" name="dbjob" value="" />
	<input type="hidden" name="form_group_id" value="" />
	<input type="hidden" name="title" value="" />
</form>
<script type="text/javascript">
	//<![CDATA[
	function frmValid(){
		with(document.frm){
			if(!title.value){
				alert('회원그룹명을 입력하세요');
				title.focus();
				return false;
			}
		}
	}

	$(document).ready(function(){
		$(".btn-modify").click(function(){
			var index = $(".btn-modify").index($(this));
			with(document.frmLIst){
				if(!$("[name=list_title]").eq(index).val()){
					alert('회원그룹명을 입력하세요');
					$("[name=list_title]").eq(index).focus();
					return;
				}
				
				group_id.value = $("[name=list_form_group_id]").eq(index).val();
				form_group_id.value = $("[name=list_group_id]").eq(index).val();
				title.value = $("[name=list_title]").eq(index).val();
				dbjob.value = 'u';
				
				submit();
			}	
		});

		$(".btn-delete").click(function(){
			var index = $(".btn-delete").index($(this));
			with(document.frmLIst){
				if(!confirm("삭제하시겠습니까?"))return;
				group_id.value = $("[name=list_form_group_id]").eq(index).val();
				dbjob.value = 'd';
				submit();
			}	
		});
	});
	//]]>
</script>