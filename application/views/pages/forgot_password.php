<div class="form-box" id="login-box">
	<div class="header"><?=$this->lang->line('lbl_forgot_password')?></div>
	<form action="login" method="post">
		<div class="body bg-gray">
			<div class="form-group">
				<input type="email" name="email" class="form-control" placeholder="Email"/>
			</div>
		</div>
		<div class="footer">
			<button type="submit" class="btn bg-olive btn-block"><?=$this->lang->line('lbl_retrieve_password')?></button>
			<a href="login" class="text-center"><?=$this->lang->line('lbl_sign_in')?></a>
		</div>
	</form>

<!-- 	<div class="margin text-center">
		<span>Sign in using social networks</span>
		<br/>
		<button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>
		<button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>
		<button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>
	</div> -->
</div>