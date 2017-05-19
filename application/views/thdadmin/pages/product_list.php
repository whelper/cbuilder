<?php	
	//1depth 메뉴
	$_cate = set_category($_category,null);
	$param = '';
	foreach($_sch as $key => $value){
		$param .= '&'.$key.'='.urlencode($value);
	}
?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<!-- <div class="panel-heading">
				Basic Form Elements
			</div> -->
			<div class="panel-body">
				<div>
					<form name="frmSearch" onsubmit="return search()">
					<input type="hidden" name="category" value="<?=$_sch['category']?>">
					<input type="hidden" name="language" value="<?=$_language?>">
					<ul class="search-box">
						<li>
							<select class="select-category form-control">
								<option value="">= 1차 분류 =</option>
								<?php
									foreach($_cate as $k => $v){
										$selected = ($v['category']==substr($_sch['category'],0,2)) ? 'selected' : '';
										echo '<option value="'.$v['category'].'" '.$selected.'>'.$v['category_name'].'</option>'.chr(10);
									}
								?>
							</select>
							<select class="select-category form-control">
								<option value="">= 2차 분류 =</option>
							</select>
							<select class="select-category form-control">
								<option value="">= 3차 분류 =</option>
							</select>
							<select class="select-category form-control">
								<option value="">= 4차 분류 =</option>
							</select>
							<select class="select-category form-control">
								<option value="">= 5차 분류 =</option>
							</select>
						</li>
						<li>
							<input type="text" name="keyword" class="form-control" style="width:770px" value="<?=$_sch['keyword']?>" placeholder="제품명"/>	
						</li>						
					</ul>
					<span class="search-btn"><input type="submit" class="btn btn-primary" value="제품검색"/></span>
					</form>
				</div>
			</div>
			<div class="panel-body">
				<div style="margin:10px 0 10px 0">
					<a class="btn btn-danger" href="javascript:del();">선택항목삭제</a>
				</div>
				<table class="table table-striped table-bordered table-hover">
					<colgroup>
						<col width="5%"/>
						<col width="5%"/>
						<col />
						<col width="5%"/>
						<col width="5%"/>
						<col width="5%"/>
						<col width="5%" />
						<col width="10%" />
						<col width="25%" />
						<col/>
					</colgroup>
					<thead class="tb-header">
						<tr>
							<th>선택</th>
							<th>No</th>
							<th>카테고리</th>
							<th>사용여부</th>
							<th>BTOC</th>
							<th>정렬</th>
							<th>재고</th>
							<th>판매가격</th>
							<th>제품명</th>
						</tr>
					</thead>
					<tbody class="tb-body">
						<?php
							foreach($_query->result() as $row){
								$_category = $this->product_model->setting_category(array('parent_id' => 1 ,'product_seq' => $row->seq));
								$_size = get_child_info($row->size);
						?>
						<tr>
							<td><input type="checkbox" class="list-seq" value="<?=$row->seq?>" /></td>
							<td><?=$_list_no?></td>
							<td>
							<?php
								krsort($_category['nav']);
								$_str = array();
								foreach($_category['nav'] as $k => $v){
									$_str[] = $v;
								}

								echo implode(' &gt; ',$_str);
							?>
							</td>
							<td><?=$row->open_yn?></td>
							<td><?=$row->btoc_yn?></td>
							<td>
								<a href="javascript:sortCategory('up',<?=$row->seq?>,<?=$row->sort_no?>)"><i class="fa fa-arrow-up "></i></a>
								<a href="javascript:sortCategory('down',<?=$row->seq?>,<?=$row->sort_no?>)"><i class="fa  fa-arrow-down "></i></a>
							</td>
							<td><?=number_format($row->stock)?></td>
							<td><?=number_format($row->price)?></td>
							<td><a href="/thdadmin/product_form?seq=<?=$row->seq?>&page=<?=$_page?>&language=<?=$row->language?><?=$param?>"><?=$row->product_nm?> (<?=$_size['title']?>)</a></td>
						</tr>
						<?php
								$_list_no--;
							}
						?>
					</tbody>
				</table>
				<div class="row">
					<div class="col-md-6">
						<a class="btn btn-primary" href="/thdadmin/product_form?language=<?=$_language?>" style="margin:20px 0;">제품등록</a>
					</div>
					<div class="col-md-6" align="right">
						<ul class="pagination">
							<?=$_paging?>
						</ul>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<form name="frm" action="/thdadmin/category_dbjob" method="post">
	<input type="hidden" name="dbjob" value="" />
	<input type="hidden" name="category" value="<?=$_sch['category']?>" />
	<input type="hidden" name="seq" value="" />
	<input type="hidden" name="seqs" value="" />
	<input type="hidden" name="sort_no" value="" />
	<input type="hidden" name="language" value="<?=$_language?>" />
</form>
<script type="text/javascript">
	//<![CDATA[ 
	function del(){
		var s='';
		$(".list-seq:checked").each(function(){
			s += (s) ? ','+$(this).val() : $(this).val();
		});

		if(!s){
			alert('삭제할제품을 선택해 주세요');
			return;
		}
		
		if(!confirm('삭제하시겠습니까?')) return;
		with(document.frm){
			dbjob.value = "md";
			seqs.value = s;
			action = "/thdadmin/product_dbjob";
			submit();
		}
	}
	function search(){
		with(document.frmSearch){
			$('.select-category').each(function(index){
				if($(this).val())category.value = $(this).val();
			});
		}
	}
	function sortCategory(d,c,s){
		with(document.frm){
			seq.value = c;
			sort_no.value = s;
			dbjob.value = d;
			action = "/thdadmin/product_dbjob";
			submit();
		}
	}

	function setDySelectBox(v,c){
		$.ajax({
			type: "GET",
			url: "/thdadmin/ajax_child_category",
			data: "category="+v,
			success: function(data){
				var prefix = eval('('+data+')');
				if(prefix.category == undefined) return;
				var index = (v.length/2)- 1;
				for(var i=0; i < prefix.category.length; i++){
					$('.select-category').eq(index+1).get(0).options[i+1] = new Option(prefix.category_name[i],prefix.category[i]);				
					if(prefix.category[i] == c.substr(0,prefix.category[i].length)){ 
						$('.select-category:eq('+(index+1)+') option:eq('+(i+1)+')').prop('selected', true); 
					}
				}
			},
			error:function(error){alert('에러');}
		});
	}

	$(document).ready(function(){
		$('.select-category').change(function(){
			var index = $('.select-category').index($(this));
			$.ajax({
				type: "GET",
				url: "/thdadmin/ajax_child_category",
				data: "category="+$(this).val(),
				success: function(data){
					var prefix = eval('('+data+')');
					//초기화
					$('.select-category').each(function(idx){
						if(idx > index){
							selObj = $(this).get(0);
							optList = new Array();
							for(var i=1; i<selObj.length; i++) {
								optList.push(i);
							}

							for(var i=optList.length-1; i>=0; i--) {
								selObj.remove(optList[i]);	
							}
						}
					});

					if(prefix.category == undefined) return;
					for(var i=0; i < prefix.category.length; i++){
						$('.select-category').eq(index+1).get(0).options[i+1] = new Option(prefix.category_name[i],prefix.category[i]);
					}
				},
				error:function(error){alert('에러');}
			});		
		});

		if($("[name=category]").val()){
			var category = $("[name=category]").val();
			var len = category.length;
			for(var i=2; i < len; i+=2){
				setDySelectBox(category.substr(0,i),category);
			}
		}
	});

	//]]>
</script>