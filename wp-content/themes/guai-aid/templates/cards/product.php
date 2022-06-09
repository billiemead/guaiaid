<?php
$meta = guai_aid_all_post_meta( get_the_ID() );
 global $product;
 $rating_count=0;
 if (  wc_review_ratings_enabled() ) {
    $rating_count = $product->get_rating_count();
    $review_count = $product->get_review_count();
    $average      = $product->get_average_rating();
}
?>
<div class="card product-item product-item-<?php the_ID();?> ">
    <a href="<?php the_permalink();?>" class="card-link d-block mb-2">
        <?php woocommerce_show_product_sale_flash();?>
        <?php guai_aid_thumbnail(get_the_ID(),'guai-aid-home-thumb','',null, null, '',content_url().'/uploads/woocommerce-placeholder-300x300.png'); ?>
    </a>
    <div class="card-body p-0">
        <div class="prod-info d-flex">
            <div class="text-left pe-md-2">
                <h3 class="card-title m-0">
                    <?php the_title(); ?>
                </h3>
                <?php /*if ( $rating_count > 0 ) : ?>
                <div class="woocommerce-product-rating">
                    <?php echo wc_get_rating_html( $average, $rating_count ); ?>
                </div>
                <?php endif;*/ ?>
            </div>
            <div class="text-right">
                <?php if ( $price_html = $product->get_price_html() ) : ?>
                <span class="price">
                    <?php echo $price_html; ?></span>
                <?php endif; ?>
            </div>
        </div>
        <a href="<?php the_permalink();?>" class="btn">
            <span class="row m-0">
                <span class="col-8 p-0">
                    <strong class="h-100 d-block">
                        <?php _e('Add to Cart','guai-aid');?></strong>
                </span>
                <span class="col-4 p-0">
                    <i class="fas fa-shopping-cart h-100  d-block"></i>
                </span>
            </span>
        </a>
    </div>
</div>