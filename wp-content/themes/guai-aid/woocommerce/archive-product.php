<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;
get_header( );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
//do_action( 'woocommerce_before_main_content' );
woocommerce_output_content_wrapper();
//woocommerce_single_product_summary () ;
?>
<?php if ( apply_filters( 'woocommerce_show_page_title', true ) )
    {  
        if(wp_is_mobile()){ 
            $img_size='medium';
        }else{
            $img_size='full';
        }
        $desc='';
        $shop_page_id = wc_get_page_id( 'shop' ); 
        if(  is_product_taxonomy() && (0 === absint( get_query_var( 'paged' ) ))  && is_tax() )
        {
            $curr_term = get_queried_object();
            $curr_term->meta = guai_aid_all_term_meta( $curr_term->term_id );
            if($curr_term->meta->thumbnail_id){
                $img_src = guai_aid_thumbnail_src(null, $img_size, $curr_term->meta);
            }else{
                $img_src = guai_aid_thumbnail_src($shop_page_id, $img_size);
            }

            if( isset($curr_term->meta->long_description) && !empty($curr_term->meta->long_description) ){
                $desc= wpautop($curr_term->meta->long_description);
            }elseif( isset($curr_term->meta->pc_content) && !empty($curr_term->meta->pc_content) ){
                $desc=  wpautop($curr_term->meta->pc_content);
            }else{
                $desc=  wc_format_content( term_description()); 
            }
        }else{
            if ( $shop_page_id ) { 
                $img_src = guai_aid_thumbnail_src($shop_page_id, $img_size);
                $shop_page=get_post( $shop_page_id);
                $desc = wc_format_content( $shop_page->post_content ); 
            } 
        }
        ?>
<div class="wc-products-header page-header position-relative m-0" style="background-image:url('<?php echo $img_src[0];?>')">
    <div class="container">
        <h1 class="wc-products-title page-title">
            <?php guai_aid_woocommerce_page_title(); ?>
        </h1>
        <?php woocommerce_breadcrumb();?>
    </div>
</div>
<?php
        /**
        * Hook: woocommerce_archive_description.
        *
        * @hooked woocommerce_taxonomy_archive_description - 10
        * @hooked woocommerce_product_archive_description - 10
        */
        //do_action( 'woocommerce_archive_description' );
    }
    ?>
<div class="container my-5">
    <div class="row">
        <div class="col-12 col-md-3 pr-md-5">
            <?php  
            /**
             * Hook: woocommerce_sidebar.
             *
             * @hooked woocommerce_get_sidebar - 10
             */
            do_action( 'woocommerce_sidebar' );
        ?>
        </div>
        <div class="col-12 col-md-9">
            <?php
                if($desc){
                    echo '<div class="wc-products-desc">'.$desc.'</div>';
                }
             woocommerce_output_all_notices();
             ?>
             <div class="bg-grey border mb-5 p-2 ">
                <div class="row">
                    <div class="col-12 col-md-5 mb-2 text-left">
                        <?php echo woocommerce_result_count();?>
                    </div>
                    <div class="col-12 col-md-3 mb-2 text-right">
                        <hr class="d-md-none" />
                        <button class="btn btn-outline-dark filter-products d-md-none w-100 my-2"><i class="fas fa-filter"></i>
                            <?php _e('Filter Products','guai-aid');?></button>
                        <hr class="d-md-none" />
                        <?php echo woocommerce_catalog_ordering();?>
                        <hr class="d-md-none" />
                    </div>

                    <div class="col-12 col-md-4 text-right">
                        <form role="search" method="get" class="woocommerce-product-search" action="<?php home_url();?>">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="screen-reader-text" id="" for="woocommerce-product-search-field-0">
                                        Search for:</label>
                                </div>
                                <input type="search" id="woocommerce-product-search-field-0" class="search-field form-control h-auto" placeholder="Search products…" value="" name="s">
                                <input type="hidden" name="post_type" value="product">
                                <div class="input-group-append">
                                    <button type="submit" value="Search" class="btn btn-dark">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> 
            <?php
        if ( woocommerce_product_loop() ) {

            /**
             * Hook: woocommerce_before_shop_loop.
             *
             * @hooked woocommerce_output_all_notices - 10
             * @hooked woocommerce_result_count - 20
             * @hooked woocommerce_catalog_ordering - 30
             */
            //do_action( 'woocommerce_before_shop_loop' );
            //woocommerce_product_loop_start();

            if ( wc_get_loop_prop( 'total' ) ) 
            {
                ?>
            <div class="row card-items card-items-center">
                <?php 
                while ( have_posts() ) {
                    the_post();

                    /**
                     * Hook: woocommerce_shop_loop.
                     */
                    do_action( 'woocommerce_shop_loop' );

                    //wc_get_template_part( 'content', 'product' );
                    ?>
                <div class="col-sm-6 col-md-4 col-lg-4 card-item-col mb-5">
                    <?php get_template_part('templates/cards/product' );  ?>
                </div>
                <?php 
                }?>
            </div>
            <?php 
            }

            //woocommerce_product_loop_end();

            /**
             * Hook: woocommerce_after_shop_loop.
             *
             * @hooked woocommerce_pagination - 10
             */
            do_action( 'woocommerce_after_shop_loop' );
        } else {
            /**
             * Hook: woocommerce_no_products_found.
             *
             * @hooked wc_no_products_found - 10
             */
            do_action( 'woocommerce_no_products_found' );
        }
        ?>
        </div>
    </div>
</div>
<?php 
/**
* Hook: woocommerce_after_main_content.
*
* @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
*/
do_action( 'woocommerce_after_main_content' );

get_footer();