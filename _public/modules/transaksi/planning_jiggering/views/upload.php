<div class="row">
	<div class="col-md-12">
		<div class="table-responsive adv-table" style="width:1000px;overflow: auto; overflow-y: hidden;">
			<table class="table  dt-responsive" style="font-size:90%;" width="100%">
				<thead>
					<tr>
						<th rowspan="2" width="4%" align="center">No</th>
						<th rowspan="2" width="8%" align="center">MESIN</th>
						<th rowspan="2" width="8%" align="center">JENIS</th>
						<th rowspan="2" width="6%" align="center">HEAD</th>
						<th rowspan="2" width="40%" align="center">SHAPE-ITEM-BODY</th>
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
					$mesin_tmp = "";
					$kode_tmp = "";
					$kolAwal1=0;
					$kolAwal2=0;
					$total1=0;
					$total2=0;
					foreach($fields as $key=>$row){ 
						$x = $key+1;
						$mesin="";
						$kode="";
						if ($mesin_tmp!==$row['mesin']){
							$mesin_tmp=$row['mesin'];
							$mesin = $row['mesin'];
						}
						if ($kode_tmp!==$row['kode']){
							$kode_tmp=$row['kode'];
							$kode = $row['kode'];
						}
						?>
						<tr><td><?=$x;?></td>
						<td><?=$kode.form_hidden(array('mesin_no[]'=>$row['mesin_no'], 'jenis_no[]'=>$row['jenis_no'], 'head_no[]'=>$row['head_no'], 'id_edit[]'=>$row['id_edit']));?></td>
						<td><?=$mesin;?></td>
						<td><?=$row['head_no'];?></td>
						<td><?=form_dropdown('item_no[]', $row['cboItem'], $row['item_no']);?></td>
						<td><?=form_input('mould_std[]', $row['mould_std'],'style="width:40px;"  class="text-center"');?></td>
						<td><?=form_input('mould_akt[]', $row['mould_akt'],'style="width:40px;" class="text-center"');?></td>
						<td><?=form_input('jml_cycle[]', $row['jml_cycle'],'style="width:40px;"  class="text-center"');?></td>
						<td><?=form_input('shift[]', $row['shift'],'style="width:40px;"  class="text-center"');?></td>
						<td><?=form_input('plan_down[]', $row['plan_down'],'style="width:40px;"  class="text-center"');?></td>
						<td><?=form_input('total_target[]', $row['total_target'],'style="width:40px"  class="text-center" readonly="readonly"');?></td>
						<td><?=form_input('total_hasil[]', $row['total_hasil'],'style="width:40px;"  class="text-center"');?></td>
						<td><?=form_input('yield[]', $row['yield'],'style="width:40px;"  class="text-center"');?></td>
						<td><?=form_input('lulus_target[]', $row['lulus_target'],'style="width:40px;"  class="text-center" readonly="readonly"');?></td>
						<td><?=form_input('lulus_hasil[]', $row['lulus_hasil'],'style="width:40px;"  class="text-center"');?></td>
						<td><?=form_input('ganti_head[]', $row['ganti_head'],'style="width:150px;" ');?></td>
						<td><?=form_dropdown('mesin_off[]', array(''=>'','off'=>'Off'), $row['mesin_off'],'style="width:40px;"  class="text-center"');?></td>
						<td><?=form_input('keterangan[]', $row['keterangan'],'style="width:150px;"');?></td></tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>