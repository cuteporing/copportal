<?php if( count($banner) > 0 ): ?>
<div class="swiper-container">
    <div class="swiper-wrapper">

    <?php foreach ($banner as $row): ?>
        <div class="swiper-slide" style="background-image: url(<?=base_url().$row['file_path'].$row['raw_name'].$row['file_ext'] ?>);">
            <div class="overlay-s"></div>
            <div class="slider-caption">
                <div class="inner-content">
                    <?php if( $row['title'] != '' && !is_null($row['title']) ): ?><h2><?=$row['title']?></h2><?php endif; ?>
                    <?php if( $row['subtitle'] != '' && !is_null($row['subtitle']) ): ?><p><?=$row['subtitle']?></p><?php endif; ?>
                    <?php if( $row['link_title'] != '' && !is_null($row['link_title']) ): ?>
                        <a href="<?=$row['link']?>" class="main-btn white"><?=$row['link_title']?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    </div>
</div>
<?php endif; ?>