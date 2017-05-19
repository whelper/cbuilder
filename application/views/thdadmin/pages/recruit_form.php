<div class="row forms">
	<div class="col-lg-12">
		<div class="panel panel-default  forms">
			<div class="panel-heading">
				<?php echo validation_errors(); ?>
			</div>
			
			<form name="frm" action="recruit_dbjob" enctype="multipart/form-data" method="post">
			<input type="hidden" name="dbjob" value="<?=$_dbjob?>">
			<input type="hidden" name="seq" value="<?=$seq?>">
			<input type="hidden" name="language" value="<?=$_language?>" />
			<div class="panel-body">
				<table width="100%" class="table-form table-bordered">
				<colgroup>
					<col width="150px"/>
					<col width="*" />
				</colgroup>
				<tbody>
				<tr>
					<th>언어</th>
					<td>
						<select name="language" class="form-control" style="width:100px;display:inline">
						<option value="">=======</option>
						<?
						foreach($this->config->item('view_languge') as $k => $v){
							$_selected = ($language == $k) ? 'selected' : null;
							echo '<option value="'.$k.'" '.$_selected.'>'.$v.'</option>'.chr(10);
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<th>공개여부</th>
					<td>
						<select name="open_yn" class="form-control" style="width:100px;display:inline">
						<option value="y">Yes</option>
						<option value="n" <?=($open_yn =='n') ? 'selected' : null?>>No</option>
						</select>
						
					</td>
				</tr>
				
				<tr>
					<th>모집부문</th>
					<td>
						<input type="text" name="title" class="form-control" value="<?=$title?>">
					</td>
				</tr>
				<tr>
					<th>접수기간</th>
					<td>
						<input type="radio" class="rdo-sch" name="rdo-sch" value="y" <?=(!$start_date && !$end_date) ? 'checked' : null?> /> 상시
						<input type="radio" class="rdo-sch" name="rdo-sch" value="n" <?=($start_date || $end_date) ? 'checked' : null?> /> 설정
						<input type="text" name="start_date" class="datepicker form-control" value="<?=$start_date?>" disabled> ~
						<input type="text" name="end_date" class="datepicker form-control" value="<?=$end_date?>" disabled>
					</td>
				</tr>
				
				<tr>
					<th>지역</th>
					<td>
						<input type="text" name="area" class="form-control" value="<?=$area?>">
					</td>
				</tr>
				<tr>
					<th>경력</th>
					<td>
						<select name="career" class="form-control" style="width:100px;display:inline">
						<option value="">=======</option>
						<?
						foreach($this->config->item('career') as $k => $v){
							$_selected = ($career == $k) ? 'selected' : null;
							echo '<option value="'.$k.'" '.$_selected.'>'.$v.'</option>'.chr(10);
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<th>내용</th>
					<td>
						<textarea name="content" id="ckeditor_standard"><?=$content?></textarea>
						<script type="text/javascript" src="/common/assets/ckeditor/full/ckeditor.js"></script>
						<script type="text/javascript">
							CKEDITOR.replace('ckeditor_standard',{
								  filebrowserImageUploadUrl:"/common/assets/ckeditor/full/upload.php?type=Images"
							 });				   
						</script>
					</td>
				</tr>
				<?for($i=1; $i<=3; $i++ ){?>
				<tr>
					<th>첨부파일<?=$i?></th>
					<td>
						<div class="file-group">
							<input type="hidden" class="file-input" name="attache_file<?=$i?>" id="attache_file<?=$i?>" value="<?=${'attache_file'.$i}?>">
							<button type="button" class="file-add btn btn-primary">파일등록</button>
							<button type="button" class="file-delete btn btn-danger">파일삭제</button>	
						</div>
					</td>
				</tr>
				<?}?>
				<tr>
					<th>상태</th>
					<td>
						<select name="ing_yn" class="form-control" style="width:100px;display:inline">
						<option value="y">Yes</option>
						<option value="n" <?=($ing_yn =='n') ? 'selected' : null?>>No</option>
						</select>
						
					</td>
				</tr>
				
				</tbody>
				</table>

			</form>
			<div style="margin-top:20px;">
				<div class="col-md-6">
					<a class="btn btn-primary" onclick="javascript:frmValid();">등 록</a>
					<a class="btn btn-default" onclick="javascript:history.back();">목 록</a>
				</div>
				<?if($_dbjob == 'u'){?>
				<div class="col-md-6" style="text-align:right">
					<a class="btn btn-danger" onclick="javascript:del();">삭 제</a>
				</div>
				<?}?>
			</div>
			

		</div>
	</div>
</div>
<style type="text/css">
.form-control{display:inline !important}
.datepicker{width:100px;}
#cke_ckeditor_standard{margin-left: 0 !important}
table.table-form td a{margin:0 !important}
</style>
<script type="text/javascript" src="/common/thdadmin/js/thdays.attachefile.js"></script>
<script type="text/javascript">
//<![CDATA[
function frmValid(){
	with(document.frm){
		if(!title.value){
			alert('모집부분을 입력해 주세요');
			title.focus();
			return;
		}
		submit();
	}
}


$(document).ready(function() {
	$(".datepicker").datepicker({ dateFormat: "yy-mm-dd"});
	attachefile.init({'area' : '.forms','file_path' : 'recruit'});
	$(".rdo-sch").click(function(){
		if($(this).val() == 'y'){
			$("[name=start_date]").attr("disabled",true);
			$("[name=end_date]").attr("disabled",true);
		}else{
			$("[name=start_date]").attr("disabled",false);
			$("[name=end_date]").attr("disabled",false);
		}
	}).filter(function(){
		if($(this).prop("checked")){
			return $(".rdo-sch").index($(this));
		}
		
	}).click();
});
//]]>

</script>