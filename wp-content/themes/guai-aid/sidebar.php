<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
if ( guai_aid_active_sidebars() ): ?>
    <aside id="secondary" class="sidebar widget-area pt-0">
        <?php
        dynamic_sidebar( 'guai-aid-sidebar' );
        ?>
    </aside>
<?php endif; ?>