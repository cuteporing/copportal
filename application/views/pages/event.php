<div class="row">
    <div class="section-header col-md-12">
        <?php if( $page_header['title']    != '' ){ echo '<h2>'.$page_header['title'].'</h2>'; }?>
        <?php if( $page_header['subtitle'] != '' ){ echo '<span>'.$page_header['subtitle'].'</span>'; }?>
    </div>
</div>
<?php if( isset($event_new_list) ): ?>
<div class="projects-holder-3">
    <div class="filter-categories">
        <ul class="project-filter">
            <li class="filter" data-filter="all"><span>All</span></li>
        </ul>
    </div>
    <div class="projects-holder">
        <div class="row">
            <div class="col-md-4 project-item mix design">
                <div class="project-thumb">
                    <img src="images/projects/project_1.jpg" alt="">
                    <div class="overlay-b">
                        <div class="overlay-inner">
                            <a href="images/projects/project_1.jpg" class="fancybox fa fa-expand" title="Project Title Here"></a>
                        </div>
                    </div>
                </div>
                <div class="box-content project-detail">
                    <h2><a href="project-details.html">Lamps by Monica Correia</a></h2>
                    <p>Nullam a vehicula tellus. Integer sodales ante eu feugiat. Sed fermentum diam dui at.</p>
                </div>
            </div>
        </div> <!-- /.row -->

        <?php if( isset($btn_load_more) ): ?>
            <div class="load-more">
                <a href="javascript:void(0)" class="load-more">Load More</a>
            </div>
        <?php endif; ?>
    </div> <!-- /.projects-holder -->
</div>
<?php endif; ?>