<div class="row forms">
	<div class="col-lg-12">
		<div class="panel panel-default  forms">
			<div class="panel-heading">
				<?php echo validation_errors(); ?>
			</div>
			
			<form name="frm" action="visual_dbjob" enctype="multipart/form-data" method="post">
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
					<th>사용여부</th>
					<td>
						<select name="open_yn" class="form-control" style="width:100px;display:inline">
						<option value="y">Yes</option>
						<option value="n" <?=($open_yn =='n') ? 'selected' : null?>>No</option>
						</select>
						
					</td>
				</tr>
				<!-- <tr>
					<th>백그라운드색상</th>
					<td>
						<input type="text" name="color_bg" id="colorpicker1" value="<?=$color_bg?>" style="width:200px;"  class="form-control">
					</td>
				</tr> -->
				<tr>
					<th>제목1</th>
					<td>
						<input type="text" name="title" class="form-control" value="<?=$title?>" style="width:400px;">
					</td>
				</tr>
				<tr>
					<th>제목2</th>
					<td>
						<input type="text" name="title_sub" class="form-control" value="<?=$title_sub?>" style="width:400px;">
					</td>
				</tr>
				<tr>
					<th>링크</th>
					<td>
						<input type="text" name="link_url" class="form-control" value="<?=$link_url?>" style="width:400px;display:inline" >
					</td>
				</tr>
				<!-- <tr>
					<th>설명</th>
					<td>
						<textarea name="summary" style="width:100%;height:50px;"><?=$summary?></textarea>
					</td>
				</tr> -->
				<tr>
					<th>배너(1920*662)</th>
					<td>
						<div class="file-group">
							<input type="hidden" class="file-input" name="file_visual" id="file_visual" value="<?=$file_visual?>">
							<button type="button" class="file-add btn btn-primary">파일등록</button>
							<button type="button" class="file-delete btn btn-danger">파일삭제</button>	
						</div>
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
<link rel="stylesheet" href="/common/thdadmin/dist/css/colorpicker/ui.colorpicker.css"/>
<script language="JavaScript" src="/common/thdadmin/dist/js/colorpicker/jq.js"></script>
<script language="JavaScript" src="/common/thdadmin/dist/js/colorpicker/jq.color.js"></script>
<script type="text/javascript" src="/common/thdadmin/js/thdays.attachefile.js"></script>
<script type="text/javascript">
//<![CDATA[
function frmValid(){
	with(document.frm){
		if(!title.value){
			alert('제목을 입력해 주세요');
			title.focus();
			return;
		}
		submit();
	}
}

$(document).ready(function() {
	var hideit = function(e, ui) { $(this).val('#'+ui.hex); $('.ui-colorpicker').css('display', 'none'); };
	//$('#colorpicker1 , #colorpicker2').colorpicker({ hide: hideit, submit: hideit });
	attachefile.init({'area' : '.forms','file_path' : 'visual'});
});
//]]>

</script>