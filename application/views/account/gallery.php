<div class="row">
<?php if( $btn_upload == 'show' ): ?>
<a class="btn btn-app" href="<?=base_url().'account/gallery/'?>">
	<i class="fa fa-picture-o"></i> <?=$this->lang->line('lbl_view_gallery')?>
</a>
<?php endif; ?>

<a class="btn btn-app" data-toggle="modal" data-target="#custom-album-modal">
	<i class="fa fa-picture-o"></i> <?=$this->lang->line('lbl_custom_album')?>
</a>
<a class="btn btn-app" data-toggle="modal" data-target="#event-album-modal">
	<i class="fa fa-calendar-o"></i> <?=$this->lang->line('lbl_custom_event_album')?>
</a>
<?php if( $btn_upload == 'show' ): ?>
<a class="btn btn-app" data-toggle="modal" data-target="#upload-photo-modal">
	<i class="fa fa-upload"></i> <?=$this->lang->line('lbl_add_photo')?>
</a>
<?php endif; ?>
</div>

<?php if( isset($result_album) ): ?>
	<div class="row">
	<?php foreach ($result_album as $obj): ?>
		<div class="col-md-4">
			<div class="box box-solid">
				<div class="box-header">
					<h3 class="box-title"><a href="<?=base_url() ?>account/gallery/<?=$obj->slug ?>"><?=$obj->title ?></a></h3>
					<div class="box-tools pull-right">
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								<li><a href="<?=base_url() ?>gallery_ajax/edit_album"><?=$this->lang->line('lbl_edit_album')?></a></li>
								<li><a href="<?=base_url() ?>gallery_ajax/delete_album/<?=$obj->gallery_id ?>" data-ajax="delete" data-del-type="refresh"><?=$this->lang->line('lbl_delete_album')?></a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="box-body">
					<?php if( is_null($obj->cover_photo_id) ): ?>
						<img src="<?=base_url().'assets/img/noPhoto-icon.png' ?>">
					<?php else: ?>
						<?php if( $obj->file_path !== '' && !is_null($obj->file_path)): ?>
							<img src="<?=base_url().$obj->file_path.$obj->raw_name.$obj->file_ext ?>">
						<?php else: ?>
							<img src="<?=base_url().'assets/img/noPhoto-icon.png' ?>">
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
	</div>
<?php endif; ?>

<?php if( isset($result_album_photos) ): ?>
	<div class="row">
		<?php foreach ($result_album_photos as $obj): ?>
			<div class="col-md-3">
				<div class="box box-solid">
					<div class="box-header">
						<div class="box-tools pull-right">
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="<?=base_url() ?>gallery_ajax/cover_photo/<?=$obj->gallery_photos_id ?>" data-ajax="delete" data-del-type="refresh"><?=$this->lang->line('lbl_set_as_cover')?></a></li>
									<li><a href="<?=base_url() ?>gallery_ajax/delete_photo/<?=$obj->gallery_photos_id ?>" data-ajax="delete" data-del-type="refresh"><?=$this->lang->line('lbl_delete_photo')?></a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="box-body">
						<img src="<?=base_url().$obj->file_path.$obj->raw_name.$obj->file_ext ?>">
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>