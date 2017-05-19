/*파일 등록관련 */
var attachefile = {
	params : {
		'file_path' : 'product',
		'thumb' : false,
		'thumb_size' : null
	},

	init : function(p) {
		var self = this;
		
		if(p){
			$.each( p, function(key,value){
				self.params[key] = value;
			}); 
		}

		var str = '';
		str += '<div id="file-controller">';
		str += '	<div class="file-form">';
		str += '		<div class="file-close">X</div>	';
		str += '		<form name="frm_file" id="frm_file" target="ifrm_proc" action="/thdadmin/product_file_proc" enctype="multipart/form-data" method="post">';
		str += '		<input type="hidden" name="file_path" id="file_path" value="'+this.params.file_path+'">';
		str += '		<input type="hidden" name="file_thumb" id="file_thumb" value="'+this.params.thumb+'">';
		str += '		<input type="hidden" name="file_thumb_size" id="file_thumb_size" value="'+this.params.thumb_size+'">';
		str += '		<input type="hidden" name="file_num" id="file_num" value="">';
		str += '		<input type="hidden" name="file_info" id="file_info" value="">';
		str += '		<div class="file-box">';
		str += '			<input type="text" class="file-txt form-control" disabled="disabled" placeholder="허용용량 21M" />';
		str += '			<span class="file-input">';
		str += '				<input type="file" name="files[]" onchange="$(this).parent().parent().find(\'.file-txt\').val($(this).val())">';
		str += '			</span>';
		str += '		</div>';
		str += '		<div class="file-btn"><a class="btn btn-warning file-upload" href="javascript:void(0);">파일첨부</a></div>';
		str += '		</form>';
		str += '	</div>';
		str += '</div>';
		str += '<iframe name="ifrm_proc" id="ifrm_proc" width="0" height="0" style="display:none"></iframe>';
		//str += '<iframe name="ifrm_proc" id="ifrm_proc"></iframe>';
		$(this.params.area).append(str);
								
		$(".file-input").each(function(index){ //파일초기화
			if($(this).val()){
				self.fileAdd(index,$(this).val());
			}else{
				$(".file-delete").eq(index).hide();
			}
		});
		
		
		$(".file-add").click(function(){
			
			var offset = $(this).offset();
			var index = $(".file-add").index($(this));
			$("#file-controller").css("top", offset.top-200);
			$("#file_num").val(index);
			$("#file-controller").show();
		});

		$(".file-delete").click(function(){
			var index = $(".file-delete").index($(this));
			$("#file_info").val($(".file-input").eq(index).val());
			$("#file_num").val(index);
			$("#frm_file").submit();
		});

		$(".file-close").click(function(){
			$("#file-controller").hide();
		});

		$(".file-upload").click(function(){
			if(!$(".file-txt").val()){
				alert('파일을 선택해주세요');
				return;
			}

			$("#frm_file").submit();
		});

	},
	
	fileInit : function(){ //초기화
		$(".file-txt").val('');
		$('[name="files[]"]').val('');
		$("#file_num").val('');
		$("#file_info").val('');
	},
	
	fileAdd : function(n,f){
		var self = this;
		self.fileInit();

		$("#file-controller").hide();
		var finfo = f.split('|');
		var v = Array();
		
		var fnm = (finfo[1] != undefined) ? finfo[1] : finfo[0];
		v.push('<span style="vertical-align:middle;height:26px;"><a href="/upload/'+this.params.file_path+'/'+finfo[0]+'" target="_blank">'+fnm+'</a></span>');
		$(".file-input").eq(n).val(f);
		$(".file-group").eq(n).prepend(v.join(''));
		$(".file-delete").eq(n).show();
		
	},
	fildDeleteDone: function(n){
		var self = this;
		self.fileInit();

		$(".file-group").eq(n).children("span").detach();
		$(".file-delete").eq(n).hide();
		$(".file-input").eq(n).val('');

	}
}