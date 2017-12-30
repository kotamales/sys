 <?php 
	$modul='';
	if (isset($_GET['module'])){
		$modul=$_GET['module'];
		$modul=explode('+', $modul);
		$modul=$modul[count($modul)-1];
	}
	
	$gender = $this->authentication->get_info_user('kelamin');
	$photo = $this->authentication->get_Preference('list_photo');
	if (!$photo){
		$photo = img_url('logo.png');
	}else{
		if (file_exists(staft_path_relative($this->authentication->get_info_user('photo'))) && !empty($this->authentication->get_info_user('photo'))){
			$photo = staft_url($this->authentication->get_info_user('photo'));
		}else{
			$photo = img_url('male.png');
			if ($gender=="P")
				$photo = img_url('female.png');
		}
	}
 ?>
 <div class="col-md-3 left_col">
  <div class="left_col scroll-view">
	<div class="navbar nav_title" style="border: 0;">
	  <a href="<?=base_url();?>" class="site_title" style="text-align:center;">
		<img src="<?=img_url('logo.png');?>" width="70">
		<span><?=$this->authentication->get_Preference('judul_atas');?></span></a>
	</div> 

	<div class="clearfix"></div>

	<!-- menu profile quick info -->
	<div class="profile clearfix">
	  <div class="profile_pic">
		<img src="<?=$photo;?>" alt="..." class="img-circle profile_img">
	  </div>
	  <div class="profile_info">
		<span>Selamat Datang,</span>
		<h2><?=$this->authentication->get_info_user('nama_lengkap');?></h2>
	  </div>
	</div>
	<!-- /menu profile quick info -->

	<br />

	<!-- sidebar menu -->
	<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
	  <div class="menu_section">
		<h3>General</h3>
		<?php echo _build_menu('kiri');?>
	  </div>
	</div>
	<!-- /sidebar menu -->

	<!-- /menu footer buttons -->
	<div class="sidebar-footer hidden-small">
	  <a data-toggle="tooltip" data-placement="top" title="Settings" href="<?=base_url('setting');?>">
		<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
	  </a>
	  <a data-toggle="tooltip" data-placement="top" title="FullScreen">
		<span class="glyphicon glyphicon-fullscreen full_screen" aria-hidden="true"></span>
	  </a>
	  <a data-toggle="tooltip" data-placement="top"  href="<?=base_url('credit');?>">
		<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
	  </a>
	  <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?=base_url('auth/logout');?>">
		<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
	  </a>
	</div>
	<!-- /menu footer buttons -->
  </div>
</div>
<script >
	var data="";
	var sts=0;
	var modul="";
	for(i=1;i<4;i++){
		if (i==1){
			modul ="<?php echo $this->uri->segment(1);?>";
		}else if (i==2){
			modul ="<?php echo $this->uri->segment(1) . '/' . $this->uri->segment(2);?>";
		}else if (i==3){
			modul ="<?php echo $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3);?>";
		}
		
		$('ul.side-menu').each(function() {
			$(this).find('li').each(function(){
				data = $(this).attr('data-modul');
				if (data==modul){
					$(this).addClass('active');
					$(this).parent().closest("li").addClass("active");
					$(this).parent().parent().closest("li").addClass("active");
					$(this).parent().parent().parent().closest("li").addClass("active");
					$(this).parent().parent().parent().parent().closest("li").addClass("active");
					$(this).parent().parent().parent().parent().parent().closest("li").addClass("active");
					
					$(this).parent().closest("ul").css({'display':'block'});
					$(this).parent().closest("ul").closest("ul").css({'display':'block'});
					
					sts=1;
					return false;
				}
			});
		});	
		if(sts==1)
			i=100;
	}
</script>