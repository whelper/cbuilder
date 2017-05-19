<?
$query_visual = $this->db->where(array('language' => $this->language,'open_yn' => 'y'))->order_by('sort_no DESC')->get('thd_banner_main');
$query_data = $this->db->where(array('language' => $this->language,'menu_id' => '2'))->order_by('ref_id DESC , ansnum')->get('thd_board',7);
$query_gal = $this->db->where(array('language' => $this->language,'menu_id' => '4'))->order_by('ref_id DESC , ansnum')->get('thd_board',4);
$query_match = $this->db->where(array('language' => $this->language))->order_by('seq DESC')->get('thd_tech_matching',7);
$query_main = $this->db->where(array('language' => $this->language))->get('thd_main_contents',1);
?>
<!DOCTYPE html>
<html lang="ko" class="main">
<head>
	<title>KORUSTEC</title>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta content="yes" name="apple-mobile-web-app-capable" />
	<meta content="minimum-scale=1.0, width=device-width, maximum-scale=1, user-scalable=no" name="viewport" />

	<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
	<meta property="og:type" content="website" />
	<meta property="og:title" content="KORUSTEC" />
	<meta property="og:url" content="http://korustec.wayhome.kr/" />
	<meta property="og:description" content="한러과학기술협력센터" />
	<meta property="og:image" content="" />

	<link rel="stylesheet" type="text/css" href="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/css/common.css" />
	<link rel="stylesheet" type="text/css" href="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/font/noto/font.css" />
	<link rel="stylesheet" type="text/css" href="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/css/2000.css" />
	<link rel="stylesheet" type="text/css" href="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/css/1200.css" />
	<link rel="stylesheet" type="text/css" href="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/css/800.css" />
	<link rel="stylesheet" type="text/css" href="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/css/700.css" />
	<link rel="stylesheet" type="text/css" href="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/css/media.css" />
	<link rel="stylesheet" type="text/css" href="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/css/layout.css" />
	<link rel="stylesheet" type="text/css" href="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/css/jquery.ui.lastest.css" />

	<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

	<!--[if lte IE 8]>
	<script src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/js/html5shiv.min.js"></script>
	<script src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/js/respond.min.js"></script>
	<![endif]-->

	<script type="text/javascript" src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/js/jquery.lastest.js"></script>
	<script type="text/javascript" src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/js/jquery.ui.lastest.js"></script>
	<script type="text/javascript" src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/js/publisher.js"></script>
	<script type="text/javascript" src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/js/link.js"></script>
	<script type="text/javascript" src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/js/menu.js"></script>
	<script type="text/javascript" src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/js/TweenMax.min.js"></script>
	<script type="text/javascript" src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/js/jquery.bxslider.js"></script>
	<script type="text/javascript" src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/js/jquery.customSelect.js"></script>
	<script type="text/javascript" src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/js/jquery.dotdotdot.min.js"></script>


	<!--[if lt IE 9]>
	  <script src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/common/js/selectivizr-min.js"></script>
	<![endif]-->

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

</head>

<body>
	
