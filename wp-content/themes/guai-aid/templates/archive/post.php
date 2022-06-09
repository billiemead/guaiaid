<?php edit_post_link('<i class="fas fa-edit mr-1"></i>'.__('Edit Blog Post','guai-aid'),'','','', 'btn btn-dark text-center edit-button left'); ?>
<a href="<?php echo esc_url(get_permalink()); ?>" class="card-link d-block h-100" title="<?php _e('Continue Reading', 'guai-aid');?> <?php the_title();?>">
    <div id="post-<?php the_ID(); ?>" class="card card-item archive-item archive-post-item">
        <div class="row m-0">
            <div class="col-md-6 p-0">
                <?php guai_aid_thumbnail(get_the_ID(),'guai-aid-post-archive'); ?>
            </div>
            <div class="col-md-6 p-0 bg-grey">
                <div class="card-body">
                    <h2 class="card-title mt-0">
                        <?php the_title(); ?>
                    </h2>
                    <ul class="nav card-meta mb-2">
                        <li class="nav-item post-author mr-4">
                            <?php echo get_avatar( get_the_author_meta( 'ID' ), 30 );?>
                            <span class="meta-text fn p-name">
                                <?php echo esc_html(get_the_author());?>
                            </span>
                        </li>
                        <li class="nav-item post-date">
                            <i class="fa fa-clock meta-icon"></i>
                            <time class="published" datetime="<?php echo esc_attr(get_the_date('c'));?>">
                                <?php echo get_the_date();?>
                            </time>
                        </li>
                    </ul>
                    <div class="card-summary">
                        <?php the_excerpt(); ?>
                        <div class="text-right">
                            <sapn class="more-link read-more btn btn-lg btn-outline-danger mt-2">
                                <?php _e('Continue Reading', 'guai-aid');?>
                                <span class="screen-reader-text sr-only">
                                    <?php the_title();?>
                                </span>
                                <i class="fa fa-arrow-right"></i>
                            </sapn>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</a>