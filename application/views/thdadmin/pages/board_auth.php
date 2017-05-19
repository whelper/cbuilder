 <div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<!-- <div class="panel-heading">
				Basic Form Elements
			</div> -->
			<div class="panel-body forms">
				<form name="frm" class="stdform" action="/thdadmin/board_auth_dbjob" method="post" onsubmit="return frmValid()">
				<input type="hidden" name="menu_id" value="48" />
				<input type="hidden" name="dbjob" value="<?=($menu_id) ? 'u' : 'i'?>" />
				
				<p>
					<label>비밀번호</label>
					<span class="field">
						<input type="text" name="passwd" class="input-large" value="<?=$passwd?>" placeholder="" style="width:100px;height:30px;">
						<button class="btn btn-primary btn-sm" type="submit">등 록</button>
					</span>
				</p>
				</form>

				
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	//<![CDATA[
	function frmValid(){
		with(document.frm){
			if(!passwd.value){
				alert('비밀번호를 입력하세요');
				passwd.focus();
				return false;
			}
		}
	}

	
	//]]>
</script>