<?php
	
	
?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<!-- <div class="panel-heading">
				Basic Form Elements
			</div> -->
			<div class="panel-body" id="panel-category">
			</div>
			
		</div>
	</div>
</div>
<style type="text/css">
	#parent-category{display:none;}
	a.init{display:none;}
</style>
<script type="text/javascript">
	//<![CDATA[ 
	function sortCategory(d,c,s){
		with(document.frm){
			category.value = c;
			sort_no.value = s;
			dbjob.value = d;
			//action = "/thdadmin/category_dbjob";
			//submit();
		}

		$.ajax({
			type: "POST",
			url: "/thdadmin/category_dbjob",
			data: $("[name=frm]").serialize(),
			success: function(data){
				var prefix = eval('('+data+')');
				alert(prefix.msg);
				categoryList();
				
			},
			error:function(error){alert('에러');}
		});	
	}

	function categoryList(prefix){
		
		$.ajax({
			type: "POST",
			url: "/thdadmin/ajax_category_list",
			data: $("[name=frm]").serialize(),
			success: function(data){
				$("#panel-category").html(data);
				if($("[name=dbjob]").val() !='i'){
					$(".init").show();
				}
				
				if(prefix){
					if(prefix.parent_id){ //연속 서브 카테고리 입력
						addChild(prefix.parent_id, prefix.now_cate);
					}

					if(prefix.now_cate){ //load시 현재 카테고리 펼침
						var len = prefix.now_cate.length;	
						$(".child-cate").each(function(){						
							if(prefix.now_cate.substr(0,len) == $(this).attr("child-cate").substr(0,len)){
							
								$(this).show();
								$(this).find(".open").addClass("fold");
								$(this).find(".open").html('<i class="fa fa-minus"></i>');
							}

						});
					}
				}

				$(".open").click(function(){
					var code = $(this).attr("open-cate");
					var fold = false;
					if($(this).hasClass("fold")){
						fold = true;
						$(this).removeClass("fold");
						$(this).html('<i class="fa fa-plus"></i>')
					}else{
						
						$(this).addClass("fold");
						$(this).html('<i class="fa fa-minus"></i>')
					}
					
					$(".child-cate").each(function(){
						if(fold){
							if(code == $(this).attr("child-cate").substr(0,code.length) && $(this).attr("child-cate").length > code.length){
								$(this).hide();
								$(this).find(".open").removeClass("fold");
								$(this).find(".open").html('<i class="fa fa-plus"></i>');
								
							}
						}else{
							if(code == $(this).attr("child-cate").substr(0,code.length) && $(this).attr("child-cate").length == (code.length+2)){
								$(this).show();
							}
						}
					});
				});
			},
			error:function(error){alert('에러');}
		});	
	}

	function modifyCategory(c){
		with(document.frm){
			category.value = c;
			dbjob.value = 'u';
			//action = "/thdadmin/ajax_category";
			//submit();
		}
		categoryList();
	}
	function addChild(p,c){
		$.ajax({
			type: "GET",
			url: "/thdadmin/ajax_category",
			data: "category="+c,
			success: function(data){
				if(data){
					$("#parent-category").show();
					$("#parent-category").html(data);
				}
				$(".init").show();
				with(document.frm){
					parent_id.value = p;
					category.value = c;
					dbjob.value = 'r';
				}
				 $('html, body').stop().animate({ scrollTop : 0 }, 500 , "easeOutQuart");  
				
			},
			error:function(error){alert('에러');}
		});		
		
		
	}
	function deleteCategory(c){
		if(!confirm('삭제하시겠습니까?'))return;
		with(document.frm){
			category.value = c;
			dbjob.value = 'd';
			//submit();
		}
		categoryDbjob();
		$("[name=category]").val('');
	
	}

	function frmValid(){
		with(document.frm){
			if(!category_name.value){
				alert("카테고리명을 입력해주세요");
				category_name.focus();
				return;
			}
			//submit();
		}
		categoryDbjob();
		$("[name=category]").val('');
		document.frm.reset();
	}

	function categoryDbjob(){		
		$.ajax({
			type: "POST",
			url: $("[name=frm]").attr("action"),
			data: $("[name=frm]").serialize(),
			success: function(data){
				//alert(data)
				var prefix = eval('('+data+')');
				if(prefix.msg){
					alert(prefix.msg)
				}
				categoryList(prefix);
				
			},
			error:function(error){alert('에러');}
		});		
	}
	
	//var cate="<?=$_now_cate?>";

	$(document).ready(function(){
		categoryList();
	});

	//]]>
</script>