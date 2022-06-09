<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
 ?>
<div class="u-columns col2-set row" id="customer_login">
    <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) { ?>
    <?php do_action( 'woocommerce_before_customer_login_form' );?>
    <div class="u-column1 col-1 col-12 col-md-4 mb-4">
        <div class="border p-4">
            <?php woocommerce_login_form( array( 'redirect' => home_url() ) );?>
        </div>
    </div>
    <div class="u-column2 col-2 col-12 col-md-8 pl-md-5">
        <div class="border p-4">
            <?php wc_get_template( 'global/form-register.php' );?>
        </div>
    </div>
    <?php do_action( 'woocommerce_after_customer_login_form' ); ?>
    <?php } else{ ?>
    <div class="col-12 col-lg-6 mx-auto">
        <?php woocommerce_login_form( array( 'redirect' => home_url() ) );?>
    </div>
    <?php }?>
</div>