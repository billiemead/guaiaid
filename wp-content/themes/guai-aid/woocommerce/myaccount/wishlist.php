<?php
    if ( !defined( 'ABSPATH' ) ) {
        exit;
    }
?>
<h2 class="page-title mt-0 mb-3">
    <?php echo apply_filters( 'woocommerce_my_account_my_orders_title', esc_html__( 'My Wishlist', 'woocommerce' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</h2>
<hr class="mb-5">
<?php 
global $wp_query;
$paged=0;
if( isset($wp_query->query['paged'])){
    $paged=trim($wp_query->query['paged']);
}elseif(isset($wp_query->query['wishlist'])){
    $paged=trim($wp_query->query['wishlist']);
    $paged=str_replace('page/', '', $paged);
}
if($uid=get_current_user_id())
{
    $ids = (array)get_metadata( 'user', $uid, 'wishlist_items',true );
    if(count($ids)>0)
    {
        $post_args=array(
            'post_type' => 'product', 
            'orderby' => 'name',
            'posts_per_page' => 20,
            'order'    => 'ASC',
            'paged'=>$paged,
            'post__in'=> (array)$ids,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'ignore_pto'=>true //to ignore post type order plugin order -
        );
        query_posts($post_args);
        ?>
<div class="row card-items">
    <?php while (have_posts()) : the_post(); ?>
    <div class="col-sm-6 col-md-4 col-lg-4 card-item-col">
        <?php get_template_part('templates/cards/product' );  ?>
    </div>
    <?php endwhile;?>
</div>
<?php
            the_posts_pagination();
            wp_reset_query();
    }else{ ?>
<div class="alert alert-info mb-5">
    <p class="m-0">You don't have any items in your wishlist. <a href="<?php echo home_url('products');?>" class="btn btn-info btn-sm px-5 wc-forward float-right mt-n1">Browse Products</a>
    </p>
</div>
<?php 

    }
}else{ ?>
<div class="alert alert-info mb-5">
    <p class="m-0">Please login to view your wishlist items. <a href="<?php echo home_url('my-account');?>" class="btn btn-info btn-sm px-5 wc-forward float-right mt-n1">Login</a>
    </p>
</div>
<?php 
}
?>