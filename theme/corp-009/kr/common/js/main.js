$(window).load(function(){
	vImg1_st1();
	start_motion();
	recruit_main_Motion();

	function start_motion(){
		$("#visualTxt .txt1").stop().delay(1300).animate({"left": "45px"}, 1000, "easeOutExpo");
		$("#visualTxt .txt2").stop().delay(1450).animate({"left": "45px"}, 1000, "easeOutExpo");
		$("#visualTxt .txt3").stop().delay(1600).animate({"left": "45px"}, 1000, "easeOutExpo");
		$("#visualTxt .txt4").stop().delay(1750).animate({"left": "45px"}, 1000, "easeOutExpo");
		$("#visualTxt .txt5").stop().delay(3800).animate({"left": "45px"}, 1000, "easeOutExpo");
		$("#visualTxt .txt6").stop().delay(3950).animate({"left": "45px"}, 1000, "easeOutExpo");
		$("#visualTxt .txt7").stop().delay(4100).animate({"left": "45px"}, 1000, "easeOutExpo");

		$("#visualConts").stop().delay(600).animate({"opacity": "1"}, 2400, "easeOutExpo");
		$("#visualConts .bg0201").stop().delay(500).animate({"width": "100%"}, 2000, "easeOutExpo");
		$("#visualConts .bg0202").stop().delay(600).animate({"width": "100%"}, 2000, "easeOutExpo");
		$("#visualConts .bg0203").stop().delay(1900).animate({"width": "100%"}, 1500, "easeOutExpo");



	};
	function vImg1_st1(){
		$("#visual01").stop().animate({"opacity": "1"}, 1500, "easeOutExpo");
		$("#visual01 .bg03").stop().delay(1700).animate({"opacity": "1"}, 1700, "easeOutExpo", function(){
			setTimeout(function(){
				vImg1_ed();
				vImg2_st();
			}, 2000);
		});
		$("#visual01 .bg04").stop().delay(4500).animate({"height": "526px"}, 3500, "easeOutExpo");
	};
	// 1번 시작하는 모션
	function vImg1_st(){
		$("#visual01").stop().animate({"opacity": "1"}, 2500, "easeOutExpo");
		$("#visual01 .bg03").stop().animate({"opacity": "1"}, 3000, "easeOutExpo", function(){
			setTimeout(function(){
				vImg1_ed();
				vImg2_st();
			}, 2000);
		});
		$("#visual01 .bg04").stop().delay(2500).animate({"height": "526px"}, 3500, "easeOutExpo");
	};
	// 1번 종료하는 모션
	function vImg1_ed(){
		$("#visual01").stop().animate({"opacity": "0"}, 3500, "easeOutExpo");
		$("#visual01 .bg03").stop().animate({"opacity": "0"}, 3500, "easeOutExpo");
		$("#visual01 .bg04").stop().animate({"height": "0px"}, 3500, "easeOutExpo");
	};

	// 2번 시작하는 모션
	function vImg2_st(){
		$("#visual02").stop().animate({"opacity": "1"}, 2500, "easeOutExpo");
		$("#visual02 .bg03").stop().animate({"opacity": "1"}, 3000, "easeOutExpo", function(){
			setTimeout(function(){
				vImg2_ed();
				vImg3_st();
			}, 2000);
		});
		$("#visual02 .bg04").stop().delay(2500).animate({"height": "526px"}, 3500, "easeOutExpo");
	};
	// 2번 종료하는 모션
	function vImg2_ed(){
		$("#visual02").stop().animate({"opacity": "0"}, 3500, "easeOutExpo");
		$("#visual02 .bg03").stop().animate({"opacity": "0"}, 3500, "easeOutExpo");
		$("#visual02 .bg04").stop().animate({"height": "0px"}, 3500, "easeOutExpo");
	};

	// 3번 시작하는 모션
	function vImg3_st(){
		$("#visual03").stop().animate({"opacity": "1"}, 2500, "easeOutExpo");
		$("#visual03 .bg03").stop().animate({"opacity": "1"}, 3000, "easeOutExpo", function(){
			setTimeout(function(){
				vImg3_ed();
				vImg4_st();
			}, 2000);
		});
		$("#visual03 .bg04").stop().delay(2500).animate({"height": "526px"}, 3500, "easeOutExpo");
	};
	// 3번 종료하는 모션
	function vImg3_ed(){
		$("#visual03").stop().animate({"opacity": "0"}, 3500, "easeOutExpo");
		$("#visual03 .bg03").stop().animate({"opacity": "0"}, 3500, "easeOutExpo");
		$("#visual03 .bg04").stop().animate({"height": "0px"}, 3500, "easeOutExpo");
	};

	// 4번 시작하는 모션
	function vImg4_st(){
		$("#visual04").stop().animate({"opacity": "1"}, 2500, "easeOutExpo");
		$("#visual04 .bg03").stop().animate({"opacity": "1"}, 3000, "easeOutExpo", function(){
			setTimeout(function(){
				vImg4_ed();
				vImg1_st();
			}, 2000);
		});
		$("#visual04 .bg04").stop().delay(2500).animate({"height": "526px"}, 3500, "easeOutExpo");
	};
	// 4번 종료하는 모션
	function vImg4_ed(){
		$("#visual04").stop().animate({"opacity": "0"}, 3500, "easeOutExpo");
		$("#visual04 .bg03").stop().animate({"opacity": "0"}, 3500, "easeOutExpo");
		$("#visual04 .bg04").stop().animate({"height": "0px"}, 3500, "easeOutExpo");
	};


	function recruit_main_Motion(){
		$("#recruitMain .txt").each(function(index){
			var de = 200 * index;
			$(this).delay(de).show().animate({left: '42px'}, 1500, "easeOutExpo");
		});
		$("#recruitMain .img").each(function(index){
			var de = 300 * index;
			$(this).delay(de).fadeIn(1000);
		});
	};
});