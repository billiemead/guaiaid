<?php
$meta = guai_aid_all_post_meta( get_the_ID() );
?>
<a href="<?php the_permalink();?>" class="card-link d-block h-100">
    <div class="card post-item post-item-<?php the_ID();?>">
        <?php guai_aid_thumbnail(get_the_ID(),'guai-aid-home-thumb','',null,function(){
            ?>
        <div class="posted-on post-date w-auto">
            <i class="far fa-calendar-alt meta-icon"></i>
            <time class="entry-date published dt-published" datetime="<?php echo esc_attr(get_the_date('c'));?>">
                <?php echo get_the_date();?>
            </time>
        </div>
        <?php
        }); ?>
        <div class="card-body">
            <div class="card-content">
                <h3 class="card-title mt-0">
                    <?php the_title(); ?><br>
                </h3>
                <div class="card-text">
                    <?php the_excerpt();?>
                </div>
            </div>
        </div>
        <div class="card-footer bg-transparent border-0 mt-0 pt-0">
            <span class="d-block btn btn-lg btn-outline-secondary btn-block">
                <?php _e('Continue Reading','guai-aid');?>
            </span>
        </div>
    </div>
</a>