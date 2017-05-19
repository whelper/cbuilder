var menu = [
	 ["01","센터소개","javascript:link0101();", "정보생산의 선두주자","<span class='tt'>체계적이고</span> 수준 높은 러시아 기술"]
		,["0101","인사말","javascript:link0101();"]
		,["0102","미션과 비전","javascript:link0102();"]
		,["0103","센터 연혁","javascript:link0103();"]
		,["0104","협력기관","javascript:link0104();"]
		,["0105","연락처/오시는길","javascript:link0105();"]

	,["02","과학기술협력","javascript:link0201();","정보생산의 선두주자","<span class='tt'>체계적이고</span> 수준 높은 러시아 기술"]
		,["0201","러시아","javascript:link0201();"]
			,["020101","과학기술 협력현황","javascript:link020101();"]
			,["020102","공동연구/인력교류 사업","javascript:link020102();"]
			,["020103","과학기술 동향뉴스","javascript:link020103();"]
		,["0202","기타국가","javascript:link0202();"]
			,["020201","과학기술 협력현황","javascript:link020201();"]
			,["020202","공동연구/인력교류 사업","javascript:link020202();"]
			,["020203","과학기술 동향뉴스","javascript:link020203();"]
		,["0203","기술매칭","javascript:link0203();"]

	,["03","자료실","javascript:link0301();","정보생산의 선두주자","<span class='tt'>체계적이고</span> 수준 높은 러시아 기술"]
		,["0301","자료실","javascript:link0301();"]

	,["04","News&Info","javascript:link0401();","정보생산의 선두주자","<span class='tt'>체계적이고</span> 수준 높은 러시아 기술"]
		,["0401","공지사항","javascript:link0401();"]
		,["0402","세미나&행사","javascript:link0402();"]
		,["0403","사진갤러리","javascript:link0403();"]
		,["0404","뉴스레터 구독신청","javascript:link0404();"]
		,["0405","채용정보","javascript:link0405();"]

	,["05","이용안내","javascript:link0501();","정보생산의 선두주자","<span class='tt'>체계적이고</span> 수준 높은 러시아 기술"]
		,["0501","사이트맵","javascript:link0501();"]

];

//@Left 메뉴셋팅
function leftMenuManager(pcd){
	if(!pcd)return;
	var  strM3dpth = '';
	for(var i=0; i < menu.length; i++){

		if(strM3dpth && menu[i][0].length < 6){
			document.write('<div class="subMenu">'+strM3dpth+'</div></li>');
			strM3dpth = '';
		}

		if(menu[i][0].substr(0,2) == pcd.substr(0,2)){
			if(menu[i][0].length==4){
				mCss="";
				if(menu[i][0] == pcd.substr(0,menu[i][0].length)) mCss='_on';
				var opens = (mCss) ? "active" : ""; //@ Left 현재 메뉴 고정
				document.write('<li class="'+opens+'"><a href="'+menu[i][2]+'">' + menu[i][1] + '</a>');
			}else if(menu[i][0].length==6){
				mCss='';
				if(menu[i][0] == pcd) mCss='_on';
				var over = (!mCss) ? "" : "active"; //@ Left 현재 메뉴 고정
				strM3dpth += '<a href="'+menu[i][2]+'" class="'+over+'">' + menu[i][1] + '</a>';
			}
		}

		if(strM3dpth && (i==menu.length-1)){
			document.write('<div class="subMenu">'+strM3dpth+'</div></li>');
			strM3dpth = '';
		}
	}
}


//@Left 메뉴셋팅(모바일)
function leftMenuManager2(pcd){
	if(!pcd)return;
	var strMainOn = '';
	var strMainOff = '';
	var strSubOn = '';
	var strSubOff = '';
	var str3dpthOn = '';
	var str3dpthOff = '';
	var str4dpthOn = '';
	var str4dpthOff = '';
	for(var i=0; i < menu.length; i++){
		// 원뎁스
		if(menu[i][0].length==2){
			mCss="";
			if(menu[i][0] == pcd.substr(0,menu[i][0].length)) mCss='_on';
			var opens = (mCss) ? "active" : ""; //@ Left 현재 메뉴 고정

			if(menu[i][0] == pcd.substr(0,menu[i][0].length)){
				strMainOn = '<li class="sMenu sDepth01"><a href="javascript:void(0);">' + menu[i][1] + '</a><div class="lnbSub">';
			}

			if(menu[i][0] != "08" && menu[i][0] != "09"){
				strMainOff += '<a href="'+menu[i][2]+'" class="'+opens+'">' + menu[i][1] + '</a>';
			}
		}

		// 투뎁스
		if(menu[i][0].length==4 && menu[i][0].substr(0,2) == pcd.substr(0,2)){
			if(menu[i][0].length==4){
				mCss="";
				if(menu[i][0] == pcd.substr(0,menu[i][0].length)) mCss='_on';
				var opens = (mCss) ? "active" : ""; //@ Left 현재 메뉴 고정

				if(menu[i][0] != "08"){
					if(menu[i][0] == pcd.substr(0,menu[i][0].length)){
						strSubOn = '<li class="sMenu sDepth02"><a href="javascript:void(0);">' + menu[i][1] + '</a><div class="lnbSub">';
					}

					strSubOff += '<a href="'+menu[i][2]+'" class="'+opens+'">' + menu[i][1] + '</a>';
				}
			}
		}
	}
	/*document.write(strMainOn+strMainOff+'</li>');
	document.write(strSubOn+strSubOff+'</li>');*/
	$("#snb_m>.inConts").append(strMainOn+strMainOff+'</li>');
	$("#snb_m>.inConts").append(strSubOn+strSubOff+'</li>');
}

