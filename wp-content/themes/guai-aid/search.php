<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
get_header();
?>
<section id="site-content" class="site-main content-area archive search-page pt-0 ">
    <?php     get_template_part('templates/page-headers/archive'); ?>
    <div class="container mt-5 pt-5">
        <?php 
        if (have_posts()) {  
            echo '<div class="row card-items m-0 card-items-center">';
            while (have_posts()) : the_post(); 
                echo '<div class="card-item-col col-10 p-0" >';
                        if(guai_aid_post_type()=='tour'){
                            get_template_part('templates/archive/tour'); 
                        } else{
                            get_template_part('templates/archive/post'); 
                        }
               echo '</div>';
            endwhile;
           echo'</div>';
            the_posts_pagination();
        } else {
            get_template_part('templates/contents/none');
        };
        ?>
        <div class="p-5"></div>
    </div>
</section>
<?php get_footer();?>