<div id="wrap">

	<!--[s] header pc-->
	<div id="header" class="pc">
		<!--[s] utility -->
		<div id="topUtility">
			<div class="inConts">
				<ul>
					<li><a href="javascript:link0501();" onfocus="blur()">SITEMAP</a></li>
					<li><a href="/eng/" onfocus="blur()">ENG</a></li>
					<li><a href="/main/" onfocus="blur()">한글</a></li>
				</ul>
			</div>
		</div>
		<!--[e] utility -->
		<div class="inConts">
			<h1><a href="javascript:link0000();"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/logo.jpg" alt="KORUSTEC" /></a></h1>
			<div id="gnb">
				<p onclick="location.href='javascript:link0000();'">HOME</p>
				<ul class="gnb"><!-- Global Navigation Bar -->
					<li class="gnb01"><a href="javascript:link0101();">센터소개</a>
						<div class="gnbSub">
							<a href="/front/html/greet"><span>인사말</span></a>
							<a href="javascript:link0102();"><span>미션과 비전</span></a>
							<a href="javascript:link0103();"><span>센터 연혁</span></a>
							<a href="javascript:link0104();"><span>협력기관</span></a>
							<a href="javascript:link0105();"><span>연락처/오시는길</span></a>
						</div>
					</li>
					<li class="gnb02"><a href="javascript:link020101();">과학기술협력</a>
						<div class="gnbSub">
							<a href="javascript:link020101();"><span>러시아</span></a>
							<a href="javascript:link020201();"><span>기타국가</span></a>
							<a href="javascript:link0203();"><span>기술매칭</span></a>
						</div>
					</li>
					<li class="gnb03"><a href="javascript:link0301();">자료실</a>
						<div class="gnbSub" >
							<a href="javascript:link0301();"><span>자료실</span></a>
						</div>
					</li>
					<li class="gnb04"><a href="javascript:link0401();">News&Info</a>
						<div class="gnbSub">
							<a href="javascript:link0401();"><span>공지사항</span></a>
							<a href="javascript:link0402();"><span>세미나&행사</span></a>
							<a href="javascript:link0403();"><span>사진갤러리</span></a>
							<a href="javascript:link0404();"><span>뉴스레터 구독신청</span></a>
							<a href="javascript:link0405();"><span>채용정보</span></a>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<div class="bgGnb"></div>
	</div>
	<!--[e] header pc -->

	<!--[s] header mobile-->
	<div id="header" class="mobile">
		<h1><a href="javascript:link0000();"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/logo.jpg" alt="KORUSTEC" /></a></h1>
		<button type="button" class="btnMenu" title="메뉴"></button>
	</div>
	<!--[e] header mobile -->

	<script type="text/javascript">
	<!--
		$(function() {
			move1();
			move2();
			move3();
			slider = $('.visual').bxSlider({
				controls : false,
				pager: true,
				mode: 'fade',
				autoDelay: 6000,
				speed: 1000,
				auto: true,
				autoControls: true,
				autoControlsCombine:true,
				pager:true,
				autoControlsSelector: ".vControl .auto",
				pagerSelector:".vControl .pager"
			});
			auto();

			$('.prev').click(function(){
				auto();
				slider.goToPrevSlide();
				return false;
			});

			$('.next').click(function(){
				auto();
				slider.goToNextSlide();
				return false;
			});
		});

		/* 자동실행 */
		function auto() {
			slider.stopAuto();
			slider.startAuto();
		};

		/* 비쥬얼 리셋 */
		function page(current) {
			reset();
			var current = slider.getCurrentSlide();

			$('.thumbs a').removeClass('active');
			$('.thumbs a').eq(current).addClass('active');

			if(current == 0) {
				move1();
			} else if(current == 1) {
				move2();
			} else if(current == 2) {
				move3();
			} else if(current == 3) {
				move4();

			}
		}
		/* 애니메이션 리셋 */
		function reset() {
			$('#visual .visual li .txt1').css({'top' : '-300px'});
			$('#visual .visual li .txt2').css({'bottom' : '-300px'});
			<!--$('#visual .visual li .obj').css('right', '-1000px');-->
		}

		function move1() {
			$('.vs1 .txt1').animate({'top' : '238px'}, 1000,  'easeInOutExpo');
			$('.vs1 .txt2').animate({'bottom' : '242px'}, 1200,  'easeInOutExpo', function() {
			<!--	$('.vs1 .obj').animate({'right' : '200px'}, 2000,  'easeInOutExpo'); -->
			});
		}

		function move2() {
			$('.vs2 .txt1').animate({'top' : '238px'}, 1000,  'easeInOutExpo');
			$('.vs2 .txt2').animate({'bottom' : '242px'}, 1200,  'easeInOutExpo', function() {
				<!-- $('.vs2 .obj').animate({'right' : '200px'}, 2000,  'easeInOutExpo'); -->
			});
		}

		function move3() {
			$('.vs3 .txt1').animate({'top' : '238px'}, 1000,  'easeInOutExpo');
			$('.vs3 .txt2').animate({'bottom' : '242px'}, 1200,  'easeInOutExpo', function() {
				<!-- $('.vs3 .obj').animate({'right' : '200px'}, 2000,  'easeInOutExpo'); -->
			});
		}
	//-->
	</script>


	<!-- visual 시작 -->
	<div id="visual">
		<div class="visualBtn">
			<a href="#" class="btn prev"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/btn_prev.png" alt="이전" /></a>
			<a href="#" class="btn next"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/btn_next.png" alt="다음" /></a>
		</div>

		<div class="visualWrap">
			<ul class="visual">
				<?
				if($query_visual->num_rows() > 0){
					$_i=1;
					foreach($query_visual->result() as $row){
						$visual = null;
						if($row->file_visual){
							$f = explode('|',$row->file_visual);
							$visual = '/upload/visual/'.$f[0];
						}
				?>
				<li class="vs<?=$_i?>" onclick="location.href='<?=($row->link_url) ? $row->link_url : 'javascript:void(0);'?>'" style="background: url('<?=$visual?>') center 0 no-repeat !important;}">
					<p class="txt1"><?=$row->title?></p>
					<p class="txt2"><?=$row->title_sub?></p>
					<div class="mob_txt">
						<p class="mtxt1"><?=$row->title?></p>
						<p class="mtxt2"><?=$row->title_sub?></p>
					</div>
				</li>
				<?
					$_i++;
					}
				}
				?>
			</ul>
		</div>

		<div class="vControl">
			<!--p class="auto"></p-->
			<p class="pager"></p>
		</div>
	</div>
	<!-- visual 종료 -->

	<!-- main_con 시작 -->
	<div id="main_con">

		<div class="main_board">
			<div class="bd_wrap">
				<!--[s] 자료실 -->
				<div class="dataArea">
					<h2>자료실</h2>
					<p>reference library</p>
					<p class="btnConts">
						<a href="/front/board/list/id/2" onfocus="blur()"><img src="<?=$this->theme_path?>/images/plus.png" alt="더보기" /></a>
					</p>
					<div class="listConts">
						<ul>
							<?
							if($query_data->num_rows() > 0){
								foreach($query_data->result() as $row){
							?>
							<li>
								<a href='/front/board/view/id/<?=$row->menu_id?>/no/<?=$row->id?>' onfocus="blur()">
								<dl>
									<dt>· <?=$row->title?></dt>
									<dd><?=date('Y.m.d',strtotime($row->register_date))?></dd>
								</dl>
								</a>
							</li>
							<?
								}
							}
							?>
							
						</ul>
					</div>
				</div>
				<!--[e] 자료실 -->

				<!--[s] 기술매칭정보 -->
				<div class="techArea">
					<h2>기술매칭정보</h2>
					<p>skill information</p>
					<p class="btnConts">
						<a href="/front/html/match" onfocus="blur()"><img src="<?=$this->theme_path?>/images/plus.png" alt="더보기" /></a>
					</p>
					<div class="listConts">
						<ul>
							<?
							if($query_match->num_rows() > 0){
								foreach($query_match->result() as $row){
							?>
							<li>
								<a href='/front/html/match_view?seq=<?=$row->seq?>' onfocus="blur()">
								<dl>
									<dt>·  <?=($row->country) ? '['.$_country[$row->country].']' : null?><?=$row->title?></dt>
									<dd><?=date('Y.m.d',strtotime($row->reg_date))?></dd>
								</dl>
								</a>
							</li>
							<?
								}
							}
							?>
							
						</ul>
					</div>
				</div>
				<!--[e] 기술매칭정보 -->
			</div><!-- bd_wrap -->
		</div>
		<!-- main_board 종료 -->

		<!-- 통계자료 시작 -->
		<div class="main_stat">
			<div class="st_list">
				<h2>통계자료</h2>
				<p>statistical data</p>
				<ul>
					<?
					if($query_main->num_rows() > 0){
						foreach($query_main->result() as $row){
							$json = json_decode($row->content,true);
							$_i=1;
							foreach($json['title'] as $k => $v){
								echo '<li>
									<p class="num'.$_i.'">'.$json['stat'][$k].'</p>
									<p class="tt">'.$v.'</p>
								</li>';
								$_i++;
							}
						}
					}
					?>
				</ul>
			</div>
		</div>
		<!-- 통계자료 종료 -->

		<!-- 사진갤러리 시작 -->
		<div class="main_gallary">
			<div class="gal_list">
				<h2>사진 갤러리</h2>
				<p>photo gallery</p>
				<p class="btnConts">
					<a href="/front/board/list/id/4" onfocus="blur()"><img src="<?=$this->theme_path?>/images/plus.png" alt="더보기" /></a>
				</p>
				<ul>
					<?
					if($query_gal->num_rows() > 0){
						foreach($query_gal->result() as $row){
							$query = $this->board_model->board_file_list(array('menu_id'=>$row->menu_id,'board_no'=>$row->id));
							$photo = null;
							foreach ($query->result() as $frow){
								$fileinfo = pathinfo($frow->file_name);
								$ext = $fileinfo['extension'];
								if(preg_match('/[gif|jpe?g|png]/',$frow->file_name)){
									$thumb = $fileinfo['filename'].'_thumb.'.$fileinfo['extension'];
									if(file_exists($frow->file_path.$thumb)){
										$photo = '<img src="/upload/board/'.$frow->board_no.'/'.$thumb.'">';
									}else{
										$photo = '<img src="/upload/board/'.$frow->board_no.'/'.$frow->file_name.'">';
									}
								}
							break;
							}
					?>
					<li onclick="location.href='/front/board/view/id/<?=$row->menu_id?>/no/<?=$row->id?>'">
						<div class="img_box">
							<?=$photo?>
						</div>
						<div class="txt_box">
							<p class="txt"><?=$row->title?></p>
							<p class="date"><?=date('Y.m.d',strtotime($row->register_date))?></p>
						</div>
					</li>
					<?
						}
					}
					?>
				</ul>
			</div>
		</div>
		<!-- 사진갤러리 종료 -->



	</div>
	<!-- main_con 종료 -->

		<div id="foot_cp" >
		<!-- 협력기관 PC 시작 -->
		<div class="main_coop">
			<div class="business_list2_area">
				<div class="roll_con">
					<ul class="business_list2" >
						<li class="business_img1">
							<div class="cp_box">
								<a href="http://www.rscf.ru/" target="_blank"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/bt_logo_01.gif"></a>
							</div>
						</li>
						<li class="business_img1">
							<div class="cp_box">
								<a href="http://www.rfbr.ru/rffi/ru/" target="_blank"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/bt_logo_02.gif"></a>
							</div>
						</li>
						<li class="business_img1">
							<div class="cp_box">
								<a href="http://www.ras.ru/" target="_blank"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/bt_logo_03.gif"></a>
							</div>
						</li>
						<li class="business_img1">
							<div class="cp_box">
								<a href="http://www.msu.ru/" target="_blank"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/bt_logo_04.gif"></a>
							</div>
						</li>
						<li class="business_img1">
							<div class="cp_box">
								<a href="http://www.bmstu.ru/" target="_blank"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/about/cp_05.jpg" alt="" /></a>
							</div>
						</li>
						<li class="business_img1">
							<div class="cp_box">
								<a href="http://www.ssau.ru/" target="_blank"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/about/cp_06.jpg" alt="" /></a>
							</div>
						</li>
						<li class="business_img1">
							<div class="cp_box">
								<a href="https://www.mai.ru/" target="_blank"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/about/cp_07.jpg" alt="" /></a>
							</div>
						</li>
						<li class="business_img1">
							<div class="cp_box">
								<a href="http://www.kasp.or.kr/" target="_blank"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/about/cp_08.jpg" alt="" /></a>
							</div>
						</li>
						<li class="business_img1">
							<div class="cp_box">
								<a href="https://mephi.ru/" target="_blank"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/about/cp_09.jpg" alt="" /></a>
							</div>
						</li>
						<li class="business_img1">
							<div class="cp_box">
								<a href="http://www.nntu.ru/" target="_blank"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/about/cp_10.jpg" alt="" /></a>
							</div>
						</li>
						<li class="business_img1">
							<div class="cp_box">
								<a href="http://www.kstu.ru/" target="_blank"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/about/cp_11.jpg" alt="" /></a>
							</div>
						</li>
						<li class="business_img1">
							<div class="cp_box">
								<a href="http://www.bntu.by/" target="_blank"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/about/cp_12.jpg" alt="" /></a>
							</div>
						</li>
						<li class="business_img1">
							<div class="cp_box">
								<a href="http://www.kaznu.kz/ru" target="_blank"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/about/cp_13.jpg" alt="" /></a>
							</div>
						</li>
						<li class="business_img1">
							<div class="cp_box">
								<a href="https://sk.ru/technopark/" target="_blank"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/about/cp_14.jpg" alt="" /></a>
							</div>
						</li>
						<li class="business_img1">
							<div class="cp_box">
								<a href="http://www.technopark-slava.ru/" target="_blank"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/about/cp_15.jpg" alt="" /></a>
							</div>
						</li>
						<li class="business_img1">
							<div class="cp_box">
								<a href="http://www.aksts.ru/" target="_blank"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/about/cp_16.jpg" alt="" /></a>
							</div>
						</li>
					</ul><!-- end : class : business_list -->
				</div>
				<div class="roll_control">
					<p class="coop_tt">협력기관</p>
					<p class="auto"><div class="bx-controls-auto"><div class="bx-controls-auto-item"><a class="bx-stop" href=""></a></div></div></p>
					<ul class="btns2">
						<li class="prev2"><a href="#self"><span class="hide">이전</span></a></li>
						<li class="next2"><a href="#self"><span class="hide">다음</span></a></li>
					</ul>
				</div>
				<div class="vControl2"></div>
			</div><!-- end : class : business_list_area -->

			 <script language="javascript" type="text/javascript">
			//<![CDATA[
				var slideObject;
					$(function(){
						slideObject=$('.business_list2').bxSlider({
							speed:500,
							pager:false,
							moveSlides:1,
							slideWidth:258,
							minSlides:1,
							maxSlides:4,
							slideMargin:0,
							autoHover:false,
							auto: true,
							autoControls: true,
							autoControlsCombine:true,
							speed: 700,
							pause: 5000,
							controls : true,
							pager:false,
							autoControlsSelector: ".auto",
							nextSelector:".vControl2>.inConts",
							prevSelector:".vControl2>.inConts",
							useCSS: false,
							onSliderLoad: function(currentIndex){
								$(".vControl2>.inConts>.txt>span").text((currentIndex+1))
							},
							onSlideAfter: function($slideElement, oldIndex, newIndex){
								$(".vControl2>.inConts>.txt>span").text((newIndex+1))
							}

						});

					$(".prev2").on("click",function(e){
						slideObject.goToPrevSlide();
						e.preventDefault();
					})

					$(".next2").on("click",function(e){
						slideObject.goToNextSlide();
						e.preventDefault();
					})
				});
			//]]>
			</script>
		</div>
		<!-- 협력기관 PC 종료 -->

		<!-- 협력기관 모바일 시작 -->
		<div class="main_coop_m">
			<a href="javascript:link0104();">협력기관 바로가기 <img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/coop_ar.gif"></a>
		</div>
		<!-- 협력기관 모바일 종료 -->
	</div>

	<div id="footer_wp">

		<div class="foot_con">
			<div class="flogo"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/foot_logo.gif" alt="KORUSTEC" /></div>
			<div class="ftxt">
				모스크바 117246, Office 35, Nauchniy proezd 17, Moscow, Russia<br />
				전화 : +7-495-783-7120/1 <span>ㅣ</span> E-mail : korustec@gmail.com (한국어, 영어), kicosmos@mail.ru (러시아어)
			</div>
			<div class="flogo_m"><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/foot_logo.gif" alt="KORUSTEC" /></div>
			<div class="family">
				<img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/family_01.gif" alt="미래창조과학부" />
				<img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/family_02.gif" alt="한국연구재단" />
			</div>
		</div><!-- foot_con -->

	</div><!-- footer_wp -->
