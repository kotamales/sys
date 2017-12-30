<?php 
	$err="";
	$hide="hide";
	$option = array('class' => 'form-signin', 'id' => 'form_login');
	if ($this->session->userdata('result_login')){
		$err = $this->session->userdata('result_login');
		$this->session->set_userdata('result_login','');
		$hide="";
	}
	if (validation_errors()){
		$err = validation_errors();
		$hide="";
	}
?>
<!-- start home -->
<div class="bg-slide" style="background:url(<?=img_url('peruri0.jpg');?>)">
	<div class="opc"></div>
	<div id="home" class= "logo text-center">
		<img src="<?=img_url('logo-login.png');?>" width="80">
	</div>
	<?php  echo form_open('auth/login', $option); ?>
	<div class= "row">
		<div class= "col-sm-4 col-sm-offset-4 timer-circle caption-login text-center">
			<div class= "main-text text-center">
				<div class="callout callout-danger <?=$hide;?>">
					<strong>ERROR: </strong>
					<?=$err;?>
				</div>
				<h2 class="top-text"><?=lang('msg_title_auth');?></h2>
				<div class="input-group margin-bottom-sm col-sm-8 col-sm-offset-2 text-center">
					<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
					<input name="username" class="form-control" type="text" placeholder="<?=lang('msg_user_id');?>">
				</div>
				<div class="input-group margin-bottom-sm col-sm-8 col-sm-offset-2 text-center form">
					<span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
					<input name="password" class="form-control" type="password" placeholder="<?=lang('msg_password');?>">
				</div>
				<div class="input-group margin-bottom-sm col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
					<button type="submit" class="btn btn-info"><?=lang('msg_sign_in_to_account');?></button>
				</div>
				<div class="hide input-group margin-bottom-sm col-md-6 col-lg-6 col-sm-8 col-xs-12 pointer" style="width:100%;margin-top:50px;color:white;">
					<span class="text-left" style="float:left;"><strong>Forgot Password</strong></span>
					<span class="pull-right"><strong>Register</strong></span>
				</div>
			</div>
			<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"></div><!-- end of clock -->
		</div><!-- end of timer-circle -->
	</div><!-- end of timer-circle -->
	</form>
</div>
			
<!-- end home -->