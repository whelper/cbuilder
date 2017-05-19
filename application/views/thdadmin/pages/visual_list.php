<div class="row">
	<div class="col-lg-12">
		<div class="wrap-tab-lang">
			<ul class="nav nav-tabs view-lang">
				<?
				foreach($this->config->item('view_languge') as $k => $v){
					$_css= ($this->language==$k) ? 'active' : '';
					echo '<li lang="'.$k.'" class="'.$_css.'"><a href="?language='.$k.'">'.$v.'</a></li>'.chr(10);
				}
				?>
			</ul>
		</div>
		<div class="panel panel-default">
			<!-- <div class="panel-heading">
			<form name="frmNotice" method="post" action="/thdadmin/notice_alim">
				공지알림표시
				<select name="open_yn" class="form-control notice-alim" style="width:100px;display:inline;margin-left:10px;">
					<option value="n">No</option>
					<option value="y"<?=($open_yn =='y') ? 'selected' : null?>>Yes</option>
				</select>
			</form>
			</div> -->
			
			<div class="panel-body">
				 <div style="margin:10px 0 10px 0">
					<a class="btn btn-danger" href="javascript:del_sel();">선택항목삭제</a>
				</div>
				

				<table class="table table-striped table-bordered table-hover">
					<colgroup>
						<col width="5%"/>
						<col width="5%"/>
						<!-- <col width="10%"/> -->
						<col width="10%" />
						<col width="10%"/>
						<col/>
						<col width="15%"/>
					</colgroup>
					<thead class="tb-header">
						<tr>
							<th><input type="checkbox" class="all-checked" /></th>
							<th>번호</th>
							<!-- <th>분류</th> -->
							<th>표시여부</th>
							<th>순서</th>
							<th>제목</th>
						</tr>
					</thead>
					<tbody class="tb-body">
						<?php
							if ($_query->num_rows() > 0){
								foreach($_query->result() as $row){
						?>	
						<tr>
							<td><input type="checkbox" class="list-seq" value="<?=$row->seq?>" /></td>
							<td><?=$_list_no?></td>
							<!-- <td>
							<?=($row->site == 'c') ? 'BTOC' : 'BTOB'?>	
							</td> -->
							<td><?=$row->open_yn?></td>
							<td><a href="javascript:msort('up',<?=$row->seq?>,<?=$row->sort_no?>)">▲</a> / <a href="javascript:msort('down',<?=$row->seq?>,<?=$row->sort_no?>)">▼</a></td>
							<td><a href="visual_form?language=<?=$_language?>&seq=<?=$row->seq?>&page=<?=$_page?>"><?=$row->title?></a></td>
						</tr>
						<?php
						$_list_no--;
					}
						}else{
							echo '<tr><td colspan="99" align="center" style="background:#fff">등록된 데이터가 없습니다.</td></tr>';
						}
					?>
					</tbody>
				</table>
				<div class="row">
					<div class="col-md-6">
						<a class="btn btn-primary" href="visual_form?language=<?=$_language?>" style="margin:20px 0;">등록</a>
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
<!-- end : .con-box -->
<form name="frm" action="visual_dbjob" method="post">
	<input type="hidden" name="dbjob">
	<input type="hidden" name="seqs">
	<input type="hidden" name="seq">
	<input type="hidden" name="sort_no">
</form>
<script type="text/javascript">
//<![CDATA[
function msort(d,c,s){
	with(document.frm){
		seq.value = c;
		sort_no.value = s;
		dbjob.value = d;
		action = "visual_dbjob";
		submit();
	}
}

function del_sel(){
	if($(".list-seq:checked").length == 0){
		alert('삭제할 항목을 선택해 주세요');
		return;
	}
	del_check();
}

function del_all(){
	$(".list-seq").attr("checked",true);
	del_check();
}

function del_check(){
	if($(".list-seq:checked").length == 0){
		alert('삭제할 항목을 선택해 주세요');
		return;
	}

	var s ='';
	$(".list-seq:checked").each(function(){
		s += (s) ? ','+$(this).val() : $(this).val(); 
	});

	if(!confirm("삭제하시겠습니까?"))return;
	with(document.frm){
		seqs.value = s;
		dbjob.value = "md";
		submit();
	}
}

$(function(){
	$(".notice-alim").change(function(){
		with(document.frmNotice){
			submit();
		}
	});

	$(".all-checked").click(function(){
		if($(this).prop("checked")){
			$(".list-seq").prop("checked",true);
		}else{
			$(".list-seq").prop("checked",false);
		}
	});
});
//]]>

</script>