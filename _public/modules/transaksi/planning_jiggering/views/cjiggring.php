<table class="table" border="1" style="font-size:90%;" width="100%">
	<thead>
		<tr>
			<th rowspan="2" width="2%" align="center">No</th>
			<th rowspan="2" width="8%" align="center">MESIN</th>
			<th rowspan="2" width="8%" align="center">JENIS</th>
			<th rowspan="2" width="6%" align="center">HEAD</th>
			<th rowspan="2" width="20%" align="center">SHAPE-ITEM-BODY</th>
			<th colspan="2" width="10%" align="center">MOULD</th>
			<th rowspan="2" width="10%" align="center">JMLH CYCLE</th>
			<th rowspan="2" width="10%" align="center">SHIFT</th>
			<th rowspan="2" width="10%" align="center">PLAN DOWN TIME</th>
			<th colspan="2" width="10%" align="center">TOTAL CETAK</th>
			<th rowspan="2" width="10%" align="center">TARGET YIELD CETAK</th>
			<th colspan="2" width="10%" align="center">LULUS CETAK</th>
			<th rowspan="2" width="20%" align="center">GANTI HEAD</th>
			<th rowspan="2" width="10%" align="center">MESIN OFF</th>
			<th rowspan="2" width="25%" align="center">KETERANGAN</th>
		</tr>
		<tr>
			<th>STD</th>
			<th>AKT</th>
			<th>TARGET</th>
			<th>HASIL</th>
			<th>TARGET</th>
			<th>HASIL</th>
		</tr>
	</thead>
	</tbody>
		<?php
		$total1=0;
		$total2=0;
		foreach($fields as $key=>$row){ 
			$x = $key+1;
			$total1 +=floatval($row['total_target']);
			$total2 +=floatval($row['lulus_target']);
			?>
			<tr><td><?=$x;?></td>
			<td><?=$row['kode'];?></td>
			<td><?=$row['mesin'];?></td>
			<td><?=$row['head_no'];?></td>
			<td><?=$row['item_ket'];?></td>
			<td><?=$row['mould_std'];?></td>
			<td><?=$row['mould_akt'];?></td>
			<td><?=$row['jml_cycle'];?></td>
			<td><?=$row['shift'];?></td>
			<td><?=$row['plan_down'];?></td>
			<td><?=$row['total_target'];?></td>
			<td><?=$row['total_hasil'];?></td>
			<td><?=$row['yield'];?></td>
			<td><?=$row['lulus_target'];?></td>
			<td><?=$row['lulus_hasil'];?></td>
			<td><?=$row['ganti_head'];?></td>
			<td><?=$row['mesin_off'];?></td>
			<td><?=$row['keterangan'];?></td></tr>
		<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="7"><?=$x;?></td>
			<td colspan="3">Total</td>
			<td><?=$total1;?></td>
			<td></td>
			<td></td>
			<td><?=$total2;?></td>
			<td colspan="6"><?=$row['yield'];?></td>
		</tr>
		<tr>
			<td colspan="7"><?=$note;?></td>
			<td colspan="7"></td>
			<td colspan="2"><?=$note1;?></td>
			<td ><?=$note2;?></td>
		</tr>
	</tfoot>
</table>