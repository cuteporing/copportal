<div class="row">
    <div class="section-header col-md-12">
        <?php if( $page_header['title']    != '' ){ echo '<h2>'.$page_header['title'].'</h2>'; }?>
        <?php if( $page_header['subtitle'] != '' ){ echo '<span>'.$page_header['subtitle'].'</span>'; }?>
    </div>
</div>
<div class="row">
<?php if( isset($album_list) ): ?>
    <div class="projects-holder col-md-12 col-sm-9">
        <div class="row">
            <?php foreach( $album_list as $row ): ?>
                <?php if( !is_null($row['cover_photo_id']) ):?>
                <div class="col-md-4 col-sm-4 project-item mix design">
                    <div class="project-thumb">
                        <img src="<?=base_url().$row['file_path'].$row['raw_name'].$row['file_ext'] ?>" alt="">
                        <div class="overlay-b">
                            <div class="overlay-inner">
                                <a href="<?=base_url().$row['file_path'].$row['raw_name'].$row['file_ext'] ?>" class="fancybox fa fa-expand" title="<?=$row['title']?>"></a>
                            </div>
                        </div>
                    </div>
                    <div class="box-content project-detail">
                        <h2><a href="<?=base_url().'galleries/title/'.$row['slug']?>"><?=$row['title']?></a></h2>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php if( isset($artcore_pagination) ): ?><?=$artcore_pagination?><?php endif; ?>
<?php endif; ?>


<?php if( isset($album_single) && $album_single['photos'] != ''): ?>
    <?php foreach( $album_single['photos'] as $row ): ?>
        <div class="col-md-4 col-sm-4 project-item mix design">
            <div class="project-thumb">
                <img src="<?=base_url().$row['file_path'].$row['raw_name'].$row['file_ext'] ?>" alt="">
                <div class="overlay-b">
                    <div class="overlay-inner">
                        <a href="<?=base_url().$row['file_path'].$row['raw_name'].$row['file_ext'] ?>" class="fancybox fa fa-expand" title="<?=$album_single['title']?>"></a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if( isset($artcore_pagination) ): ?><?=$artcore_pagination?><?php endif; ?>
<?php endif; ?>
</div>