</div><!-- wrap -->

<!--[s] menuArea -->
<div id="menuArea">
	<div class="menuList">
		<div class="tit">
			<img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/mobile/img_menu_logo.gif" alt="KORUSTEC" />
			<button type="button" class="btnMenuClose" title="메뉴닫기"></button>
		</div>
		<div class="mnation">
			<ul>
				<li onclick="location.href='/index.html'">
					<p><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/mobile/kor.gif" alt="korean" /></p>
					<p>KOR</p>
				</li>
				<li onclick="location.href='/eng/index.html'">
					<p><img src="/theme/<?=$this->config->item('theme')?>/<?=$_language?><?=$_folder?>/images/mobile/eng.gif" alt="english" /></p>
					<p>ENG</p>
				</li>
			</ul>
		</div>
		<ul class="list">
			<li class="icon01">
				<a href="javascript:void(0);">센터소개<span class="icon"></span></a>
				<ul class="sMenu">
					<li><a href="javascript:link0101();">인사말</a></li>
					<li><a href="javascript:link0102();">미션과 비전</a></li>
					<li><a href="javascript:link0103();">센터연혁</a></li>
					<li><a href="javascript:link0104();">협력기관</a></li>
					<li><a href="javascript:link0104();">연락처/오시는길</a></li>
				</ul>
			</li>
			<li class="icon02">
				<a href="javascript:void(0);">과학기술협력<span class="icon"></span></a>
				<ul class="sMenu">
					<li><a href="javascript:link0201();">러시아</a></li>
					<li><a href="javascript:link0202();">기타국가</a></li>
					<li><a href="javascript:link0203();">기술매칭</a></li>
				</ul>
			</li>
			<li class="icon03">
				<a href="javascript:void(0);">자료실<span class="icon"></span></a>
				<ul class="sMenu">
					<li><a href="javascript:link0301();">자료실</a></li>
				</ul>
			</li>
			<li class="icon04">
				<a href="javascript:void(0);">News & Info<span class="icon"></span></a>
				<ul class="sMenu">
					<li><a href="javascript:link0401();">공지사항</a></li>
					<li><a href="javascript:link0402();">세미나&행사</a></li>
					<li><a href="javascript:link0403();">사진갤러리</a></li>
					<li><a href="javascript:link0404();">뉴스레터 구독신청</a></li>
					<li><a href="javascript:link0405();">채용정보</a></li>
				</ul>
			</li>

		</ul>

	</div>
</div>
<!--[e] menuArea -->


<!--[s] Layer -->
<div id="layerArea">
	<div class="layerIn">
		<div class="layerCell"><!-- ajax Layer --></div>
	</div>
</div>
<!--[e] Layer -->

<iframe name="ifrm_proc" id="ifrm_proc" style="display:none"></iframe>
</body>
</html>

