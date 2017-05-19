<table class="table table-striped table-bordered table-hover">
<colgroup>
	<col width="15%"/>
	<col />
	<col width="15%" />
	<col width="15%" />
	<col width="15%"/>
</colgroup>
<thead class="tb-header">
<tr class="warning">
	<th>코드</th>
	<th>코드명</th>
	<th>비고1</th>
	<th>비고2</th>
	<th>비고3</th>
</tr>
</thead>
<tbody>
<?
foreach($_query->result() as $row)
{
	$cssUseYN = ($row->open_yn == 'n') ? 'trUseOff' : '';
?>
<tr class="row-data-child <?=$cssUseYN?>" data-master-id="<?=$row->master_id?>">
	<td class="code_id"><?=$row->code_id?></td>
	<td><?=$row->title?></td>
	<td><?=$row->etc1?></td>
	<td><?=$row->etc2?></td>
	<td><?=$row->etc3?></td>
</tr>
<?
}
?>
</tbody>
</table>
