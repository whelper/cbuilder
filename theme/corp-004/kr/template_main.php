<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8" />
	<title>류마내과의원</title>
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
		$(function(){
			$(".top-menu li a").mouseover(function(){
				var index = $(".top-menu li a").index($(this));
				
				$(".sub-menu").show();
				$(".sub-menu .wrap-menu ul").hide();

				$(".sub"+index).show();
			});

			$("#header").mouseout(function(){
				$(".sub-menu").hide();		
				$(".sub-menu").mouseover(function(){
					$(".sub-menu").show();
				});
			});

			
		});
		//]]>
	</script>
	</head>
<body id="main">
<div id="wrap">	
	<div id="header">
		<div id="gnb">
			<div class="wrap-menu">
				<h1><a href="/" class="logo"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/logo.png" alt="류마내과의원 로고" /></a></h1>
				<ul class="top-menu">
					<?php
						$xml = file_get_contents('./application/views/html/menu_'.$_language.'.xml');
						$parser = new XMLParser($xml);
						$parser->Parse();
						
						foreach($parser->document->menu1 as $menu){				
							if($menu->etc_yn[0]->tagData == 'N'){ //기타메뉴 제외
							echo '<li><a href="'.$menu->hyperlink[0]->tagData.'">'.$menu->menuname[0]->tagData.'</a></li>'.chr(10);
							}
						
						}
					?>	
				</ul>
			</div>
			<div class="sub-menu">
				<div class="wrap-menu">
					<? //sub menu
					$_s = 0;
					foreach($parser->document->menu1 as $menu){				
						$_sub = null;
						foreach($menu->menu2 as $menu_sub){
							$_sub .= '<li><a href="'.$menu_sub->hyperlink[0]->tagData.'">'. $menu_sub->menuname[0]->tagData.'</a></li>'.chr(10);
						}

						echo '<ul class="sub'.$_s.'">'.chr(10);
						echo $_sub;
						echo '</ul>'.chr(10);
						$_s++;
					}
					?>
				</div>
			</div>
		</div>
		</div>
		<div id="main-visual">
			<div class="main-bg">
				<div class="mbg01" title="수술없는 관철치료, 면혁치료"></div>
			</div>
		</div>
	</div>
	<div id="container">
		<div class="wrap-main">
			<ul class="card">
				<li onclick="location.href='/front/board/list/id/35'" class="linkon">
					<h2 class="talk">류마 Talk</h2>
					<a href="/front/board/list/id/35" class="more">더보기</a>
					<div class="bg-talk"></div>
				</li>
				<li onclick="location.href='/front/board/list/id/37'" class="linkon">
					<h2 class="vod">류마 VOD</h2>
					<a href="/front/board/list/id/37" class="more">더보기</a>
					<div class="bg-vod"></div>
				</li>
				<li onclick="location.href='/front/html/id/8'" class="linkon">
					<h2 class="rheuma">류마티스내과란?</h2>
					<a href="/front/html/id/8" class="more">더보기</a>
					<div class="bg-rheuma"></div>
				</li>
				
				<li class="box4">
					<h2 class="news">진료사례</h2>
					<a href="/front/board/list/id/36" class="more">더보기</a>
					<ol>
						<?php
							foreach($_sample->result() as $row){
						?>
						<li><a href="/front/board/view/id/<?=$row->menu_id?>/no/<?=$row->id?>"><?=character_limiter($row->title,12)?></a></li>
						<?php
							}
						?>
						
					</ol>
				</li>
				<li class="box4 linkon" onclick="location.href='/front/html/address'" class="">
					<h2 class="sample">오시는길</h2>
					<a href="/front/html/address" class="more">더보기</a>
					<div class="bg-address"></div>
				</li>
				<li class="box2">
					<h2 class="time">진료시간</h2>
					<div class="time-list">
						<p><label>평&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;일</label>09:00 ~ 19:00</p>
						<p class="mt13"><label>토 요 일</label>09:00 ~ 15:00</p>
						<p class="mt13"><label>점심시간</label>13:00 ~ 14:00</p>
						<p class="mt15">일요일.공유일 휴진입니다</p>
					</div>
				</li>
			</ul>
			<div class="card-tel">
				<div class="txt-tel">
					<h2>문의전화 안내</h2>
					<p class="mt10"><span>(02)</span><strong>474.5450</strong></p>
				</div>
			</div>
		</div>
	</div>
	<div id="footer">
		<div class="wrap-footer">
			<div class="footer-menu">
				<a href="/front/html/address">찾아오시는길</a>
				<span class="f_bar">|</span>
				<a href="/front/html/sitemap">사이트맵 </a>
				<span class="f_bar">|</span>
				<a href="/front/html/privacy">개인정보 처리방침</a>
			</div>
			<address>
			서울 강동구 천호동 447번지 정산빌딩 5층<span class="f_bar">|</span>TEL. 02-474-5450<span class="f_bar">|</span>FAX. 02-474-5460
			</address>
			<p class="copyright">
			Copyright 2016 류마내과 All Rights Reserved.
			</p>
		</div>
	</div>
</div>
</body>
</html>