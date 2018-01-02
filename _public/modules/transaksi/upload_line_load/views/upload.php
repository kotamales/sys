<section class="content-header">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url() ?>"><i class="fa fa-dashboard"></i> Awal</a></li>
		<li><a href="/upload-line-load/" class="text-primary">upload-line-load</a></li>
	</ol>
</section>

<div class="page-title">
	<div class="title_left">
		<h3 class="judul_list">Upload Excel</h3>
	</div>
</div>
<div class="x_panel">
	<div class="x_content">
        <input id="fileUpload" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,  application/vnd.ms-excel" type="file" style="display: inline;padding-right: 30px">
        <button id="Preview" type="button" class="btn btn-info btn-flat " style="margin-right:5px;"> Preview</button>
        <button id="Proses" type="button" class="btn btn-success btn-flat " style="margin-right:5px;"> Proses</button>
	</div>
</div>

<div class="x_panel">
	
	<div class="x_title">
		Result
	</div>
	
	<div class="x_content">
		<div class="males__result"></div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		function males_write_table(data_to_write) {
			$('.males__result').empty()
				.append(data_to_write);
		}

		$('#Preview').on('click', function(event) {
			var file_data = $('#fileUpload').prop('files')[0];   
		    var form_data = new FormData();                  
		    form_data.append('file', file_data);
                           
		    $.ajax({
                url: '<?php echo base_url("upload-line-load/preview"); ?>',
                dataType: 'text', 
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(php_script_response){
                    males_write_table(php_script_response); 
                }
		     });
		});

		$('#Proses').on('click', function(event) {
			var file_data = $('#fileUpload').prop('files')[0];   
		    var form_data = new FormData();                  
		    form_data.append('file', file_data);
                           
		    $.ajax({
                url: '<?php echo base_url("upload-line-load/proses"); ?>',
                dataType: 'text', 
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(php_script_response){
                    males_write_table(php_script_response); 
                }
		     });
		});

	});
</script>