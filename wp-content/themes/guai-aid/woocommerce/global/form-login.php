<?php
/**
 * Login form
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
}

?>
<div class="wc-login-form-wrap">
    <h2 class="title">
        <?php esc_html_e( 'Login', 'woocommerce' ); ?>
    </h2>
    <?php do_action( 'woocommerce_before_customer_login_form' ); ?>
    <form class="woocommerce-form woocommerce-form-login login mt-3" method="post" <?php echo ( $hidden ) ? 'style="display:none;"' : '' ; ?>>
        <?php do_action( 'woocommerce_login_form_start' ); ?>
        <?php echo ( $message ) ? wpautop( wptexturize( $message ) ) : ''; // @codingStandardsIgnoreLine ?>
        <div class="" style="max-width: 500px;">
            <div class="form-group">
                <label for="username" class="sr-only">
                    <?php esc_html_e( 'Username or email', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <div class="position-relative">
                    <i class="far fa-user"></i>
                    <input type="text" class="form-control" name="username" id="username" autocomplete="username" placeholder="<?php esc_html_e( 'Username or email', 'woocommerce' ); ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="sr-only">
                    <?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <div class="position-relative">
                    <i class="fas fa-unlock-alt"></i>
                    <input class="form-control" type="password" name="password" id="password" autocomplete="current-password" placeholder="<?php esc_html_e( 'Password', 'woocommerce' ); ?>" />
                </div>
            </div>
            <?php do_action( 'woocommerce_login_form' ); ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="woocommerce-form__input woocommerce-form__input-checkbox form-check-input" name="rememberme" type="checkbox" id="rememberme" value="forever" />
                            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme form-check-label" for="rememberme">
                                <span>
                                    <?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="btn-link">
                            <?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group ">
            <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
            <input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ); ?>" />
            <button type="submit" class="btn w-100" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>">
                <?php esc_html_e( 'Login', 'woocommerce' ); ?></button>
            <p class="text-center mt-3 mb-0">By Creating An Account You Will Be Able To Shop Faster, Be Up To Date On An Order's Status, And Keep Track Of The Orders You Have Previously Made. <a href="<?php echo home_url('my-account/register/');?>" class=" btn-link ">Sign Up!</a>
        </div>
        <?php do_action( 'woocommerce_login_form_end' ); ?>
    </form>
</div>