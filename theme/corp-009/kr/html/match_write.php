<div id="section" pgCode="0203">
    <!-- 내용 -->
	<form name="frm" action="" enctype="multipart/form-data" method="post">
    <!--게시판 쓰기(기술매칭) start-->
    <div class="board_write">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="25%" class="tb_tt" >Full name</td>
            <td width="73%" >
                <input type="text" name="name" id ="" value="" class="on_inp_01" >
            </td>
        </tr>
        <tr>
            <td class="tb_tt">E-mail</td>
            <td>
                <ul class="email_wp">
                    <li class="em_inp"><input type="text" name="mail[]" id="mail1" value="" class="on_inp_01"></li>
                    <li class="em_a">@</li>
                    <li class="em_inp"><input type="text" name="mail[]" id="mail2" value="" class="on_inp_01"></li>
                </ul>
            </td>
        </tr>
        <tr>
            <td class="tb_tt">Telephone</td>
            <td>
                <ul class="tb_tel">
                    <li>
                    <input type="text" name="tel[]" id="tel1" value="" class="on_inp_01">
                    </li>
                    <li style="width:2%;text-align:center;padding-top:5px;">-</li>
                    <li style=""><input type="text" name="tel[]" id="tel2" value="" class="on_inp_01"></li>
                    <li style="width:2%;text-align:center;padding-top:5px;">-</li>
                    <li style="padding:0;"><input type="text" name="tel[]" id="tel3" value=""class="on_inp_01"></li>
                </ul>
            </td>
        </tr>
        <tr>
            <td class="tb_tt">Organization</td>
            <td>
                <input type="text" name="organ" id="organ" title="" class="on_inp_01">
            </td>
        </tr>
        <tr>
            <td class="tb_tt">Position</td>
            <td><input type="text" name="position" id="position" value="" title="" class="on_inp_01" ></td>
        </tr>
        <tr>
            <td class="tb_tt">Country</td>
            <td>
                <select name="country" class="on_sel_01" >
                <option value="">국가선택</option>
               <?
				foreach($this->config->item('country') as $k => $v){
					$_selected = ($language == $k) ? 'selected' : null;
					echo '<option value="'.$k.'" '.$_selected.'>'.$v.'</option>'.chr(10);
				}
				?>
				</select>
            </td>
        </tr>
        <tr>
            <td class="tb_tt">Subject</td>
            <td><input type="text" name="title" id="" value="" title="" class="on_inp_01" ></td>
        </tr>
        <tr>
            <td class="tb_tt">Keywords</td>
            <td><input type="text" name="keywords" id="" value="" title="" class="on_inp_01" ></td>
        </tr>
        <tr>
            <td class="tb_tt">City</td>
            <td><input type="text" name="city" id="" value="" title="" class="on_inp_01" ></td>
        </tr>
        <tr>
            <td class="tb_tt">Summary</td>
            <td>
                <div class="on_editor">
                    <textarea name="summary" id="ckeditor_standard1"></textarea>
					<script type="text/javascript" src="/common/assets/ckeditor/standard/ckeditor.js"></script>
					<script type="text/javascript">
						CKEDITOR.replace('ckeditor_standard1',{
							  filebrowserImageUploadUrl:"/common/assets/ckeditor/full/upload.php?type=Images"
						 });				   
					</script>
                </div>
                <!-- on_editor -->
            </td>
        </tr>
        <tr>
            <td class="tb_tt">Description</td>
            <td>
                <div class="on_editor">
                    <textarea name="description" id="ckeditor_standard2"></textarea>
					<script type="text/javascript" src="/common/assets/ckeditor/standard/ckeditor.js"></script>
					<script type="text/javascript">
						CKEDITOR.replace('ckeditor_standard2',{
							  filebrowserImageUploadUrl:"/common/assets/ckeditor/full/upload.php?type=Images"
						 });				   
					</script>
                </div>
                <!-- on_editor -->
            </td>
        </tr>
        <tr>
            <td class="tb_tt">Advantages and Innovations</td>
            <td>
                <div class="on_editor">
                   <textarea name="advantages" id="ckeditor_standard3"></textarea>
					<script type="text/javascript" src="/common/assets/ckeditor/standard/ckeditor.js"></script>
					<script type="text/javascript">
						CKEDITOR.replace('ckeditor_standard3',{
							  filebrowserImageUploadUrl:"/common/assets/ckeditor/full/upload.php?type=Images"
						 });				   
					</script>
                </div>
                <!-- on_editor -->
            </td>
        </tr>
        <tr>
            <td class="tb_tt">Attachments (10MB limit)</td>
            <td id="attFiles">
				<!-- <input type="file"> -->
                <div class="file">
                    <p class="file_a">
                    첨부파일
                    <input type="file" name="files[]">
                    </p>
                    <p class="file_nm"></p>
                    <p class="file_d file-delete" style="display:none">
                    삭제
                    </p>

                </div>
            </td>
        </tr>
        <tr>
            <td class="tb_tt">IPR status </td>
            <td><input type="text" name="ipr_status" id="" value="" title="" class="on_inp_01" ></td>
        </tr>
        <tr>
            <td class="tb_tt">Stage of Development </td>
            <td class="textright">
                <label for=""><input type="radio" id="" name="stage_of_develop" value="01"> Funding needed</label>
                <label for=""><input type="radio" id="" name="stage_of_develop" value="02"> Available for demonstration </label>
                <label for=""><input type="radio" id="" name="stage_of_develop" value="03"> Already on the market</label>
            </td>
        </tr>
        <tr>
            <td class="tb_tt">Partner sought</td>
            <td><input type="text" name="partner_sought" id="" value="" title="" class="on_inp_01" ></td>
        </tr>
        </table>
    </div>
    <!--게시판 쓰기(기술매칭) end-->

    <div class="privacyArea">
        <div class="scroll ol_list">
            한러과학기술협력센터는 기업/단체 및 개인의 정보 수집 및 이용 등 처리에 있어 아래의 사항을 관계법령에 따라 고지하고 안내해 드립니다.
            <ol>
                <li>정보수집의 이용 목적 : 기술매칭 문의</li>
                <li>수집/이용 항목 : 이름, 연락처, 이메일</li>
                <li>보유 및 이용기간 : 개인정보 수집 및 이용목적이 달성된 후에는 관련 법령에 의한 정보보호 사유에 따라 일정 기간 저장된 후 파기</li>
                <li>개인정보처리담당 : 민다흰 / 이메일 : korustec@gmail.com</li>
            </ol>
        </div>
        <label for="agree2" class="agr_chk2"><input type="checkbox" name="agree" id="agree">
        <span>위의 개인정보에 대한 수집 및 이용약관에 동의합니다.</span></label>
    </div>

    <div class="app_btn mt50">
        <p onclick="javascript:frmValid();" class="btnNormal" >SEND</p>
        <p onclick="javscript:history.back();" class="btnNormal_g" >LIST</p>
    </div>
	<input type="hidden" name="dbjob" value="i">
	<input type="hidden" class="file-input" name="attache_file1" id="attache_file1" value="">
	<input type="hidden" name="file_path" id="file_path" value="match">
	<input type="hidden" name="file_thumb" id="file_thumb" value="">
	<input type="hidden" name="file_thumb_size" id="file_thumb_size" value="">
	<input type="hidden" name="file_num" id="file_num" value="0">
	<input type="hidden" name="file_info" id="file_info" value="">
	</form>
