<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>
<?php if ( ! WC()->cart->is_empty() ) : ?>
<ul class="woocommerce-mini-cart cart_list product_list_widget list-unstyled <?php echo esc_attr( $args['list_class'] ); ?> p-0">
    <?php
		do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('thumbnail'), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
    <li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
        <table class="table table-borderless w-100">
            <tr>
                <td class="p-0" valign="top">
                    <?php echo $thumbnail;?>
                </td>
                <td class="py-0">
                    <h5>
                        <?php if ( empty( $product_permalink ) ) : 
            	echo  $product_name;
            else : ?>
                        <a href="<?php echo esc_url( $product_permalink ); ?>">
                            <?php echo  $product_name; ?>
                        </a>
                    </h5>
                    <?php endif;
			echo wc_get_formatted_cart_item_data( $cart_item );
            echo '<p class="mb-1">'.apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ).'</p>';
            ?>
                </td>
                <td class="p-0">
                    <?php echo apply_filters( 'woocommerce_cart_item_remove_link',
                	sprintf(
                		'<a href="%s" class="remove remove_from_cart_button btn btn-danger btn-sm" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
                		esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                		esc_attr__( 'Remove this item', 'woocommerce' ),	
                		esc_attr( $product_id ), 
                		esc_attr( $cart_item_key ), 
                		esc_attr( $_product->get_sku() )),
                	$cart_item_key );
             ?>
                </td>
            </tr>
        </table>
    </li>
    <li>
        <hr class="w-100">
    </li>
    <?php
			}
		}
		do_action( 'woocommerce_mini_cart_contents' );
		?>
</ul>
<p class="woocommerce-mini-cart__total total text-center font-weight-bold">
    <?php
		/**
		 * Hook: woocommerce_widget_shopping_cart_total.
		 *
		 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
		 */
		do_action( 'woocommerce_widget_shopping_cart_total' );
		?>
</p>
<hr>
<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
<div class="woocommerce-mini-cart__buttons buttons btn-group">
    <?php 
    echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="button wc-forward btn btn-cart px-5">' . esc_html__( 'View cart', 'woocommerce' ) . '</a>';
    echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="button btn-checkout wc-forward btn px-5">' . esc_html__( 'Checkout', 'woocommerce' ) . '</a>';
    //do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?>
</div>
<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>
<?php else : ?>
<div class="woocommerce-mini-cart__empty-message alert alert-info m-0">
    <?php esc_html_e( 'No products in the cart.', 'woocommerce' ); ?>
</div>
<?php endif; ?>
<?php do_action( 'woocommerce_after_mini_cart' ); ?>