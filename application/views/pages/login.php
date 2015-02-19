<div class="form-box" id="login-box">
	<div class="header"><?=$this->lang->line('lbl_sign_in')?></div>
	<?php echo form_open('login') ?>
		<div class="body bg-gray">
			<?=validation_errors('<p class="error">', '</p>') ?>
			<?=$error_msg ?>
			<div class="form-group">
				<input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo set_value('username'); ?>" maxlength="50"/>
			</div>
			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo set_value('password'); ?>" maxlength="50"/>
			</div>
			<!-- <div class="form-group">
				<input type="checkbox" name="remember_me"/> <?=$this->lang->line('lbl_remember_me')?>
			</div> -->
		</div>
		<div class="footer">
			<button type="submit" class="btn bg-olive btn-block"><?=$this->lang->line('lbl_sign_me_in')?></button>
			<!-- <p><a href="forgot_password"><?=$this->lang->line('lbl_forgot_password')?></a></p> -->
			<!-- <a href="register" class="text-center"><?=$this->lang->line('lbl_register_member')?></a> -->
		</div>
	<?php echo form_close(); ?>
</div>