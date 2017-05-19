<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default forms">
			<div class="panel-heading">
				<p class="text-danger"><i class="fa fa-warning"></i> 공통 코드를 관리 하는 화면 입니다. 코드는 시스템상 중요한 역할을 하기 때문에 신중히 관리 해야합니다.</p>
				<p class="text-danger"><i class="fa fa-warning"></i> 그룹코드 및 코드 삭제시 DATA가 실제 삭제되지 않습니다. 실제 삭제를 원하실 경우 개발팀에 처리를 요청해주세요</p>
				
			</div> 
			<div class="row input-code ">
				<div class="col-md-6 ">
					<div class="panel-body ">
					<form id="frmGroup" name="frmGroup" method="post" class="stdform">
					<input type="hidden" name="dbjob" value="i">
					<input type="hidden" name="master_id" value="">
					<input type="hidden" name="codeType" value="GROUP">
					<p>
						<label>그룹명</label>
						<span class="field">
							<input type="text" name="title" class="form-control" value="" placeholder="" style="width:50%">
						</span>
					</p>
					<p>
						<label>사용여부</label>
						<span class="field">
							<input type="radio" name="open_yn" value="y" checked />Yes
							<input type="radio" name="open_yn" value="n" />No
						</span>
					</p>
					<p>
						<label>비고1</label>
						<span class="field">
							<input type="text" name="etc1" class="form-control" value="" placeholder="" style="width:50%">
						</span>
					</p>
					<p>
						<label>비고2</label>
						<span class="field">
							<input type="text" name="etc2" class="form-control" value="" placeholder="" style="width:50%">
						</span>
					</p>
					<p>
						<label>비고3</label>
						<span class="field">
							<input type="text" name="etc3" class="form-control" value="" placeholder="" style="width:50%">
						</span>
					</p>
					<p class="stdformbutton">
						<a class="btn btn-primary" onclick="javascript:frmValidGroup('i');">그룹 코드 등록</a>
						<a class="btn btn-danger btnDelGroupCode" onclick="javascript:frmValidGroup('d');">그룹 코드 삭제</a>
					</p>
					</form>
					</div>
					
				</div>
				<div class="col-md-6">
					<div class="panel-body ">
					<form id="frmCode" name="frmCode" class="stdform"  method="post">
					<input type="hidden" name="dbjob" value="i">
					<input type="hidden" name="code_id" value="">
					<input type="hidden" name="codeType" value="CODE">
					<p>
						<label>그룹코드</label>
						<span class="field">
							<input type="text" name="master_id" readonly class="form-control" value="" placeholder="" style="width:50%">
						</span>
					</p>
					<p>
						<label>코드명</label>
						<span class="field">
							<input type="text" name="title" class="form-control" value="" placeholder="" style="width:50%">
						</span>
					</p>
					<p>
						<label>사용여부</label>
						<span class="field">
							<input type="radio" name="open_yn" value="y" checked />Yes
							<input type="radio" name="open_yn" value="n" />No
						</span>
					</p>
					<p>
						<label>비고1</label>
						<span class="field">
							<input type="text" name="etc1" class="form-control" value="" placeholder="" style="width:50%">
						</span>
					</p>
					<p>
						<label>비고2</label>
						<span class="field">
							<input type="text" name="etc2" class="form-control" value="" placeholder="" style="width:50%">
						</span>
					</p>
					<p>
						<label>비고3</label>
						<span class="field">
							<input type="text" name="etc3" class="form-control" value="" placeholder="" style="width:50%">
						</span>
					</p>
					<p class="stdformbutton">
						<a class="btn btn-primary" onclick="javascript:frmValidCode();">코드 등록</a>
						<a class="btn btn-danger btnDelCode" onclick="javascript:frmValidCode('d');">코드 삭제</a>
					</p>
					</form>
					</div>
				</div>
			</div>
			<div class="row input-code ">
				<div class="col-md-6 ">
					<div class="panel-body" id="code-group">
						
					</div>
					
				</div>
				<div class="col-md-6">
					<div class="panel-body" id="code-list">
						
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<iframe name="ifrmProcess" id="ifrmProcess"></iframe>
<style type="text/css">
	<!--
		/*.tableOv td,
		.tableOvCode td{font-size:11px; word-break:keep-all; word-break:break-all; word-break:break-all;}

		.tableOv{table-layout:fixed; margin-top:10px; background-color:#E6E6E6;}
		.table-hover tr.trOff{background-color:#fff; cursor:pointer}
		.table-hover tr.trOn{background-color:#fcbb6a; cursor:pointer}
		.table-hover tr.trOff td{padding:4px 4px 1px;}
		.table-hover tr.trOn td{padding:4px 4px 1px; color:#fff;}

		.tableOvCode{table-layout:fixed; margin-top:10px; background-color:#E6E6E6;}
		.tableOvCode tr.trOff{background-color:#fff; cursor:pointer}
		.tableOvCode tr.trOn{background-color:#fcbb6a; cursor:pointer}
		.tableOvCode tr.trOff td{padding:4px 4px 1px;}
		.tableOvCode tr.trOn td{padding:4px 4px 1px; color:#fff;}
*/
		#ifrmProcess{display:none;}
		.dVscroll{border:1px solid #E6E6E6; padding:10px; margin-top:10px; height:330px;overflow:hidden; overflow-y:scroll;}
		.btnDelCode{display:none;}
		.btnDelGroupCode{display:none;}
		.trUseOff td{text-decoration:line-through;background:#ccc}
	-->
</style>
<script type="text/javascript">
	//<![CDATA[
	(function($){
		$.setCodeGroup = function(){ //그룹코드 목록
			$.ajax({
				type: "GET",
				url: "ajax_code_group",
				/*data: "master_id="+gp,*/
				success: function(data){
					$("#code-group").html(data);
					$.setEffect();
					$("#frmGroup [name=master_id]").attr("reaonly",false);
					$(".btnDelGroupCode").hide();
					$(".btnDelCode").hide();

					$(".row-data").click(function(){
						var index = $(".row-data").index($(this));
						setCallCode($(".master_id").eq(index).text());
					});
					
				},
				error:function(error){alert('에러');}
			});
		},
		$.setCodeGroupInfo = function(gp){ //그룹코드 정보
			$.ajax({
				type: "GET",
				url: "ajax_code_group_info",
				data: "master_id="+gp,
				success: function(data){
					var result = eval('('+data+')');
					$(".btnDelCode").hide();
					document.frmCode.reset(); //코드 정보 초기화
					with(document.frmGroup){
						master_id.readOnly = true;
						dbjob.value = "u";
						master_id.value = result.master_id;
						title.value = result.title;
						$("#frmGroup [name=open_yn]").each(function(){
							if(result.open_yn == $(this).val()){
								$(this).attr("checked",true);
							}else{
								$(this).attr("checked",false);
							} 
						});
						//$("[name=open_yn]").attr("checked",true);
						//open_yn.value = result.open_yn;
						etc1.value = result.etc1;
						etc2.value = result.etc2;
						etc3.value = result.etc3;
					}
				},
				error:function(error){alert('에러');}
			});
		},
		$.setCodeInfo = function(gp,code){ //상세코드 정보
			$.ajax({
				type: "GET",
				url: "ajax_code_info",
				data: "master_id="+gp+"&code="+code,
				success: function(data){
					var result = eval('('+data+')');
					$(".btnDelCode").show();
					with(document.frmCode){
						dbjob.value = "u";
						master_id.value = result.master_id;
						code_id.value = result.code_id;
						title.value = result.title;
						$("#frmCode [name=open_yn]").each(function(){
							if(result.open_yn == $(this).val()){
								$(this).attr("checked",true);
							}else{
								$(this).attr("checked",false);
							} 
						});

						etc1.value = result.etc1;
						etc2.value = result.etc2;
						etc3.value = result.etc3;
					}
				},
				error:function(error){alert('에러');}
			});
		},
		$.setCodeList = function(gp,code){ //상세코드 목록
			$.ajax({
				type: "GET",
				url: "ajax_code_list",
				data: "master_id="+gp+'&code='+code,
				success: function(data){
					$("#code-list").html(data);
					$.setEffect();
					$(".btnDelCode").hide();
					with(document.frmCode){
						master_id.value = gp;
					}
					
					$(".row-data-child").click(function(){
						var index = $(".row-data-child").index($(this));
						setCallCodeInfo($(this).attr("data-master-id"),$(".code_id").eq(index).text());
					});

				},
				error:function(error){alert('에러');}
			});
		},
		$.setEffect = function(){ //클릭시 효과
			$(".table-hover tr").click(function(){
				$(".table-hover tr").removeClass("trOn");
				$(".btnDelGroupCode").show();
				$(this).addClass("trOn");
			});

			$(".tableOvCode tr").click(function(){
				$(".tableOvCode tr").removeClass("trOn");
				$(this).addClass("trOn");
			});
		}

	})(jQuery);

	function setCallCode(gp){ //그룹코드 클릭시
		with(document.frmCode){
			frmCode.reset();
			dbjob.value = "i";
			frmCode.code_id.value = ''
		}
		$.setCodeGroupInfo(gp);
		$.setCodeList(gp);

	}

	function setCallCodeInfo(gp,code){ //상세코드 클릭시
		$.setCodeInfo(gp,code)
	}

	function setDbResult(ty,dbjob){ //코드 DB결과값
		if(ty == 'GROUP'){
			document.frmGroup.reset(); //그룹코드 정보 초기화
			$.setCodeGroup();
		}else{
			
			var gp = document.frmCode.master_id.value;
			var code = document.frmCode.code_id.value;
			document.frmCode.reset(); //그룹코드 정보 초기화
			
			if(dbjob == 'up' || dbjob == 'down'){
				$.setCodeList(gp,code);
				$.setCodeInfo(gp,code);
			}else{
				if(dbjob == 'd') frmCode.dbjob.value = 'i';
				
				$.setCodeList(gp);
			}
		}
	}

	function addGroupCode(){ //그룹코드 등록
		document.frmGroup.reset(); //그룹코드 정보 초기화
		document.frmCode.reset(); //코드 정보 초기화
		$(".btnDelGroupCode").hide();
		$(".btnDelCode").hide();
		$("#code-list").empty();
		with(document.frmGroup){
			master_id.readOnly = false;
			dbjob.value = "i";
		}
	}

	function addCode(){ //코드 등록
		document.frmCode.reset(); //코드 정보 초기화
		$(".btnDelCode").hide();
		var gp = document.frmGroup.master_id.value;
		with(document.frmCode){
			code.readOnly = false;
			//master_id.value = gp;
			dbjob.value = "i";
		}
	}

	function frmValidGroup(db){ //코드그룹 유효성검사
		
		with(document.frmGroup){
			if(db == 'd'){
				if(!confirm('그룹코드 삭제시 시스템상 문제가 발생할수 있습니다.\n\n그래도 삭제하시겠습니까?')) return;
				dbjob.value = db;
			}else{			
				
				if(!title.value){
					alert('그룹명을 입력해주세요');
					title.focus();
					return;
				}
			}
			target = "ifrmProcess";
			action = "code_dbjob";
			submit();
		}
	}

	function frmValidCode(db){ //코드 유효성검사
		with(document.frmCode){
			if(db == 'd'){
				if(!confirm('선택된 코드를 삭제하시겠습니까?')) return;
				dbjob.value = db;
			}else{

				if(!master_id.value){
					alert('그룹코드를 입력해주세요');
					master_id.focus();
					return;
				}

				/*if(!code_id.value){
					alert('코드를 입력해주세요');
					code.focus();
					return;
				}*/

				if(!title.value){
					alert('코드명을 입력해주세요');
					title.focus();
					return;
				}

				//순서 조정후 확인 클릭시 수정모드로 변환한다.
				if(dbjob.value == 'up' || dbjob.value == 'down'){
					dbjob.value = 'u';
				}

			}
			target = "ifrmProcess";
			action = "code_dbjob";
			submit();
			code_id.value = '';
			title.value = '';

		}
	}

	function setOrder(db){
		with(document.frmCode){
			if(dbjob.value == 'u'){
				target = "ifrmProcess";
				dbjob.value = db;
				action = "config_codeOk.php";
				submit();
			}else{
				alert('정렬기능은 수정화면 상태에서 사용가능합니다.')
			}
		}
	}

	$(function(){ //초기화
		$.setCodeGroup('');

	});
	//]]>
</script>