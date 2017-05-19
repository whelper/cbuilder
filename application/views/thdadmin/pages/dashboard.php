 <div class="row">
	 <div class="panel-body">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#home" data-toggle="tab">최신 게시물</a></li>
			<!-- <li><a href="#profile" data-toggle="tab">최신 온라인문의</a></li> -->
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<div class="tab-pane fade in active" id="home">
				 <table class="table table-striped table-bordered table-hover">
					<colgroup>
						<col width="20%" />
						<col />
						<col width="15%" />
						<col width="15%"/>
					</colgroup>
					<thead>
						<tr>
							<th>게시판</th>
							<th>제목</th>
							<th>작성자</th>
							<th>등록일</th>
						</tr>
					</thead>
					<tbody>
						<?php
							if ($_board->num_rows() > 0){
								foreach($_board->result() as $row){
						?>
						<tr>
							<td><?=$row->board_name?></td>
							<td><a href="/thdadmin/board_view?menu_id=<?=$row->menu_id?>&language=<?=$_language?>&id=<?=$row->id?>"><?=$row->title?></a></td>
							<td><?=$row->writer?></td>
							<td><?=date('Y.m.d',strtotime($row->register_date))?></td>
						</tr>
						<?php
								}
							}else{
								echo '<tr><td colspan="4" align="center" style="background:#fff">등록된 데이터가 없습니다.</td></tr>';
							}
						?>
						
					</tbody>
				</table>
			</div>
			<div class="tab-pane fade" id="profile">
				 <table class="table table-striped table-bordered table-hover">
					<colgroup>
						<col />
						<col width="15%" />
						<col width="15%"/>
					</colgroup>
					<thead>
						<tr>
							<th>제목</th>
							<th>작성자</th>
							<th>등록일</th>
						</tr>
					</thead>
					<tbody>
						<?php
							if ($_enquiry->num_rows() > 0){
								foreach($_enquiry->result() as $row){
						?>
						<tr>
							<td><?=$row->title?></td>
							<td><?=$row->name?></td>
							<td><?=date('Y.m.d',strtotime($row->regist_date))?></td>
						</tr>
						<?php
								}
							}else{
								echo '<tr><td colspan="3" align="center" style="background:#fff">등록된 데이터가 없습니다.</td></tr>';
							}
						?>
						
					</tbody>
				</table>
			</div>
			
		</div>
	</div>
</div>
<!-- <div class="row">
	 <div class="col-lg-12">
		<div class="panel panel-default">
		<div class="panel-heading">
				웹사이트 접속 통계(GA)
			</div>
			<div class="panel-body">
				<div class="flot-chart">
					  <div id="morris-area-chart"></div>
				</div>
			</div>
		</div>
	</div>
</div> -->

<script type="text/javascript">
	//<![CDATA[
	$(function() {	
		Morris.Area({
			element: 'morris-area-chart',
			data: [<?=$_GA?>],
			xkey: 'period',
			/*ykeys: ['iphone', 'ipad', 'itouch'],
			labels: ['iPhone', 'iPad', 'iPod Touch'],*/
			ykeys: ['users'],
			labels: ['접속인원'],
			pointSize: 3,
			hideHover: 'auto',
			resize: true
		});
	});

	//]]>
</script>


 <!-- <script src="/common/thdadmin/js/morris-data.js"></script>  -->