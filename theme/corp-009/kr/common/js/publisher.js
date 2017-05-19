var scrollTop,			// 스크롤 높이
	 gnbTop,				// GNB Top
	 lnbTop,				// LNB Top

	 win_w,				// 윈도우 넓이 - 메인
	 win_h,				// 윈도우 높이 - 메인

	 lyNums = 0,			// 레이어에 사용
	 lyOne = 0;			// 레이어에 사용

var pgCode, depth_1, depth_2, depth_3, depth_4;

$(function(){
	if($("html").hasClass("layerIns")){
		$.ajax({
			type : "GET" //"POST", "GET"
			, url : "../addLayer.html" //Request URL
			, error : function(request, status, error) {
			 //통신 에러 발생시 처리
			 alert("code : " + request.status + "\r\nmessage : " + request.reponseText);
			}
			, success : function(data, status, request) {
				//통신 성공시
				$(".layerCell").append(data);
				//alert(response+", "+status+", "+request)
				//$(".layerCell")
			}
			, beforeSend: function() {
				$(".layerCell").html("")
			}
			, complete: function() {
				//$(".small>a").eq(0).click();
			}
		});
	}

	/*if($("html").hasClass("sub")){
		menuTop = $(".sub #container #snb").offset().top;
		scrollTop = $(window).scrollTop();
		scrollE(scrollTop);
	}*/
});


$(window).load(function(){
	// 오픈시 지워야함
	$("body").append('<p class="testText"></p>');

	// select box 디자인
	selectDesign();

	// Gnb on
	$("body").on("mouseenter", ".gnb>li", function(){
		var idx = $(".gnb>li").index($(this));

		if($("html").hasClass("main")){
			$("#header .bgGnb").slideDown(200);

		}else{
			$("#header .bgGnb").slideDown(200);
		}
		$(".gnb>li").each(function(index){
			if(idx == index){
				$(this).addClass("active");
				$(".gnbSub").eq(index).stop().slideDown(200);
			}else{
				$(this).removeClass("active");
				$(".gnbSub").eq(index).stop().slideUp(200);
			}
		});
	});
	// Gnb off
	$("body").on("mouseleave", ".gnb", function(){
		$(".gnb>li").each(function(index){
			$(this).removeClass("active");
			if($(this).hasClass("openPage")){
				$(this).find(".gnbSub").stop().slideDown(200);
			}else{
				$(this).find(".gnbSub").stop().slideUp(200);
			}
		});
		if($("html").hasClass("main")){
			$("#header .bgGnb").slideUp(200);
		}else{
			$("#header .bgGnb").slideUp(200);
		}
	});


	// Lnb on
	$("body").on("mouseenter", "#snb>.nav>li>a", function(){
		var idx = $("#snb>.nav>li>a").index($(this));
		$("#snb>.nav>li").each(function(index){
			if(idx == index){
				if(!$(this).hasClass("openPage")){
					$(this).addClass("active");
					$(this).find(".subLnb3").stop().slideDown(200);
				}
			}else{
				if(!$(this).hasClass("openPage")){
					$(this).removeClass("active");
					$(this).find(".subLnb3").stop().slideUp(200);
				}
			}
		});
	});
	// Lnb off
	$("body").on("mouseleave", "#snb>.nav", function(){
		$("#snb>.nav>li").each(function(index){
			if(!$(this).hasClass("openPage")){
				$(this).removeClass("active");
				$(this).find(".subLnb3").stop().slideUp(300);
			}
		});
	});


	// Go Top
	/*$("body").on("click", "#footer .goTop>a", function(){
		$('html, body').animate({scrollTop: $("html").offset().top}, 1000, "easeOutExpo");
	});

	if($("html").hasClass("sub")){
		//스크롤 이벤트
		$(window).on("scroll", function(){
			scrollTop = $(window).scrollTop();
			scrollE(scrollTop);
		});
	}*/
});

