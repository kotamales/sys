<?php 
	echo form_open_multipart(base_url('data-head/proses-import'),array('id'=>'form_input'));
?>

<div class="row">
	<aside class="col-md-12">
		<section class="box box-warning">
			<div class="box-header ui-sortable-handle" style="cursor: move;">
				<i class="ion ion-clipboard"></i>
				<h3 class="box-title text-warning"><strong>Proses Import</strong></h3>
			</div>
			<div class="panel-body">
				<p>Proses Import adalah proses memasukkan data yang telah dientri pada file excel dengan format yang telah ditentukan oleh sistem kedalam database, ketentuan dalam proses import:</p>
				<ul>
				<li>Data yang akan di proses hanya data baru, sedangkan untuk data yang sudah pernah di import sebelumnya dapat di edit melalui menu Setup - Data Kode.</li>
				<li>Untuk memulai Import klik tombol Browse dibawah, selanjutnya pilih file yang akan di import</li>
				<li>klik tombol Proses Import untuk mulai mengemport data</li>
				</ul>
				<table class="table">
					<tr><td><?=form_upload('file_import');?></td></tr>
					<tr><td><input type="submit" class="btn btn-warning" id="proses_import" style="width:100% !important;"	value="Memulai Proses Import"></td></tr>
				</table>
			</div>
		</section>
	</aside>
</div>
<?php echo form_close();?>