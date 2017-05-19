<?
if($dbjob == 'r'){
	$writer = null;
	$content = null;
}

//첨부파일
$attache_cnt = ($_settings['attache_cnt']) ? $_settings['attache_cnt'] : 1;
?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default  forms">
			<!-- <div class="panel-heading">
				Basic Form Elements
			</div> -->
			<form name="frm" class="stdform" action="/thdadmin/board_dbjob" enctype="multipart/form-data" method="post">
			<input type="hidden" name="dbjob" value="<?=$dbjob?>">
			<input type="hidden" name="menu_id" value="<?=$menu_id?>">
			<input type="hidden" name="language" value="<?=$_language?>">
			<input type="hidden" name="id" value="<?php echo $id;?>">
			<input type="hidden" name="ref_id" value="<?php echo $ref_id;?>">
			<input type="hidden" name="depth" value="<?php echo $depth;?>">
			<input type="hidden" name="ansnum" value="<?php echo $ansnum;?>">
			<input type="hidden" name="passwd" value="<?php echo $passwd;?>">

			<div class="panel-body">
				<p>
					<label>언어</label>
					<span class="field">
						<select name="language" class="form-control" style="width:100px;display:inline">
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
					<label>표시</label>
					<span class="field">
						<input type="checkbox" name="notice" value="1" <?=($notice == 1) ? 'checked' : ''?> /> 공지
						<!-- <input type="checkbox" name="main_yn" value="y" <?=($main_yn == 'y') ? 'checked' : ''?> /> 메인 -->
					</span>
				</p>
				<p>
					<label>제목</label>
					<span class="field">
						<?php
							if($_settings['cate']){
								echo '<select name="cate" class="input-small">'.chr(10);
								$arr_cate = explode(',',$_settings['cate']);
									foreach($arr_cate as $key => $value){
										$selected = ($value == $cate) ? 'selected' : null;
										echo '<option value="'.$value.'" '.$selected.'>'.$value.'</option>'.chr(10);
									}
								echo '</select>'.chr(10);
							}
						?>
						<input type="text" name="title" class="input-large" value="<?=$title?>" placeholder="" style="width:50%">
						
					</span>
				</p>
				<p>
					<label>작성자</label>
					<span class="field"><input type="text" name="writer" class="input-xlarge" value="<?=$writer?>"  placeholder="" style="width:50%"></span>
				</p>
				<?for($i=0; $i < $attache_cnt; $i++){?>
				<p>
					<label>첨부파일</label>
					<span class="field">
						<input name="files[]" class="input-file uniform_on" id="fileInput" type="file" />
						<?php echo $attach_delete;?>
					</span>
				</p>
				<?}?>
				<p>
					<label>내용</label>
					<span class="field">
						<textarea name="content" id="ckeditor_standard"><?=$content?></textarea>
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
				</p>
			</form>
			
		</div>
	</div>
</div>
<script type="text/javascript">
	//<![CDATA[  
	function frmValid(){
		
		with(document.frm){
			if(!writer.value){
				alert("작성자를 입력하세요");
				writer.focus();
				return;
			}
			
			if(!title.value){
				alert("제목을 입력하세요");
				title.focus();
				return;
			}
			
			if(!CKEDITOR.instances.ckeditor_standard.getData()){
				alert("내용을 입력하세요");
				return;
			}
			
			submit();
		}
	}

	//]]>
</script>