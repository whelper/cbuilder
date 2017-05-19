<?
$cate = set_category($_category,$_parent_id);
?>
<div id="category-controller">
	<div class="box">
		<div class="category-close">X</div>
		<select name="cate[]" multiple class="select-category">
		<?php
			foreach($cate as $k => $v){
				$selected = ($v['category']==substr($category,0,2)) ? 'selected' : '';
				echo '<option value="'.$v['category'].'" '.$selected.'>'.$v['category_name'].'</option>'.chr(10);
			}
		?>
		</select>
		<select name="cate[]" multiple class="select-category"></select>
		<select name="cate[]" multiple class="select-category"></select>
		<select name="cate[]" multiple class="select-category"></select>
		<button class="btn btn-warning" onclick="javascript:attachecategory.addCategory();">추 가</button>
	</div>
</div>			