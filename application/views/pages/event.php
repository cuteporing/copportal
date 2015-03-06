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
                        <?php if( isset($row['status_display']) ): ?><?=$row['status_display']?><br><?php endif; ?>
                        <span class="blog-meta"><?=$row['date_display']?> <small style="font-size:11px; color:rgb(184, 184, 184);"><?=$row['time_start']?> - <?=$row['time_end']?></small></span><br>
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
                <h3>Beneficiaries</h3>
                <?php if( isset($event_single['members']) && !is_null($event_single['members']) ): ?>
                    <?php $counter = 1;?>
                    <ul>
                        <?php foreach ($event_single['members'] as $row): ?>
                            <li class="lined-list"><span class="small-inline-flex"><?=$counter?></span><?=$row['first_name']?> <?=$row['last_name']?></li>
                            <?php $counter++ ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <?php if( count($event_single['members']) == 0 ): ?>
                 No Beneficiary
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="blog-info col-md-8">
            <div class="box-content">
                <h2 class="blog-title"><?=$event_single['title']?></h2>
                <span class="blog-meta">
                    <?php if( !is_null($event_single['date_display']) && $event_single['date_display'] !== ''): ?>
                        WHEN : <?=$event_single['date_display']?><br>
                    <?php endif; ?>
                    <?php if( !is_null($event_single['time_start']) && $event_single['time_start'] !== ''): ?>
                        START: <?=$event_single['time_start']?><br>
                    <?php endif; ?>
                    <?php if( !is_null($event_single['time_end']) && $event_single['time_end'] !== ''): ?>
                        END &nbsp;&nbsp;&nbsp;: <?=$event_single['time_end']?><br>
                    <?php endif; ?>
                    <?php if( !is_null($event_single['location']) && $event_single['location'] !== ''): ?>
                        VENUE: <?=$event_single['location']?><br>
                    <?php endif; ?>
                </span>
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
                <h3>Beneficiaries</h3>
                <?php if( isset($event_single['members']) && !is_null($event_single['members']) ): ?>
                    <?php $counter = 1;?>
                    <ul>
                        <?php foreach ($event_single['members'] as $row): ?>
                            <li class="lined-list"><span class="small-inline-flex"><?=$counter?></span><?=$row['first_name']?> <?=$row['last_name']?></li>
                            <?php $counter++ ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <?php if( count($event_single['members']) == 0 ): ?>
                 No Beneficiary
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div> <!-- /.row -->
<?php endif; ?>


<?php if( !isset($event_new_list) && !isset($event_single)): ?>
<div class="projects-holder col-md-12 col-sm-9">
        <div class="row">
                <p class="text-center"><img src="<?=base_url()?>assets/img/trash.png" style="margin: 0 auto;"> No event</p>
        </div>
</div>
<?php endif; ?>