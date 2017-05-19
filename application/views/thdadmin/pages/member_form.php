<?
$hp = ($hp) ? explode('-',$hp) : array(null,null,null);
$email = ($email) ? explode('@',$email) : array(null,null);
$biz_no = ($biz_no) ? explode('-',$biz_no) : array(null,null,null);
$corp_tel = ($corp_tel) ? explode('-',$corp_tel) : array(null,null,null);
$corp_fax = ($corp_fax) ? explode('-',$corp_fax) : array(null,null,null);

$arr_agency = $_cust = array();
if ($_agency->num_rows() > 0){
	foreach($_agency->result() as $row){		
		$arr_agency[$row->seq] = $row->name;

	}
}

if ($_customer->num_rows() > 0){
	foreach($_customer->result() as $row){		
		$_cust[$row->customer_seq] = $row->name;

	}
}

if($_membership){
	$membership = $_membership;
}else if(set_value('membership')){
	$membership = set_value('membership');
}

if(set_value('user_id')) $user_id = set_value('user_id'); 


?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default  forms">
			<div class="panel-heading">
				<?php echo validation_errors(); ?>
			</div>
			
			<form name="frm" action="/thdadmin/member_dbjob" method="post">
			<input type="hidden" name="dbjob" value="<?=$_dbjob?>" />
			<input type="hidden" name="customer" value="" />
			<input type="hidden" name="membership" value="<?=$membership?>" />
			<input type="hidden" name="valid_user_id" value="" />
			<input type="hidden" name="related_products" value="" />
			<input type="hidden" name="category" value="" />
			<input type="hidden" name="seq" value="<?=$seq?>" />
			<input type="hidden" name="language" value="<?=$_language?>" />
			<div class="panel-body">
				<table width="100%" class="table-form table-bordered">
				<colgroup>
					<col width="150px"/>
					<col width="*" />
				</colgroup>
				<tbody>
				<tr>
					<th>사용여부</th>
					<td>
						<select name="open_yn" class="form-control" style="width:100px;display:inline">
						<option value="y">Yes</option>
						<option value="n" <?=($open_yn =='n') ? 'selected' : null?>>No</option>
						</select>
						
					</td>
				</tr>
				<tr>
					<th>아이디</th>
					<td>
						<input type="text" name="user_id" class="form-control" value="<?=$user_id?>" style="width:150px;display:inline;">
						<a class="btn btn-sm btn-info vaild-userid" onclick="javascript:chkid();">중복확인</a>
					</td>
				</tr>
				<tr>
					<th>비밀번호</th>
					<td>
						<input type="password" name="passwd" class="form-control" value="" style="width:150px;display:inline"> <label for="passwd_yn" class="passwd_yn hidden"><input type="checkbox" name="passwd_yn" id="passwd_yn" value="y"> 비밀번호변경</label>
					</td>
				</tr>
				<tr>
					<th>비밀번호 확인</th>
					<td>
						<input type="password" name="chkpasswd" class="form-control" value="" style="width:150px">
					</td>
				</tr>
				<tr>
					<th>이름</th>
					<td>
						<input type="text" name="name" class="form-control" value="<?=$name?>" style="width:150px;">
					</td>
				</tr>
				<tr>
					<th>전화</th>
					<td>
						<select name="corp_tel[]" class="form-control" style="width:100px;display:inline">
						<option value="">-----</option>
						<?
						foreach($this->config->item('conf_local_num') as $key => $value){
							$selected = ($corp_tel[0] == $value) ? 'selected' : null;	
							echo '<option value="'.$value.'" '.$selected.'>'.$value.'</option>'.chr(10);
						}
						?>
						</select>
						<input type="text" name="corp_tel[]" class="form-control" value="<?=$corp_tel[1]?>" style="width:100px;display:inline">
						<input type="text" name="corp_tel[]" class="form-control" value="<?=$corp_tel[2]?>" style="width:100px;display:inline">
					</td>
				</tr>
				
				<tr class="v1 hidden">
					<th>사업자등록번호</th>
					<td>
						<input type="text" name="biz_no[]" maxlength="3" class="form-control" value="<?=$biz_no[0]?>" style="width:80px;display:inline">
						<input type="text" name="biz_no[]" maxlength="2" class="form-control" value="<?=$biz_no[1]?>" style="width:60px;display:inline">
						<input type="text" name="biz_no[]" maxlength="5" class="form-control" value="<?=$biz_no[2]?>" style="width:100px;display:inline">
					</td>
				</tr>
				<tr class="v1 hidden">
					<th>사업장주소</th>
					<td>
						<p style="margin-top:10px;">
							<input type="text" name="corp_post" id="corp_post" readonly class="form-control" value="<?=$corp_post?>" style="width:100px;display:inline">
							<a class="btn btn-sm btn-info" onclick="javascript:post();">우편번호찾기</a>
						</p>
						<p>
							<input type="text" name="corp_addr1" id="corp_addr1" readonly class="form-control" value="<?=$corp_addr1?>" style="width:80%;">
						</p>
						<p>
							<input type="text" name="corp_addr2" id="corp_addr2" class="form-control" value="<?=$corp_addr2?>" style="width:80%;">
						</p>
					</td>
				</tr>
				
				<tr class="v1 hidden">
					<th>팩스</th>
					<td>
						<select name="corp_fax[]" class="form-control" style="width:100px;display:inline">
						<option value="">-----</option>
						<?
						foreach($this->config->item('conf_local_num') as $key => $value){
							$selected = ($corp_tel[0] == $value) ? 'selected' : null;
							echo '<option value="'.$value.'" '.$selected.'>'.$value.'</option>'.chr(10);
						}
						?>
						</select>
						<input type="text" name="corp_fax[]" class="form-control" value="<?=$corp_fax[1]?>" style="width:100px;display:inline">
						<input type="text" name="corp_fax[]" class="form-control" value="<?=$corp_fax[2]?>" style="width:100px;display:inline">
					</td>
				</tr>
				<tr class="v1 hidden">
					<th>담당부서</th>
					<td>
						<input type="text" name="corp_division" class="form-control" value="<?=$corp_division?>" style="width:80%;">
					</td>
				</tr>
				<tr class="v1 hidden">
					<th>담당자명</th>
					<td>
						<input type="text" name="corp_name" class="form-control" value="<?=$corp_name?>" style="width:80%;">
					</td>
				</tr>
				<tr>
					<th>연락처</th>
					<td>
						<select name="hp[]" class="form-control" style="width:100px;display:inline">
						<option value="">-----</option>
						<?
						foreach($this->config->item('conf_hp_num') as $key => $value){
							$selected = ($hp[0] == $value) ? 'selected' : null;
							echo '<option value="'.$value.'" '.$selected.'>'.$value.'</option>'.chr(10);
						}
						?>
						</select>
						<input type="text" name="hp[]" class="form-control" value="<?=$hp[1]?>" style="width:100px;display:inline">
						<input type="text" name="hp[]" class="form-control" value="<?=$hp[2]?>" style="width:100px;display:inline">
					</td>
				</tr>
				<tr>
					<th>이메일</th>
					<td>
						<input type="text" name="email[]" class="form-control" value="<?=$email[0]?>" style="width:200px;display:inline">
						@
						<input type="text" name="email[]" class="form-control" value="<?=$email[1]?>" style="width:200px;display:inline">
						<select name="mail_doamin" class="form-control" style="width:200px;display:inline">
						<option value="">직접입력</option>
						<?
						foreach($this->config->item('conf_mail_domain') as $key => $value){
							$selected = ($email[1] == $value) ? 'selected' : null;
							echo '<option value="'.$value.'">'.$value.'</option>'.chr(10);
						}
						?>
						</select>
					</td>
				</tr>
				<tr class="v1 hidden">
					<th>담당영업사원</th>
					<td>
						<select name="salesman" class="form-control" style="width:100px;display:inline">
						<option value="">-----</option>
						<?
						foreach($_query->result() as $row){
							$selected = ($salesman == $row->seq) ? 'selected' : null;
							echo '<option value="'.$row->seq.'" '.$selected.'>'.$row->name.'</option>'.chr(10);
						}
						?>
						</select>
					</td>
				</tr>
				<tr class="v2 hidden">
					<th>거래처</th>
					<td>

						<div class="multi_option">
							<div class="form-group input-group">
								<input class="form-control" name="agency" type="text">
								<span class="input-group-btn">
									<button class="btn btn-default btn-agency" type="button"><i class="fa fa-search"></i>
									</button>
								</span>
							</div>
							<select name="stuff" class="form-control" multiple="">
							<?php
								foreach($arr_agency as $key => $value){
									if(!array_key_exists($key,$_cust)){
										echo '<option value="'.$key.'">'.$value.'</option>'.chr(10);
									}
								}
							?>
							</select>
						</div>
						<div class="multi_btn">
							<a class="add-stuff" href="javascript:void(0);">▶</a>
							<a class="del-stuff" href="javascript:void(0);">◀</a>
						</div>
						<div class="multi_option" style="margin:60px 0 10px 0;">
							<select name="add_stuff" class="form-control" multiple="">
							<?php
								foreach($_cust as $key => $value){
									echo '<option value="'.$key.'">'.$value.'</option>'.chr(10);
								}
							?>
							</select>
						</div>
						
						<!-- <div class="multi_btn">
							<a href="javascript:void(0);" class="up-stuff">▲</a>
							<a href="javascript:void(0);" class="down-stuff">▼</a>
							<!-- <a href="javascript:void(0);" class="del-stuff btn ty2">선택삭제</a> --<
						</div>
						-->
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
				<div class="col-md-6" style="text-align:right">
					<a class="btn btn-danger" onclick="javascript:del();">삭 제</a>
				</div>
			</div>
			

		</div>
	</div>
