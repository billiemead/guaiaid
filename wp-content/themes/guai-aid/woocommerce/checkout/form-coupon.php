<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.4
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
    return;
}

?>
<div class="col-12">
    <div class="woocommerce-form-coupon-toggle bg-grey p-4 border mb-3">
        <div class="woocommerce-info mb-0 font-weight-bold " style="font-size: 16px">
            <?php esc_html_e( 'Have a coupon?', 'woocommerce' );?> <a href="#" class="showcoupon btn btn-sm btn-link" style="font-size: 14px">
                <?php esc_html_e( 'Click here to enter your code', 'woocommerce' );?></a>
        </div>
        <form class="checkout_coupon woocommerce-form-coupon" method="post" style="display:none">
            <hr>
            <p>
                <?php esc_html_e( 'If you have a coupon code, please apply it below.', 'woocommerce' ); ?>
            </p>
            <div class="input-group coupon">
                <input type="text" name="coupon_code" class="input-text form-control" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" style="max-width: 250px;     height: 35px;" />
                <div class="input-group-append">
                    <button type="submit" class="btn btn-dark" name="apply_coupon" value="<?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?>">
                        <?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>