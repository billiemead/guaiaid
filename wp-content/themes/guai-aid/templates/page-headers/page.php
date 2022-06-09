<?php
    $post_type=guai_aid_post_type();
    $meta=guai_aid_all_post_meta( get_the_ID());
?>
<header class="entry-header page-header position-relative">
    <?php if( function_exists('woocommerce_breadcrumb')){
            woocommerce_breadcrumb();
        }?>
    <h1 class="entry-title page-title">
        <?php the_title();?>
    </h1>
    <hr>
    <?php guai_aid_thumbnail(get_the_ID(),'full','d-print-none my-5'); ?>
    <?php guai_aid_social_share();?>
</header>