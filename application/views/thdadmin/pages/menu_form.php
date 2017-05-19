
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default  forms">
			<!-- <div class="panel-heading">
				Basic Form Elements
			</div> -->
			<form name="frm" class="stdform" action="/thdadmin/menu_dbjob" method="post">
			<input type="hidden" name="dbjob" value="<?=$dbjob?>">
			<input type="hidden" name="parent_id" value="<?=$parent_id?>">
			<input type="hidden" name="single_yn" value="<?=$single_yn?>">
			<input type="hidden" name="menu_id" value="<?=$menu_id?>">
			<input type="hidden" name="language" value="<?=$_language?>">
			<div class="panel-body">
				<?php
					if($dbjob == 'u'){
				?>
				<p>
					<label>페이지주소</label>
					<span class="field">
						<?=$page_url?>
					</span>
				</p>
				<?php
					}
				?>
				<p>
					<label>기타메뉴(GNB메뉴제외)</label>
					<span class="field">
						<input type="radio" name="etc_yn" value="Y" <?=($etc_yn=='Y') ? 'checked':'';?> /> Yes
						<input type="radio" name="etc_yn" value="N" <?=($etc_yn=='N' || !$etc_yn) ? 'checked':'';?> /> No
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
					<label>분류</label>
					<span class="field">
						<select name="menu_type">
							<option value="HTML" <?=($menu_type=='HTML')?'selected':'';?>>HTML</option>
							<option value="LINK" <?=($menu_type=='LINK')?'selected':'';?>>링크</option>
							<option value="BOARD" <?=($menu_type=='BOARD')?'selected':'';?>>게시판</option>
							<option value="PLUGIN" <?=($menu_type=='PLUGIN')?'selected':'';?>>플러그인</option> 
						</select>
					</span>
				</p>
				<p>
					<label>페이지제목</label>
					<span class="field"><input type="text" name="title" class="input-large" value="<?=$title?>" placeholder="" style="width:50%"></span>
				</p>
				<p>
					<label>키워드</label>
					<span class="field"><input type="text" name="keyword" class="input-xlarge" value="<?=$keyword?>"  placeholder="키워드1,키워드2" style="width:50%"></span>
				</p>
				<p>
					<label>설명</label>
					<span class="field"><input type="text" name="description" class="input-xlarge" value="<?=$description?>"  placeholder="메뉴설명" style="width:50%"></span>
				</p>
				<p>
					<label>컨텐츠영역 상단</label>
					<span class="field"><textarea name="include_top" class="span5" rows="5" cols="120"><?=$include_top?></textarea></span>
				</p>
				<p>
					<label>컨텐츠영역 하단</label>
					<span class="field"><textarea name="include_bottom" class="span5" rows="5" cols="120"><?=$include_bottom?></textarea></span>
				</p>
				<p>
					<label>추가 URL 파라미터</label>
					<span class="field"><input type="text" name="add_parameter" class="input-xlarge" value="<?=$add_parameter?>"  placeholder="/변수/값" style="width:50%"></span>
				</p>
				</div>
				<!--HTML Begin-->
				<div class="panel-body dy-input gp-html">
					<p>
						<label>최근저장내역</label>
						<span class="field">
							<?php
								$history = null;
								if($menu_id){
									$dest_dir = $this->config->item('thd_path_html').'/history';
									$saved_fname = $menu_id.'.html';
									if ($dh = opendir($dest_dir)) {
										while (($file = readdir($dh)) !== false) {
											if (preg_replace('/^His[0-9]*_/', '', $file) == $saved_fname){
												preg_match('/His([^_]*)_/', $file, $His);
												$history[] = '<option value="'.$file.'">'.date('Y-m-d H:i:s', $His[1]).' 저장내용</option>';
											}
											
										}
									}
								}
							?>
							<select name="html_history">
							<?php
								if(is_array($history)){
									echo '<option value="">최근에 저장된 내용 입니다.</option>';
									foreach($history as $k => $v){
										echo $v.chr(10);
									}
								}else{
									echo '<option value="">최근에 저장된 내용이 없습니다.</option>';
								}
							?>
							</select>
						</span>
					</p>
					<p>
						<label>사용자정의주소</label>
						<span class="field">
							<span class="url">http://<?php echo $_SERVER['HTTP_HOST']?><?=($_language!='kr') ? '/en' : '';?>/front/html/<span id="alias"><?php echo $url_alias?></span></span>
							<input type="text" name="url_alias" class="input-large" value="<?=$url_alias?>" placeholder="">
						</span>
					</p>
					<p>
						<label>내용</label>
						<span class="field">
							<textarea name="content" id="content"><?=$content?></textarea>
						</span>
					</p>
					<!-- <p>
						<label>모바일용</label>
						<span class="field">
							<textarea name="content_mobile" class="span5" rows="15" cols="120"><?=$content_mobile?></textarea>
						</span>
					</p> -->
				</div>
				<!--HTML End-->
				<!--게시판 Begin-->
				<div class="panel-body dy-input gp-board">
					<p>
						<label>스킨</label>
						<span class="field">
							<select name="board_skin">
								<option value="">---------선택하세요--------</option>
								<?php
									$dic = directory_map('./theme/'.$this->config->item('theme').'/'.$_language.'/board',1);
									foreach($dic as $item){
										$item = str_replace('/','',$item);
										$selected = ($item == $board_skin) ? 'selected' : null;
										echo "<option value=\"$item\" {$selected}>$item</option>\n";
									}
								?>
							</select>
						</span>
					</p>
					<p>
						<label>보기</label>
						<span class="field">
							<input type="radio" name="board_type" value="1" <?=($board_type=='1' || !$board_type) ? 'checked':'';?> /> 일반형
							<input type="radio" name="board_type" value="2" <?=($board_type=='2') ? 'checked':'';?> /> 갤러리형
						</span>
					</p>
					<p>
						<label>첨부파일갯수</label>
						<span class="field"><input type="text" name="attache_cnt" class="input-large" value="<?=$attache_cnt?>" placeholder=""></span>
					</p>
					<p class="dy-input gp-board board-general">
						<label>목록갯수</label>
						<span class="field"><input type="text" name="list_cnt" class="input-large" value="<?=$list_cnt?>" placeholder=""></span>
					</p>
					<p class="dy-input gp-board board-gallery">
						<label>목록갯수</label>
						<span class="field">
							<select name="cols">
								<option value="">열</option>
								<?php
									for($i=1; $i<=10; $i++){
										$selected = ($i == $cols) ? 'selected' : '';
										echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>'.chr(10);
									}
								?>
							</select>
							<select name="rows">
								<option value="">행</option>
								<?php
									for($i=1; $i<=10; $i++){
										$selected = ($i == $rows) ? 'selected' : '';
										echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>'.chr(10);
									}
								?>
							</select>
						</span>
					</p>
					<p class="dy-input gp-board board-gallery">
						<label>썸네일사이즈</label>
						<span class="field">
							<input type="text" name="thumb_w" value="<?=$thumb_w?>"> X <input type="text" name="thumb_h" value="<?=$thumb_h?>">
						</span>
					</p>
					<p>
						<label>말줄임</label>
						<span class="field"><input type="text" name="limit_title" class="input-large" placeholder="" value="<?=$limit_title?>"></span>
					</p>
					<p>
						<label>댓글사용</label>
						<span class="field">
							<input type="radio" name="commen_yn" value="Y" <?=($comment_yn=='Y') ?'checked':'';?> />Yes
							<input type="radio" name="commen_yn" value="N" <?=($comment_yn=='N' || !$comment_yn) ?'checked':'';?>>	No
						</span>
					</p>
					<p>
						<label>카테고리</label>
						<span class="field"><input type="text" name="cate" class="input-large" placeholder="" value="<?=$cate?>"></span>
					</p>
					<p>
						<label>권한-목록</label>
						<span class="field">
							<select name="auth_list">
								<option value="">제한없음</option>
								<?php 
									foreach($_member_group->result() as $row){
										$selected = ($auth_list == $row->group_id) ? 'selected' : '';
								?>
									<option value="<?php echo $row->group_id?>" <?php echo $selected;?>><?php echo $row->title;?>[<?php echo $row->group_id;?>]</option>
								<?php
									}	
								?>
							</select>
						</span>
					</p>
					<p>
						<label>권한-쓰기</label>
						<span class="field">
							<select name="auth_write">
								<option value="">제한없음</option>
								<?php 
									foreach($_member_group->result() as $row){
										$selected = ($auth_write == $row->group_id) ? 'selected' : '';
								?>
									<option value="<?php echo $row->group_id?>" <?php echo $selected;?>><?php echo $row->title;?>[<?php echo $row->group_id;?>]</option>
								<?php
									}	
								?>
							</select>
						</span>
					</p>
					<p>
						<label>권한-답변</label>
						<span class="field">
							<select name="auth_reply">
								<option value="">제한없음</option>
								<?php 
									foreach($_member_group->result() as $row){
										$selected = ($auth_reply == $row->group_id) ? 'selected' : '';
								?>
									<option value="<?php echo $row->group_id?>" <?php echo $selected;?>><?php echo $row->title;?>[<?php echo $row->group_id;?>]</option>
								<?php
									}	
								?>
							</select>
						</span>
					</p>
					<p>
						<label>권한-댓글</label>
						<span class="field">
							<select name="auth_comment">
								<option value="">제한없음</option>
								<?php 
									foreach($_member_group->result() as $row){
										$selected = ($auth_comment == $row->group_id) ? 'selected' : '';
								?>
									<option value="<?php echo $row->group_id?>" <?php echo $selected;?>><?php echo $row->title;?>[<?php echo $row->group_id;?>]</option>
								<?php
									}	
								?>
							</select>
						</span>
					</p>
					<p>
						<label>권한-읽기</label>
						<span class="field">
							<select name="auth_view">
								<option value="">제한없음</option>
								<?php 
									foreach($_member_group->result() as $row){
										$selected = ($auth_view == $row->group_id) ? 'selected' : '';
								?>
									<option value="<?php echo $row->group_id?>" <?php echo $selected;?>><?php echo $row->title;?>[<?php echo $row->group_id;?>]</option>
								<?php
									}	
								?>
							</select>
						</span>
					</p>
					<p>
						<label>비밀글</label>
						<span class="field">
							<input type="radio" name="secret_yn" value="Y" <?=($secret_yn=='Y') ?'checked':'';?> /> Yes
							<input type="radio" name="secret_yn" value="N" <?=($secret_yn=='N' || !$secret_yn) ?'checked':'';?> >	No
						</span>
					</p>
				</div>
				<!--게시판 End-->
				<!--플러그인 Begin-->
				<div class="panel-body dy-input gp-plugin">
					<p>
						<label>플러그인</label>
						<span class="field">
							<select name="plugin">
								<option value="">선택하세요</option>
								<?php
									$dic = directory_map(APPPATH.'modules',1);
									foreach($dic as $item){
										$xml = read_file(APPPATH.'/modules/'.$item.'/module.xml');
										$item = str_replace('/','',$item);
										if($xml){
											$parser = new XMLParser($xml);
											$parser->Parse();
											$selected = ($item == $module_name) ? 'selected' : '';
											echo "<option value=\"{$item}\" {$selected}>{$parser->document->title[0]->tagData}</option>\n";
											
										}
									}
								?>
							</select>
						</span>
					</p>
				</div>
				<!--플러그인 End-->
				<!--링크 Begin-->
				<div class="panel-body dy-input gp-link">
					<p>
						<label>URL</label>
						<span class="field">
							<select name="target">
								<option value="_self">현재창</option>
								<option value="_blank" <?=($target == '_blank') ? 'selected' : '';?>>새창</option>
							</select>
							<span class="field"><input type="text" name="link" class="input-large" value="<?=$link?>" placeholder="" style="width:50%"></span>
						</span>
					</p>
				</div>
				<!--링크 End-->
				<p class="stdformbutton">
					<a class="btn btn-primary" onclick="javascript:frmValid();">등 록</a>
					<a class="btn btn-default" onclick="javascript:history.back();">목 록</a>
				</p>
			</form>
			
		</div>
	</div>
