<?php 
// Wooocommerce --------------------
    // Remove Gift Card from Product list
    add_action( 'pre_get_posts', function ( $query ) {
        if ( ! is_admin() && $query->is_main_query() ) 
        {
            if($query->is_archive() && isset($query->query['post_type']) && ($query->query['post_type']=='product') ){
                $query->set( 'post__not_in', array( 104,181  ) );
            }
        }
    } );

    add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
    add_filter('woocommerce_gallery_image_html_attachment_image_params',function($array){
        $array['class']=$array['class'].' img-fluid';
        return $array;
    });

    add_filter( 'loop_shop_per_page', function ( $cols ) {
	  $cols = 21;
	  return $cols;
	}, 20 );

    add_filter('woocommerce_format_sale_price',function($price, $regular_price, $sale_price){
        return $price = '<ins>' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins><del>' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del>';
    }, 100, 3);

    add_filter('wc_add_to_cart_message_html',function($message){
        return  str_replace('class="button wc-forward"','class="btn btn-success  btn-sm px-5 wc-forward float-right mt-n1"',$message);
    });

    add_filter( 'wvs_variable_item', function ($data, $type, $options, $args, $saved_attribute)
    {
        $product   = $args['product'];
        $attribute = $args['attribute'];
        $new_data      = '';
        if ( ! empty( $options )  && ($type=='image')) 
        {

            if ( $product && taxonomy_exists( $attribute ) ) 
            {
                $terms =(array)wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );
                $name  = uniqid( wc_variation_attribute_name( $attribute ) );
                foreach ( $terms as $term ) 
                {
                    if ( in_array( $term->slug, $options, true ) ) 
                    {

                        // aria-checked="false"
                        $option = esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name, $term, $attribute, $product ) );

                        $is_selected    = ( sanitize_title( $args['selected'] ) == $term->slug );
                        $selected_class = $is_selected ? 'selected' : '';
                        $tooltip        = trim( apply_filters( 'wvs_variable_item_tooltip', $option, $term, $args ) );

                        $tooltip_html_attr       = ! empty( $tooltip ) ? sprintf( ' data-wvstooltip="%s"', esc_attr( $tooltip ) ) : '';
                        $screen_reader_html_attr = $is_selected ? ' aria-checked="true"' : ' aria-checked="false"';

                        $attachment_id = apply_filters( 'wvs_product_global_attribute_image_id', absint( wvs_get_product_attribute_image( $term ) ), $term, $args );
                        $full_image         = wp_get_attachment_image_src( $attachment_id, 'full' );

                        $image_size    = woo_variation_swatches()->get_option( 'attribute_image_size' );
                        $image         = wp_get_attachment_image_src( $attachment_id, apply_filters( 'wvs_product_attribute_image_size', $image_size, $attribute, $product ) );

                        $new_data .='<li '.$screen_reader_html_attr . $tooltip_html_attr.' 
                            class="variable-item '.esc_attr( $type ).'-variable-item '.esc_attr( $type ).'-variable-item-'.esc_attr( $term->slug).' '.esc_attr( $selected_class ).'" 
                            title="'.esc_attr( $option ).'" 
                            data-title="'.esc_attr( $option ).'" 
                            data-value="'.esc_attr( $term->slug).'" 
                            data-image="'.esc_attr($full_image[0]).'"
                            data-id="'.esc_attr( $term->term_id).'"  
                            role="radio" 
                            tabindex="0"
                        >
                                <div class="variable-item-contents">
                                    <img aria-hidden="true" alt="'.esc_attr( $option ).'" src="'.esc_url( $image[0] ).'" width="'.esc_attr( $image[1] ).'" height="'.esc_attr( $image[2] ).'" />
                                </div>
                            </li>';
                    }
                }
            }
            return $new_data;
        }

        return $data;
    },100,5);


	add_filter('wvs_variable_items_wrapper',function($data, $contents, $type, $args, $saved_attribute ){
		$product   = $args['product'];
	    $attribute = $args['attribute'];
	    $new_data='';
		if($attribute=='pa_hair-color'){
        	return '<p class="mb-1" style="font-size:12px;"><a href="#color-info" class="text-info"><i class="fas fa-exclamation-circle"></i>'.__('Actual color may slightly differ','guai-aid').'*</a></p>'.$data;
        }
        return $data;
	},100,5);

