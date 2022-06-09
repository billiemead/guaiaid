<?php
defined( 'ABSPATH' ) || exit;

// if ( ! $product_attributes ) {
//     return;
// }
//echo $product->get_sku();
if(!wp_is_mobile()){ 
    $width='200px;';
}else{
    $width='150px;';
}

?>
<div class="table-responsive">
<table class="woocommerce-product-attributes shop_attributes table table-sm">
    
    <?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
    <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--sku sku_wrapper">
        <th class="woocommerce-product-attributes-item__label" width="<?php echo $width;?>">
            <?php esc_html_e( 'SKU:', 'woocommerce' ); ?>
        </th>
        <td valign="top" width="20px">:</td>
        <td class="woocommerce-product-attributes-item__value">
            <span class="sku">
                <?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span>
        </td>
    </tr>
    <?php endif; ?>

    <?php foreach ( $product_attributes as $product_attribute_key => $product_attribute ) : ?>
    <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--<?php echo esc_attr( $product_attribute_key ); ?>">
        <th class="woocommerce-product-attributes-item__label" width="<?php echo $width;?>">
            <?php echo wp_kses_post( $product_attribute['label'] ); ?>
        </th>
        <td valign="top" width="20px">:</td>
        <td class="woocommerce-product-attributes-item__value">
            <?php echo wp_kses_post( $product_attribute['value'] ); ?>
        </td>
    </tr>
    <?php endforeach; ?>

    <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--sku sku_wrapper">
        <th class="woocommerce-product-attributes-item__label" width="<?php echo $width;?>">
            <?php esc_html_e( 'Categories:', 'woocommerce' ); ?>
        </th>
        <td valign="top" width="20px">:</td>
        <td class="woocommerce-product-attributes-item__value">
            <?php echo wc_get_product_category_list( $product->get_id(), ', ', '', '' ); ?>
        </td>
    </tr>
</table>
</div>