<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
get_header();
get_template_part( 'templates/single/' . guai_aid_post_type() );
get_footer();
?>