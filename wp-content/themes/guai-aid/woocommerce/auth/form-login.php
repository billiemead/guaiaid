<?php
/**
 * Auth form login
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/auth/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Auth
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_auth_page_header' ); ?>
<h2>
    <?php
    /* translators: %s: app name */
    printf( esc_html__( '%s would like to connect to your store', 'woocommerce' ), esc_html( $app_name ) );
    ?>
</h2>
<?php wc_print_notices(); ?>
<p>
    <?php
    /* translators: %1$s: app name, %2$s: URL */
    echo wp_kses_post( sprintf( __( 'To connect to %1$s you need to be logged in. Log in to your store below, or <a href="%2$s">cancel and return to %1$s</a>', 'woocommerce' ), esc_html( wc_clean( $app_name ) ), esc_url( $return_url ) ) );
    ?>
</p>
<form class="wc-auth-login" method="post">
    <div class="form-group">
        <label for="username">
            <?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
        <input type="text" class="form-control" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
        <?php // @codingStandardsIgnoreLine ?>
    </div>
    <div class="form-group">
        <label for="password">
            <?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
        <input class="form-control" type="password" name="password" id="password" autocomplete="current-password" />
    </div>
    <?php do_action( 'woocommerce_login_form' ); ?>
    <div class="form-group">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="forever" id="rememberme" name="rememberme">
            <label class="form-check-label" for="rememberme">
                <?php esc_html_e( 'Remember me', 'woocommerce' ); ?>
            </label>
        </div>
        <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-outline-primary  px-5" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>">
            <?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
        <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="btn btn-outline-dark px-5">
            <?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
    </div>
</form>
<?php do_action( 'woocommerce_auth_page_footer' ); ?>