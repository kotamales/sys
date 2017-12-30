<!-- start header -->
<header>
	<div class="container" id="top">
		<div class="row">
			<div class="col-md-3 col-sm-4 col-xs-12">
				<p><i class="fa fa-phone"></i><span> Phone</span><?=$this->authentication->get_Preference('telp_kantor');?></p>
			</div>
			<div class="col-md-3 col-sm-4 col-xs-12">
				<p><i class="fa fa-envelope-o"></i><span> Email</span><a href="#"><?=$this->authentication->get_Preference('email_kantor');?></a></p>
			</div>
			<div class="col-md-5 col-sm-4 col-xs-12">
				<ul class="social-icon">
					<li><span>Meet us on</span></li>
					<li><a href="#" class="fa fa-facebook"></a></li>
					<li><a href="#" class="fa fa-twitter"></a></li>
					<li><a href="#" class="fa fa-instagram"></a></li>
					<li><a href="#" class="fa fa-apple"></a></li>
				</ul>
			</div>
		</div>
	</div>
</header>