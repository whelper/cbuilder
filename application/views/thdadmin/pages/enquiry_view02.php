 <div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<!-- <div class="panel-heading">
				Basic Form Elements
			</div> -->
			<div class="panel-body forms">
				<form class="stdform" name="frm" action="/thdadmin/enquiry_dbjob" method="post">
				<input type="hidden" name="seq" value="<?=$seq?>">
				<input type="hidden" name="dbjob" value="">
				<input type="hidden" name="page" value="<?=$_page?>">
				<input type="hidden" name="p_cate" value="<?=$p_cate?>">
				
				<p>
					<label>제목</label>
					<span class="field"><?=$title?></span>
				</p>
				<p>
					<label>이름</label>
					<span class="field"><?=$name?></span>
				</p>							
				<p>
					<label>상담가능시간</label>
					<span class="field">
					<?=$consulting_hour?>
					</span>
				</p>
				<!-- <p>
					<label>이메일</label>
					<span class="field"><?=$email?></span>
				</p> -->
				<p>
					<label>연락처</label>
					<span class="field"><?=$phone?></span>
				</p>
				<p>
					<label>내용</label>
					<span class="field">
						<?=nl2br($content)?>
					</span>
				</p>
				<p>
					<label>답변</label>
					<span class="field">
						<textarea name="reply" style="width:200px;height:200px;" onkeyup="smsMsgCount(this.value);"><?=$reply?></textarea>
						<span id="sms-count">0</span> / 90bytpe
					</span>

					<ul style="overflow:hidden">
						<li>단문(SMS) : 최대 90byte까지 전송할 수 있으며, 잔여건수 1건이 차감됩니다.</li>
						<li>장문(LMS) : 한번에 최대 2,000byte까지 전송할 수 있으며 1회 발송당 잔여건수 3건이 차감됩니다. </li>
					</ul>
				</p>
				
				<!-- <p class="stdformbutton">
					<a class="btn btn-primary" href="/thdadmin/enquiry_list?language=<?=$_language?>&page=<?=$_page?>&p_cate=<?=$p_cate?>">답변등록</a>
					<a class="btn btn-default" href="/thdadmin/enquiry_list?language=<?=$_language?>&page=<?=$_page?>&p_cate=<?=$p_cate?>">목 록</a>
					<a class="btn btn-danger" href="javascript:del()">삭 제</a>
				</p>
 -->
				<div class="col-md-6">
					<a class="btn btn-primary" href="javascript:reply();">답변등록</a>
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
			dbjob.value = 'd';
			submit();
		}
	}

	$(function(){
		smsMsgCount($("[name=reply]").val());
	});
	//]]>
</script>
