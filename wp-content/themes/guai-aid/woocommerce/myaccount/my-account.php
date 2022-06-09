<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="row">
    <div class="col-12 col-md-3">
        <?php do_action( 'woocommerce_account_navigation' ); ?>
    </div>
    <div class="col-12 col-md-9 woocommerce-MyAccount-content">
        <?php do_action( 'woocommerce_account_content' );?>
    </div>
</div>