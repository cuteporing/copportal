<?php echo form_open('manage_users_ajax/change_password/') ?>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label><?=$this->lang->line('lbl_password')?></label>
			<input type="hidden" name="id" value="<?php if(isset($id)){ echo $id; } ?>">
			<input type="hidden" name="user_name" value="<?php if(isset($user_name)){ echo $user_name; } ?>">
			<input type="hidden" name="first_name" value="<?php if(isset($first_name)){ echo $first_name; } ?>">
			<input type="password" class="form-control" name="user_password" maxlength="50">
			<p class="error"></p>
		<input type="submit" class="btn btn-warning btn-block " value="Save">

		</div>
	</div>
</div>
<?php echo form_close(); ?>