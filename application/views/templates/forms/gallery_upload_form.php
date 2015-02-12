<?php echo form_open_multipart('gallery_ajax/upload_gallery_photo');?>

<div class="form-group">
	<input type="hidden" name="upload_photo_path" value="GALLERY">
	<label for="exampleInputFile">Upload an image</label>
	<input type="file" name="userfile" size="20" id="userfile">
	<p class="error"></p>
</div>
<div class="progress sm progress-striped active hide">
	<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
		<span class="sr-only">20% Complete</span>
	</div>
</div>
<input type="submit" class="btn btn-success btn-block"  value="upload" />

<?php echo form_close(); ?>

<div id="files"></div>