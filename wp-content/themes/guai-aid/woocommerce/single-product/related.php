<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Related products', 'woocommerce' ) );
if ( $related_products ) {?>
<div id="home-products" class="page-section home-page-section">
    <div class="container position-relative">
        <h2 class="home-title wow zoomIn">Related <span>PRODUCTS</span></h2>
        <div class="slick-arrows">
            <button class="slick-arrow prevArrow"><i class="flaticon-back"></i> <span class="sr-only">
                    <?php _e('Prev','guai-aid');?></span></button>
            <button class="slick-arrow nextArrow"><i class="flaticon-next"></i> <span class="sr-only">
                    <?php _e('Next','guai-aid');?></span></button>
        </div>
        <div class="card-items slides row m-0 mt-5">
            <?php foreach ( $related_products as $related_product )
                    {                        
                        $post_object = get_post( $related_product->get_id() );
                        setup_postdata( $GLOBALS['post'] =& $post_object );
                          ?>
            <div class="card-item-col col-12 col-md-4 col-lg-3 p-2">
                <?php get_template_part('templates/cards/product' );  ?>
            </div>
            <?php
                        }
                    ?>
        </div>
    </div>
</div>
<?php
}
wp_reset_postdata();