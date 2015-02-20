<?php if( isset($result) ): ?>
	<div class="row">
		<div class="col-md-8"><h3><?=$result->user_name ?></h3></div>
		<div class="col-md-4">
			<a class="btn btn-warning btn-block" data-toggle="modal" data-target="#change-password-modal">
				<i class="fa fa-lock"></i> Change password
			</a><br>
		</div>
	</div>
<?php endif; ?>
<?php if( isset($result) ): ?>
	<?php echo form_open('manage_users_ajax/edit/') ?>
	<input  type="text" class="form-control hide" name="id" value="<?php if(isset($result->id)){ echo $result->id; } ?>">
<?php else: ?>
	<?php echo form_open('manage_users_ajax/create') ?>
<?php endif; ?>
<div class="row">
	<div class="error_message"></div>
	<!-- LEFT COLUMN -->
	<div class="col-md-8">
		<!-- EVENT TITLE -->
		<div class="box box-warning">
			<div class="box-header">
				<h3 class="box-title">
					<?php if( !isset($result) ): ?>
						<?=$this->lang->line('lbl_create_user')?>
					<?php else: ?>
						<?=$this->lang->line('lbl_edit_user')?>
					<?php endif; ?>
				</h3>
			</div>
			<div class="box-body">
				<?php if( !isset($result) ): ?>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label><?=$this->lang->line('lbl_user_name')?></label>
							<input type="text" class="form-control" name="user_name" value="<?php if(isset($result)){ echo $result->user_name; } ?>" maxlength="50">
							<p class="error"></p>
						</div>
					</div>
					<div class="col-md-6">
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label><?=$this->lang->line('lbl_password')?></label>
							<input type="password" class="form-control" name="user_password" value="<?php if(isset($result)){ echo $result->user_password; } ?>" maxlength="50">
							<p class="error"></p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label><?=$this->lang->line('lbl_re_password')?></label>
							<input type="password" class="form-control" name="re_user_password" value="<?php if(isset($result)){ echo $result->user_password; } ?>" maxlength="50">
							<p class="error"></p>
						</div>
					</div>
				</div>
				<?php else: ?>
					<input type="hidden" class="form-control" name="user_name" value="<?php if(isset($result)){ echo $result->user_name; } ?>" maxlength="50">
					<input type="hidden" class="form-control" name="user_password" value="<?php if(isset($result)){ echo $result->user_password; } ?>" maxlength="50">
					<input type="hidden" class="form-control" name="re_user_password" value="<?php if(isset($result)){ echo $result->user_password; } ?>" maxlength="50">
				<?php endif; ?>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label><?=$this->lang->line('lbl_first_name')?></label>
							<input type="text" class="form-control" name="first_name" value="<?php if(isset($result)){ echo $result->first_name; } ?>" maxlength="30">
							<p class="error"></p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label><?=$this->lang->line('lbl_last_name')?></label>
							<input type="text" class="form-control" name="last_name" value="<?php if(isset($result)){ echo $result->last_name; } ?>" maxlength="30">
							<p class="error"></p>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label><?=$this->lang->line('lbl_street_address')?></label>
					<input type="text" class="form-control" name="address_street" value="<?php if(isset($result)){ echo $result->address_street; } ?>" maxlength="150">
					<p class="error"></p>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label><?=$this->lang->line('lbl_city')?></label>
							<select class="form-control" name="city">
								<?php foreach ($city_list as $row): ?>
									<?php if( isset( $selected ) && $row['city_id'] == $selected['address_city_id'] ): ?>
										<?= create_tag('option', $row['city'], array('value'=>$row['city_id'], 'selected'=>'selected')) ?>
									<?php else: ?>
										<?= create_tag('option', $row['city'], array('value'=>$row['city_id'])) ?>
									<?php endif; ?>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label><?=$this->lang->line('lbl_gender')?></label>
							<select class="form-control" name="gender">
								<?php foreach ($gender_list as $gender): ?>
									<?php if( isset( $selected ) && $gender == $selected['gender'] ): ?>
										<?= create_tag('option', $gender, array('value'=>$gender, 'selected'=>'selected')) ?>
									<?php else: ?>
										<?= create_tag('option', $gender, array('value'=>$gender)) ?>
									<?php endif; ?>
								<?php endforeach ?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<input type="submit" class="btn btn-success btn-block " value="Save">
			</div>
		</div>
	</div><!--//END col-md-8 -->

	<input type="hidden" name="confirm" id="confirm" value="no">

	<!-- RIGHT COLUMN -->
	<div class="col-md-4">
		<?php if( isset($result) ): ?>
			<div class="box box-primary">
				<div class="box-header"><h3 class="box-title"><?=$this->lang->line('lbl_account_status')?></h3></div>
				<div class="box-body">
					<div class="form-group">
						<label>
							<input type="radio" name="status" class="minimal" value="Inactive" <?php if( $result->status == "Inactive"){ echo 'checked'; } ?>/>
							Disabled
						</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<label>
							<input type="radio" name="status" class="minimal" value="Active" <?php if( $result->status == "Active"){ echo 'checked'; } ?>/>
							Active
						</label>
					</div>
				</div>
			</div>

		<?php else: ?>
			<input type="hidden" name="status" class="minimal-red" value="Active" checked/>
		<?php endif; ?>

		<div class="box box-primary">
			<div class="box-header"><h3 class="box-title"><?=$this->lang->line('lbl_contact_details')?></h3></div>
			<div class="box-body">
				<div class="form-group">
					<label><?=$this->lang->line('lbl_email')?></label>
					<div class="input-group">
						<div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>
						<input type="email" name="email" class="form-control" placeholder="sample@example.com"/>
					</div>
				</div>
				<div class="form-group phone">
					<label><?=$this->lang->line('lbl_phone')?></label>
					<div class="input-group">
						<div class="input-group-addon"><i class="fa fa-phone"></i></div>
						<input type="text" name="phone[]" class="form-control" <?php if(isset($phone_list[0])){ ?> value="<?php echo $phone_list[0] ?>" <?php }else{ ?>data-inputmask="'mask': ['9999-999-9999', '+639 99 999 9999']" data-mask <?php } ?>/>
					</div>
				</div>
				<div class="form-group phone hide">
					<label><?=$this->lang->line('lbl_phone')?></label>
					<div class="input-group">
						<div class="input-group-addon"><i class="fa fa-phone"></i></div>
						<input type="text" name="phone[]" class="form-control" <?php if(isset($phone_list[0])){ ?> value="<?php echo $phone_list[0] ?>" <?php }else{ ?>data-inputmask="'mask': ['9999-999-9999', '+639 99 999 9999']" data-mask <?php } ?>/>
					</div>
				</div> 
				<div class="form-group phone hide">
					<label><?=$this->lang->line('lbl_phone')?></label>
					<div class="input-group">
						<div class="input-group-addon"><i class="fa fa-phone"></i></div>
						<input type="text" name="phone[]" class="form-control" <?php if(isset($phone_list[0])){ ?> value="<?php echo $phone_list[0] ?>" <?php }else{ ?>data-inputmask="'mask': ['9999-999-9999', '+639 99 999 9999']" data-mask <?php } ?>/>
					</div>
				</div>
				<button class="btn btn-primary btn-block" data-blind="phone"><i class="fa fa-plus"></i> Add</button>
			</div><!--//END box-body -->
		</div><!--//END box-primary -->
	</div><!--//END col-md-4 -->
</div>
<?php echo form_close(); ?>



