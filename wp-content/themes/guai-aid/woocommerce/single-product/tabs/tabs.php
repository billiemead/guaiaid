<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );
//unset($product_tabs['description']);
unset($product_tabs['additional_information']);
//unset($product_tabs['reviews']);

// $product_tabs['related']=array(
//     'title'=>'Related Products',
//     'priority'=>5,
//     'callback'=>'woocommerce_output_related_products',
// );
// $product_tabs['upsell']=array(
//     'title'=>'You may also like&hellip;',
//     'priority'=>10,
//     'callback'=>'guai_aid_woocommerce_upsell_display',
// );
// $product_tabs['reviews']=array(
//     'title'=>'Reviews',
//     'priority'=>15,
//     'callback'=>'comments_template',
// );
//print_r($product_tabs);

if ( ! empty( $product_tabs ) ) : ?>
<div class="product-tabs">
    <ul class="tabs wc-tabs nav nav-tabs" role="tablist">
        <?php 
        $i=1;
        foreach ( $product_tabs as $key => $product_tab ) : ?>
        <li class="nav-item me-2">
            <a class="nav-link <?php if($i==1){ echo 'active';}?>" id="tab-title-<?php echo esc_attr( $key ); ?>" data-bs-toggle="tab" href="#tab-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>" aria-selected="<?php if($i==1){ echo 'true';}else{echo 'false'; }?>">
                <?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
            </a>
        </li>
        <?php 
            $i++;
            endforeach; 
        ?>
    </ul>
    <div class="tab-content">
        <?php 
            $i=1;
            foreach ( $product_tabs as $key => $product_tab ) : 
        ?>
        <div class="tab-pane mx-2 <?php if($i==1){ echo 'active';}?>" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
            <?php
                if ( isset( $product_tab['callback'] ) ) {
                    call_user_func( $product_tab['callback'], $key, $product_tab );
                }
                ?>
        </div>
        <?php 
            $i++;
            endforeach; 
        ?>
        <?php do_action( 'woocommerce_product_after_tabs' ); ?>
    </div>
</div>
<?php endif; ?>