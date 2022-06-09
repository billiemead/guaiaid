<?php
$author_id = get_the_author_meta( 'ID' );
$name = esc_html( get_the_author_meta( 'display_name' ) );
$title = esc_attr( 'Posts by', 'guai-aid' ) . ' ' . $name;
$url = esc_url( get_author_posts_url( $author_id ) );
if ( is_single() ) {
    $class = 'byline author vcard hcard h-card author-' . esc_attr( $author_id );
} else {
    $class = '';
}
?>
<div id="author-info" class="author-info clear <?php echo $class;?> bg-grey">
    <div class="media">
        <div class="author-avatar">
            <?php  if( is_single()) { 
            echo get_avatar(get_the_author_meta('user_email'),100);  
        }else{ 
            echo get_avatar(get_the_author_meta('user_email'),150); 
        }?>
        </div>
        <div class="media-body pl-4">
            <h3 class="author-title"><a href="<?php echo $url; ?>" title="<?php echo $title;?>" rel="author">
                    <span class="fn">
                        <?php  echo  $name;?>
                    </span> </a></h3>
        
            <?php if($desc=get_the_author_meta('description')){  ?>
            <div class="author-bio author-description">
                <p class="m-0">
                    <?php echo $desc;?>
                </p>
            </div>
            <?php }           ?>
            <div class="author-meta">
                <ul class="list-group list-group-horizontal list-unstyled m-0 p-0">
                    <?php 
                if($post_count=count_user_posts($author_id)) {
                echo '<li class="item list-group-item border-0 bg-transparent p-0"><a href='.esc_url(get_author_posts_url($author_id)).' title="'.esc_attr($post_count).' '.esc_attr('Posts', 'guai-aid').'" class="nav-link posts"><i class="fas fa-pen-nib"></i><span class="count">'.esc_html($post_count).'</span><span class="sr-only">'. esc_html__('Posts', 'guai-aid').'</span></a></li>';
                }
                if($website=esc_url(get_the_author_meta('url', $author_id)) ) {
                echo '<li class="item list-group-item border-0 bg-transparent p-0"><a href="'.esc_url($website).'" rel="noopener" target="_blank" class="nav-link social web" title="'. esc_attr('Author\'s Website', 'guai-aid').'"><i class="fas fa-globe"></i><span class="sr-only">'. esc_html__('Website', 'guai-aid').'</span></a></li>';
                }
                if($twitter=esc_url(get_the_author_meta('guai_aid_twitter', $author_id)) ) {
                echo '<li class="item list-group-item border-0 bg-transparent p-0"><a href="https://twitter.com/'.esc_attr($twitter).'/" rel="noopener" target="_blank" class="nav-link social twitter" title="'. esc_attr('Twitter', 'guai-aid').'"><i class="fab fa-twitter"></i><span class="sr-only">'. esc_html__('Twitter', 'guai-aid').'</span></a></li>';
                }
                if($facebook=esc_url(get_the_author_meta('guai_aid_facebook', $author_id)) ) {
                echo '<li class="item list-group-item border-0 bg-transparent p-0"><a href="'.esc_url($facebook).'" rel="noopener" target="_blank" class="nav-link social facebook" title="'. esc_attr('Facebook', 'guai-aid').'"><i class="fab fa-facebook-f"></i><span class="sr-only">'. esc_html__('Facebook', 'guai-aid').'</span></a></li>';
                }
                if($instagram=esc_url(get_the_author_meta('guai_aid_instagram', $author_id)) ) {
                echo '<li class="item list-group-item border-0 bg-transparent p-0"><a href="'.esc_url($instagram).'" rel="noopener" target="_blank" class="nav-link social instagram" title="'. esc_attr('Instagram', 'guai-aid').'"><i class="fab fa-instagram"></i><span class="sr-only">'. esc_html__('Instagram', 'guai-aid').'</span></a></li>';
                }
                if($gplus=esc_url(get_the_author_meta('guai_aid_gplus', $author_id)) ) {
                echo '<li class="item list-group-item border-0 bg-transparent p-0"><a href="'.esc_url($gplus).'" rel="noopener author" target="_blank" class="nav-link social gplus" title="'. esc_attr('Google Plus', 'guai-aid').'"><i class="fab fa-google-plus-g"></i><span class="sr-only">'. esc_html__('Google Plus', 'guai-aid').'</span></a></li>';
                }
                if($linked_in=esc_url(get_the_author_meta('guai_aid_linked_in', $author_id)) ) {
                echo '<li class="item list-group-item border-0 bg-transparent p-0"><a href="'.esc_url($linked_in).'" rel="noopener" target="_blank" class="nav-link social linked-in" title="'. esc_attr('LinkedIn', 'guai-aid').'"><i class="fab fa-linkedin"></i><span class="sr-only">'. esc_html__('LinkedIn', 'guai-aid').'</span></a></li>';
                }
                if($guai_aid_flickr=esc_url(get_the_author_meta('guai_aid_flickr', $author_id)) ) {
                echo '<li class="item list-group-item border-0 bg-transparent p-0"><a href="'.esc_url($guai_aid_flickr).'" rel="noopener" target="_blank" class="nav-link social flickr" title="'. esc_attr('Flickr', 'guai-aid').'"><i class="fab fa-flickr"></i><span class="sr-only">'. esc_html__('Flickr', 'guai-aid').'</span></a></li>';
                }
                if($guai_aid_github=esc_url(get_the_author_meta('guai_aid_github', $author_id)) ) {
                echo '<li class="item list-group-item border-0 bg-transparent p-0"><a href="'.esc_url($guai_aid_github).'" rel="noopener" target="_blank" class="nav-link social github" title="'. esc_attr('Github', 'guai-aid').'"><i class="fab fa-github"></i><span class="sr-only">'. esc_html__('Github', 'guai-aid').'</span></a></li>';
                }
                if($guai_aid_pinterest=esc_url(get_the_author_meta('guai_aid_pinterest', $author_id)) ) {
                echo '<li class="item list-group-item border-0 bg-transparent p-0"><a href="'.esc_url($guai_aid_pinterest).'" rel="noopener" target="_blank" class="nav-link social pinterest" title="'. esc_attr('Pinterest', 'guai-aid').'"><i class="fab fa-pinterest"></i><span class="sr-only">'. esc_html__('Pinterest', 'guai-aid').'</span></a></li>';
                }
                if($guai_aid_tumblr=esc_url(get_the_author_meta('guai_aid_tumblr', $author_id)) ) {
                echo '<li class="item list-group-item border-0 bg-transparent p-0"><a href="'.esc_url($guai_aid_tumblr).'" rel="noopener" target="_blank" class="nav-link social tumblr" title="'. esc_attr('Tumblr', 'guai-aid').'"><i class="fab fa-tumblr"></i><span class="sr-only">'. esc_html__('Tumblr', 'guai-aid').'</span></a></li>';
                }
                if($guai_aid_medium=esc_url(get_the_author_meta('guai_aid_medium', $author_id)) ) {
                echo '<li class="item list-group-item border-0 bg-transparent p-0"><a href="'.esc_url($guai_aid_medium).'" rel="noopener" target="_blank" class="nav-link social medium" title="'. esc_attr('Medium', 'guai-aid').'"><i class="fab fa-medium-m"></i><span class="sr-only">'. esc_html__('Medium', 'guai-aid').'</span></a></li>';
                }
                echo '<li class="item list-group-item border-0 bg-transparent p-0"><a href="'.esc_url(get_author_feed_link($author_id)).'" rel="noopener" title="'.esc_attr('Subscribe RSS Feed', 'guai-aid').'" target="_blank" class="nav-link social rss"><i class="fa fa-rss"></i><span class="sr-only">'. esc_html__('RSS Feed', 'guai-aid').'</span></a></li>';
                ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php if( !is_single()) { ?>
<h3 class="page-title screen-reader-text sr-only">
    <?php echo esc_html(get_the_author_meta('display_name')); ?>
    <?php esc_html_e('\'s Posts', 'guai-aid'); ?>
</h3>
<?php } ?>