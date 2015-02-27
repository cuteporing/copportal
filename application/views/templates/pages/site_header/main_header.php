<div class="main-header">
	<div class="row">
		<div class="main-header-left col-md-3 col-sm-6 col-xs-8">
			<a id="search-icon" class="btn-left fa fa-search" href="#search-overlay"></a>
			<div id="search-overlay">
				<a href="#search-overlay" class="close-search"><i class="fa fa-times-circle"></i></a>
				<div class="search-form-holder">
					<h2>Type keywords and hit enter</h2>
					<form id="search-forms" action="<?=base_url().$search_link?>">
						<input type="text"  placeholder="" autocomplete="off" id="search-input"/>
					</form>
				</div>
			</div>
			<?php if( $swipper_arrow == true ): ?>
					<a href="#" class="btn-left arrow-left fa fa-angle-left"></a>
					<a href="#" class="btn-left arrow-right fa fa-angle-right"></a>
			<?php endif; ?>
		</div>
		<div class="menu-wrapper col-md-9 col-sm-6 col-xs-4">
			<a href="#" class="toggle-menu visible-sm visible-xs"><i class="fa fa-bars"></i></a>
			<ul class="sf-menu hidden-xs hidden-sm">
				<?php if( count($top_nav) > 0 ): ?>
					<?php foreach ($top_nav as $row): ?>
						<li>
							<a href="<?=base_url().$row['link'] ?>" data-page="<?=$row['slug'] ?>">
								<?php if($row['slug'] == 'login' && isset($logged_in_user)):?>
									<?= $logged_in_user;?>
								<?php else: ?>
									<?=$row['title'] ?>
								<?php endif; ?>
							</a>
							<?php if( count($row['subtab']) > 0 ): ?>
								<ul>
								<?php foreach ($row['subtab'] as $sub): ?>
									<li><a href="<?=base_url().$sub['link'] ?>" data-page="<?=$row['slug'] ?>"><?=$sub['title'] ?></a></li>
								<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</div>