$(window).load(function(){
	// 오픈시 지워야함
	$("body").append('<p class="testText"></p>');

	// 왼쪽메뉴열기
	$("body").on("click ", "#header .btnMenu", function(){
		winH = $(window).height();
		$("#menuArea").fadeIn(300);
		TweenLite.to($("#wrap"), 0.3, {height:winH, "position":"relative"});
		TweenLite.to($("#wrap .aIn"), 0.3, {left:-528, "position":"absolute", delay:0.3});
		TweenLite.to($("#menuArea .menuList"), 0.3, {right:0, delay:0.3});
		$("#wrap").bind('touchmove', function(e){e.preventDefault()});

	});

	// 왼쪽메뉴닫기
	$("body").on("click ", "#menuArea .btnMenuClose", function(){
		$("#menuArea").delay(300).fadeOut(300);
		TweenLite.to($("#wrap"), 0.3, {height:"auto", "position":"relative"});
		TweenLite.to($("#wrap .aIn"), 0.3, {left:0, "position":"relative"});
		TweenLite.to($("#menuArea .menuList"), 0.3, {right:-528});
		 $("#wrap").unbind('touchmove');
	});

	// 왼쪽 하위 메뉴
	$("body").on("click ", "#menuArea .menuList>.list>li", function(){
		var idx = $("#menuArea .menuList>.list>li").index($(this));
		$("#menuArea .menuList>.list>li").each(function(index){
			if(idx == index){
				if(!$(this).hasClass("active")){
					$(this).addClass("active");
					$(this).find(".sMenu").slideDown(300);
				}else{
					$(this).removeClass("active");
					$(this).find(".sMenu").slideUp(300);
				}
			}else{
				$(this).removeClass("active");
				$(this).find(".sMenu").slideUp(300);
			}
		});
	});

	//서브 페이지 메뉴
	$("body").on("click ", "#snb_m .sMenu", function(){
		var idx = $("#snb_m .sMenu").index($(this));
		$("#snb_m .sMenu").each(function(index){
			if(idx == index){
				if(!$(this).hasClass("active")){
					$(this).addClass("active");
					$(this).find(".lnbSub").stop().slideDown(300);
				}else{
					$(this).removeClass("active");
					$(this).find(".lnbSub").stop().slideUp(300);
				}
			}else{
				$(this).removeClass("active");
				$(this).find(".lnbSub").stop().slideUp(300);
			}
		});
	});

	/*if(pgCode != undefined){
		pNTop = $("#snb_m").offset().top;
		scrollTop = $(window).scrollTop();
		pnSH(scrollTop)

		$(window).on("scroll",function(){
			scrollTop = $(window).scrollTop();
			pnSH(scrollTop)
		});
	}*/
});



/*function scrollE(sTop){
	winH = $(window).height();

	if(menuTop < sTop){
		TweenLite.to([".sub #container #snb"], 0, {top: sTop-66, ease:Linear.easeNone});
	}else{
		TweenLite.to([".sub #container #snb"], 0, {top: 66, ease:Linear.easeNone});
	}
}*/
// select box 디자인
function selectDesign(){
	$(".selectType:not('.lay')").each(function(index){
		if(!$(this).hasClass("on")){
			$(this).addClass("on");
			$(this).find("select.selectCus").customSelect({customClass:"selType"});
		}
	});
}
// 레이어 열기
var layOne = true;
function openLay(name){
	if(layOne == true){
		lyNums++;
		$(".layerBox").each(function(index){
			if($(this).hasClass(name)){
				layOne = false;
				$(this).layerScript({divs : name});
			}
		});

		// 레이어 스크롤
		$("body").on("scroll", "#layerArea", function(e){
			var siteTop = $("#layerBg").scrollTop();
			if(siteTop > 30){
				$(".layerArea .title").addClass("fixed");
			}else{
				$(".layerArea .title").removeClass("fixed");
			}
		});
	}
}
// 레이어 닫기
function layerClose(name){
	$(".layerBox").each(function(index){
		if($(this).hasClass(name)){
			var e = $(this);

			e.hide().attr("style","");
			$(".layerBgIn").remove();
			$(".layerBox").eq(0).show();

			lyNums --;
			if(lyNums == 0){
				$("html").css("overflow-y","auto");
				$("body").removeClass("lyOn");
				$("#layerBg").remove();
				$("#layerArea").removeClass("ons");
				$(".layerBox").hide();
			}

			if(name == "mapLay"){
				//$(".mapLay .mapCont").attr("id", "");
				$(".mapLay .mapCont>div").detach();
				$(".mapLay .juso>p").text("");
				$(".mapLay .tel>p").text("");
			}
		}
	});
}

