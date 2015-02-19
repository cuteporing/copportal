<div id="responsive-menu">
	<ul>
		<?php if( count($top_nav) > 0 ): ?>
			<?php foreach ($top_nav as $row): ?>
				<li>
					<a href="<?=base_url().$row['link'] ?>" data-page="<?=$row['slug'] ?>"><?=$row['title'] ?></a>
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