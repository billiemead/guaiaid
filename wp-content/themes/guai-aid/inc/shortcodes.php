<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
add_shortcode( 'guiaid_wc_reg_form', function(){
   if ( is_admin() ) return;
   if ( is_user_logged_in() ) return;
   ob_start();
   wc_get_template( 'global/form-register.php' );
   return ob_get_clean();
} );
    

add_shortcode( 'guiaid_wc_login_form', function(){
   if ( is_admin() ) return;
   if ( is_user_logged_in() ) return;
   ob_start();
   woocommerce_login_form( array( 'redirect' => home_url() ) );
   return ob_get_clean();
} );
?>