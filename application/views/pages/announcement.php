<div class="row">
    <div class="section-header col-md-12">
        <?php if( $page_header['title']    != '' ){ echo '<h2>'.$page_header['title'].'</h2>'; }?>
        <?php if( $page_header['subtitle'] != '' ){ echo '<span>'.$page_header['subtitle'].'</span>'; }?>
    </div>
</div>

<?php if( isset($announcement_list) ): ?>
    <div class="row">
        <div class="blog-masonry masonry-true">

            <?php foreach ($announcement_list as $row): ?>
                <div class="post-masonry col-md-4 col-sm-6">

                    <?php if( $row['raw_name'] !== '' && !is_null($row['raw_name']) ): ?>
                        <div class="blog-thumb">
                            <img src="<?=base_url().$row['file_path'].$row['raw_name'].$row['file_ext'] ?>" alt="">
                            <div class="overlay-b">
                                <div class="overlay-inner">
                                    <a href="<?=base_url()?>announcement/title/<?=$row['slug']?>" class="fa fa-link"></a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="blog-body">
                        <div class="box-content">
                            <h3 class="post-title"><a href="<?=base_url()?>announcement/title/<?=$row['slug']?>"><?=$row['title']?></a></h3>
                            <span class="blog-meta"><?=$row['date_entered']?></span>
                            <p><?=$row['description'] ?></p>
                        </div>
                    </div>

                </div> <!-- /.post-masonry -->
            <?php endforeach; ?>

        </div>
    </div>
    <?php if( isset($artcore_pagination) ): ?><?=$artcore_pagination?><?php endif; ?>
<?php endif; ?>

<?php if( isset($announcement_single) ): ?>
    <div class="row">
        <?php if( $announcement_single['raw_name'] !== '' && !is_null($announcement_single['raw_name']) ): ?>
            <div class="blog-image col-md-12">
                <img src="<?=base_url().$announcement_single['file_path'].$announcement_single['raw_name'].$announcement_single['file_ext'] ?>" alt="">
            </div> <!-- /.blog-image -->
        <?php endif; ?>
        <div class="blog-info col-md-12">
            <div class="box-content">
                <h2 class="blog-title"><?=$announcement_single['title']?></h2>
                <span class="blog-meta"><?=$announcement_single['date_entered']?></span>
                <?php if( !is_null($announcement_single['description']) ): ?>
                    <p>
                    <?php foreach ($announcement_single['description'] as $row): ?>
                        <?=$row['description'] ?>
                    <?php endforeach; ?>
                    </p>
                <?php endif; ?>
            </div>
        </div> <!-- /.blog-info -->
    </div> <!-- /.row -->
<?php endif; ?>