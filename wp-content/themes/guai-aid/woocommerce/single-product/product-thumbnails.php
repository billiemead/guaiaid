<?php
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'guai_aid_wc_get_gallery_image_html' ) ) {
    return;
}

global $product;
$post_thumbnail_id = $product->get_image_id();
$attachment_ids = $product->get_gallery_image_ids();
$terms=wp_get_object_terms($product->get_ID(), 'pa_pack-of');
$variations=array();
if( ($product->get_type()=='variable') ){
    $variations = (array)$product->get_available_variations();
}
//col-12 col-md-4 col-lg-3 p-0
?>
<div class="img-slider m-0 mt-3 ">
    <div class="slick-arrows">
        <button class="slick-arrow prevArrow"><i class="fas fa-chevron-left"></i> <span class="sr-only">
                <?php _e('Prev','funday');?></span></button>
        <button class="slick-arrow nextArrow"><i class="fas fa-chevron-right"></i> <span class="sr-only">
                <?php _e('Next','funday');?></span></button>
        <span class="çlearfix"></span>
    </div>
    <div class="slides">
<?php 
    
    if ( $post_thumbnail_id ) 
    {
        echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', guai_aid_wc_get_gallery_image_html( $post_thumbnail_id,'','','p-1'), $post_thumbnail_id ); 
    }

    if ( $attachment_ids ) 
    {
    	foreach ( $attachment_ids as $attachment_id ) {  
        	echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', guai_aid_wc_get_gallery_image_html( $attachment_id,'','','p-1'), $attachment_id ); 
    	}
	}

    if($terms)
    {
        foreach($terms as $term)
        {
            //print_r($term);
            if($id=get_term_meta($term->term_id,'product_attribute_image',true))
            {
                $class='p-1 swatch-img-'.$id.' swatch-item-'.$term->term_id;
                echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', guai_aid_wc_get_gallery_image_html( $id,'','',$class), $id );
            }
        }

    } else if($variations){
        foreach($variations as $variation)
        {
            $i=1;
            if(count($variation['image'])>0)
            {
                echo '<div class="woocommerce-product-gallery_thumb_image swatch-item-'.$i.' p-1" data-thumb="'.$variation['image']['gallery_thumbnail_src'].'" data-thumb-alt="'.$variation['image']['alt'].'">
                        <a href="'.$variation['image']['src'].'" class="d-block">
                           <img 
	                           width="'.$variation['image']['gallery_thumbnail_src_w'].'" 
	                           height="'.$variation['image']['gallery_thumbnail_src_h'].'" 
	                           src="'.$variation['image']['gallery_thumbnail_src'].'" 
	                           class=" img-fluid" 
	                           alt="" 
	                           loading="lazy" 
	                           title="'.$variation['image']['title'].'" 
	                           data-caption="'.$variation['image']['title'].'"
                           >
                        </a>
                    </div>';
            }
            $i++;
        }
    }

?>
    </div>
</div>