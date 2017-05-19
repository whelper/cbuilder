<div class="layer-area-wrap">
	<div class="pop layer-pop" id="project-request">
        <form name="frm" method="post" action="/enquiry/enquiryDbjob">
		<input type="hidden" name="dbjob" value="i" />
		<input type="hidden" name="userno" value="<?=$userno?>" />
		<input type="hidden" name="return_url" value="<?=$this->agent->referrer()?>" />
		<div class="p-body">
            <a href="#" class="close">닫기</a>
            <h3>프로젝트의뢰</h3>
            <ul class="write">
                <li>
                    <span class="tit">이름</span>
                    <div class="con">
                        <div class="input-box"><input type="text" name="name" value="<?=$name?>" /></div>
                    </div>
                </li>
                <li>
                    <span class="tit">회사명</span>
                    <div class="con">
                        <div class="input-box"><input type="text" name="corp" /></div>
                    </div>
                </li>
                <li>
                    <span class="tit">이메일</span>
                    <div class="con">
                        <div class="input-box"><input type="text" name="email"  value="<?=$email?>" /></div>
                    </div>
                </li>
                <li>
                    <span class="tit">연락처</span>
                    <div class="con">
                        <div class="input-box"><input type="text" name="phone"  value="<?=$hp?>" placeholder="ex) 010-1234-1234 '-' 포함하여 작성해주세요." /></div>
                    </div>
                </li>
            </ul>
            <p class="note"><span class="pointC-ty2">* 의뢰인의 연락처는 연락 용도로만 사용되며 다른 곳에 공개되지 않습니다.</span></p>
            <ul class="write">
                <li class="mt row">
                    <span class="tit"><input type="checkbox" id="agree" /><label for="agree"> 개인정보수집 및 이용 안내</label></span>
                    <div class="con">
                        <div class="table-ty1">
                            <table>
                                <colgroup><col width="36%" /><col width="*" /><col width="26%" /></colgroup>
                                <thead>
                                <tr>
                                    <th>목적</th>
                                    <th>항목</th>
                                    <th>보유 및 이용기간</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="center">이용자 식별, 서비스이용 및 상담</td>
                                    <td class="center">이름, 이메일, 비밀번호, 휴대전화번호</td>
                                    <td class="center">회원탈퇴 후 5일 까지</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </li>
                <li class="mt row">
                    <div class="con">
                        <div class="request-sel">
                            <span><input type="radio" id="type1" name="c_cate" value="영상" /><label for="type1">영상</label></span>
                            <span><input type="radio" id="type2" name="c_cate" value="디자인" /><label for="type2">디자인</label></span>
                            <span><input type="radio" id="type3" name="c_cate" value="서체개발" /><label for="type3">서체개발</label></span>
                            <span><input type="radio" id="type4" name="c_cate" value="광고" /><label for="type4">광고</label></span>
                            <span><input type="radio" id="type5" name="c_cate" value="아이덴티티" /><label for="type5">아이덴티티</label></span>
                            <span><input type="radio" id="type6" name="c_cate" value="기타" /><label for="type6">기타</label></span>
                        </div>
                    </div>
                </li>
                <li>
                    <span class="tit">제목</span>
                    <div class="con">
                        <div class="input-box"><input type="text" name="title" /></div>
                    </div>
                </li>
                <li>
                    <span class="tit">내용</span>
                    <div class="con">
                        <div class="input-box"><textarea name="content" placeholder="프로젝트에 대해 자세히 작성해주세요.(800자 이내)" rows="5"></textarea></div>
                    </div>
                </li>
            </ul>
            <p class="note">프로젝트 문의 후 1~2일내에 이메일 혹은 전화 드리겠습니다.<br />(관련문의: 02-741-9960)</p>
            <div class="btns">
                <a href="javascript:frmValid()" class="btn ty8 flip"><span class="front">프로젝트 문의</span><span class="back">프로젝트 문의</span></a>
                <a href="#" class="btn ty7 flip"><span class="front">취소</span><span class="back">취소</span></a>
            </div>
        </div>
		</form>
    </div>
</div>
<script type="text/javascript">
	//<![CDATA[
	function frmValid(){
		with(document.frm){
			if(!name.value){
				alert('이름을 입력해주세요');
				name.focus();
				return;
			}

			if(!email.value){
				alert('이메일을 입력해주세요');
				email.focus();
				return;
			}

			if(!phone.value){
				alert('연락처를 입력해주세요');
				phone.focus();
				return;
			}

			if($("[name=c_cate]:checked").length == 0){
				alert("분류를 선택해주세요");
				return;
			}

			if(!title.value){
				alert('제목을 입력해주세요');
				title.focus();
				return;
			}

			if(!content.value){
				alert('내용을 입력해주세요');
				content.focus();
				return;
			}
			
			if(!$("#agree").prop("checked")){
				alert("개인정보수집 및 이용안내에 동의 하셔야 합니다.");
				return;
			}
			submit();
		}
	}	
	//]]>
</script>