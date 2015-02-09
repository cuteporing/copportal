<div class="row">
<a class="btn btn-app" data-toggle="modal" data-target="#compose-modal">
	<i class="fa fa-edit"></i> Create album
</a>
</div>

<?php if( isset($result_album) ): ?>
	<div class="row">
	<?php foreach ($result_album as $obj): ?>
		<div class="col-md-4">
			<div class="box">
				<div class="box-header"><?=$obj->title ?></div>
				<div class="box-tools pull-right">
					<button class="btn btn-default btn-sm"><i class="fa fa-angle-down"></i></button>
				</div>
				<div class="box-body">

				</div>
			</div>
		</div>
	<?php endforeach; ?>
	</div>
<?php endif; ?>