//@Left 타이틀셋팅
function leftMenuTitle(pcd){
	var tcd = pcd.substr(0,2);
	depth_1 = pcd.substr(1,1)-1;
	depth_2 = pcd.substr(3,1)-1;
	depth_3 = pcd.substr(5,1)-1;
	depth_4 = pcd.substr(7,1)-1;

	for(var i=0; i < menu.length; i++){
		if(menu[i][0].length==2 && menu[i][0] == tcd){
			break;
		}
	}
	//document.write('<h2><img src="/images/common/h2_lnb'+tcd+'.gif" alt="'+menu[i][1] +'" /></h2>');

	//document.write('<strong>'+menu[i][1]+'</strong>');
	$("#snb>h2").html('<strong>'+menu[i][1]+'</strong>');

	setTimeout(function(){
		//lnbOpen();
		//$(".testText").text("pcd = "+pcd+", tcd = "+tcd+", depth_1 = "+depth_1+", depth_2 = "+depth_2+", depth_3 = "+depth_3+", depth_4 = "+depth_4);

		$("#header #gnb>li").eq(depth_1).addClass("openPage");
		$("#header #gnb>li.openPage .gnbSub>a").eq(depth_2).addClass("active");
			/*
		#header #gnb>li.openPage
		#header #gnb .gnbSub>a
		*/
		$("#container #snb>.nav").eq(depth_1).addClass("active");
		$("#container #snb>.nav.active>li").eq(depth_2).addClass("openPage");
		$("#container #snb>.nav.active>li.openPage>.subLnb3>li").eq(depth_3).addClass("active");
		$("#container #snb>.nav.active>li.openPage>.subLnb3>li.active>.subLnb4>a").eq(depth_4).addClass("active");


		$('.pageTop>h2>strong').addClass("subcon"+tcd)
	}, 200);
}


//@Left 타이틀셋팅(서브비주얼)
function leftMenuTitle2(pcd){
	var tcd = pcd.substr(0,2);
	depth_1 = pcd.substr(1,1)-1;
	depth_2 = pcd.substr(3,1)-1;
	depth_3 = pcd.substr(5,1)-1;
	depth_4 = pcd.substr(7,1)-1;

	for(var i=0; i < menu.length; i++){
		if(menu[i][0].length==2 && menu[i][0] == tcd){
			break;
		}
	}
	//document.write('<h2><img src="/images/common/h2_lnb'+tcd+'.gif" alt="'+menu[i][1] +'" /></h2>');

	//document.write('<div class="sub_top">'+'<h2>'+menu[i][4]+'</h2>'+'<span>'+menu[i][3]+'</span>'+'</div>');
	$("#view-title").html('<div class="sub_top">'+'<h2>'+menu[i][4]+'</h2>'+'<span>'+menu[i][3]+'</span>'+'</div>');
	$("#sVisual").addClass("bg"+tcd);
}


//@Page 타이틀셋팅
function pageTop(pcd){
	if(pcd.length == 4){
		var tcd = pcd.substr(0,4);
		for(var i=0; i < menu.length; i++){
			if(menu[i][0].length==4 && menu[i][0] == tcd){
				break;
			}
		}
	}else if(pcd.length == 6){
		var tcd = pcd.substr(0,6);
		for(var i=0; i < menu.length; i++){
			if(menu[i][0].length==6 && menu[i][0] == tcd){
				break;
			}
		}

	}

	if(menu[i][3] == undefined){
		//document.write('<strong>'+menu[i][1]+'</strong>'); //+menu[i][1]
		$("#contents>.pageTop>h2").html('<strong>'+menu[i][1]+'</strong>');
	}else{
		//document.write('<strong>'+menu[i][1]+'</strong>'); //+menu[i][3]
		$("#contents>.pageTop>h2").html('<strong>'+menu[i][1]+'</strong>');
	}
	$("html head title").html(menu[i][1]+" | KORUSTEC");
}

//@Page Navi셋팅
function findMenuName(cd){
	var menuName = '';
	for(var i=0; i < menu.length; i++){
		if(menu[i][0]==cd){
			menuName = menu[i][1];
			break;
		}
	}
	return menuName;
}
function globalNavigation(pcd){
	if(!pcd)return;
	var navi = '';
	var lastNaviNum = parseInt(pcd.length / 2,10);
	for(var y=1; y <= lastNaviNum; y++){

		mcd = pcd.substr(0,y*2);
		if(findMenuName(mcd)){
			if(y==lastNaviNum){
				navi +='<span class="last">'+findMenuName(mcd)+'</span>';
			}else{
				navi +='<span>'+findMenuName(mcd)+'</span>';
			}
		}
	}
	$("#view-navi").html('<span class="home">HOME</span>'+navi);
	//document.write('<span class="home">HOME</span>'+navi);
}


function globalMenuControler(){
	pgCode = $("#section").attr("pgCode");
	if(pgCode){
		leftMenuTitle2(pgCode);
		globalNavigation(pgCode);
		leftMenuManager2(pgCode);
		leftMenuTitle(pgCode);
		pageTop(pgCode);
	}
}