<div class="row">
    <div class="section-header col-md-12">
        <?php if( $page_header['title']    != '' ){ echo '<h2>'.$page_header['title'].'</h2>'; }?>
        <?php if( $page_header['subtitle'] != '' ){ echo '<span>'.$page_header['subtitle'].'</span>'; }?>
    </div>
</div>
<?php if( isset($event_new_list) ): ?>
<div class="projects-holder-3">
    <?php if( isset($filter) ): ?>
    <div class="filter-categories">
        <ul class="project-filter">
            <?php foreach( $filter as $value ): ?>
                <li class="filter" data-filter="<?=strtolower($value)?>"><span><?=$value?></span></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
    <div class="projects-holder">
        <div class="row">
            <?php foreach( $event_new_list as $row ): ?>
                <div class="col-md-4 project-item mix <?=strtolower($row['filter'])?>">
                    <?php if( !is_null($row['raw_name']) ): ?>
                        <div class="project-thumb">
                            <img src="<?=base_url().$row['file_path'].$row['raw_name'].$row['file_ext']?>" alt="">
                            <div class="overlay-b">
                                <div class="overlay-inner">
                                    <a href="<?=base_url().$row['file_path'].$row['raw_name'].$row['file_ext']?>" class="fancybox fa fa-expand" title="<?=$row['title'] ?>"></a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="box-content project-detail">
                        <h2><a href="<?=base_url().'event/title/'.$row['slug']?>"><?=$row['title'] ?></a></h2>
                        <span class="blog-meta"><?=$row['date_display']?></span><br>
                        <span class="blog-meta"><span class="blue"><?=$row['location']?></span></span>
                        <p><?=$row['description'] ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div> <!-- /.row -->

        <?php if( isset($artcore_pagination) ): ?><?=$artcore_pagination?><?php endif; ?>
        <?php if( isset($btn_load_more) ): ?>
            <div class="load-more">
                <a href="javascript:void(0)" class="load-more">Load More</a>
            </div>
        <?php endif; ?>
    </div> <!-- /.projects-holder -->
</div>
<?php endif; ?>

<?php if( isset($event_single) ): ?>
    <div class="row">
        <?php if( $event_single['raw_name'] !== '' && !is_null($event_single['raw_name']) ): ?>
            <div class="blog-image col-md-8">
                <img src="<?=base_url().$event_single['file_path'].$event_single['raw_name'].$event_single['file_ext'] ?>" alt="">
            </div> <!-- /.blog-image -->
            <div class="box-content col-md-4">
                <?php if( isset($event_single['members']) && !is_null($event_single['members']) ): ?>

                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="blog-info col-md-8">
            <div class="box-content">
                <h2 class="blog-title"><?=$event_single['title']?></h2>
                <span class="blog-meta"><?=$event_single['date_entered']?></span>
                <?php if( isset($event_single['description']) && !is_null($event_single['description']) ): ?>
                    <p>
                    <?php foreach ($event_single['description'] as $row): ?>
                        <?=$row['description'] ?>
                    <?php endforeach; ?>
                    </p>
                <?php endif; ?>
            </div>
        </div> <!-- /.blog-info -->
        <?php if( $event_single['raw_name'] == '' && is_null($event_single['raw_name']) ): ?>
            <div class="box-content col-md-4">
                <?php if( isset($event_single['members']) && !is_null($event_single['members']) ): ?>
                    <ul>
                        <?php foreach ($event_single['members'] as $row): ?>
                            <li><?=$row['first_name']?> <?=$row['last_name']?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div> <!-- /.row -->
<?php endif; ?>