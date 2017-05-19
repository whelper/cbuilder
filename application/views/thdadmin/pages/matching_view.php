 <div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<!-- <div class="panel-heading">
				Basic Form Elements
			</div> -->
			<div class="panel-body forms">
				<form class="stdform" name="frm" action="/thdadmin/matching_dbjob" method="post">
				<input type="hidden" name="seq" value="<?=$seq?>">
				<input type="hidden" name="dbjob" value="<?=$_dbjob?>">
				<input type="hidden" name="page" value="<?=$_page?>">
				<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
				<tr>
					<th width="250">Full name</th>
					<td class="field"><?=$name?></td>
				</tr>

					<th>E-mail</th>
					<td class="field"><?=$email?></td>
				</tr>							

					<th>Telephone</th>
					<td class="field"><?=$tel?></td>
				</tr>

					<th>Organization</th>
					<td class="field"><?=$organ?></td>
				</tr>

					<th>Position</th>
					<td class="field"><?=$position?></td>
				</tr>

					<th>Country</th>
					<td class="field"><?=$country?></td>
				</tr>

					<th>City</th>
					<td class="field"><?=$city?></td>
				</tr>

					<th>Subject</th>
					<td class="field"><?=$title?></td>
				</tr>

					<th>Keywords</th>
					<td class="field"><?=$keywords?></td>
				</tr>

					<th>Summary</th>
					<td class="field"><?=$summary?></td>
				</tr>


					<th>Description</th>
					<td class="field">
						<?=nl2br($description)?>
					</td>
				</tr>

					<th>Advantages and Innovations</th>
					<td class="field">
						<?=nl2br($advantages)?>
					</td>
				</tr>

					<th>Attachments</th>
					<td class="field">
					<?
					if($attache_file1){
						$f = explode('|',$attache_file1);
						echo '<a href="/front/download?fpath='.$f[2].'&fname='.$f[1].'">'.$f[1].'</a>';
					}
					?>
					</td>
				</tr>

					<th>IPR status </th>
					<td class="field"><?=$ipr_status?></td>
				</tr>

					<th>Stage of Development</th>
					<td class="field"><?=$stage_of_develop?></td>
				</tr>

					<th>Partner sought</th>
					<td class="field"><?=$partner_sought?></td>
				</tr>

					<th>Approval status</th>
					<td class="field">
					<select name="approval" class="form-control" style="width:100px;display:inline">
						<option value="">=======</option>
						<?
						foreach($this->config->item('approval') as $k => $v){
							$_selected = ($approval == $k) ? 'selected' : null;
							echo '<option value="'.$k.'" '.$_selected.'>'.$v.'</option>'.chr(10);
						}
						?>
						</select>
					</td>
				</tr>
				</table>
				
				
				<div class="col-md-6">
					<!-- <a class="btn btn-primary" href="javascript:reply();">답변등록</a> -->
					<a class="btn btn-default" onclick="javascript:history.back();">목 록</a>
				</div>
				<div class="col-md-6" style="text-align:right">
					<a class="btn btn-danger" onclick="javascript:del();">삭 제</a>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>

<style type="text/css">
.stdform label{width:250px !important}
</style>
<script type="text/javascript">
	//<![CDATA[

	function reply(){
		with(document.frm){
			if(!reply.value){
				alert('답변을 입력해주세요');
				reply.focus();
				return;
			}
			dbjob.value = 'r';
			submit();
		}
	}
	function del(){
		with(document.frm){
			if(!confirm("삭제하시겠습니까?"))return;
			target = "";
			dbjob.value = 'd';
			submit();
		}
	}

	$(function(){
		$("[name=approval]").change(function(){
			with(document.frm){
				target = "ifrm_proc";
				dbjob.value = "u";
				submit();
			}
		});
	});
	//]]>
</script>