// Plugin Script
jQuery(function($){
	//[s] Tab Script
	$.fn.tabScript = function(o){
		o = $.extend({
			btns : '',
			conts : '',
			classd: ''
		}, o || {});

		var e = $(this),
			  e_btn = e.find(o.btns),
			  e_cont = e.find(o.conts);

		// 초기화
		e_btn.eq(0).addClass(o.classd);
		e_cont.eq(0).show();

		// 클릭 이벤트
		e.on("click", o.btns, function(){
			e_btn.removeClass(o.classd);
			if(!e.hasClass("noScript")){
				e_cont.hide();
			}

			var idx = e_btn.index($(this));
			e_btn.each(function(index){
				if(idx == index){
					$(this).addClass(o.classd);
					if(!e.hasClass("noScript")){
						e_cont.eq(index).show();
					}
				}
			});
		});
	}
	//[e] Tab Script

	//[s] Layer Script
	$.fn.layerScript = function(o){
		o = $.extend({
			divs : ''
		}, o || {});

		var e = $(this),
			  bg = $('<div id="layerBg"></div>'),
			  bgIn = $('<div class="layerBgIn"></div>'),
			  ly_w,
			  ly_h,
			  closeDiv = o.divs;

		//tab
		if(e.hasClass("tab")){
			// 플러그인 텝 메뉴
			$(".tabArea.ly").tabScript({
				btns : '.btnTab>a',
				conts : '.tabConts',
				classd: 'active',
				nums: '0'
			});
		}

		$("body").attr("lyNums", lyNums);
		// 열기
		if(!$("body").hasClass("lyOn")){
			$("html").css("overflow-y","hidden");
			$("body").addClass("lyOn");
			$("#layerArea").addClass("ons");
			bg.prependTo($("body"));
		}

		e.show();
		layOne = true;

		if(lyNums == 2){
			bgIn.prependTo($("#layerArea .layerIn"));
			$(".layerBox").eq(0).hide();
			e.css("z-index",13);
		}

		// select box 디자인
		e.find(".selectType.lay").each(function(index){
			if(!$(this).hasClass("on")){
				$(this).addClass("on");
				$(this).find("select.selectCus").customSelect({customClass:"selType"});
			}
		});

		// 닫기
		$(this).find(".tit>.closeLy").off("click");
		$(this).find(".tit>.closeLy").on('click', function(){
			layerClose(closeDiv);
		});
	}
	//[e] Layer Script

	//[s] Img Over Script
	$.fn.iOverScript = function(o){
		o = $.extend({
			btns : '',
			bg : '',
			speed : 700
		}, o || {});

		var e = $(this);

		// 활성화
		e.on("mouseenter", o.btns, function(event){
			var idx = $(o.btns).index($(this));
			point_ray("on", idx, event);
		});
		// 비활성화
		e.on("mouseleave", o.btns, function(event){
			var idx = $(o.btns).index($(this));
			point_ray("off", idx, event);
		});

		function point_ray(directions, nums, event){
			e.find(o.btns).each(function(index){
				if(nums == index){
					w = $(this).width();
					h = $(this).height();
					x = ( event.pageX - $(this).offset().left - ( w/2 )) * ( w > h ? ( h/w ) : 1 ),
					y = ( event.pageY - $(this).offset().top  - ( h/2 )) * ( h > w ? ( w/h ) : 1 ),
					direction = Math.round( ( ( ( Math.atan2(y, x) * (180 / Math.PI) ) + 180 ) / 90 ) + 3 )  % 4;

					if(directions == "on"){
						$(this).find(o.bg).show();
						if(direction == 0) {
							$(this).find(o.bg).css({"top":-h, "left":0});
						} else if(direction == 1) {
							$(this).find(o.bg).css({"top":0, "left":w});
						} else if(direction == 2) {
							$(this).find(o.bg).css({"top":h, "left":0});
						} else {
							$(this).find(o.bg).css({"top":0, "left":-w});
						}
						$(this).find(o.bg).stop().animate({top:0, left:0}, o.speed, "easeOutExpo");
					}else if(directions == "off"){
						if(direction == 0) {
							$(this).find(o.bg).stop().animate({top:-h, left:0}, o.speed, "easeOutExpo", function(){$(this).parent().find(o.bg).hide();});
						} else if(direction == 1) {
							$(this).find(o.bg).stop().animate({top:0, left:w}, o.speed, "easeOutExpo", function(){$(this).parent().find(o.bg).hide();});
						} else if(direction == 2) {
							$(this).find(o.bg).stop().animate({top:h, left:0}, o.speed, "easeOutExpo", function(){$(this).parent().find(o.bg).hide();});
						} else {
							$(this).find(o.bg).stop().animate({top:0, left:-w}, o.speed, "easeOutExpo", function(){$(this).parent().find(o.bg).hide();});
						}
					}
				}
			});
		}
	}
	//[e] Img Over Script

	//[s] Img Curtain Script
	$.fn.curtainScript = function(o){
		o = $.extend({
			direction : 'x'
		}, o || {});

		var e = $(this),
			  $sliceContainer = e.find(".img"),
			  $containerWidth = $sliceContainer.width(),
			  $containerHeight = $sliceContainer.height(),
			  $defaultTop = 0,
			  $defaultLeft = 0,
			  $defaultLeftMove = $containerWidth / 2,
			  $defaultTopMove = $containerHeight / 2,
			  $numOfSlices = 2,
			  $img,
			  e_direction = o.direction;

		$('img', $sliceContainer).css('display', 'none');

		if(o.direction == "x"){
			// 좌우 갈라지기
			for(var $i=0;$i<$numOfSlices;$i++){
				$img = $sliceContainer.find('img').attr('src');

				var $html = "";

				$html += "<div class='img_"+$i+"' style='width:"+($containerWidth / $numOfSlices)+"px;height:"+$containerHeight+"px;left:"+($containerWidth / $numOfSlices * $i)+"px;position:absolute;overflow:hidden;'>";
				$html += "<img style='position:absolute;"+($i % 2 != 0 ? "left:-"+$defaultLeftMove+"px;": "")+"' src='"+$img+"' alt='' />";
				$html += "</div>";

				$($html).appendTo($sliceContainer);
			}
		}else{
			// 위 아래 갈라지기
			for(var $i=0;$i<$numOfSlices;$i++){
				$img = $sliceContainer.find('img').attr('src');

				var $html = "";

				$html += "<div class='img_"+$i+"' style='width:"+$containerWidth +"px;height:"+($containerHeight / $numOfSlices)+"px;top:"+($containerHeight / $numOfSlices * $i)+"px;position:absolute;overflow:hidden;'>";
				$html += "<img style='position:absolute;"+($i % 2 != 0 ? "top:-"+$defaultTopMove+"px;": "")+"' src='"+$img+"' alt='' />";
				$html += "</div>";

				$($html).appendTo($sliceContainer);
			}
		}

		// 활성화
		e.on("mouseenter", $sliceContainer, function(){
			point_ray("on");
		});
		// 비활성화
		e.on("mouseleave", $sliceContainer, function(){
			point_ray("off");
		});

		function point_ray(directions){
			if(directions == "on"){
				if(o.direction == "x"){
					// 좌우 갈라지기
					for($j=0;$j<$numOfSlices;$j++){
						if($j % 2 != 0){
							e.find($('.img_'+$j)).stop().animate({left: "+"+$containerWidth}, 700, "easeOutExpo");
						}else{
							e.find($('.img_'+$j)).stop().animate({left: "-"+$defaultLeftMove}, 700, "easeOutExpo");
						}
					}
				}else{
					//alert(e_move+", "+$containerHeight+", "+$defaultTopMove)
					// 위 아래 갈라지기
					for($j=0;$j<$numOfSlices;$j++){
						if($j % 2 != 0){
							e.find($('.img_'+$j)).stop().animate({top: "+"+$containerHeight}, 700, "easeOutExpo");
						}else{
							e.find($('.img_'+$j)).stop().animate({top: "-"+$defaultTopMove}, 700, "easeOutExpo");
						}
					}
				}
			}else if(directions == "off"){
				if(o.direction == "x"){
					// 좌우 갈라지기
					for($j=0;$j<$numOfSlices;$j++){
						if($j % 2 != 0){
							e.find($('.img_'+$j)).stop().animate({left: "+"+$defaultLeftMove}, 700, "easeOutExpo");
						}else{
							e.find($('.img_'+$j)).stop().animate({left: 0}, 700, "easeOutExpo");
						}
					}
				}else{
					// 위 아래 갈라지기
					for($j=0;$j<$numOfSlices;$j++){
						if($j % 2 != 0){
							e.find($('.img_'+$j)).stop().animate({top: "+"+$defaultTopMove}, 700, "easeOutExpo");
						}else{
							e.find($('.img_'+$j)).stop().animate({top: 0}, 700, "easeOutExpo");
						}
					}
				}
			}
		}
	}
	//[e] Img Curtain Script

	//[s] Notice Rollring Script
	$.fn.noticeOneScript = function(o){
		o = $.extend({
			btnAll : "",
			btnUp : "",
			btnDown : "",
			auto : true,
			btnStop : "btn_roll_stop",
			btnPlay : "btn_roll_play",
			move : "",
			delay : "5000",
			speed : "300"
		}, o || {});

		var nArr, nAuto, ntNum, timers,
			  e = $(this),
			  e_area = e.find(">ul"),
			  e_list = e.find(">ul>li"),
			  e_all = $(o.btnAll),
			  e_up = o.btnUp,
			  e_down = o.btnDown,
			  e_auto = o.auto,
			  e_stop = o.btnStop,
			  e_play = o.btnPlay,
			  e_move = o.move,
			  e_delay = o.delay,
			  e_speed = o.speed;

		// 공지
		ntNum = Number(e_list.length);
		if(ntNum > 1){
			// 원할한 동작을 위한 클론 생성
			for(i=0; i<ntNum; i++) {
				if(i == (ntNum-1)){
					e_list.eq(i).clone().prependTo(e_area).attr("number", "num"+i);
				}else{
					e_list.eq(i).clone().appendTo(e_area).attr("number", "num"+i);
				}
			}

			// 클릭 이벤트
			e_all.off("click");
			e_all.on('click', function(){
				if($(this).hasClass(e_down)){
					nArr = "d";
					nAuto = "p";
					$(this).siblings("."+e_play).removeClass(e_play).addClass(e_stop).html("정지");
				}else if($(this).hasClass(e_up)){
					nArr = "u";
					nAuto = "p";
					$(this).siblings("."+e_play).removeClass(e_play).addClass(e_stop).html("정지");
				}else if($(this).hasClass(e_stop)){
					nAuto = "s";
					$(this).removeClass(e_stop).addClass(e_play).html("시작");
					clearInterval(timers);
				}else{
					nAuto = "p";
					$(this).removeClass(e_play).addClass(e_stop).html("정지");
				}

				if(nAuto != "s"){
					noTice(nArr);
					clearInterval(timers);
					timers = setInterval(function(){noTice(nArr)}, e_delay);
				}
			});

			// 자동 롤링
			if(e_auto){
				timers = setInterval(function(){noTice('u')}, e_delay);
			}
		}else{
			e_area.css("top",0);
			e_all.hasClass(e_stop).hide();
		}

		// 공지 롤링
		function noTice(arr){
			if(arr == "d"){
				e.find(">ul>li").first().stop().animate({"margin-top": e_move}, e_speed, function(){
					e.find(">ul>li").last().prependTo(e_area).attr("style","");
					$(this).first().attr("style","");
				});
			}else{
				e.find(">ul>li").first().stop().animate({"margin-top": "-"+e_move}, e_speed, function(){
					$(this).appendTo(e_area).attr("style","");
				});
			}
		}
	}
	//[e] Notice Rollring Script
});

