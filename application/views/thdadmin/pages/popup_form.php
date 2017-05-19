<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default  forms">
			<!-- <div class="panel-heading">
				Basic Form Elements
			</div> -->
			<form name="frm" class="stdform" action="/thdadmin/popup_dbjob" enctype="multipart/form-data" method="post">
			<input type="hidden" name="dbjob" value="<?=$_dbjob?>">
			<input type="hidden" name="language" value="<?=$_language?>">
			<input type="hidden" name="id" value="<?php echo $id;?>">

			<div class="panel-body">
				<p>
					<label>언어</label>
					<span class="field">
						<select name="language"  class="input-large"  style="width:100px;">
						<option value="">=======</option>
						<?
						foreach($this->config->item('view_languge') as $k => $v){
							$_selected = ($language == $k) ? 'selected' : null;
							echo '<option value="'.$k.'" '.$_selected.'>'.$v.'</option>'.chr(10);
						}
						?>
						</select>
						
					</span>
				</p>
				<p>
					<label>제목</label>
					<span class="field">
						
						<input type="text" name="title" class="input-large" value="<?=$title?>" placeholder="" style="width:50%">
						
					</span>
				</p>
				<p>
					<label>사용여부</label>
					<span class="field">
						<input type="radio" name="use_yn" value="Y" <?=($use_yn=='Y' || !$use_yn) ? 'checked':'';?> /> 사용
						<input type="radio" name="use_yn" value="N" <?=($use_yn=='N') ? 'checked':'';?> /> 미사용
					</span>
				</p>
				<p>
					<label>기간</label>
					<span class="field">
						<input type="text" name="start_date" class="datepicker" value="<?=$start_date?>">
						<input type="text" name="end_date" class="datepicker" value="<?=$end_date?>">
					</span>
				</p>
				<p>
					<label>레이어팝업</label>
					<span class="field"><input type="checkbox" name="layer_yn" value="Y" <?=($layer_yn == 'Y') ? 'checked':'';?>> Yes</span>
				</p>
				<!-- <p>
					<label>팝업형태</label>
					<span class="field">
						<input type="radio" name="popup_style" value="I"> 이미지
						<input type="radio" name="popup_style" value="E"> 에디터
					</span>
				</p> -->
				<p>
					<label>팝업위치</label>
					<span class="field">
						<input type="text" name="popup_top" value="<?=$popup_top?>"> Top
						<input type="text" name="popup_left" value="<?=$popup_left?>"> Left
					</span>
				</p>
				<p>
					<label>팝업크기</label>
					<span class="field">
						<input type="text" name="popup_width" value="<?=$popup_width?>"> Width
						<input type="text" name="popup_height" value="<?=$popup_height?>"> Height
					</span>
				</p>
				<!-- <p>
					<label>이미지</label>
					<span class="field">
						<input name="files[]" class="input-file uniform_on" id="fileInput" type="file" />
					</span>
				</p> -->
				<p>
					<label>내용</label>
					<span class="field">
						<textarea name="content" id="ckeditor_standard"><?=$popup_content?></textarea>
						<script type="text/javascript" src="/common/assets/ckeditor/full/ckeditor.js"></script>
						<script type="text/javascript">
							CKEDITOR.replace('ckeditor_standard',{
								  filebrowserImageUploadUrl:"/common/assets/ckeditor/full/upload.php?type=Images"
							 });				   
						</script>
					</span>	
				</p>
				</div>

				<p class="stdformbutton">
					<a class="btn btn-primary" onclick="javascript:frmValid();">등 록</a>
					<a class="btn btn-default" onclick="javascript:history.back();">목 록</a>
					<a class="btn btn btn-danger" class="del" onclick="javascript:del();">삭 제</a>
				</p>
			</form>
			
		</div>
	</div>
</div>
<style type="text/css">
	a.del{display:none;}
</style>
<script type="text/javascript">
	//<![CDATA[  
	$(function() {
		$(".datepicker").datepicker({ dateFormat: "yy-mm-dd"});
		//if($("[name=dbjob]").val() == 'u') $(".delete").show();
	});

	function del(){
		if(!confirm('삭제하시겠습니까?'))return;
		with(document.frm){
			dbjob.value = 'd';
			submit();
		}
	}

	function frmValid(){
		with(document.frm){
			if(!title.value){
				alert("제목을 입력하세요");
				title.focus();
				return;
			}			
			submit();
		}
	}

	//]]>
</script>