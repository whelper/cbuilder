<?php
$products = $_products = array();

if ($_query->num_rows() > 0){
	foreach($_query->result() as $row){		
		$_code = get_child_info($row->size);
		$_products[$row->seq] = $row->product_nm.'('.$_code['title'].')';

	}
}

?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default  forms">
			<!-- <div class="panel-heading">
				Basic Form Elements
			</div> -->
			<form name="frm" class="stdform" action="/thdadmin/product_sort_dbjob" enctype="multipart/form-data" method="post">
			<input type="hidden" name="products" value="" />
			<input type="hidden" name="category" value="" />
			<input type="hidden" name="language" value="<?=$_language?>" />
			<div class="panel-body">
				<table width="100%" class="table-form table-bordered">
				<colgroup>
					<col width="150px"/>
					<col width="*" />
				</colgroup>
				<tbody>
				<tr>
					<th>제품정렬</th>
					<td>
						<div class="multi_option">
							<select name="add_stuff" class="form-control" multiple="">
							<?php
								$i=1;
								foreach($_products as $key => $value){
									if(!in_array($key,$products)){
										echo '<option value="'.$key.'">'.$i.' : '.$value.'</option>'.chr(10);
										$i++;
									}
								}
							?>
							</select>
						</div>
						
						<div class="multi_btn">
							<a href="javascript:void(0);" class="up-stuff">▲</a>
							<a href="javascript:void(0);" class="down-stuff">▼</a>
							<!-- <a href="javascript:void(0);" class="del-stuff btn ty2">선택삭제</a> -->
						</div>

					</td>
				</tr>
				
				
				</tbody>
				</table>

			</form>
			<div style="margin-top:20px;">
				<div class="col-md-6">
					<a class="btn btn-primary" onclick="javascript:frmValid();">정렬순서 적용</a>
				</div>
				
			</div>
			

		</div>
	</div>
</div>
<style type="text/css">
div.multi_option{margin-top:10px;float:left;}
div.multi_option select{width:500px;height:600px;border:1px solid #ccc}
div.multi_btn{margin:20px 10px 0 10px;float:left}
div.multi_btn a{display:block;font-size:23px}
</style>
<script type="text/javascript" src="/common/thdadmin/js/thdays.product.js"></script>
<script type="text/javascript" src="/common/thdadmin/js/thdays.attachefile.js"></script>
<script type="text/javascript" src="/common/thdadmin/js/thdays.category.js"></script>
<script type="text/javascript">
	//<![CDATA[ 

	function frmValid(){
		if(!confirm('제품순서를 적용하시겠습니까?'))return;
		var s= '';
		$('[name="add_stuff"] option').each(function(){
			s += (s) ? ','+$(this).val() : $(this).val();
		});

		with(document.frm){
			products.value = s;	
			submit();
		}
	}

	function del(){
		if(!confirm('삭제하시겠습니까?'))return;
		with(document.frm){
			dbjob.value ='d';
			submit();
		}
	}

	$(document).ready(function(){
		var p = {"tags" : ["cate","cate_lineup","cate_model"]};
		
		attachecategory.init(p);
		product.init();
		attachefile.init({'area' : '.forms'});
	});

	//]]>
</script>