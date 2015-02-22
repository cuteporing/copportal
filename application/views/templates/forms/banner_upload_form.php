<?php echo form_open_multipart('banner_ajax/upload_photo');?>
<div class="progress sm progress-striped active hide">
	<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
		<span class="sr-only">20% Complete</span>
	</div>
</div>
<input type="hidden" name="upload_photo_path" value="GALLERY">
<input type="hidden" name="banner_id" value="<?php if( isset($banner_id) ){ echo $banner_id; }?>">
<input type="hidden" name="upload_type" value="<?php if( isset($banner_id) ){ echo 'edit'; }else{ echo 'create'; }?>">

<div class="form-group">
	<input type="text" class="form-control"name="banner_title" value="<?php if( isset($banner_title) ){ echo $banner_title; }?>" placeholder="Title">
</div>

<div class="form-group">
	<input type="text" class="form-control"name="banner_subtitle" value="<?php if( isset($subtitle) ){ echo $subtitle; }?>"  placeholder="Description">
</div>
<div class="row">
	<div class="form-group col-md-3">
		<div class="row">
			<div class="checkbox">
					<label data-blind="banner-link" data-blind-single>
						<input type="checkbox" />
						Has button link
					</label>
			</div>
		</div>
	</div>

	<div class="form-group col-md-9 banner-link hide">
		<input type="text" class="form-control"name="banner_link" value="<?php if( isset($link) ){ echo $link; }?>" placeholder="e.g http://localhost/copportal/">
	</div>
</div>

<div class="form-group">
	<label for="userfile">Upload an image</label>
	<input type="file" name="userfile" size="20">
	<p class="error"></p>
</div>

<input type="submit" class="btn btn-success btn-block disabled" value="Save" disabled />

<?php echo form_close(); ?>

<div id="files"></div>