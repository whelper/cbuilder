/*상품 등록관련*/
var product = {
	params : {		
	},

	init : function() {
		var self = this;
						
		
		$(".add-stuff").click(function(){ 
			var index = $(".add-stuff").index($(this));
			var max = 0;
			$('[name="stuff"] option:selected').each(function(i){
				for(var j=0; j < $(this).val(); j++){
					if($('[name="add_stuff"] option[value='+ j +']').text() != ''){
						max = j;
					}
				}
				if(max == 0){
					
					$('[name="add_stuff"]').prepend($(this).clone());
				}else{
					$('[name="add_stuff"] option[value='+ max +']').after($(this).clone());
				}
				$(this).remove();
			});
		});	
		
		//빼기
		$(".del-stuff").click(function(){
			var index = $(".del-stuff").index($(this));
			var max = 0;
			$('[name="add_stuff"] option:selected').each(function(i){
				for(var j=0; j < $(this).val(); j++){
					if($('[name="stuff"] option[value='+ j +']').text() != ''){
						max = j;
					}
				}

				if(max > 0){
					$('[name="stuff"] option[value='+ max +']').after($(this).clone());
				}else{
					$('[name="stuff"]').prepend($(this).clone());
				}
				$(this).remove();
			});
		});	

		$(".up-stuff").click(function(){ //순서 위
			 $('[name="add_stuff"] option:selected').each(function(){
				 var selectObj = $(this);
				 if(selectObj.index() == 0 ) 
					 return false;
				 
				 var targetObj = $('[name="add_stuff"] option:eq('+(selectObj.index()-1)+')');
				 targetObj.before(selectObj);
			 });
		});

		$(".down-stuff").click(function(){ //순서 아래
			 $('[name="add_stuff"] option:selected').each(function(){
				 var selectObj = $(this)
				 if(selectObj.index() == $('[name="add_stuff"]').children().length ) 
					 return false;
				 
				 var targetObj = $('[name="add_stuff"] option:eq('+(selectObj.index()+1)+')');
				 targetObj.after(selectObj);
			 });
		});
	},

	valid : function(){
		if(!$("[name=opt_nm]").val()){
			alert("옵션명을 입력하세요");
			return;
		}

		if(!$("[name=opt_price]").val()){
			alert("옵션가격을 입력하세요");
			return;
		}
	},
	getOptionValue : function() {
		var v = Array();
		v.push($("[name=opt_nm]").val());
		v.push($("[name=opt_price]").val());
		return v;
	},
}