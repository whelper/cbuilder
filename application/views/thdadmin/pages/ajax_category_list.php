 <?
 //카테고리 목록 HTML
	function create_category($v){
		$result  = '';
		$result .='<tr class="depth-'.strlen($v['category']).' child-cate" child-cate="'.$v['category'].'">';
		$result .='	<td>'.$v['category'].'</td>';
		
		if($v['parent_id'] == 0){
			$result .='	<td class="cate-depth'.strlen($v['category']).'"> <a href="javascript:void(0)" class="open fold" open-cate="'.$v['category'].'"><i class="fa fa-minus"></i></a> '.$v['category_name'].'</td>';
		}else if($v['is_child'] > 0 ){
			$result .='	<td class="cate-depth'.strlen($v['category']).'"> <a href="javascript:void(0)" class="open" open-cate="'.$v['category'].'"><i class="fa fa-plus"></i></a> '.$v['category_name'].'</td>';
		}else{
			$result .='	<td class="cate-depth'.strlen($v['category']).'">'.$v['category_name'].'</td>';
		}
		$result .='	<td>'.$v['use_yn'].'</td>';
		$result .='	<td>';
		$result .='		<a href="javascript:sortCategory(\'up\',\''.$v['category'].'\','.$v['sort_no'].')"><i class="fa fa-arrow-up "></i></a>';
		$result .='		<a href="javascript:sortCategory(\'down\',\''.$v['category'].'\','.$v['sort_no'].')"><i class="fa  fa-arrow-down "></i></a>';
		$result .='	</td>';
		$result .='	<td>';
		$result .='		<a href="javascript:modifyCategory(\''.$v['category'].'\');" title="수 정"><i class="fa fa-edit"></i></a> ';
		$result .='		<a href="javascript:addChild('.$v['id'].',\''.$v['category'].'\')" title="하위카테고리추가"><i class="fa fa-plus-square-o"></i></a> ';
		$result .='		<a href="javascript:deleteCategory(\''.$v['category'].'\');" title="삭 제"><i class="fa fa-minus-square-o"></i></a> ';
		$result .='	</td>';
		$result .='</tr>';
		return $result;
	}
 ?>
<div class="form-group">
<form name="frm" action="/thdadmin/category_dbjob" method="post">
<input type="hidden" name="dbjob" value="<?=$_dbjob?>" />
<input type="hidden" name="parent_id" value="" />
<input type="hidden" name="sort_no" value="" />
<input type="hidden" name="category" value="<?=$category?>" />
<input type="hidden" name="language" value="<?=$_language?>" />
	<label id="parent-category"></label>
	<input placeholder="카테고리명" name="category_name" value="<?=$category_name?>" style="width:400px;height:33px;">
	<input type="checkbox" name="use_yn" id="use_yn" value="Y" <?=($use_yn =='N') ? '' :'checked';?> /><label for="use_yn">사용</label>
	<a class="btn btn-primary" href="javascript:frmValid()" style="margin:20px 0;">등 록</a>
	<a class="btn btn-danger init" href="?language=<?=$_language?>" style="margin:20px 0;">초기화</a>
	<p class="text-danger">※ 카테고리명을 입력해 주세요</p>
</form>
</div>
 <table class="table table-striped table-bordered table-hover">
	<colgroup>
		<col width="8%"/>
		<col />
		<col width="8%" />
		<col width="8%"/>
		<col width="8%"/>
	</colgroup>
	<thead class="tb-header">
		<tr>
			<th>코드</th>
			<th>카테고리명</th>
			<th>사용여부</th>
			<th>정렬</th>
			<th>관리</th>
		</tr>
	</thead>
	<tbody>
		<?php
			
			$cate = set_category($_category,null);
			foreach($cate as $k => $v){	//1depth
				echo create_category($v);
				$cate = set_category($_category,$v['id']);
				foreach($cate as $k => $v){	//2depth
					echo create_category($v);
					$cate = set_category($_category,$v['id']);
					foreach($cate as $k => $v){	//3depth
						echo create_category($v);
						$cate = set_category($_category,$v['id']);
						foreach($cate as $k => $v){	//4depth
							echo create_category($v);
							$cate = set_category($_category,$v['id']);
							foreach($cate as $k => $v){	//5depth
								echo create_category($v);
							}	//5depth
						}	//4depth
					}	//3depth
				}	//2depth
			}	//1depth
		?>
	</tbody>
</table>