</div>
<!-- section -->
<script type="text/javascript">
//<![CDATA[
	function frmValid(){
		if($("[name=agree]:checked").length == 0){
			alert(" 개인정보에 대한 수집 및 이용약관에 동의해 주세요");
			return;
		}
		
		with(document.frm){
			if(!name.value){
				alert('Full name을 입력해주세요');
				name.focus();
				return;
			}

			if(!title.value){
				alert('Subject를 입력해주세요');
				title.focus();
				return;
			}
			
			if(!CKEDITOR.instances.ckeditor_standard1.getData()){
				alert("Summary를 입력하세요");
				return;
			}

			if($("[name=stage_of_develop]:checked").length == 0){
				alert("Stage of Development 선택해주세요");
				return;
			}

			action = '/front/match_dbjob';
			submit();
		}
	}

	function fileAdd(n,f){
		var finfo = f.split('|');
		var v = Array();
		
		var fnm = (finfo[1] != undefined) ? finfo[1] : finfo[0];
		v.push('<a href="/upload/'+$("#file_path").val()+'/'+finfo[0]+'" target="_blank">'+fnm+'</a>');
		$(".file-input").eq(n).val(f);
		//$(".file-group").eq(n).prepend(v.join(''));
		$(".file-delete").eq(n).show();
		$(".file_nm").eq(n).html(v.join(''));
		
	}

	function fildDeleteDone(n){
		$(".file_nm").eq(n).html('');
		$(".file-delete").eq(n).hide();
		$(".file-input").eq(n).val('');

	}

	$(function(){
		$('[name="files[]"]').change(function(){
			with(document.frm){
				target ="ifrm_proc";
				action = "/front/product_file_proc";
				submit();
				target ="";
			}
		});

		$(".file-delete").click(function(){
			var index = $(".file-delete").index($(this));
			$("#file_info").val($(".file-input").eq(index).val());
			$("#file_num").val(index);
			with(document.frm){
				target ="ifrm_proc";
				action = "/front/product_file_proc";
				submit();
				target ="";
			}
		});

	});
//]]>
</script>