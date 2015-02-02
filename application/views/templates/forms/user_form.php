
<?php if( isset($result) ): ?>
	<?php echo form_open('manage_users_ajax/edit/') ?>
	<input  type="text" class="form-control hide" name="id" value="<?php if(isset($result)){ echo $result->id; } ?>">
<?php else: ?>
	<?php echo form_open('manage_users_ajax/create') ?>
<?php endif; ?>
<div class="row">
	<div class="error_message"></div>
	<!-- LEFT COLUMN -->
	<div class="col-md-8">
		<!-- EVENT TITLE -->
		<div class="box box-warning">
			<div class="box-header"><h3 class="box-title"><?=$this->lang->line('lbl_create_user')?></h3></div>
			<div class="box-body">
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
							<input type="password" class="form-control" name="re_user_password" value="<?php if(isset($result)){ echo $result->re_user_password; } ?>" maxlength="50">
							<p class="error"></p>
						</div>
					</div>
				</div>

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
		<div class="box box-danger">
			<div class="box-header"><h3 class="box-title"><?=$this->lang->line('lbl_disable_account')?></h3></div>
			<div class="box-body">
				<div class="form-group">
					<label>
						<input type="radio" name="status" class="minimal-red" value="Inactive"/>
						Yes
					</label>
					<label>
						<input type="radio" name="status" class="minimal-red" value="Active" checked/>
						No
					</label>
				</div>
			</div><!--//END box-body -->
		</div><!--//END box-primary -->

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
						<input type="text" name="phone[]" class="form-control" data-inputmask="'mask': ['9999-999-9999', '+639 99 999 9999']" data-mask/>
					</div>
				</div>
				<div class="form-group phone hide">
					<label><?=$this->lang->line('lbl_phone')?></label>
					<div class="input-group">
						<div class="input-group-addon"><i class="fa fa-phone"></i></div>
						<input type="text" name="phone[]" class="form-control" data-inputmask="'mask': ['9999-999-9999', '+639 99 999 9999']" data-mask/>
					</div>
				</div> 
				<div class="form-group phone hide">
					<label><?=$this->lang->line('lbl_phone')?></label>
					<div class="input-group">
						<div class="input-group-addon"><i class="fa fa-phone"></i></div>
						<input type="text" name="phone[]" class="form-control" data-inputmask="'mask': ['9999-999-9999', '+639 99 999 9999']" data-mask/>
					</div>
				</div>
				<button class="btn btn-primary btn-block" data-blind="phone"><i class="fa fa-plus"></i> Add</button>
			</div><!--//END box-body -->
		</div><!--//END box-primary -->
	</div><!--//END col-md-4 -->


</div>
<?php echo form_close(); ?>



