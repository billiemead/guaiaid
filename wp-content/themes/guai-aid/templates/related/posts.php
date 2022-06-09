<?php
$tagIDs = $cateIDs = array();
$meta = guai_aid_all_post_meta( get_the_ID() );
$args = array(
    'post_type' => 'post',
    'post__not_in' => array( get_the_ID() ),
    'posts_per_page' => 8,
    'ignore_sticky_posts' => 1,
    'orderby' => 'rand',
    'order' => 'ASC',
    'ignore_pto' => true,
    'no_found_rows'=>true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
);

if ( is_singular( 'tour' ) && ( $terms = wp_get_post_terms( get_the_ID(), 'tour_destination', array( 'fields' => 'ids' ) ) ) ) {
    $title = __( 'Related Blog Posts', 'guai-aid' );
    $args[ 'meta_key' ] = 'destination';
    $args[ 'meta_value' ] = ( array )$terms;
    $args[ 'meta_compare' ] = 'IN';
    $args[ 'meta_type' ] = 'NUMERIC';

} else {
    $title = __( 'Related Posts', 'guai-aid' );
    if ( ( $post_categories = ( array )get_the_category( get_the_ID() ) ) && ( count( $post_categories ) > 0 ) ) {
        foreach ( $post_categories as $post_category ) {
            $cateIDs[] = $post_category->term_id;
        }
        $args[ 'cat' ] = $cateIDs;
    }
    if ( ( $post_tags = ( array )wp_get_post_tags( get_the_ID() ) ) && ( count( $post_tags ) > 0 ) ) {
        foreach ( $post_tags as $post_tag ) {
            $tagIDs[] = $post_tag->term_id;
        }
        $args[ 'tag__in' ] = $tagIDs;
    }
}
query_posts( $args );
if ( have_posts() ) {
    ?>
    <div id="related_posts" class="page-section">
        <div class="container">
            <h4 class="page-section-title">
                <?php echo $title;?>
            </h4>
            <div class="row card-items">
                <?php 
            while (have_posts()) : the_post();
                echo '<div class="card-item-col col-12 col-sm-6 col-md-4 col-lg-3">';
                get_template_part('templates/cards/post' ); 
                echo '</div>'; 
            endwhile;
            ?>
            </div>
        </div>
    </div>
    <?php
}
wp_reset_query();
?>