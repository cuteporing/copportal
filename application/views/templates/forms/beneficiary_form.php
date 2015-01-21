
<?php if( isset($result) ): ?>
	<?php echo form_open('manage_beneficiary_ajax/edit/') ?>
	<input  type="text" class="form-control hide" name="id" value="<?php if(isset($result)){ echo $result->id; } ?>">
<?php else: ?>
	<?php echo form_open('manage_beneficiary_ajax/create') ?>
<?php endif; ?>
<div class="row">
	<div class="error_message"></div>
	<!-- LEFT COLUMN -->
	<div class="col-md-8">
		<!-- EVENT TITLE -->
		<div class="box box-warning">
			<div class="box-header"><h3 class="box-title"><?=$this->lang->line('lbl_add_beneficiary')?></h3></div>
			<div class="box-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label><?=$this->lang->line('lbl_first_name')?></label>
							<input type="text" class="form-control" name="first_name" value="<?php if(isset($result)){ echo $result->first_name; } ?>" maxlength="50">
							<p class="error"></p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label><?=$this->lang->line('lbl_last_name')?></label>
							<input type="text" class="form-control" name="last_name" value="<?php if(isset($result)){ echo $result->last_name; } ?>" maxlength="50">
							<p class="error"></p>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label><?=$this->lang->line('lbl_street_address')?></label>
					<input type="text" class="form-control" name="first_name" value="<?php if(isset($result)){ echo $result->address_street; } ?>" maxlength="150">
					<p class="error"></p>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label><?=$this->lang->line('lbl_city')?></label>
							<select class="form-control" name="city">
								<?php foreach ($city_list as $row): ?>
									<?php if( isset( $selected ) && $row['address_city_id'] == $selected['city_id'] ): ?>
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
	<!-- RIGHT COLUMN -->
	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-header"><h3 class="box-title"><?=$this->lang->line('lbl_contact_details')?></h3></div>
			<div class="box-body">
				<div class="form-group">
					<label><?=$this->lang->line('lbl_street_address')?></label>
					<input type="text" class="form-control" name="first_name" value="<?php if(isset($result)){ echo $result->address_street; } ?>" maxlength="150">
					<p class="error"></p>
				</div>
			</div><!--//END box-body -->
		</div><!--//END box-primary -->
	</div><!--//END col-md-4 -->
</div>
<?php echo form_close(); ?>



