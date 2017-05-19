<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8" />
	<title>류마내과의원</title>
	<meta name="viewport" content="width=640, user-scalable=yes"/>
	<meta name="description" content="알레르기 ,호흡기 , 천식 특화 병원입니다." />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="stylesheet" type="text/css" href="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/css/common.css" />
	<link rel="stylesheet" type="text/css" href="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/css/jquery.ui.lastest.css" />
	<script type="text/javascript" src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/js/jquery.lastest.js"></script>
	<script type="text/javascript" src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/js/jquery.ui.lastest.js"></script>
	<script type="text/javascript" src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/js/jquery.customSelect.js"></script>
	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>

	<!--[if lt IE 10]>
		<script type="text/javascript" src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/js/placeholder.js"></script>
	<![endif]-->
	<!--[if lt IE 9]>
		<link rel="stylesheet" type="text/css" href="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/css/ie8.css" />
	<![endif]-->
	<!--[if lt IE 8]>
		<link rel="stylesheet" type="text/css" href="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/css/ie7.css" />
	<![endif]-->
	<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" href="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/css/ie6.css" />
	<![endif]-->

	<script type="text/javascript">
		//<![CDATA[
		$(document).ready(function(){
			//gnb menu begin
			$(".allMenu").click(function(){
				if($(".pop-menu").css("width") == '0px'){
					$(".pop-menu").animate({
						"width" : "446px"
						/*"right" : 0*/
					},200,'easeOutExpo', function (){
						$(".blinder").css({
							"width" : $(document).width(),
							"height" : $(document).height()
						}).fadeTo("fast", 0.8);

						//close begin
						$(".pop-menu>.head>.close").click(function(){
							$(".pop-menu").animate({
								"width" : 0
							},200,'easeOutExpo', function (){
								
								$(".blinder").css({
									"width" : 0,
									"height" : 0
								}).fadeTo("fast", 0.8);
							});
						});
						//close end
					});
				}
			});
			//gnb menu end
			$(".pop-menu dl dt").click(function(){
				var index = $(".pop-menu dl dt").index($(this));
				if($(this).hasClass("on")){
					$(this).removeClass("on");
					$(".pop-menu dl dd").eq(index).hide();
				}else{
					$(this).addClass("on");
					$(".pop-menu dl dd").eq(index).show();
				}
			});
			
			
		});
		//]]>
	</script>
	</head>
<body>
<div id="wrap">	
	<div id="header">
		<div id="gnb">
			<div class="wrap-menu">
				<h1><a href="/" class="logo"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/logo.png" alt="류마내과의원 로고" /></a></h1>
				<button type="button" class="allMenu">메뉴</button>
			</div>
		</div>
		
	</div>
	<div id="container">
		<div class="navi">
		<button class="back" onclick="history.back()"></button>
		<?=$_title?>
		
		</div>
		<div class="contents">
		<?php
			$this->load->view($_contents);
		?>
		</div>
	</div>
	<div id="footer">
		<div class="wrap-footer">
			<div class="footer-menu">
				<a href="/front/html/address">찾아오시는길</a>
				<!-- <span class="f_bar">|</span>
				<a href="/front/html/sitemap">사이트맵 </a> -->
				<span class="f_bar">|</span>
				<a href="/front/html/privacy">개인정보 처리방침</a>
				<span class="f_bar">|</span>
				<a href="/front/?pc">PC화면보기</a>
			</div>
			<address>
			서울 강동구 천호동 447번지 정산빌딩 5층<br>
			TEL. 02-474-5450<span class="f_bar">|</span>FAX. 02-474-5460<br>
			Copyright 2016 류마내과 All Rights Reserved.
			</address>
			
		</div>
	</div>
</div>
<!--begin 전체메뉴 -->
		<div class="pop-menu">
			<div class="head">
				<h1>전체메뉴</h1>
				<p class="close"></p>
			</div>
			<dl>
				<?php
					$xml = file_get_contents('./application/views/html/menu_'.$_language.'.xml');
					$parser = new XMLParser($xml);
					$parser->Parse();
					
					foreach($parser->document->menu1 as $menu){				
						if($menu->etc_yn[0]->tagData == 'N'){ //기타메뉴 제외
							echo '<dt>'.$menu->menuname[0]->tagData.'</dt>'.chr(10);
							if($menu->menu2){
								echo '<dd>'.chr(10);
								echo '	<ul>'.chr(10);
								foreach($menu->menu2 as $menu_sub){
									echo '<li onclick="location.href=\''.$menu_sub->hyperlink[0]->tagData.'\'">'.$menu_sub->menuname[0]->tagData.'</li>'.chr(10);
								}
								echo '	</ul>'.chr(10);
								echo '</dd>'.chr(10);
							}
						}
					
					}
				?>	
			
			</dl>
		</div>
		<!--end 전체메뉴-->
<div class="blinder"></div>
<!--begin layer-->
<div class="wrap-layer">
	<div class="bg"></div>
	<div class="layer-box">
		<a href="javascript:void(0);" class="close">close</a>
		<div class="layer-wrap">
			<input type="password" id="layer-passwd" style="width:178px" placeholder="비밀번호를 입력해주세요" /><a href="javascript:auth_board();" class="btn ml10">확인</a>
			<p class="ctxt-4d8ed3 mt10">글 작성시 입력한 비밀번호를 입력해 주세요</p>
		</div>
	</div>
</div>
<!--end layer-->
</body>
</html>