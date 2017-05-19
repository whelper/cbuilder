<div id="pop-layer-<?php echo $popup_id;?>" style="width:<?php echo $popup_width;?>px;height:<?php echo $popup_height;?>px;top:<?php echo $popup_top;?>px;left:<?php echo $popup_left;?>px;position:absolute;border:1px solid;z-index:999;background:#fff">
<?php
	if($popup_style == 'I'){
		$photo = explode('|',$popup_image);
		echo '<img src="/upload/popup/'.$photo[0].'" />';
	}else{
		echo $popup_content;
	}
?>
<span><input type="checkbox" name="today" class="vam"  /> ¿À´Ã ÇÏ·ç¸¸ º¸±â <a href="javascript:Popup.layerClose('pop-layer-<?php echo $popup_id;?>')">´Ý±â</a></span>
</div>