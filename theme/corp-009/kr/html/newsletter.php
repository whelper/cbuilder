<div id="section" pgCode="0404">
    <!-- 내용 -->
    <div class="letter_top">
        <p>
        <span class="dev">아래의 입력사항을 입력하시면</span>
        <span class="dev">한러과학기술협력센터에서 정기적으로 발행하는</span>
        <span style="color:#ffd266;">뉴스레터</span> 등 <span style="color:#6dd1ff;">다양한 정보</span>를 제공받으실 수 있습니다.
        </p>
    </div>

    <!--게시판 쓰기(기술매칭) start-->
	<form name="frm" action="" enctype="multipart/form-data" method="post">
    <div class="board_write mt30">
        
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="15%" class="tb_tt2" >성명</td>
            <td width="83%" >
                <input type="text" name="name" id ="" value="" class="on_inp_01" required >
            </td>
        </tr>
        <tr>
            <td class="tb_tt2" >소속기관명</td>
            <td>
                <input type="text" name="organ" id ="" value="" class="on_inp_01"required >
            </td>
        </tr>
        <tr>
            <td class="tb_tt2">E-mail</td>
            <td>
                <ul class="email_wp">
                    <li class="em_inp"style=""><input type="text" name="mail[]" id="mail1" value="" class="on_inp_01" required></li>
                    <li class="em_a">@</li>
                    <li class="em_inp"><input type="text" name="mail[]" id="mail2"value="" class="on_inp_01" required></li>
                </ul>
            </td>
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
	<input type="hidden" name="dbjob" value="i">
	</form>
    <div class="app_btn mt50">
        <p onclick="frmValid()" class="btnNormal" >SEND</p>
    </div>

</div>
<!-- section -->
<script type="text/javascript">
//<![CDATA[
	var mailRegEx = /^\s*[\w\~\-\.]+\@[\w\~\-]+(\.[\w\~\-]+)+\s*$/i;	//메일
	function frmValid(){
		if($("[name=agree]:checked").length == 0){
			alert(" 개인정보에 대한 수집 및 이용약관에 동의해 주세요");
			return;
		}
		
		with(document.frm){
			if(!name.value){
				alert('이름을 입력해주세요');
				name.focus();
				return;
			}

			if(!organ.value){
				alert('소속기관명을 입력해주세요');
				organ.focus();
				return;
			}
			
			var mail = $('[name="mail[]"]').eq(0).val()+'@'+$('[name="mail[]"]').eq(1).val();
			if(!mailRegEx.test(mail)){
				alert('메일형식에 맞게 입력해주세요');
				return;
			}	
			target = "ifrm_proc";	
			action = '/front/newsletter_dbjob';
			submit();
			target = "";
		}
	}

//]]>
</script>
