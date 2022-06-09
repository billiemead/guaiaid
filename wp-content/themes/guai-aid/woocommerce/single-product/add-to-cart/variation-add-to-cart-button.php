<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>
<div class="woocommerce-variation-add-to-cart variations_button">
    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
    <?php do_action( 'woocommerce_before_add_to_cart_quantity' );?>
    <div class="input-group mb-3">
        <span class="input-group-prepend border-0">
            <span class="input-group-text bg-transparent border-0 pl-0">
                <?php _e('Quantity','guai-aid');?>:</span>
        </span>
        <span class="input-group-prepend">
            <span class="input-group-text decrease-qty"><i class="fas fa-minus"></i></span>
        </span>
        <?php
    woocommerce_quantity_input(
        array(
            'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
            'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
            'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
        )
    );
    ?>
        <span class="input-group-append">
            <span class="input-group-text increase-qty"><i class="fas fa-plus"></i></span>
        </span>
        <input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
        <input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
        <input type="hidden" name="variation_id" class="variation_id" value="0" />
    </div>
    <?php  do_action( 'woocommerce_after_add_to_cart_quantity' );?>
    <button type="submit" class="single_add_to_cart_button button alt btn mb-2 rounded-0">
        <?php echo esc_html( $product->single_add_to_cart_text() ); ?><i class="fa fa-shopping-cart ms-2"></i></button>
    <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
</div>