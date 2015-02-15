<?php echo form_open('gallery_ajax/create_album') ?>
	<input type="hidden" name="album_type" value="event">
	<div class="form-group">
		<label><?=$this->lang->line('lbl_album_title')?></label>
		<select class="form-control" name="event">
				<?php foreach ($event_list as $row): ?>
						<?= create_tag('option', $row['title'], array('value'=>$row['event_id'])) ?>
				<?php endforeach ?>
		</select>
		<p class="error"></p>
	</div>

	<div class="form-group">
		<label><?=$this->lang->line('lbl_description')?></label>
		<textarea name="description" rows="6" style="width:100%"></textarea>
		<p class="error"></p>
	</div>

	<input type="submit" class="btn btn-warning btn-block " value="Create">
<?php echo form_close(); ?>