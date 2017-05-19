<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title;?></title>
<style type="text/css">
/*@import url("http://fonts.googleapis.com/earlyaccess/nanumgothic.css");*/
/* 추가할 CSS가 있을시 import하세요 */
/* @import url(''); */

/* global defaults */
body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td,legend{margin:0;padding:0}
fieldset,img,abbr,acronym{border:none}
fieldset{display:block}
ol,ul{list-style:none outside}
h1,h2,h3,h4,h5,h6,address,caption,cite,code,dfn,em,th,var{font-size:100%;font-weight:normal}
div.bottom{font-size:12px;text-align:right;margin:10px 10px 0 0}
.vam{vertical-align:middle !important}
</style>
<script type="text/javascript" src="/theme/<?=$this->config->item('theme')?>/<?=$_language?>/common/js/jquery.lastest.js"></script>
<script type="text/javascript" src="/theme/<?=$this->config->item('theme')?>/<?=$_language?>/common/js/popup.js"></script>
<script type="text/javascript">
//<![CDATA[
	function jclose(){
		if($("[name=today]:checked").length > 0){
			Popup.set("pop-win-<?php echo $id;?>", "Y", 1);
		}
		self.close();
	}
//]]>
</script>
</head>
<body>
<?php
	if($popup_style == 'I'){
		$photo = explode('|',$popup_image);
		echo '<img src="/upload/popup/'.$photo[0].'" />';
	}else{
		echo $popup_content;
	}
?>
<div class="bottom"><input type="checkbox" name="today" class="vam" /> 오늘 하루만 보기 <a href="javascript:jclose()">닫기</a></div>
</body>
</html>
