<?php 
	echo form_open_multipart($this->uri->uri_string,array('id'=>'form_input'));
?>
<section id="main-content">
	<section class="wrapper site-min-height">
		<section class="panel">
              <!--state overview end-->
			<div class="row">
				<aside class="col-md-12">
					<!--user info table start-->
					<section class="panel">
						<div class="panel-body">
							<div class="box box-warning" id="scrollingDiv">
								<div class="box-header" style="z-index:1000;">
								<?=$action;?>
								</div>		
							</div>
						</div>
						
						<div class="panel-body">
							<menu id="nestable-menu" class="pull-right">
								<button type="button" data-action="expand-all">Expand All</button>
								<button type="button" data-action="collapse-all">Collapse All</button>
							</menu>
							<table class="table">
								<tr>
									<td>
									<textarea id="nestable-output" name="nestable-output" class="hide"><?=$source_tree;?></textarea>
									<div class="dd" id="nestable">
										<ol class="dd-list">
											<?php echo $tree;?>
										</ol>
									</div>
									</td>
								</tr>
							</table>
						</div>
					</section>
				</aside>
			</div>
		</section>
	</section>
</section>
<?php echo form_close();?>


<script>
	$(function(){
		$(".edit_modul").click(function(){
			var id = $(this).attr('data-id');
			$("#mdl_"+id).toggle();
		})
		
		$(".title_modul").keyup(function(){
			$(this).closest(".dd3-content").find(".judul").html($(this).val());
		})
		$(".icon_modul").change(function(){
			$(this).closest(".dd3-content").find("i").removeClass().addClass($(this).val());
		})
	})
</script>