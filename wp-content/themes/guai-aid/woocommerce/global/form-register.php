<?php
/**
 * Register form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( is_user_logged_in() ) {
    return;
}?>
<div class="wc-login-form-wrap">
    <h2 class="title">
        <?php esc_html_e( 'Register', 'woocommerce' ); ?>
    </h2>
    <?php do_action( 'woocommerce_before_customer_login_form' );?>
    <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
        <div class="row">
            <div class="col-12">
                <h5 class="mb-4 text-start">YOUR PERSONAL DETAILS</h5>
            </div>
            <?php do_action( 'woocommerce_register_form_start' ); ?>
            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
            <div class="col-md-6 form-group">
                <label for="reg_username" class="sr-only">
                    <?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <div class="position-relative">
                    <i class="fas far fa-user"></i>
                    <input type="text" class="form-control" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr(sanitize_title(wp_unslash( $_POST['username'] )) ) : ''; ?>" placeholder="<?php esc_html_e( 'Username', 'woocommerce' ); ?>" />
                </div>
                <?php // @codingStandardsIgnoreLine ?>
            </div>
            <?php endif; ?>
            <div class="col-md-6 form-group">
                <label for="reg_email" class="sr-only">
                    <?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <div class="position-relative">
                    <i class="far fa-envelope"></i>
                    <input type="email" class="form-control" name="email" id="reg_email" autocomplete="email" placeholder="<?php esc_html_e( 'Email address', 'woocommerce' ); ?>" value="
                    <?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" />
                </div>
                <?php // @codingStandardsIgnoreLine ?>
            </div>
            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
            <div class="col-12">
                <h5 class="mb-4 text-start">Your <span>YOUR PASSWORD</span></h5>
            </div>
            <div class="col-md-6 form-group">
                <label for="reg_password" class="sr-only">
                    <?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <div class="position-relative">
                    <i class="fas fa-unlock-alt"></i>
                    <input type="password" class="form-control" name="password" id="reg_password" autocomplete="new-password" placeholder="<?php esc_html_e( 'Password', 'woocommerce' ); ?>" />
                </div>
            </div>
            <div class="col-md-6 form-group">
                <label for="reg_password_c" class="sr-only">
                    <?php esc_html_e( 'Confirm Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <div class="position-relative">
                    <i class="fas fa-unlock-alt"></i>
                    <input type="password" class="form-control" name="password_c" id="reg_password_c" required placeholder="<?php esc_html_e( 'Confirm Password', 'woocommerce' ); ?>" />
                </div>
            </div>
            <?php else : ?>
            <div class="col-12 form-group">
                <?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?>
            </div>
            <?php endif; ?>
            <div class="col-12 form-group">
                <?php do_action( 'woocommerce_register_form' ); ?>
            </div>
            <div class="col-12 form-group text-right">
                <hr>
                <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                <button type="submit" class="btn " name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>">
                    <?php esc_html_e( 'Register', 'woocommerce' ); ?><i class="fas fa-long-arrow-alt-right"></i></button>
                <p>If you already have an account with us, please login at the? <a href="<?php echo home_url('my-account');?>" class="btn-link">Sign In!</a></p>
            </div>
            <?php do_action( 'woocommerce_register_form_end' ); ?>
        </div>
    </form>
</div>