<?php
/* Template Name: Woocommerce */
    if ( !defined( 'ABSPATH' ) ) {
        exit;
    }
    get_header();
?>
<div id="site-content" class="my-md-5">
    <div class="container">
        <?php while ( have_posts() ):
    the_post();
?>
        <article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="page-header mb-5">
                <?php if( function_exists('woocommerce_breadcrumb')){
            woocommerce_breadcrumb();
        }?>
                <h1 class="page-title">
                    <?php the_title();?>
                </h1>
                <?php guai_aid_social_share();?>
                <hr>
            </div>
            <?php if ( !empty( get_the_content() ) ){  ?>
            <div class="page-section pt-0">
                <?php the_content(); ?>
            </div>
            <?php }?>
        </article>
        <?php endwhile; ?>
    </div>
</div>
<?php get_footer();?>