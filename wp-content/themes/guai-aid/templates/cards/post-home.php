<?php
$meta = guai_aid_all_post_meta( get_the_ID() );
?>
<a href="<?php the_permalink();?>" class="card-link d-block h-100">
    <div class="card post-item post-item-<?php the_ID();?>">
        <?php guai_aid_thumbnail(get_the_ID(),'guai-aid-home-thumb','',null,function(){
            ?>
        <div class="posted-on post-date w-auto">
            <time class="entry-date published dt-published" datetime="<?php echo esc_attr(get_the_date('c'));?>">
                <?php echo get_the_date('Y-m-d');?>
            </time>
        </div>
        <?php
        }); ?>
        <div class="card-body">
            <div class="card-content p-3">
                <h3 class="card-title mt-0">
                    <?php the_title(); ?>
                </h3>
                <div class="card-text">
                    <?php the_excerpt();?>
                </div>
                <span class="btn">
                    <?php _e('Continue Reading','guai-aid');?>
                    <i class="ml-2 fas fa-long-arrow-alt-right"></i>
                </span>
            </div>
        </div>
    </div>
</a>