<div class="products-page-header ">
    <?php
		if(  is_product_taxonomy() && (0 === absint( get_query_var( 'paged' ) ))  && is_tax() )
		{
			$curr_term = get_queried_object();
			$curr_term->meta = guai_aid_all_term_meta( $curr_term->term_id );

			if(wp_is_mobile()){ 
				$img_size='medium';
			}else{
				$img_size='full';
			}

			if( isset($curr_term->meta->banner_image) && $curr_term->meta->banner_image>0){
				guai_aid_thumbnail('',$img_size,'mb-5',$curr_term->meta);
			}elseif( isset($curr_term->meta->thumbnail_id) && $curr_term->meta->thumbnail_id>0){
				guai_aid_thumbnail('',$img_size,'mb-5',$curr_term->meta);
			}

			if( isset($curr_term->meta->long_description) && !empty($curr_term->meta->long_description) ){
				echo wpautop($curr_term->meta->long_description);
			}elseif( isset($curr_term->meta->pc_content) && !empty($curr_term->meta->pc_content) ){
				echo wpautop($curr_term->meta->pc_content);
			}else{
				echo '<div class="term-description">' . wc_format_content( term_description()) . '</div>'; 
			}
		}else{
			guai_aid_thumbnail(wc_get_page_id( 'shop' ) ,'full','mb-5');
			woocommerce_product_archive_description();
		}

			  <h1 class="woocommerce-products-header__title page-title mb-0">
        <?php guai_aid_woocommerce_page_title(); ?>
    </h1>
    /**
    * Hook: woocommerce_archive_description.
    *
    * @hooked woocommerce_taxonomy_archive_description - 10
    * @hooked woocommerce_product_archive_description - 10
    */
    //do_action( 'woocommerce_archive_description' );
    ?>
</div>