</div>
<style type="text/css">
	p.dy-input{display:none;}
</style>

<link rel="stylesheet" href="/common/codemirror/css/codemirror.css">
<!-- <link rel="stylesheet" href="/common/codemirror/css/docs.css"> -->
<link rel="stylesheet" href="/common/codemirror/theme/cobalt.css">
<script src="/common/codemirror/codemirror.js"></script>
<script src="/common/codemirror/xml.js"></script>
<script src="/common/codemirror/javascript.js"></script>
<script src="/common/codemirror/css.js"></script>
<script src="/common/codemirror/vbscript.js"></script>
<script src="/common/codemirror/htmlmixed.js"></script> 
<script>
	var mixedMode = {
	name: "htmlmixed",
	scriptTypes: [{matches: /\/x-handlebars-template|\/x-mustache/i,
				   mode: null},
				  {matches: /(text|application)\/(x-)?vb(a|script)/i,
				   mode: "vbscript"}]
  };
  var editor = CodeMirror.fromTextArea(document.getElementById("content"), {mode: mixedMode, tabMode: "indent",lineNumbers:true});
  editor.setOption("theme", "cobalt");
  function confirm(){
	opener.frmReg.content.value = editor.getValue();
	self.close();
}
</script>
<script type="text/javascript">
	function frmValid(){
		with(document.frm){
			submit();
		}
	}

	function assert_msglen(message, maximum){
		var inc = 0;
		var nbytes = 0;
		var msg = "";
		var msglen = message.length;

		for (i=0; i<msglen; i++) {
				var ch = message.charAt(i);
				if (escape(ch).length > 4) {
						inc = 2;
				} else if (ch == '\n') {
						if (message.charAt(i-1) != '\r') {
								inc = 1;
						}
				} else if (ch == '<' || ch == '>') {
						inc = 4;
				} else {
						inc = 1;
				}
				if ((nbytes + inc) > maximum) {
						break;
				}
				nbytes += inc;
				msg += ch;
		}

		return msg;
	}

	$(document).ready(function(){
		$("[name=html_history]").change(function(){
			if($(this).val()){
				$.ajax({
					type: "GET",
					url: "/thdadmin/ajax_history",
					data: "history_file="+$(this).val(),
					success: function(data){
						if(data) $("[name=content]").val(data);
					},
					error:function(error){alert('에러');}
				});		
			}
		});
		
		//메뉴분류
		$("[name=menu_type]").change(function(){
			var name = $(this).val().toLowerCase();	
			$("div.dy-input").hide();
			$("div.gp-"+name).show();
		}).filter(function(){
			var index = $("[name=menu_type] option").index($("[name=menu_type] option:selected")); 
			$("[name=menu_type] option:eq("+index+")").attr("selected", true).change();
		});
		
		//게시판 > 보기유형
		$("[name=board_type]").click(function(){
			if($(this).val()=='1'){
				$(".board-general").show();
				$(".board-gallery").hide();
			}else{
				$(".board-general").hide();
				$(".board-gallery").show();
			}
		}).filter(function(){
			var index = $("[name=board_type]").index($("[name=board_type]:checked")); 	
			$("[name=board_type]:eq("+index+")").attr("checked", true).click();
			/*if($("[name=board_type]:checked").val()=='1'){
				$(".board-general").show();
				$(".board-gallery").hide();
			}else{
				$(".board-general").hide();
				$(".board-gallery").show();
			}*/
		});
			
		//사용자정의주소
		$("[name=url_alias]").keyup(function(){
			var contentsRegEx = /^[a-zA-Z0-9가-힣\-]*$/i;
			if(!contentsRegEx.test($(this).val())){
				alert('주소에는 한글,영문,숫자,하이픈("-")만 입력가능합니다');
				var msg = assert_msglen($(this).val(),$(this).val().length-1);
				$(this).val(msg)
				url_alias.focus();
				return;
			}
						
			$("#alias").html($(this).val())
		});

	});
</script>