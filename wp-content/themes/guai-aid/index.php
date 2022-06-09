<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
get_header();
?>
<div id="site-content" class="container py-5">
    <?php get_template_part( 'templates/page-headers/archive' );?>
    <div class="row mt-5">
        <div class="col-md-9">
            <section id="site-content" class="site-main content-area archive pt-0">
                <?php 
                if (have_posts()) 
                { 

                    if (!is_home() && !is_front_page()) 
                    { 
                        echo '<div class="archive-header">';
                        if (is_author()) {
                             get_template_part('templates/page-headers/author');  

                        }elseif (is_search()) { 
                            echo '<h1 class="archive-title">';
                            printf(esc_html__('Searching for: "%s"', 'guai-aid'), get_search_query());
                            echo '</h1>';
                        } else {
                            the_archive_title('<h1 class="archive-title">', '</h1>');
                            the_archive_description('<div class="archive-description">', '</div>');
                        }
                        echo '</div>';
                    } 
                    echo '<div class="tour-archive card-items">';
                    while (have_posts()) : the_post();
                        echo '<div class="card-item-col col-12 p-0">';
                        get_template_part('templates/archive/post' );  
                        echo '</div>';  
                    endwhile;
                    echo '</div>'; 
                    the_posts_pagination();
                } else {
                    get_template_part('templates/contents/none');
                };
                ?>
                <div class="clear"></div>
            </section>
        </div>
        <div class="col-md-3">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php get_footer();?>