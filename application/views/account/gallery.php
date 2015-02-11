<div class="row">
<a class="btn btn-app" data-toggle="modal" data-target="#custom-album-modal">
	<i class="fa fa-picture-o"></i> <?=$this->lang->line('lbl_custom_album')?>
</a>
<a class="btn btn-app" data-toggle="modal" data-target="#event-album-modal">
	<i class="fa fa-calendar-o"></i> <?=$this->lang->line('lbl_custom_event_album')?>
</a>
</div>

<?php if( isset($result_album) ): ?>
	<div class="row">
	<?php foreach ($result_album as $obj): ?>
		<div class="col-md-4">
			<div class="box box-solid">
				<div class="box-header">
					<h3 class="box-title"><?=$obj->title ?></h3>
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
				</div>
			</div>
		</div>
	<?php endforeach; ?>
<?php endif; ?>
