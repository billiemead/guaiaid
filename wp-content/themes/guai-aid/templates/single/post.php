<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div id="site-content" class="container py-2 py-md-5">
    <div class="row">
        <div class="col-md-9 col-print-12">
            <?php while ( have_posts() ): the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php get_template_part('templates/page-headers/page' );?>
                <?php guai_aid_entry_meta();?>
                <div class="entry-content">
                    <?php 
                            the_content(sprintf(__('Continue reading %s', 'guai-aid'), the_title('<span class="screen-reader-text sr-only">', '</span>', false)));
                            guai_aid_wp_link_pages();           
                        ?>
                    <?php
                    if ( is_singular( 'attachment' ) ) {
                        the_post_navigation( array( 'prev_text' => '<span class="meta-nav">' . __( 'Published in', 'guai-aid' ) . '</span><span class="post-title">%title</span>' ) );
                    } elseif ( is_singular( 'post' ) ) {
                        the_post_navigation( array(
                            'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'guai-aid' ) . '</span> ' .
                            '<span class="screen-reader-text sr-only">' . __( 'Next post:', 'guai-aid' ) . '</span> ' .
                            '<span class="post-title">%title</span>',
                            'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'guai-aid' ) . '</span> ' .
                            '<span class="screen-reader-text sr-only">' . __( 'Previous post:', 'guai-aid' ) . '</span> ' .
                            '<span class="post-title">%title</span>',
                        ) );
                    }
                    get_template_part('templates/page-headers/author');   
                    ?>
                </div>
                <?php if (comments_open() || get_comments_number() ) { 
                    comments_template(); 
                }?>
            </article>
            <?php endwhile; ?>
        </div>
        <div class="col-md-3 d-print-none">
            <?php get_sidebar();?>
        </div>
    </div>
</div>