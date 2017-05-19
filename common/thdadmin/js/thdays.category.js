/*파일 등록관련 */
var attachecategory = {
	params : {
		
	},

	init : function(p) {
		var self = this;
		
		if(p){
			$.each( p, function(key,value){
				self.params[key] = value;
			}); 
		}

		if(self.params.tags){ //add event tags
			$.each(self.params.tags,function(index,value){
				$("#"+value+"_view li").click(function(){
					$(this).remove();
				});
			});
		}

		
		$(".add-cate").click(function(){
			var parent_id = $(this).attr("data-parent-id");
			var tag = $(this).attr("data-tag");
			self.params['tag'] = tag;
			var offset = $(this).offset();
			
			$.ajax({
				type: "POST",
				url: "/thdadmin/ajax_pop_category",
				data: "parent_id="+parent_id,
				success: function(data){
					$("#category-controller").detach();
					$(".forms").append(data);
					$("#category-controller").css("top", offset.top-237);
				
					$(".category-close").click(function(){
						$("#category-controller").detach();
					});
					
					//event select box begin
					$('[name="cate[]"]').change(function(){
						var index = $('[name="cate[]"]').index($(this));
						$.ajax({
							type: "GET",
							url: "/thdadmin/ajax_child_category",
							data: "category="+$(this).val(),
							success: function(data){
								var prefix = eval('('+data+')');
								//초기화
								$('[name="cate[]"]').each(function(idx){
									if(idx > index){
										$(this).empty();
									}
								});

								if(prefix.category == undefined) return;
								for(var i=0; i < prefix.category.length; i++){
									$('[name="cate[]"]').eq(index+1).get(0).options[i] = new Option(prefix.category_name[i],prefix.category[i]);
								}
							},
							error:function(error){alert('에러');}
						});		
					});
					//event select box end
				},
				error:function(error){alert('에러');}
			});
		});
		
		

	},
	
	
	addCategory : function(){ //카테고리 더하기
		var txt="";
		var cate = "";
		$('[name="cate[]"] option:selected').each(function(idx){
			txt += (txt) ? " &gt; "+$(this).text() : $(this).text(); 
			
			cate = $(this).val();
		});
		li = '<li cate="'+cate+'">'+txt+' <i class="glyphicon glyphicon-remove" title="삭제"></i></li>';

		$("#"+this.params.tag+"_view").append(li);
		$("#category-controller").detach();

		$("#"+this.params.tag+"_view li").click(function(){
			$(this).remove();
		});
	}

}