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
			<div style="position:absolute;top:0;right:15px">
			<form>	
			<input type="hidden" name="language" value="<?=$this->language?>">	
				<select  name="keyname" class="form-control" style="width:150px;display:inline">
					<option value="">----------</option>
					<option value="title" <?=($this->input->get('keyname') == 'title') ? 'selected' : null?>>제목</option>
					<option value="content" <?=($this->input->get('keyname') == 'content') ? 'selected' : null?>>내용</option>
				</select>
				<input type="text" class="form-control" name="keyword" style="width:300px;display:inline" value="<?=$this->input->get('keyword')?>" placeholder="검색어"/>
				<input type="submit" class="btn btn-primary" style="margin-top:-5px" value="검 색"/>
			</form>
			</div>
		</div>
		<div class="panel panel-default">
			<!-- <div class="panel-heading">
				Basic Form Elements
			</div> -->
			<div class="panel-body">
				 <div style="margin:10px 0 10px 0">
					<a class="btn btn-danger" href="javascript:del();">선택항목삭제</a>
				</div>
				 <table class="table table-striped table-bordered table-hover">
					<colgroup>
						<col width="5%"/>
						<col width="8%"/>
						<col />
						<col width="20%"/>
						<col width="8%" />
						<col width="8%"/>
					</colgroup>
					<thead class="tb-header">
						<tr>
							<th><input type="checkbox" class="all-check"></th>
							<th>번호</th>
							<th>제목</th>
							<th>일정</th>							
							<th>진행여부</th>
							<th>공개여부</th>
						</tr>
					</thead>
					<tbody class="tb-body">
						<?php
							if ($_query->num_rows() > 0){
								foreach($_query->result() as $row){
									if($row->start_date && $row->end_date){
										$sch = $row->start_date.' ~ '.$row->end_date;
									}else{
										$sch = '상시';
									}
						?>
						<tr>
							<td><input type="checkbox" class="list-seq" value="<?=$row->seq?>" /></td>
							<td><?=$_list_no?></td>
							<td class="title"><a href="/thdadmin/seminar_form?language=<?=$_language?>&seq=<?=$row->seq?>&page=<?=$_page?>"><?=$row->title?></a></td>
							<td><?=$sch?></td>
							<td><?=($row->ing_yn=='y') ? '진행중' : '종료'?></td>
							<td><?=($row->open_yn=='y') ? '공개' : '미공개'?></td>
						</tr>
						<?php
									$_list_no--;
								}
							}else{
								echo '<tr><td colspan="10" align="center" style="background:#fff">등록된 데이터가 없습니다.</td></tr>';
							}
						?>
						
					</tbody>
				</table>
				<div class="row">
					<div class="col-md-6">
						<a class="btn btn-primary" href="/thdadmin/seminar_form?language=<?=$this->language?>" style="margin:20px 0;">등록</a>
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
<form name="frm" action="" method="post">
	<input type="hidden" name="dbjob" value="" />
	<input type="hidden" name="seq" value="" />
	<input type="hidden" name="seqs" value="" />
	<input type="hidden" name="language" value="<?=$this->language?>" />
</form>
<script type="text/javascript">
	//<![CDATA[ 
	function del(){
		var s='';
		$(".list-seq:checked").each(function(){
			s += (s) ? ','+$(this).val() : $(this).val();
		});

		if(!s){
			alert('삭제할 데이터를 선택해 주세요');
			return;
		}
		
		if(!confirm('삭제하시겠습니까?')) return;
		with(document.frm){
			dbjob.value = "md";
			seqs.value = s;
			action = "/thdadmin/seminar_dbjob";
			submit();
		}
	}
	
	$(function(){
		$(".all-check").click(function(){
			if($(this).prop("checked")){				
				$(".list-seq").prop("checked",true);
			}else{
				$(".list-seq").prop("checked",false);
			}
		});
	});
	//]]>
</script>