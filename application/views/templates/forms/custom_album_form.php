<?php echo form_open('gallery_ajax/create_album') ?>
	<input type="hidden" name="album_type" value="custom">
	<div class="form-group">
		<label><?=$this->lang->line('lbl_album_title')?></label>
		<input type="text" class="form-control" name="title" value="<?php if(isset($result)){ echo $result->title; } ?>" maxlength="30">
		<p class="error"></p>
	</div>

	<div class="form-group">
		<label><?=$this->lang->line('lbl_description')?></label>
		<textarea name="description" rows="6" style="width:100%"></textarea>
		<p class="error"></p>
	</div>

	<input type="submit" class="btn btn-warning btn-block " value="Create">
<?php echo form_close(); ?>