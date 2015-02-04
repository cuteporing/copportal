<div class="box box-solid box-primary">
	<div class="box-header">
		<h3 class="box-title"><?=$result_event->title ?></h3>
		<div class="box-tools pull-right">
			<button class="btn btn-warning"> <i class="ion ion-android-person-add"></i> Add a member</button>
			<button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div>
	<div class="box-body">
		<?php if( isset($result_desc) && count($result_desc) > 0 ): ?>
			<?php foreach ($result_desc as $description): ?>
				<?=$description->description ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>