<?php
$query_size = set_child_list('1');
$query_loc = set_child_list('2');

$products = $_products = array();
if($related_products){
	$products = explode(',',$related_products);
}

if ($_query->num_rows() > 0){
	foreach($_query->result() as $row){		
		$_code = get_child_info($row->size);
		$_products[$row->seq] = $row->product_nm.'('.$_code['title'].')';

	}
}

$json = array(
	'tread_width'=>'',
	'skid_depth'=>'',
	'ply_rating'=>'',
	'weight'=>'',
	);
if($spec){
	$json = json_decode($spec,true);
}


?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default  forms">
			<!-- <div class="panel-heading">
				Basic Form Elements
			</div> -->
			<form name="frm" class="stdform" action="/thdadmin/product_dbjob" enctype="multipart/form-data" method="post">
			<input type="hidden" name="dbjob" value="<?=$_dbjob?>" />
			<input type="hidden" name="related_products" value="" />
			<input type="hidden" name="category" value="" />
			<input type="hidden" name="seq" value="<?=$seq?>" />
			<input type="hidden" name="page" value="<?=$_page?>" />
			<input type="hidden" name="language" value="<?=$_language?>" />
			<div class="panel-body">
				<table width="100%" class="table-form table-bordered">
				<colgroup>
					<col width="150px"/>
					<col width="*" />
				</colgroup>
				<tbody>
				<tr>
					<th>카테고리</th>
					<td>
						<a class="btn btn-primary add-cate" data-parent-id="1" data-tag="cate">추 가</a>
						<ul id="cate_view" class="clist">
						<?
						if(array_key_exists('1',$_category)){
							foreach($_category['1'] as $key => $value){
								echo '<li cate="'.$key.'">'.implode(' &gt; ',$value).' <i class="glyphicon glyphicon-remove" title="삭제"></i></li>'.chr(10);
							}
						}
						?>
						</ul>
					</td>
				</tr>
				<tr>
					<th>사이즈 / 장착위치</th>
					<td>
						<select name="size" class="form-control" style="width:150px;display:inline">
							<option value="">사이즈</option>
							<?
							foreach($query_size->result() as $row){
								$selected = ($row->code_id == $size) ? 'selected' : null;
								echo '<option value="'.$row->code_id.'" '.$selected.'>'.$row->title.'</option>'.chr(10);
							}
							?>
						</select>
						/
						<select name="loc" class="form-control" style="width:150px;display:inline">
							<option value="">장착위치</option>
							<?
							foreach($query_loc->result() as $row){
								$selected = ($row->code_id == $loc) ? 'selected' : null;
								echo '<option value="'.$row->code_id.'" '.$selected.'>'.$row->title.'</option>'.chr(10);
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<th>라인업</th>
					<td>
						<a class="btn btn-primary add-cate" data-parent-id="209" data-tag="cate_lineup">추 가</a>
						<ul id="cate_lineup_view" class="clist">
						<?
						if(array_key_exists('209',$_category)){
							foreach($_category['209'] as $key => $value){
								echo '<li cate="'.$key.'">'.implode(' &gt; ',$value).' <i class="glyphicon glyphicon-remove" title="삭제"></i></li>'.chr(10);
							}
						}
						?>
						</ul>
				
					</td>
				</tr>
				<tr>
					<th>차종별</th>
					<td>
						<a class="btn btn-primary add-cate" data-parent-id="2" data-tag="cate_model" style="margin:5px 0 5px 0">추 가</a>
						<ul id="cate_model_view" class="clist">
						<?
						if(array_key_exists('2',$_category)){
							foreach($_category['2'] as $key => $value){
								echo '<li cate="'.$key.'">'.implode(' &gt; ',$value).' <i class="glyphicon glyphicon-remove" title="삭제"></i></li>'.chr(10);
							}
						}
						?>
						</ul>
				
					</td>
				</tr>
				<tr>
					<th>화면표시</th>
					<td>
						<input type="checkbox" name="open_yn" class="input-large" value="y" <?=($open_yn != 'n')?'checked':'';?> > Yes
					</td>
				</tr>
				<tr>
					<th>BTOC표시</th>
					<td>
						<input type="checkbox" name="btoc_yn" value="y" <?=($btoc_yn != 'n')?'checked':'';?> > Yes
					</td>
				</tr>
				<tr>
					<th>제품명</th>
					<td>
						<input type="text" name="product_nm" class="form-control" value="<?=$product_nm?>" placeholder="" style="width:50%">
					</td>
				</tr>
				<tr>
					<th>판매가격</th>
					<td>
						<input type="text" name="price" class="form-control" value="<?=$price?>" placeholder="" style="width:20%">
					</td>
				</tr>
				<tr>
					<th>소비자가격</th>
					<td>
						<input type="text" name="consumer" class="form-control" value="<?=$consumer?>" placeholder="" style="width:20%">
					</td>
				</tr>
				<tr>
					<th>재고량</th>
					<td>
						<input type="text" name="stock" class="form-control" value="<?=$stock?>" placeholder="" style="width:20%">
					</td>
				</tr>
				<tr>
					<th>스펙</th>
					<td style="padding:10px 0 15px 15px">
						TREAD WIDTH<input type="text" name="tread_width" class="form-control" value="<?=$json['tread_width']?>" placeholder="" style="width:20%">
						SKID DEPTH<input type="text" name="skid_depth" class="form-control" value="<?=$json['skid_depth']?>" placeholder="" style="width:20%">
						PLY RATING<input type="text" name="ply_rating" class="form-control" value="<?=$json['ply_rating']?>" placeholder="" style="width:20%">
						WEIGHT<input type="text" name="weight" class="form-control" value="<?=$json['weight']?>" placeholder="" style="width:20%">
					</td>
				</tr>
				<tr>
					<th>대체가능제품</th>
					<td>

						<div class="multi_option">
							<select name="stuff" class="form-control" multiple="">
							<?php
								foreach($_products as $key => $value){
									if(!in_array($key,$products)){
										echo '<option value="'.$key.'">'.$value.'</option>'.chr(10);
									}
								}
							?>
							</select>
						</div>
						<div class="multi_btn">
							<a class="add-stuff" href="javascript:void(0);">▶</a>
							<a class="del-stuff" href="javascript:void(0);">◀</a>
						</div>
						<div class="multi_option">
							<select name="add_stuff" class="form-control" multiple="">
							<?php
								foreach($products as $key => $value){
									echo '<option value="'.$value.'">'.$_products[$value].'</option>'.chr(10);
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
				
				<tr>
					<th>목록이미지</th>
					<td>
						<div class="file-group">
							<input type="hidden" class="file-input" name="file_list" id="file_list" value="<?=$file_list?>">
							<button type="button" class="file-add btn btn-primary">파일등록</button>
							<button type="button" class="file-delete btn btn-danger">파일삭제</button>	
						</div>
					</td>
				</tr>
				<tr>
					<th>상세대표이미지</th>
					<td>
						<div class="file-group">
							<input type="hidden" class="file-input" name="file_detail_thumb" id="file_detail_thumb" value="<?=$file_detail_thumb?>">
							<button type="button" class="file-add btn btn-primary">파일등록</button>
							<button type="button" class="file-delete btn btn-danger">파일삭제</button>	
						</div>
					</td>
				</tr>
				<tr>
					<th>제품설명</th>
					<td>
						<ul class="group-attache">
							<li>
								<h2>PC <i class="fa fa-image "></i></h2>
								<?
								foreach($this->config->item('file_upload') as $key => $value)
								{
									$no = $key+1;
								?>
								<dl>
									<dt><?=$value?></dt>
									<dd>
										<div class="file-group">
											<input type="hidden" class="file-input" name="file_pc_detail<?=$no?>" id="file_pc_detail<?=$no?>" value="<?=${'file_pc_detail'.$no}?>">
											<button type="button" class="file-add btn btn-primary">파일등록</button>
											<button type="button" class="file-delete btn btn-danger">파일삭제</button>	
										</div>
									</dd>
								</dl>
								<?
								}
								?>
							</li>
							<li>
								<h2>MOBILE <i class="fa fa-image "></i></h2>
								<?
								foreach($this->config->item('file_upload') as $key => $value)
								{
									$no = $key+1;
								?>
								<dl>
									<dt><?=$value?></dt>
									<dd>
										<div class="file-group">
											<input type="hidden" class="file-input" name="file_m_detail<?=$no?>" id="file_m_detail<?=$no?>" value="<?=${'file_m_detail'.$no}?>">
											<button type="button" class="file-add btn btn-primary">파일등록</button>
											<button type="button" class="file-delete btn btn-danger">파일삭제</button>	
										</div>
									</dd>
								</dl>
								<?
								}
								?>
							</li>
						</ul>
					</td>
				</tr>
				</tbody>
				</table>

			</form>
			<div style="margin-top:20px;">
				<div class="col-md-6">
					<a class="btn btn-primary" onclick="javascript:frmValid();">등 록</a>
					<a class="btn btn-default" onclick="javascript:history.back();">목 록</a>
				</div>
				<?if($_dbjob == 'u'){?>
				<div class="col-md-6" style="text-align:right">
					<a class="btn btn-danger" onclick="javascript:del();">삭 제</a>
				</div>
				<?}?>
			</div>
			

		</div>
	</div>
</div>
<style type="text/css">
div.multi_option{margin-top:10px;float:left;}
div.multi_option select{width:300px;height:300px;border:1px solid #ccc}
div.multi_btn{margin:20px 10px 0 10px;float:left}
div.multi_btn a{display:block;font-size:23px}
</style>
<script type="text/javascript" src="/common/thdadmin/js/thdays.product.js"></script>
<script type="text/javascript" src="/common/thdadmin/js/thdays.attachefile.js"></script>
<script type="text/javascript" src="/common/thdadmin/js/thdays.category.js"></script>
<script type="text/javascript">
	//<![CDATA[ 

	function frmValid(){
		var is_cate = 0; //카테고리등록여부
		var c = '';
		$(".clist li").each(function(){
			if($(this).attr("cate").substr(0,2) == '01'){ //카테고리등록체크
				is_cate = 1;
			}
			c += (c) ? ','+ $(this).attr("cate") : $(this).attr("cate");
		});

		var s= '';
		$('[name="add_stuff"] option').each(function(){
			s += (s) ? ','+$(this).val() : $(this).val();
		});
		
		with(document.frm){
			category.value = c;
			related_products.value = s;	
			
			if(!is_cate){
				alert("제품 카테고리를 선택해주세요");
				return;
			}
						
			/*if(!category.value){
				alert("제품 카테고리를 선택해주세요");
				return;
			}*/
					
			if(!product_nm.value){
				alert("제품명을 입력하세요");
				product_nm.focus();
				return;
			}

			
			
			/*if(!CKEDITOR.instances.ckeditor_standard.getData()){
				alert("내용을 입력하세요");
				return;
			}*/
			
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