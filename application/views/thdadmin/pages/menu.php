<div class="row">
	<div class="col-lg-12">
		<p><a href="/thdadmin/menu_form?language=<?=$_language?>" class="btn btn-primary">메뉴등록</a></p>
	</div>
</div>

<form name="frm" method="post">
	<input type="hidden" name="menu_id" />
	<input type="hidden" name="parent_id" />
	<input type="hidden" name="sort_no">
	<input type="hidden" name="menu_type" />
	<input type="hidden" name="language" value="<?=$_language?>" />
	<input type="hidden" name="dbjob" />
</form>

<div class="row">
	<?php
		foreach($menu as $k => $v){
			if($v['parent_id'] == 0 && $v['single_yn'] == 'N'){ // 1depth
				$css = ($v['etc_yn'] == 'Y') ? 'etc' :'default';
				if($v['use_yn'] == 'N') $css =  'menu_close' ;		
		
	?>
	 <div class="col-lg-2">
		<div class="panel panel-default <?=$css?>">
			<div class="panel-heading">
				<span><?=$v['title']?></span>
				<a href="/thdadmin/menu_form?language=<?=$_language?>&menu_id=<?=$k?>" title="메뉴수정"><i class="fa fa-edit"></i></a> 
				<a href="/thdadmin/menu_form?language=<?=$_language?>&parent_id=<?=$k?>" title="하위메뉴추가"><i class="fa fa-plus-square-o"></i> 
				<a href="javascript:deleteMenu(<?=$k?>,'<?=$v['menu_type']?>');" title="메뉴삭제"><i class="fa fa-minus-square-o"></i></a>
				<a href="<?=$v['url']?>" title="미리보기" target="_blank"><i class="fa fa-eye"></i></a>
				<ul class="sort">
					<li><a href="javascript:msort('up',<?=$k?>,<?=$v['sort_no']?>,<?=$v['parent_id']?>)">▲</a></li>
					<li><a href="javascript:msort('down',<?=$k?>,<?=$v['sort_no']?>,<?=$v['parent_id']?>)">▼</a></li>
				</ul>
			</div>
			<div class="panel-body">
				<ul class="list-unstyled">
					<?php
						$past_id = null;
						foreach($menu as $k1 => $v1){
							if($k == $v1['parent_id']){ // 2depth
								if($past_id && $k1 !=$past_id )echo '</ul></li>';
					?>
							<li>
								<?=$v1['title']?> 
								<a href="/thdadmin/menu_form?language=<?=$_language?>&menu_id=<?=$k1?>" title="메뉴수정"><i class="fa fa-edit"></i></a> 
								<a href="/thdadmin/menu_form?language=<?=$_language?>&parent_id=<?=$k1?>" title="하위메뉴추가"><i class="fa fa-plus-square-o"></i></a> 
								<a href="javascript:deleteMenu(<?=$k1?>,'<?=$v['menu_type']?>');" title="메뉴삭제"><i class="fa fa-minus-square-o"></i></a> 
								<a href="<?=$v1['url']?>" title="미리보기" target="_blank"><i class="fa fa-eye"></i></a>
							</li>
					<?php
								foreach($menu as $k2 => $v2){
									if($k1 == $v2['parent_id']){ // 3depth
										if($past_id != $k1) echo '<li><ul>';
									?>									
									<li>
									<?=$v2['title']?> 
									<a href="" title="메뉴수정"><i class="fa fa-edit"></i></a> 
									<a href="javascript:deleteMenu(<?=$k2?>,'<?=$v['menu_type']?>');" title="메뉴삭제"><i class="fa fa-minus-square-o"></i></a></li>
									<a href="<?=$v2['url']?>" title="미리보기" target="_blank"><i class="fa fa-eye"></i></a>
									
									<?
										$past_id = $k1;	
									}
								}
							}
						}
					?>
				</ul>
			</div>
		</div>
	</div>
	<?php
			}
		}
	?>

	<div class="col-lg-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="">단일페이지</a>  <a href="/thdadmin/menu_form?language=<?=$_language?>&single_yn=Y"><i class="fa fa-plus-square-o"></i>
			</div>
			<div class="panel-body">
				<ul class="list-unstyled">
					<?php
						foreach($menu as $k => $v){
							if($v['single_yn'] == 'Y'){
					?>
							<li>
								<?=$v['title']?>
								<a href="/thdadmin/menu_form?language=<?=$_language?>&menu_id=<?=$k?>" title="메뉴수정"><i class="fa fa-edit"></i></a> 
								<!-- <a href="/thdadmin/menu_form?parent_id=<?=$k?>" title="하위메뉴추가"><i class="fa fa-plus-square-o"></i></a>  -->
								<a href="javascript:deleteMenu(<?=$k?>);" title="메뉴삭제"><i class="fa fa-minus-square-o"></i></a> 
								<a href="<?=$v['url']?>" title="미리보기" target="_blank"><i class="fa fa-eye"></i></a>
							</li>
					<?php
							}
						}
					?>
				</ul>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
ul,li{list-style:none;padding:0;margin:0;}
.sort{position:absolute;top:0;right:10px}
.sort li{display:block}

.default{position:relative;}
.etc .panel-heading{position:relative;background-color:#333 !important;color:#fff  !important;}
.etc a{color:#fff  !important;}
.etc .panel-body{background-color:#666;color:#fff}
.menu_close{position:relative;background-color:#ddd !important;}
.menu_close a{color:#999  !important;}
.menu_close .panel-heading, .menu_close .panel-body{background-color:#ddd !important;color:#999  !important;}
.menu_close span{text-decoration:line-through}

</style>
<script type="text/javascript">
	function msort(d,c,s,p){
		with(document.frm){
			menu_id.value = c;
			parent_id.value = p;
			sort_no.value = s;
			dbjob.value = d;
			action = "menu_dbjob";
			submit();
		}
	}
	function deleteMenu(no,type){
		if(!confirm('삭제하시겠습니까?')) return;
		with(document.frm){
			menu_id.value = no;
			menu_type.value = type;
			dbjob.value = 'd';
			action = "/thdadmin/menu_dbjob";
			submit();
		}
	}
</script>