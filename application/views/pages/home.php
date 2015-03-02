<?php if( isset($banner) && count($banner) > 0 ): ?>
<div class="swiper-container" style="width: 100% !important;">
    <div class="swiper-wrapper">

    <?php foreach ($banner as $row): ?>
        <div class="swiper-slide" style="background-image: url(<?=base_url().$row['file_path'].$row['raw_name'].$row['file_ext'] ?>);">
            <div class="overlay-s"></div>
            <div class="slider-caption">
                <div class="inner-content">
                    <?php if( $row['title'] != '' && !is_null($row['title']) ): ?><h2><?=$row['title']?></h2><?php endif; ?>
                    <?php if( $row['subtitle'] != '' && !is_null($row['subtitle']) ): ?><p><?=$row['subtitle']?></p><?php endif; ?>
                    <?php if( $row['link'] != '' && !is_null($row['link']) ): ?>
                        <a href="<?=$row['link']?>" class="main-btn white"><?=$row['link_title']?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-6">
        <div class="calendar-container">
            <div class="calendar">
                <header>
                    <h2 class="month"></h2>
                    <!-- <a class="btn-prev fontawesome-angle-left" href="#"></a> -->
                    <!-- <a class="btn-next fontawesome-angle-right" href="#"></a> -->
                </header>
                <table>
                    <thead>
                        <tr><td>Mon</td><td>Tues</td><td>Wed</td><td>Thurs</td><td>Fri</td><td>Sat</td><td>Sun</td></tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="col-md-5">
       <div class="list">
        </div>
    </div>
</div>