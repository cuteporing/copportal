<a class="btn btn-app" data-toggle="modal" data-target="#upload-photo-modal">
	<i class="fa fa-upload"></i> <?=$this->lang->line('lbl_add_photo')?>
</a>

<?php if( isset($banner_list) ): ?>
	<div class="row">
		<?php foreach ($banner_list as $row): ?>
			<div class="col-md-4">
				<div class="box box-solid">
					<div class="box-header">
						<div class="box-tools pull-right">
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="<?=base_url() ?>banner_ajax/delete/<?=$row['banner_id'] ?>" data-ajax="delete" data-del-type="refresh"><?=$this->lang->line('lbl_delete_banner')?></a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="box-body" style="text-align:center;">
						<img src="<?=base_url().$row['file_path'].$row['raw_name'].$row['file_ext'] ?>" style="height:200px; width:100%; max-height:350px; max-width:350px">
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>