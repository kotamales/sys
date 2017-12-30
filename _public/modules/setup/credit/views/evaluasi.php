<?php 
	echo form_open_multipart($this->uri->uri_string,array('id'=>'form_input'));
?>
<!-- Main content -->
<section class="content-header">
  <h1>
	Master Evaluasi Rumah Susun
  </h1>
  <ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	<li><a href="#">Evaluasi Rusun</a></li>
  </ol>
</section>

<section class="content">

	<div class="box box-warning" id="scrollingDiv">
		<div class="box-header" style="z-index:1000;">
		<?=$action;?>
		</div>		
	</div>
						
	<section class="box box-primary box-header">
		<section class="panel">
              <!--state overview end-->
			<div class="row">
				<aside class="col-md-12">
					<!--user info table start-->
					<table class="table table-bordered table-striped table-hover dataTable data table-small-font dt-responsive">
						<thead>
							<tr>
								<th>No.</th>
								<th>Tahapan</th>
								<th>Object</th>
								<th>Bobot</th>
								<th>Indikator</th>
								<th>Bobot</th>
								<th>Parameter</th>
								<th>Bobot</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$no=0;
						$kegiatan_tmp="";
						$kegiatan="";
						$object_tmp="";
						$object="";
						foreach($field as $row){ 
							$kegiatan="";
							$object="";
							if ($kegiatan_tmp!==$row['nama_kegiatan']){
								$kegiatan = $row['nama_kegiatan'];
								$kegiatan_tmp = $row['nama_kegiatan'];
							}
							if ($object_tmp!==$row['nama_objek']){
								$object = $row['nama_objek'];
								$object_tmp = $row['nama_objek'];
							}
							?>
							<tr>
								<td><?=++$no;?></td>
								<td><?=$kegiatan;?></td>
								<td><?=$object;?></td>
								<td class="text-right"><?=($row['object_bobot']>0)?$row['object_bobot']:'';?></td>
								<td><?=$row['indikator'];?></td>
								<td class="text-right"><?=($row['indikator_bobot']>0)?$row['indikator_bobot']:'';?></td>
								<td><?=$row['param'];?></td>
								<td class="text-right"><?=($row['param_bobot']>0)?$row['param_bobot']:'';?></td>
								<td><a href="<?=base_url(_MODULE_NAME_.'/edit/'.$row['id']);?>">Edit</a></td>
							</tr>
						<?php } ;?>
						</tbody>
					</table>
				</aside>
			</div>
		</section>
	</section>
</section>
<?php echo form_close();?>