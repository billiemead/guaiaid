<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
if ( guai_aid_active_sidebars() ): ?>
<aside id="secondary" class="sidebar widget-area pt-0 woo-sidebar">
    <div class="position-relative">
        <button class="btn btn-dark close-sidebar d-md-none"><i class="fas fa-times"></i></button>
        <?php
    /*<div id="woocommerce_product_search-2" class="card widget tour-filter-widget woocommerce widget_product_search">
        <div class="card-header widget-header">
            <h4 class="card-title widget-title m-0">Search</h4>
        </div>
        <div class="card-body widget-body">
            <form role="search" method="get" class="woocommerce-product-search" action="<?php home_url();?>">
        <div class="input-group">
            <div class="input-group-prepend">
                <label class="screen-reader-text" id="" for="woocommerce-product-search-field-0">
                    Search for:</label>
            </div>
            <input type="search" id="woocommerce-product-search-field-0" class="search-field form-control" placeholder="Search products…" value="" name="s">
            <input type="hidden" name="post_type" value="product">
            <div class="input-group-append">
                <button type="submit" value="Search" class="btn btn-sm px-3 btn-primary">Search</button>
            </div>
        </div>
        </form>
        <div class="clear"></div>
    </div>
    </div>
    <?php*/
    if( class_exists('WC_Widget_Layered_Nav_Filters')) 
    {
        $args=array('before_widget'=>' <div id="woocommerce_active_filters" class="card widget  woocommerce woocommerce_active_filters">',
                'before_title'=>'<div class="card-header widget-header bg-transparent"><h4 class="card-title widget-title m-0">',
                'after_title'=>'</div><div class="card-body widget-body">',
                'after_widget'=>'</div> <div class="clear"></div></div>'
            );
        (new WC_Widget_Layered_Nav_Filters())->widget($args,'');
    }?>
   <!--  <h3 class="sidebar-title mb-4">
        <?php _e('Refine By','guai-aid');?>
    </h3> -->
    <?php dynamic_sidebar( 'guai-aid-filter' );?>
    </div>
</aside>
<?php endif; ?>