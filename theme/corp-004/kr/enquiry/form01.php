<?
$query = $this->product_model->category_list(array('use_yn'=>'Y'));
$info = array();
foreach($query->result() as $row){
	$info[$row->sort_no] = array('id'=>$row->id,'parent_id' => $row->parent_id,'category' => $row->category,'category_name' => $row->category_name,'use_yn' => $row->use_yn,'sort_no' => $row->sort_no, 'is_child' => $row->is_child);
}

$_brand = set_category($info,209); //브랜드
$_wheel = set_category($info,203); //휠
$_etc = set_category($info,204); //주변제품
$_model = set_category($info,2); //차종

$query_size = set_child_list('1');
$query_loc = set_child_list('2');

?>
<h2 class="title"><span><em>문의하기</em></span></h2>
<div class="contact-box">
    <div class="tab-cover">
        <ul  class="col2">
            <li><a href="/enquiry/enquiryForm?p_cate=01" class="act"><span>가격문의</span></a></li>
            <li><a href="/enquiry/enquiryForm?p_cate=02"><span>기술문의</span></a></li>
        </ul>
    </div>
    <!-- end : tab-cover -->
	<form name="frm" action="/enquiry/enquiryDbjob" method="post">
	<input type="hidden" name="p_cate" value="01">
	<input type="hidden" name="c_cate" value="">
	<input type="hidden" name="dbjob" value="i">
    <div class="form">
        <ul>
            <li>
            <span class="label">문의제품 종류</span>
            <div class="row">
                <div class="sel-cover">
                    <span class="item-r"><input type="radio" name="cate" id="radio1_1" onclick="$('.cost-goods').hide(); $('#tire').show();" checked="checked" value="tire" /><label for="radio1_1">타이어</label></span>
                    <span class="item-r"><input type="radio" name="cate" id="radio1_2" onclick="$('.cost-goods').hide(); $('#wheel').show();"  value="wheel" /><label for="radio1_2">휠</label></span>
                    <span class="item-r"><input type="radio" name="cate" id="radio1_3" onclick="$('.cost-goods').hide(); $('#acc').show();" value="etc" /><label for="radio1_3">기타상품</label></span>
                </div>
            </div>
            </li>
            <li class="cost-goods" id="tire">
            <span class="label">문의제품 선택</span>
            <div class="row">
                <div class="sel-cover">
                    <span class="item-r"><input type="radio" name="tire" value="size" id="product1_1" onclick="$('.sel-row').hide(); $('#product_sel_1').show();" checked="checked" /><label for="product1_1">사이즈 검색</label></span>
                    <span class="item-r"><input type="radio" name="tire" value="model" id="product1_2" onclick="$('.sel-row').hide(); $('#product_sel_2').show();"  /><label for="product1_2">차종 검색</label></span>
                </div>
                <div class="sel-row" id="product_sel_1">
                    <!-- <span class="select-cover w2">
						<label></label>
						<select class="select-category1 size">
							<option value="">브랜드</option>
							<?php
								foreach($_brand as $k => $v){
									echo '<option value="'.$v['category'].'">'.$v['category_name'].'</option>'.chr(10);
								}
							?>
						</select>
                    </span>
					<span class="select-cover w2">
						<label title="패턴"></label>
						<select class="select-category1 size">
						<option value="">패턴</option>
						</select>
                    </span> -->
                    <span class="select-cover w2">
						<label></label>
						<select name="size">
						<option value="">사이즈</option>
						<?
						foreach($query_size->result() as $row){
							echo '<option value="'.$row->code_id.'">'.$row->title.'</option>'.chr(10);
						}
						?>
						</select>
                    </span>
                    <span class="select-cover w2">
						<label></label>
						<select name="loc">
						<option value="">장착위치</option>
						<?
						foreach($query_loc->result() as $row){
							echo '<option value="'.$row->code_id.'">'.$row->title.'</option>'.chr(10);
						}
						?>
						</select>
                    </span>
                </div>
                <div class="sel-row"  id="product_sel_2" style="display:none;">
                    <span class="select-cover w3">
						<label></label>
						<select class="model">
						<option value="">분류</option>
						<?php
							foreach($_model as $k => $v){
								echo '<option value="'.$v['category'].'">'.$v['category_name'].'</option>'.chr(10);
							}
						?>
						</select>
                    </span>
                    <span class="select-cover w3">
						<label title="제조사"></label>
						<select class="model">
						<option value="">제조사</option>
						</select>
                    </span>
                    <span class="select-cover w3">
						<label title="차종"></label>
						<select class="model">
						<option value="">차종</option>
						</select>
                    </span>
                    <span class="select-cover w3">
						<label title="톤"></label>
						<select class="model">
						<option value="">톤</option>
						</select>
                    </span>
					 <span class="select-cover w3">
						<label></label>
						<select name="loc2">
						<option value="">장착위치</option>
						<?
						foreach($query_loc->result() as $row){
							echo '<option value="'.$row->code_id.'">'.$row->title.'</option>'.chr(10);
						}
						?>
						</select>
                    </span>
                </div>
            </div>
            </li>
            <li class="cost-goods" id="wheel" style="display:none;">
            <span class="label">문의제품 선택</span>
            <div class="row">
                <span class="label">휠</span>
                <div class="in">
                    <span class="select-cover w2">
						<label></label>
						<select class="wheel">
						<option value="">분류</option>
						<?php
							foreach($_wheel as $k => $v){
								echo '<option value="'.$v['category'].'">'.$v['category_name'].'</option>'.chr(10);
							}
						?>
						</select>
                    </span>
					<span class="select-cover w3">
						<label></label>
						<select class="wheel">
						<option value="">----------</option>
						</select>
                    </span>
                    <!-- <span class="select-cover w2">
                    <label></label>
						<select class="wheel">
						<option value="">분류</option>
						</select>
                    </span> -->
                </div>
            </div>
            </li>
            <li class="cost-goods" id="acc" style="display:none;">
            <span class="label">문의제품 선택</span>
            <div class="row">
                <span class="label">기타상품</span>
                <div class="in">
                    <span class="select-cover w2">
                    <label></label>
						<select class="etc">
						<option value="">분류</option>
						<?php
							foreach($_etc as $k => $v){
								echo '<option value="'.$v['category'].'">'.$v['category_name'].'</option>'.chr(10);
							}
						?>
						</select>
                    </span>
					<span class="select-cover w3">
						<label></label>
						<select class="etc">
						<option value="">----------</option>
						</select>
                    </span>
                    <!-- <span class="select-cover w2">
                    <label></label>
						<select class="etc">
						<option>분류</option>
						</select>
                    </span> -->
                </div>
            </div>
            </li>
            <li>
            <span class="label">답변 받을 연락처</span>
            <div class="row">
                <span class="label">전화번호</span>
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
<style type="text/css">
.w3{width:125px !important}
</style>
<script type="text/javascript">
//<![CDATA[ 
function frmValid(){
	var selobj;
	var c='';
	if($("[name=cate]:checked").val() == 'tire'){ //타이어
		selobj = $("[name=tire]:checked").val();

		if(selobj == 'model'){
			$("."+selobj+" option:selected").each(function(){
				if($(this).val()) c = $(this).val(); 	
			});

			if(c.length < 6){
				alert('문의제품을 선택해주세요');
				return;
			}
		}

		if(selobj == 'size'){
			with(document.frm){
				if(!size.value){
					alert('사이즈를 선택해주세요');
					size.focus();
					return;
				}

				if(!loc.value){
					alert('장착위치를 선택해주세요');
					loc.focus();
					return;
				}
			}
		}


	}else{ //휠,기타제품
		selobj = $("[name=cate]:checked").val();
		$("."+selobj+" option:selected").each(function(){
			if($(this).val()) c = $(this).val(); 	
		});
		if(c.length < 4){
			alert('문의제품을 선택해주세요');
			return;
		}
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

	if($("[name=agree]:checked").val() !="y"){
		alert("개인정보수집 및 이용안내에 동의해 주세요");
		return;
	}

	with(document.frm){
		c_cate.value = c;
		submit();
	}
}

function init_category(selobj){
	$('.'+selobj).change(function(){
		var index = $('.'+selobj).index($(this));
		$.ajax({
			type: "GET",
			url: "/front/ajax_child_category",
			data: "category="+$(this).val(),
			success: function(data){
				var prefix = eval('('+data+')');
				
				//초기화
				$('.'+selobj).each(function(idx){
					if(idx > index){
						$(this).prev("label").html($(this).get(0).options[0].text);
						$(this).find("option").not("[value='']").remove();
						//$(this).empty();
					}
				});

				if(prefix.category == undefined) return;
				for(var i=0; i < prefix.category.length; i++){
					$('.'+selobj).eq(index+1).get(0).options[i+1] = new Option(prefix.category_name[i],prefix.category[i]);
				}
			},
			error:function(error){alert('에러');}
		});		
	});
}

$(document).ready(function(){
	init_category("size");
	init_category("wheel");
	init_category("etc");
	init_category("model");
});

menu_on(3); //메뉴관리
//]]>
</script>

