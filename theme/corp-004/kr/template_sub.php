
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8" />
	<title><?=$_menu['title']?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="<?=$_menu['description']?>" />
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
<body>
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
						$_leftIndex = 0;
						$_i = 0;
						foreach($parser->document->menu1 as $menu){				
							if($menu->id[0]->tagData == $_menu['parent_id']){
								$_menu_image = '/theme/'.$this->config->item('theme').'/'.$_language.'/images/common/gnb'.$menu->id[0]->tagData.'_on.gif';
								$_css = 'on';
								$_leftIndex = $_i; 
							}else{
								$_menu_image = '/theme/'.$this->config->item('theme').'/'.$_language.'/images/common/gnb'.$menu->id[0]->tagData.'.gif';
								$_css = '';
							}

							if($menu->etc_yn[0]->tagData == 'N'){ //기타메뉴 제외
							echo '<li><a href="'.$menu->hyperlink[0]->tagData.'">'.$menu->menuname[0]->tagData.'</a></li>'.chr(10);
							}
							$_i++;
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
						if($menu->etc_yn[0]->tagData == 'N'){  //기타메뉴 제외
							foreach($menu->menu2 as $menu_sub){
								$_sub .= '<li><a href="'.$menu_sub->hyperlink[0]->tagData.'">'. $menu_sub->menuname[0]->tagData.'</a></li>'.chr(10);
							}
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
		<div id="sub-visual" class="bg0<?=$_leftIndex+1?>"></div>
	</div>
	<div id="container">
		<div class="left-menu">
			<h2 class="left-title0<?=$_leftIndex+1?>"></h2>
			<ul>
				<?php
					foreach($parser->document->menu1[$_leftIndex]->menu2 as $menu){
						$_menu_image = '/theme/'.$this->config->item('theme').'/'.$_language.'/images/common/lnb'.$menu->id[0]->tagData.'.gif';
						$_css = ($menu->id[0]->tagData == $_menu['menu_id']) ? 'on' : '';
						echo '<li class="'.$_css.'"><a href="'.$menu->hyperlink[0]->tagData.'">'.$menu->menuname[0]->tagData.'</a></li>'.chr(10);
					}
				?>		
			</ul>
		</div>
		<div class="navi"><span class="home">홈</span> 
		<?
			krsort($_menu['nav']);
			foreach($_menu['nav'] as $_k => $_v){
				$current = ($_k == 0) ? 'current' : null;
				echo ' &gt; <span class="'.$current.'">'.$_v.'</span>';
				
			}
		?>
		
		</div>
		<div class="contents">
			<h3 class="title"><?=$_menu['title']?></h3>
			<?php
				$this->load->view($_contents);
			?>
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
<!--begin layer-->
<div class="wrap-layer">
	<div class="bg"></div>
	<div class="layer-box">
		<a href="javascript:void(0);" class="close">close</a>
		<div class="layer-wrap">
			<input type="password" id="layer-passwd" style="width:178px" placeholder="비밀번호를 입력해주세요" /><a href="javascript:auth_board();" class="btn-s ml10">확인</a>
			<p class="ctxt-4d8ed3 mt10">글 작성시 입력한 비밀번호를 입력해 주세요</p>
		</div>
	</div>
</div>
<!--end layer-->
</body>
</html>