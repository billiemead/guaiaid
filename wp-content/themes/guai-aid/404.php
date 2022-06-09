<?php

if ( !defined( 'ABSPATH' ) ) {

    exit;

}

get_header();

?>
<div class="page-section">
    <div class="error404 not-found fof-page container text-center py-5">
        <h1 class="h1 display-3 font-weight-bold">
            <?php echo esc_html_e('404', 'guai-aid'); ?>
        </h1>
        <h2 class="mb-4">
            <?php echo esc_html_e('Oops! That page can&rsquo;t be found.', 'guai-aid'); ?>
        </h2>
        <p>
            <?php esc_html_e('It looks like nothing was found at this location. Maybe try a search?', 'guai-aid'); ?>
        </p>
        <div class="search-form-wrap mx-auto mt-4" style="max-width: 700px; ">
            <?php get_search_form(); ?>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php get_footer(); ?>