</div>
<style type="text/css">
div.multi_option{margin-top:10px;float:left;}
div.multi_option select{width:250px;height:200px;border:1px solid #ccc}
div.multi_btn{margin:45px 10px 0 10px;float:left}
div.multi_btn a{display:block;font-size:23px;}
</style>
<script type="text/javascript" src="/common/thdadmin/js/thdays.product.js"></script>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script type="text/javascript">
	//<![CDATA[ 
	 function post() {
        new daum.Postcode({
            oncomplete: function(data) {
               // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 도로명 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var fullRoadAddr = data.roadAddress; // 도로명 주소 변수
                var extraRoadAddr = ''; // 도로명 조합형 주소 변수

                // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                    extraRoadAddr += data.bname;
                }
                // 건물명이 있고, 공동주택일 경우 추가한다.
                if(data.buildingName !== '' && data.apartment === 'Y'){
                   extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 도로명, 지번 조합형 주소가 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                if(extraRoadAddr !== ''){
                    extraRoadAddr = ' (' + extraRoadAddr + ')';
                }
                // 도로명, 지번 주소의 유무에 따라 해당 조합형 주소를 추가한다.
                if(fullRoadAddr !== ''){
                    fullRoadAddr += extraRoadAddr;
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('corp_post').value = data.zonecode; //5자리 새우편번호 사용
                document.getElementById('corp_addr1').value = fullRoadAddr;
                //document.getElementById('corp_addr2').value = data.jibunAddress;

            }
        }).open();
    }
	
	function chkid(){
		with(document.frm){
			if(!user_id.value){
				alert('아이디를 입력해 주세요');
				user_id.focus();
				return;
			}
		}
		
		$.ajax({
			type: "POST",
			url: "/thdadmin/ajax_user_id",
			data: "category="+$('[name=user_id]').val(),
			success: function(data){
				var prefix = eval('('+data+')');
				alert(prefix.msg);
				//1: ok 0: no
				$("[name=valid_user_id]").val(prefix.rst);
				
			},
			error:function(error){alert('에러');}
		});		
	}

	function frmValid(){
		var s= '';
		$('[name="add_stuff"] option').each(function(){
			s += (s) ? ','+$(this).val() : $(this).val();
		});

		with(document.frm){
			customer.value = s;
			submit();
		}
	}

	function del(){
		if(!confirm('삭제하시겠습니까?'))return;
		with(document.frm){
			dbjob.value ='d';
			submit();
		}
	}

	$(document).ready(function(){
		var dbjob = "<?=$_dbjob?>";
		
		$(".v"+$("[name=membership]").val()).removeClass('hidden');

		$(".btn-agency").click(function(){
			/*if(!$('[name=agency]').val()){
				alert("검색어를 입력해주세요");
				return;
			}*/
			$.ajax({
				type: "POST",
				url: "/thdadmin/ajax_agency",
				data: "agency="+encodeURIComponent($('[name=agency]').val()),
				success: function(data){
					var prefix = eval('('+data+')');
					if(prefix.rst.length > 0){
						$('[name="stuff"] option').remove();
						$.each(prefix.rst,function(index,value){
							$('[name="stuff"]').append('<option value="'+value[0]+'">'+value[1]+'</option>');
						});
					}
					
				},
				error:function(error){alert('에러');}
			});	
		});
		
		if(dbjob == 'u'){
			$("[name=user_id]").attr('readonly',true);
			$("[name=passwd]").attr('readonly',true);
			$("[name=chkpasswd]").attr('readonly',true);
			$(".passwd_yn").removeClass('hidden');
			$(".vaild-userid").addClass('hidden');
			
		}

		$("[name=passwd_yn]").click(function(){
			if($(this).prop('checked')){
				$("[name=passwd]").attr('readonly',false);
				$("[name=chkpasswd]").attr('readonly',false);
			}else{
				$("[name=passwd]").attr('readonly',true);
				$("[name=chkpasswd]").attr('readonly',true);
			}
		});
		
		$("[name=mail_doamin]").change(function(){
			if($(this).val()){
				$('[name="email[]"]:eq(1)').attr('readonly',true);
				$('[name="email[]"]:eq(1)').val($(this).val());	
			}else{
				$('[name="email[]"]:eq(1)').attr('readonly',false);
				$('[name="email[]"]:eq(1)').focus();
			}
		});

		product.init();
	});

	//]]>
</script>