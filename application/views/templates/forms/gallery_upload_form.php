<?php echo form_open_multipart('upload/upload_gallery_photo');?>

<div class="form-group">
    <input type="hidden" name="upload_path" value="GALLERY">
    <label for="exampleInputFile">Upload an image</label>
    <input type="file" name="userfile" size="20" id="userfile">
    <p class="error"></p>
</div>
<input type="submit" class="btn btn-success btn-block"  value="upload" />

<?php echo form_close(); ?>

<div id="files"></div>