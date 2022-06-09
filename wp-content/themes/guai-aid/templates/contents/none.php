<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="page-section">
    <h3 class="font-weight-bold h2">
        <?php esc_html_e('Nothing Found', 'guai-aid'); ?>
    </h3>
    <?php if (guai_aid_is_home_page() && current_user_can('publish_posts') ) : ?>
    <p>
        <?php echo esc_html__('Ready to publish your first post? ', 'guai-aid').'<a href="'.esc_url(admin_url('post-new.php')).'">'.esc_html__('Get started here.', 'guai-aid').'</a>'; ?>
    </p>
    <?php elseif (is_search() ) : ?>
    <p>
        <?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'guai-aid'); ?>
    </p>
    <?php else : ?>
    <p>
        <?php esc_html_e('It seems we can\' find what you\'re looking for. Perhaps searching can help.', 'guai-aid'); ?>
    </p>
    <div class="search-form-wrap">
        <?php get_search_form(); ?>
    </div>
    <?php endif; ?>
</div>