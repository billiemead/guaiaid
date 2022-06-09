<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $upsells ) { ?>
<section class="up-sells upsells products">
    <?php
		$heading = apply_filters( 'woocommerce_product_upsells_products_heading', __( 'You may also like&hellip;', 'woocommerce' ) );

		if ( $heading ) :
			?>
    <h2>
        <?php echo esc_html( $heading ); ?>
    </h2>
    <?php endif; ?>
    <?php //woocommerce_product_loop_start(); ?>
    <div class="row card-items card-items-center">
        <?php foreach ( $upsells as $upsell ) : ?>
        <?php
				$post_object = get_post( $upsell->get_id() );
				setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found
				//wc_get_template_part( 'content', 'product' );
				?>
        <div class="col-sm-6 col-md-4 col-lg-4 card-item-col mb-4">
            <?php get_template_part('templates/cards/product' );  ?>
        </div>
        <?php endforeach; ?>
        <?php// woocommerce_product_loop_end(); ?>
    </div>
</section>
<?php
}else{

}

wp_reset_postdata();