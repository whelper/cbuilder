  <!-- 달력 관련 스크립트 -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <script>
    $( function() {
      $(".jsdatapicker").datepicker({
        showOn: "button",
        buttonImage: "/theme/<?=$this->config->item('theme')?>/<?=$_language?>/<?=$_folder?>/images/btn/calendar.gif",
        buttonImageOnly: true,
        buttonText: "Select date",
        dateFormat: 'yy-dd-mm'
      });
    } );
  </script>
<h2 class="title"><span><em>문의하기</em></span></h2>
<div class="contact-box">
    <div class="tab-cover">
        <ul  class="col2">
            <li><a href="/enquiry/enquiryForm?p_cate=01"><span>가격문의</span></a></li>
            <li><a href="/enquiry/enquiryForm?p_cate=02" class="act"><span>기술문의</span></a></li>
        </ul>
    </div>
    <!-- end : tab-cover -->
	<form name="frm" action="/enquiry/enquiryDbjob" method="post">
	<input type="hidden" name="p_cate" value="02">
	<input type="hidden" name="c_cate" value="">
	<input type="hidden" name="dbjob" value="i">
	<input type="hidden" name="title" value="기술문의">
	<input type="hidden" name="name" value="자동등록">
    <div class="form">
        <ul>
            <li>
            <span class="label">답변 받을 연락처</span>
            <div class="row">
                <div class="in">
                    <div class="tel">
                        <span class="select-cover">
                        <label></label>
                        <select name="phone[]">
                        <option value="">-------</option>
						<?
						foreach($this->config->item('conf_hp_num') as $key => $value){
							echo '<option value="'.$value.'">'.$value.'</option>'.chr(10);
						}
						?>
                        </select>
                        </span> -
                        <input type="text" name="phone[]" maxlength="4" /> -
                        <input type="text" name="phone[]" maxlength="4" />
                        <span class="caption">의뢰인의 연락처는 답변을 위한 용도로만 사용되며, 다른 곳에 공개되지 않습니다.</span>
                    </div>
                    <!-- end : tel -->
                </div>
                <!-- end : in -->
            </div>
            </li>
            <li>
            <span class="label">상담가능시간</span>
            <div class="row">
                <div class="in">
                    <div class="time">
                        <span class="datapicker"><input type="text" name="dt" id="datapicker1" class="jsdatapicker" /></span>
                        <span class="select-cover">
                        <label></label>
                        <select name="hh">
							<?
							for($i=8; $i < 18; $i++){
								$h = substr('0'.$i,-2).':00~'.substr('0'.($i+1),-2).':00'; 
								echo '<option value="'.$h.'">'.$h.'</option>'.chr(10);
							}
							?>
							
                        </select>
                        </span>
                    </div>
                    <!-- end : tel -->
                </div>
                <!-- end : in -->
            </div>
            </li>
            <li>
            <span class="label">상담 요청 내용</span>
            <div class="row">
                <div class="in">
                    <textarea name="content" rows="8"></textarea>
                </div>
                <!-- end : in -->
            </div>
            </li>
            <li class="terms">
            <span class="label">개인정보수집 및 <em>이용안내</em></span>
            <div class="row">
                <div class="txt">
                    <p><strong>개인정보보호를 위한 이용자 동의서에 동의하십니까?</strong></p>
                    <p>목적: 이용자 식별 및 상담 및 이벤트 안내</p>
                    <p>항목: 전화번호</p>
                    <p>보유 및 이용기간: 삭제요청접수 후 일주일</p>
                </div>
                <div class="sel-cover">
                     <span class="item-r"><input type="radio" name="agree" value="y" id="radio2_1" checked="checked" /><label for="radio2_1">예</label></span>
                    <span class="item-r"><input type="radio" name="agree" value="n" id="radio2_2" /><label for="radio2_2">아니오</label></span>
                </div>
            </div>
            </li>
        </ul>
    </div>
	</form>
    <!-- end : form -->
    <div class="btn-check">
        <a href="javascript:frmValid()" class="btn ty3">가격 문의하기</a>
    </div>
</div>
<script type="text/javascript">
//<![CDATA[ 
function frmValid(){
	if($("[name=agree]:checked").val() !="y"){
		alert("개인정보수집 및 이용안내에 동의해 주세요");
		return;
	}
	
	var hp = Array();
	$('[name="phone[]"]').each(function(){
		hp.push($(this).val());
	});
	hp = hp.join("-");
	if(!hpRegEx.test(hp)){
		alert('답변받을 연락처를 정확히 입력해주세요');
		return;
	}

	with(document.frm){
		if(!dt.value || !hh.value){
			alert('상담가능 시간을 입력해 주세요');
			return;
		}
		
		if(!content.value){
			alert('상담내용을 입력해주세요');
			content.focus();
			return;
		}
		submit();
	}
}

$(document).ready(function(){

});

menu_on(3); //메뉴관리
//]]>
</script>