function guai_aid_wc_get_gallery_image_html( $attachment_id, $main_image = false, $is_swatch=false, $class='' )
{
    $class=trim($class);

    $flexslider        = (bool) apply_filters( 'woocommerce_single_product_flexslider_enabled', get_theme_support( 'wc-product-gallery-slider' ) );
    $gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
    $thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
    $image_size        = apply_filters( 'guai-aid-post-archive', $flexslider || $main_image ? 'woocommerce_single' : $thumbnail_size );  
    $full_size         = apply_filters( 'full', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );   
    $thumbnail_src     = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
    $full_src          = wp_get_attachment_image_src( $attachment_id, $full_size );
    $alt_text          = trim( wp_strip_all_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );
    
    if($main_image){
        $class .=" woocommerce-product-gallery__image";
    }else{
        $class .=" woocommerce-product-gallery_thumb_image";
    }

    $woo_img= apply_filters('woocommerce_gallery_image_html_attachment_image_params', array(
        'title'                   => _wp_specialchars( get_post_field( 'post_title', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
        'data-caption'            => _wp_specialchars( get_post_field( 'post_excerpt', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
        'data-src'                => esc_url( $full_src[0] ),
        'data-large_image'        => esc_url( $full_src[0] ),
        'data-large_image_width'  => esc_attr( $full_src[1] ),
        'data-large_image_height' => esc_attr( $full_src[2] ),
        'class'                   => esc_attr( $main_image ? 'wp-post-image' : '' ),
    ));
    if($is_swatch==true){
        $image_size='guai-aid-post-archive';
    }
    $image = wp_get_attachment_image( $attachment_id, $image_size, false,$woo_img ,$attachment_id,$image_size,$main_image );  

    return '<div  class="'.$class.'" data-thumb="' . esc_url( $thumbnail_src[0] ) . '" data-thumb-alt="' . esc_attr( $alt_text ) . '">
        <a href="' . esc_url( $full_src[0] ) . '" class="d-block">' . $image . '</a>
        </div>';
}

function guai_aid_wc_get_gallery_image_html2( $attachment_id, $main_image = false, $is_swatch=false )
 {
    $flexslider        = (bool) apply_filters( 'woocommerce_single_product_flexslider_enabled', get_theme_support( 'wc-product-gallery-slider' ) );
    $gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
    $thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
    $image_size        = apply_filters( 'guai-aid-post-archive', $flexslider || $main_image ? 'woocommerce_single' : $thumbnail_size );
   
    $full_size         = apply_filters( 'full', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
    
    $thumbnail_src     = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
    $full_src          = wp_get_attachment_image_src( $attachment_id, $full_size );
    $alt_text          = trim( wp_strip_all_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );
    
    $woo_img= apply_filters('woocommerce_gallery_image_html_attachment_image_params', array(
        'title'                   => _wp_specialchars( get_post_field( 'post_title', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
        'data-caption'            => _wp_specialchars( get_post_field( 'post_excerpt', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
        'data-src'                => esc_url( $full_src[0] ),
        'data-large_image'        => esc_url( $full_src[0] ),
        'data-large_image_width'  => esc_attr( $full_src[1] ),
        'data-large_image_height' => esc_attr( $full_src[2] ),
        'class'                   => esc_attr( $main_image ? 'wp-post-image' : '' ),
    ));
    if($is_swatch==true){
        $image_size='guai-aid-post-archive';
    }
    $image = wp_get_attachment_image( $attachment_id, $image_size, false,$woo_img ,$attachment_id,$image_size,$main_image );  


    if($main_image){
        $class="woocommerce-product-gallery__image";
    }else{
        $class="woocommerce-product-gallery_thumb_image";
    }

    return '<a href="' . esc_url( $full_src[0] ) . '" class="d-block">' . $image . '</a>';
}


function guai_aid_woocommerce_upsell_display( $limit = '-1', $columns = 4, $orderby = 'rand', $order = 'desc' ) 
{ 
    global $product, $woocommerce_loop; 
 
    if ( ! $product ) { 
        return; 
    } 
 
    // Handle the legacy filter which controlled posts per page etc. 
    $args = apply_filters( 'woocommerce_upsell_display_args', array( 
        'posts_per_page' => $limit,  
        'orderby' => $orderby,  
        'columns' => $columns,  
    )); 

    $woocommerce_loop['name'] = 'up-sells'; 
    $woocommerce_loop['columns'] = apply_filters( 'woocommerce_upsells_columns', isset( $args['columns'] ) ? $args['columns'] : $columns ); 
    $orderby = apply_filters( 'woocommerce_upsells_orderby', isset( $args['orderby'] ) ? $args['orderby'] : $orderby ); 
    $limit = apply_filters( 'woocommerce_upsells_total', isset( $args['posts_per_page'] ) ? $args['posts_per_page'] : $limit ); 
 
    // Get visble upsells then sort them at random, then limit result set. 
    $upsells = wc_products_array_orderby( array_filter( array_map( 'wc_get_product', $product->get_upsell_ids() ), 'wc_products_array_filter_visible' ), $orderby, $order ); 
    if( count($upsells)>0){
        $upsells = $limit > 0 ? array_slice( $upsells, 0, $limit ) : $upsells; 
    }
 
    wc_get_template( 'single-product/up-sells.php', array( 
        'upsells' => $upsells,  
        'posts_per_page' => $limit,  
        'orderby' => $orderby,  
        'columns' => $columns,  
 ) ); 
}


function woocom_tabs(){
   return array(
        'wishlist'=>array('title'=>'Wishlist')
     );
}
add_action('init',function()
{
    global $error_msg;
    $user=get_current_user_id();  
    foreach(woocom_tabs() as $endpoint=>$item){
        add_rewrite_endpoint( $endpoint, EP_ROOT | EP_PAGES );
    }
});

// Adding end points ---------------->
add_filter( 'query_vars', function($vars ){
   foreach(woocom_tabs() as $endpoint=>$item){
       $vars[] = $endpoint;
   }
  return $vars;
}, 0 );

// Title filter  ---------------->
// add_filter( 'the_title', function($title, $object_id) 
// {
//    global $wp_query;
//    foreach(woocom_tabs() as $endpoint=>$item)
//     {
//         if ( is_user_logged_in() && isset( $wp_query->query_vars[$endpoint])  &&  $object_id ){
//           $title= $item['title'];
//         }
//    }
//     return $title;
// }, 10, 2 );


// Creating Account menu items  ---------------->
add_filter( 'woocommerce_account_menu_items', function( $items )
{
    $new_items=array();
    $new_items['dashboard'] = $items['dashboard'];
    foreach($items as $index=>$item ){
        if( !in_array($index,array('dashboard','customer-logout'))){
            $new_items[$index] =$item;
        }
    }
    foreach(woocom_tabs() as $endpoint=>$item)  {
        $new_items[$endpoint] =$item['title'];
    }
    $new_items['customer-logout'] = $items['customer-logout'];  
    return $new_items;
});


//  My wishlist end point  ---------------->
add_filter( 'woocommerce_account_wishlist_endpoint', function(){
   wc_get_template( 'myaccount/wishlist.php' ); 
});


add_filter( 'woocommerce_form_field_args' , function( $args ) {
    $args['input_class'][]='form-control';
    return $args;
});


//  Saving Extra profile feilds  ---------------->
add_action( 'woocommerce_save_account_details',function ( $user_id ) 
{
  $post_items=array_filter($_POST,'trim');

  foreach($post_items as $index=>$value)
  {
    if(in_array($index,array('description','twitter')) ){
          $value=esc_html($value);
    }else{
          $value=esc_url($value);
    }
    update_user_meta($user_id,$index,$value);  
  }

});


//  Validting errors  ---------------->
add_action( 'woocommerce_save_account_details_errors',function( $args )
{
    if ( isset( $_POST['description'] ) ) // Your custom field
    {
        if(strlen($_POST['description'])>500 ) // condition to be adapted
        $args->add( 'error', __( 'About Me: Maximum 500 characters', 'woocommerce' ),'');
    }
}, 10, 1 );



// Registration extra fields ------------->
add_action('woocommerce_register_form_start', function () {
    ?>
<div class="col-md-6 form-group">
    <label for="billing_first_name" class="sr-only">
        <?php _e('First name', 'woocommerce'); ?>
        <span class="required text-danger">*</span></label>
        <div class="position-relative">
                    <i class="fas far fa-user"></i>
    <input type="text" class="form-control input-text" name="first_name" id="billing_first_name" value="<?php if (!empty($_POST['first_name'])) esc_attr_e(sanitize_title($_POST['first_name'])); ?>" autocomplete="given-name" required  placeholder="<?php _e('First name', 'woocommerce'); ?>" />
</div>
</div>
<div class="col-md-6 form-group">
    <label for="billing_last_name"  class="sr-only">
        <?php _e('Last name', 'woocommerce'); ?>
        <span class="required text-danger">*</span></label>
        <div class="position-relative">
                    <i class="fas far fa-user"></i>
    <input type="text" class="form-control input-text" name="last_name" id="billing_last_name" value="<?php if (!empty($_POST['last_name'])) esc_attr_e(sanitize_title($_POST['last_name'])); ?>" autocomplete="family-name" required  placeholder="<?php _e('Last name', 'woocommerce'); ?>"/>
</div>
</div>
<?php
});

// function wc_captcha_form(){
//  echo '<div class="clear"></div>
//  <hr>
//  <div class="form-group woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
//      <label>Captcha <span class="required text-danger">*</span></label>
//      <div class="g-recaptcha" data-sitekey="6LdsSiYUAAAAAOc7CorwHsjTqRccB0E4uVO9fUgP" style="margin:0 0 15px;"></div>
//      <div class="clear"></div>
//  </div>
//  <hr>';  
// }
// // Adding captcha woocommerce register and login forms
// add_action('woocommerce_register_form','wc_captcha_form');
// add_action('woocommerce_login_form', 'wc_captcha_form');



// Registration Validation --------->
add_action( 'woocommerce_register_post', function( $username, $email, $validation_errors ) 
{
    //print_r($_POST);
      /*  $resp=trim( $_POST['g-recaptcha-response']);
        $url='https://www.google.com/recaptcha/api/siteverify?secret=6LdsSiYUAAAAALqzdZONi1Y6gdgZuDCwcalES7ID&response='.$resp.'&remoteip='.trim($_SERVER['REMOTE_ADDR']);
        $args = array(
                'user-agent'  => 'Mozilla/7.0 (Windows NT 11.0; Win64; x64) AppleWebKit/600.00 (KHTML, like Gecko) Chrome/100 Safari/600.00',
                'compress'    => true,
                'decompress'  => true,
                'sslverify'   => false,
            ); 
        if(!$resp){
            $validation_errors->add( 'capcha_error', __( 'Please validate captcha', 'woocommerce' ) );
            
        }else{
            $response=wp_remote_post($url,$args);
            if ( is_wp_error( $response ) ) {
               $error_message = $response->get_error_message();
                $validation_errors->add( 'capcha_error', __( "Something went wrong: ".$error_message, 'woocommerce' ) );
            } else if( $response['response']['code']!='200') {
                $validation_errors->add( 'capcha_error', __( "Something went wrong: ".$response['response']['message'], 'woocommerce' ) );
            }
        }
*/
        if(validate_email_domain($email)){
            $validation_errors->add( 'email_error', __( 'Invalid email address!.', 'woocommerce' ) );
        }

        if ( isset( $_POST['first_name'] ) && ($first_name=sanitize_title($_POST['first_name'] )) && empty( $first_name ) ) {
            $validation_errors->add( 'first_name_error', __( 'First name is required!', 'woocommerce' ) );
        }

        if ( isset( $_POST['last_name'] ) && ($last_name=sanitize_title($_POST['last_name'] )) && empty( $last_name ) ) {
              $validation_errors->add( 'last_name_error', __( 'Last name is required!.', 'woocommerce' ) );
        }

        if( illegal_usernames($username) ){
            $validation_errors->add( 'username_error_0', __( 'Please use different username!.', 'woocommerce' ) );
        }

        if( strlen($username)<8){
            $validation_errors->add( 'username_error_1', __( 'Username character length is very short!.', 'woocommerce' ) );
        }
        
        
        if ($_POST['password_c'] !=  $_POST['password'] ) {
              $validation_errors->add( 'password_c_error', __( 'Passwords are not matching!.', 'woocommerce' ) );
        }
        
        return $validation_errors;

        //exit;
        
},10, 3 );



// login Validation --------->
/*add_filter( 'woocommerce_login_credentials', function($creds) 
{

        $resp=trim( $_POST['g-recaptcha-response']);
        $url='https://www.google.com/recaptcha/api/siteverify?secret=6LdsSiYUAAAAALqzdZONi1Y6gdgZuDCwcalES7ID&response='.$resp.'&remoteip='.trim($_SERVER['REMOTE_ADDR']);
        $args = array(
                'user-agent'  => 'Mozilla/7.0 (Windows NT 11.0; Win64; x64) AppleWebKit/600.00 (KHTML, like Gecko) Chrome/100 Safari/600.00',
                'compress'    => true,
                'decompress'  => true,
                'sslverify'   => false,
        );
        if(!$resp){
            throw new Exception( '<strong>' . __( 'Error:', 'woocommerce' ) . '</strong> ' . __( 'Please validate captcha', 'woocommerce' ) );
            //$validation_errors->add( 'capcha_error', __( 'Please validate captcha', 'woocommerce' ) );
        }else{
            $response=wp_remote_post($url,$args);
            if ( is_wp_error( $response ) ) {
               $error_message = $response->get_error_message();
                //$validation_errors->add( 'capcha_error', __( "Something went wrong: ".$error_message, 'woocommerce' ) );
                throw new Exception( '<strong>' . __( 'Error:', 'woocommerce' ) . '</strong> ' . __( "Something went wrong: ".$error_message, 'woocommerce' ) );
                
            } else if( $response['response']['code']!='200') {
                throw new Exception( '<strong>' . __( 'Error:', 'woocommerce' ) . '</strong> ' . __( "Something went wrong: ".$error_message, 'woocommerce' ) );
            }
        }
        return $creds;
    //}
        //exit;
},10,1 );
*/

//To save WooCommerce registration form custom fields. ------->
add_action('woocommerce_created_customer', function($customer_id)
{
    $full_name='';
    
    //First name field
    if (
        isset($_POST['first_name']) && 
        ($first_name=trim($_POST['first_name'])) &&  
        ($first_name=ucwords(sanitize_text_field($first_name)))  
    ){
        $full_name .= $first_name;
        update_user_meta($customer_id, 'first_name', $first_name);
        update_user_meta($customer_id, 'billing_first_name', $first_name);
    }
    
    //Last name field
    if (
        isset($_POST['last_name']) && 
        ($last_name=trim($_POST['last_name'])) &&  
        ($last_name=ucwords(sanitize_text_field($last_name)))  
    ){
        $full_name .=' '.$last_name;
        update_user_meta($customer_id, 'last_name',$last_name );
        update_user_meta($customer_id, 'billing_last_name', $last_name);
    }
    
    $arr=array( 
        'ID' => $customer_id, 
        'display_name' => $full_name,
        'nickname'=> $full_name
    );
    wp_update_user($arr);
});


// username filter ------------->
add_filter( 'woocommerce_new_customer_data', function($array){
    $username=@sanitize_user($array['user_login']);
    $username=@preg_replace('/[^a-zA-Z0-9]/', '', $username);
    $username=strtolower($username);
    $array['user_login']=$username;
    return $array; 

}, 10, 1 ); 


// remove account_display_name from required section ------------->
add_filter('woocommerce_save_account_details_required_fields', function( $required_fields ){
    unset( $required_fields['account_display_name'] );
    return $required_fields;
});



function guai_aid_woocommerce_form_field( $key, $args, $value = null ) 
{ 
    $defaults = array( 
        'type' => 'text',  
        'label' => '',  
        'description' => '',  
        'placeholder' => '',  
        'maxlength' => false,  
        'required' => false,  
        'autocomplete' => false,  
        'id' => $key,  
        'class' => array(),  
        'label_class' => array(),  
        'input_class' => array(),  
        'return' => false,  
        'options' => array(),  
        'custom_attributes' => array(),  
        'validate' => array(),  
        'default' => '',  
        'autofocus' => '',  
        'priority' => '',  
 ); 
 
    $args = wp_parse_args( $args, $defaults ); 
    $args = apply_filters( 'woocommerce_form_field_args', $args, $key, $value ); 
 
    if ( $args['required'] ) { 
        $args['class'][] = 'validate-required'; 
        $args['custom_attributes']['required']='required';
        $required = '<span class="required text-danger" title="' . esc_attr__( 'required', 'woocommerce' ) . '">*</span>'; 
    } else { 
        $required = ''; 
    } 
 
    if ( is_string( $args['label_class'] ) ) { 
        $args['label_class'] = array( $args['label_class'] ); 
    } 
 
    if ( is_null( $value ) ) { 
        $value = $args['default']; 
    } 
 
    // Custom attribute handling 
    $custom_attributes = array(); 
    $args['custom_attributes'] = array_filter( (array) $args['custom_attributes'] ); 
 
    if ( $args['maxlength'] ) { 
        $args['custom_attributes']['maxlength'] = absint( $args['maxlength'] ); 
    } 
 
    if ( ! empty( $args['autocomplete'] ) ) { 
        $args['custom_attributes']['autocomplete'] = $args['autocomplete']; 
    } 
 
    if ( true === $args['autofocus'] ) { 
        $args['custom_attributes']['autofocus'] = 'autofocus'; 
    } 
 
    if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) { 
        foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) { 
            $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"'; 
        } 
    } 
 
    if ( ! empty( $args['validate'] ) ) { 
        foreach ( $args['validate'] as $validate ) { 
            $args['class'][] = 'validate-' . $validate; 
        } 
    } 
 
    $field = ''; 
    $label_id = $args['id']; 
    $sort = $args['priority'] ? $args['priority'] : ''; 
    $field_container = '<div class="%1$s"><div class="form-group" id="%2$s" data-priority="' . esc_attr( $sort ) . '">%3$s</div></div>'; 
 
    switch ( $args['type'] ) 
    { 
        case 'country' : 
 
            $countries = 'shipping_country' === $key ? WC()->countries->get_shipping_countries() : WC()->countries->get_allowed_countries(); 
 
            if ( 1 === sizeof( $countries ) ) { 
 
                $field .= '<strong>' . current( array_values( $countries ) ) . '</strong>'; 
 
                $field .= '<input type="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="' . current( array_keys( $countries ) ) . '" ' . implode( ' ', $custom_attributes ) . ' class="country_to_state" />'; 
 
            } else { 
 
                $field = '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="country_to_state country_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . '>' . '<option value="">' . esc_html__( 'Select a country…', 'woocommerce' ) . '</option>'; 
 
                foreach ( $countries as $ckey => $cvalue ) { 
                    $field .= '<option value="' . esc_attr( $ckey ) . '" ' . selected( $value, $ckey, false ) . '>' . $cvalue . '</option>'; 
                } 
 
                $field .= '</select>'; 
 
                $field .= '<noscript><input type="submit" name="woocommerce_checkout_update_totals" value="' . esc_attr__( 'Update country', 'woocommerce' ) . '" /></noscript>'; 
 
            } 
 
            break; 
        case 'state' : 
 
            /** Get Country */ 
            $country_key = 'billing_state' === $key ? 'billing_country' : 'shipping_country'; 
            $current_cc = WC()->checkout->get_value( $country_key ); 
            $states = WC()->countries->get_states( $current_cc ); 
 
            if ( is_array( $states ) && empty( $states ) ) { 
              $field_container = '<div class="form-group %1$s" id="%2$s" style="display: none">%3$s</div>'; 
                 $field .= '<input type="hidden" class="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="" ' . implode( ' ', $custom_attributes ) . ' placeholder="' . esc_attr( $args['placeholder'] ) . '" />'; 
 
            } elseif ( ! is_null( $current_cc ) && is_array( $states ) ) { 
                
                $field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="state_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ) . '"> 
                    <option value="">' . esc_html__( 'Select a state…', 'woocommerce' ) . '</option>'; 
                foreach ( $states as $ckey => $cvalue ) { 
                    $field .= '<option value="' . esc_attr( $ckey ) . '" ' . selected( $value, $ckey, false ) . '>' . $cvalue . '</option>'; 
                } 
                $field .= '</select>'; 
 
            } else { 
                $field .= '<input type="text" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" value="' . esc_attr( $value ) . '"  placeholder="' . esc_attr( $args['placeholder'] ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" ' . implode( ' ', $custom_attributes ) . ' />'; 
            } 
 
            break; 
        case 'textarea' : 
 
            $field .= '<textarea name="' . esc_attr( $key ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . ( empty( $args['custom_attributes']['rows'] ) ? ' rows="2"' : '' ) . ( empty( $args['custom_attributes']['cols'] ) ? ' cols="5"' : '' ) . implode( ' ', $custom_attributes ) . '>' . esc_textarea( $value ) . '</textarea>'; 
 
            break; 
        case 'checkbox' : 
 
            $field = '<label class="checkbox ' . implode( ' ', $args['label_class'] ) . '" ' . implode( ' ', $custom_attributes ) . '> 
                    <input type="' . esc_attr( $args['type'] ) . '" class="input-checkbox ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="1" ' . checked( $value, 1, false ) . ' /> ' 
                     . $args['label'] . $required . '</label>'; 
 
            break; 
        case 'password' : 
        case 'text' : 
        case 'email' : 
        case 'tel' : 
        case 'number' : 
 
            $field .= '<input type="' . esc_attr( $args['type'] ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '"  value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />'; 
 
            break; 
        case 'select' : 
 
            $options = $field = ''; 
 
            if ( ! empty( $args['options'] ) ) { 
                foreach ( $args['options'] as $option_key => $option_text ) { 
                    if ( '' === $option_key ) { 
                        // If we have a blank option, select2 needs a placeholder 
                        if ( empty( $args['placeholder'] ) ) { 
                            $args['placeholder'] = $option_text ? $option_text : __( 'Choose an option', 'woocommerce' ); 
                        } 
                        $custom_attributes[] = 'data-allow_clear="true"'; 
                    } 
                    $options .= '<option value="' . esc_attr( $option_key ) . '" ' . selected( $value, $option_key, false ) . '>' . esc_attr( $option_text ) . '</option>'; 
                } 
 
                $field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ) . '"> 
                        ' . $options . ' 
                    </select>'; 
            } 
 
            break; 
        case 'radio' : 
 
            $label_id = current( array_keys( $args['options'] ) ); 
 
            if ( ! empty( $args['options'] ) ) { 
                foreach ( $args['options'] as $option_key => $option_text ) { 
                    $field .= '<input type="radio" class="input-radio ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" value="' . esc_attr( $option_key ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '"' . checked( $value, $option_key, false ) . ' />'; 
                    $field .= '<label for="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '" class="radio ' . implode( ' ', $args['label_class'] ) . '">' . $option_text . '</label>'; 
                } 
            } 
 
            break; 
    } 
 
    if ( ! empty( $field ) ) { 
        $field_html = ''; 
 
        if ( $args['label'] && 'checkbox' != $args['type'] ) { 
            $field_html .= '<label for="' . esc_attr( $label_id ) . '" class="' . esc_attr( implode( ' ', $args['label_class'] ) ) . '">' . $args['label'] . $required . '</label>'; 
        } 
 
        $field_html .= $field; 
 
        if ( $args['description'] ) { 
            $field_html .= '<span class="description">' . esc_html( $args['description'] ) . '</span>'; 
        } 
        $container_class = esc_attr( implode( ' ', $args['class'] ) ); 
        $container_class = str_replace( array('form-row-first','form-row-last'),'col-md-6',$container_class);
        $container_class = str_replace( 'form-row-wide','col-12',$container_class);
        $container_id = esc_attr( $args['id'] ) . '_field'; 
        $field = sprintf( $field_container, $container_class, $container_id, $field_html ); 
    } 
 
    $field = apply_filters( 'woocommerce_form_field_' . $args['type'], $field, $key, $args, $value ); 
 
    if ( $args['return'] ) { 
        return $field; 
    } else { 
        echo $field; 
    } 
}


function guai_aid_wc_get_account_menu_item_classes( $endpoint ) 
{ 
    global $wp; 
     $classes = array( 
        'list-group-item',
        'list-group-item-action',
        'mt-n1',
        'd-block',
        'list-group-item-' . $endpoint,  
    ); 
 
    // Set current item class. 
    $current = isset( $wp->query_vars[ $endpoint ] ); 
    if ( 'dashboard' === $endpoint && ( isset( $wp->query_vars['page'] ) || empty( $wp->query_vars ) ) ) { 
        $current = true; // Dashboard is not an endpoint, so needs a custom check. 
    } 
    if ( $current ) { 
        $classes[] = 'active'; 

    } else  if (isset( $wp->query_vars['view-order'] )  && $endpoint=='orders' ) { 
        $classes[] = 'active'; 
    } 
    return implode( ' ', array_map( 'sanitize_html_class', $classes ) ); 
}


add_action('woocommerce_after_add_to_cart_button',function()
{
    if($uid=get_current_user_id()){
        global $product;
        $ids = (array)get_metadata( 'user', $uid, 'wishlist_items',true );
        $pid=$product->get_ID();

        if(!in_array($pid,$ids) ){
            echo'<button class="btn add-to-wishlist" type="button" data-product="'.$pid.'"><i class="fas fa-heart mr-2"></i><span>'.__('Add to Wishlist','guai-aid').'</span>';
        }else{
            echo'<button class="btn remove-wishlist" type="button" data-product="'.$pid.'"><i class="fas fa-heart mr-2"></i><span>'.__('Remove From Wishlist','guai-aid').'</span>';
        }
        echo '</button>';
    }
});


add_filter( 'woocommerce_demo_store', function($notice){
    return str_replace( array('<p','</p>'),array('<div','</div>'),$notice);
});

function validate_email_domain($email)
{
    $not_allowed = [
        'vdsina.ru',
        'mail.ru',
        'yandex.com',
        'qq.com',
        'info89.ru',
        'canadianpharmacyrxp.bid',
        'bk.ru',
        'rambler.ru',
        'ilink.ml',
        'post.opole.pl',
    ];
    if (filter_var($email, FILTER_VALIDATE_EMAIL)){
        $parts = explode('@', $email);
        $domain = array_pop($parts);
        if (in_array($domain, $not_allowed)){ return true; }
    }
    return false;
}
    
function illegal_usernames($username){
    $array= array( 
        'blog','guai-aid','lines','admin','administrator','site','author','subscriber','info', "www", "web", 
        "root", "admin", "main", "invite",'user','admins'
    );
    return in_array($username, $array);
}

function guai_aid_woocommerce_page_title( $echo = true ) { 
 
    if ( is_search() ) { 
        $page_title = sprintf( __( 'Search results: “%s”', 'woocommerce' ), get_search_query() ); 
 
        if ( get_query_var( 'paged' ) ) 
            $page_title .= sprintf( __( ' – Page %s', 'woocommerce' ), get_query_var( 'paged' ) ); 
 
    } elseif ( is_tax() ) { 
        $term = get_queried_object();
        if($term->term_id=='40'){
            $page_title =__('Distinguished gentleman','guai-aid');
        }else{
            $page_title = $term->name;
        }
 
    } else { 
 
        $shop_page_id = wc_get_page_id( 'shop' ); 
        $page_title = get_the_title( $shop_page_id ); 
 
    } 
 
    $page_title = apply_filters( 'woocommerce_page_title', $page_title ); 
 
    if ( $echo ) 
        echo $page_title; 
    else 
        return $page_title; 
} 