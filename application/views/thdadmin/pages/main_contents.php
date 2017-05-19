<div class="row">
	<div class="col-lg-12">
		<div class="wrap-tab-lang">
			<ul class="nav nav-tabs view-lang">
				<?
				foreach($this->config->item('view_languge') as $k => $v){
					$_css= ($this->language==$k) ? 'active' : '';
					echo '<li lang="'.$k.'" class="'.$_css.'"><a href="?language='.$k.'">'.$v.'</a></li>'.chr(10);
				}
				?>
			</ul>
		</div>
		<div class="panel panel-default">
			<!-- <div class="panel-heading">
			<form name="frmNotice" method="post" action="/thdadmin/notice_alim">
				공지알림표시
				<select name="open_yn" class="form-control notice-alim" style="width:100px;display:inline;margin-left:10px;">
					<option value="n">No</option>
					<option value="y"<?=($open_yn =='y') ? 'selected' : null?>>Yes</option>
				</select>
			</form>
			</div> -->
			
			<div class="panel-body">
			<form name="frm" class="stdform" action="/thdadmin/main_contents_dbjob" enctype="multipart/form-data" method="post">
			<input type="hidden" name="dbjob" value="<?=$_dbjob?>">	 
				 <div style="margin:10px 0">
					<select name="language" class="form-control notice-alim" style="width:100px;display:inline;">
					<?
					foreach($this->config->item('view_languge') as $k => $v){
						$_selected = ($this->language == $k) ? 'selected' : null;
						echo '<option value="'.$k.'" '.$_selected.'>'.$v.'</option>'.chr(10);
					}
					?>
				</select>
				</div>
				 <table class="table table-striped table-bordered table-hover">
					<colgroup>
						<col width="10%"/>
						<col/>
						<col width="20%"/>
					</colgroup>
					<thead class="tb-header">
						<tr>
							<th colspan="2">타이틀</th>
							<th>통계</th>
						</tr>
					</thead>
					<tbody class="tb-body">
						<?
						$json = null;
						if($content){
							$json = json_decode($content,true);
						}	
						
						$title = $stat = null;
						for($i=1; $i <=4; $i++){
							if($json){
								$title = $json['title'][$i-1];
								$stat = $json['stat'][$i-1];
							}
						?>
						<tr>
							<td><?=$i?></td>
							<td><input type="text" name="title[]" value="<?=$title?>" class="form-control" /></td>
							<td><input type="text" name="stat[]" value="<?=$stat?>"  class="form-control" /></td>
						</tr>
						<?
						}
						?>
					</tbody>
				</table>
				<div class="row">
					<div class="col-md-2" >
						<a class="btn btn-primary" href="javascript:frmValid();">등록</a>
					</div>
				</div>
			</form>
			</div>
			
		</div>
	</div>
</div>
<!-- end : .con-box -->
<script type="text/javascript">
//<![CDATA[
function frmValid(){
	with(document.frm){
		submit();
	}
}

$(function(){
	$("[name=language]").change(function(){
		with(document.frm){
			action = "main_contents";
			submit();
		}
	});
});
//]]>
</script>