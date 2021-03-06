<?php if( isset($result) ): ?>
	<?php echo form_open('announcements_ajax/edit/') ?>
	<input  type="text" class="form-control hide" name="announcement_id" value="<?php if(isset($result)){ echo $result['announcement_id']; } ?>">
	<textarea class="hide" id="description_mirror" name="description_mirror">
		<?php if( isset($result_desc) && count($result_desc) > 0 ): ?>
			<?php foreach ($result_desc as $description): ?>
				<?=$description['description'] ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</textarea>
<?php else: ?>
	<?php echo form_open('announcements_ajax/create') ?>
<?php endif; ?>
<div class="row">
	<div class="error_message"></div>
	<!-- LEFT COLUMN -->
	<?php if( isset($result) ): ?>
			<div class="col-md-8">
	<?php else: ?>
			<div class="col-md-12">
	<?php endif;?>

		<!-- EVENT TITLE -->
		<div class="box box-warning">
			<div class="box-header">
				<h3 class="box-title">
					<?php if( isset($result) ): ?>
						<?=$this->lang->line('lbl_edit_announcement')?>
					<?php else: ?>
						<?=$this->lang->line('lbl_create_announcement')?>
					<?php endif; ?>
				</h3>
			</div>
			<div class="box-body">
				<div class="form-group">
					<label><?=$this->lang->line('lbl_announcement_title')?></label>
					<input type="text" class="form-control" name="title" value="<?php if(isset($result)){ echo $result['title']; } ?>" maxlength="150">
					<p class="error"></p>
					<?php if( isset($result) && !is_null($result['raw_name']) ):?>
						<img src="<?=base_url().$result['file_path'].$result['raw_name'].$result['file_ext']?>">
					<?php endif; ?>
				</div>
			</div>
		</div>
		<!-- EVENT DESCRIPTION -->
		<div class='box'>
			<div class='box-header'>
				<h3 class='box-title'><small><?=$this->lang->line('lbl_event_description')?></small></h3>
				<div class="pull-right box-tools">
					<button class="btn btn-default btn-sm" data-widget='collapse' data-toggle="tooltip" onclick="return false;"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class='box-body pad'>
				<textarea class="textarea" id="description" name="description" value="" placeholder="Place some text here" style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<input type="submit" class="btn btn-success btn-block " value="Save">
			</div>
		</div>
	</div><!--//END col-md-8 -->
	<?php if( isset($result) ): ?>

		<div class="col-md-4">
			<a class="btn btn-warning btn-block" data-toggle="modal" data-target="#announcement-upload-modal" data-autoload>
				<i class="fa fa-photo"></i> Upload photo
			</a><br>
		</div>
<?php endif; ?>

</div>
<?php echo form_close(); ?>



