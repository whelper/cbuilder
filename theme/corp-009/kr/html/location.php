<script type="text/javascript" src="<?=$this->theme_path?>/common/js/google.map.js"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyAldwVePVXQ4nDV3iZwvb2_Uov6h4HBSsg"></script>
<script type="text/javascript">
	function contentPrint() {
			var windowLeft = (screen.width-740)/2;
		}
	$(window).load(function(){	// $(".testText").text("off2");
		var addr= Array("Nauchniy proezd 17, Moscow, Russia");
		GoogleMap.initialize(addr[0]);
	});
</script>
<div id="section" pgCode="0105">
    <div id="map_wp">
        <div id="GoogleMap_map" ></div>
        <div class="loc_img">
            <img src="<?=$this->theme_path?>/images/about/map_img.jpg" alt="" />
        </div>
        <div class="loc_tb">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="20%" valign="top" class="tt">주소</td>
                <td width="80%" valign="top">117246, Office 35, Nauchniy proezd 17, Moscow, Russia</td>
            </tr>
            <tr>
                <td valign="top" class="tt">전화</td>
                <td valign="top">+7-495-783-7120/1 </td>
            </tr>
            <tr>
                <td valign="top" class="tt">E-mail</td>
                <td valign="top" class="email">
                    korustec@gmail.com (한국어, 영어), <br>
                    kicosmos@mail.ru (러시아어)
                </td>
            </tr>
            </table>
        </div>
    </div>
</div>
<!-- section -->
