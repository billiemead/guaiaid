<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !is_admin() ) {
    return 0;
}

add_action( 'admin_enqueue_scripts', function () {
    wp_enqueue_style( 'admin-styles', guai_aid_asset( 'css', 'admin.css' ), array(), NULL, 'screen' );
} );



// Acf Relationship filter ------------------------->
add_filter( 'acf/fields/relationship/result', function ( $title, $post, $field, $post_id ) 
{
    
    if ( !$post_id ) {
        $post_id = acf_get_form_data( 'post_id' );
    }
    $title = acf_get_post_title( $post );




    if ( ( ( $field[ '_name' ] == 'top_attractions' )  || ( $field[ 'name' ] == 'top_attractions' ) ) && ($post->post_type=='attraction' )  &&( $term= get_term_by('id',get_post_meta( $post->ID,'attr_destination', true),'tour_destination'))) 
    {
        
        $title = $title.' (<strong>'.$term->name.'</strong>)' ;


    }else if ( ( ( $field[ '_name' ] == 'package_tours' )  || ( $field[ 'name' ] == 'package_tours' ) )  && ( $days = get_post_meta( $post->ID, 'days', true ) ) )   {
        
        if ( ( $t_type = get_post_meta( $post->ID, 'tour_list_type', true ) ) && $t_type == 'treatment' ) {

        } else {
            $title = $days . ' Days & ' . ( $days - 1 ) . ' Nights - ' . $title;
        }
    }
    if ( acf_in_array( 'featured_image', $field[ 'elements' ] ) && ( $thumbnail = acf_get_post_thumbnail( $post->ID, array( 17, 17 ) ) ) ) {
        $class = 'thumbnail';
        if ( $thumbnail[ 'type' ] == 'icon' ) {
            $class .= ' -' . $thumbnail[ 'type' ];
        }
        $title = '<div class="' . $class . '">' . $thumbnail[ 'html' ] . '</div>' . $title;
    }
    return $title;
}, 10, 4 );


add_filter( 'acf/fields/relationship/query', function ( $args, $field, $options ) {
    if (
        ( $field[ 'name' ] == 'top_attractions' ) &&
        is_string( $options ) &&
        strstr( $options, 'term_' )
    ) {
        $args[ 'meta_query' ] = array(
            'relation' => 'AND',
            array(
                'key' => 'attr_destination',
                'value' => str_replace( 'term_', '', $options ),
                'compare' => '=',
            ),
        );
    }else  if ( ( $field[ 'name' ] == 'top_attractions' ) ){
        $args[ 'meta_key'] = 'attr_destination';
         $args['orderby'] = 'meta_value_num';
         $args['order'] ='ASC';
    }
    return $args;
}, 10, 3 );

/*add_filter('acf/pre_render_fields', function( $fields, $post_id  )
{
    $_fields=array();
    global $wpdb;
    if( $fields ) 
    {
        foreach( $fields as $field ) 
        {
           if( ($field['name']=='package_tours') && ($post_id) )
           {
                if( $field['value'] === null ) {
                    $values= (array)acf_get_value( $post_id, $field );
                }else{
                    $values=(array)trim($field['value']);
                }
                $get_values = (array)$wpdb->get_col("SELECT DISTINCT post_id FROM ".$wpdb->prefix."postmeta where meta_key ='package_tours' and meta_value ='".$post_id."'");  
                $field['value']=array_merge($values,$get_values);
           } 
           $_fields[]=$field;
        }
        $fields=$_fields;
    }
   return $fields;
},10, 2);*/

/*add_filter('pods_field_dfv_data', function($data, $args, $attributes)
{ 
    global $wpdb, $post;
    $qry="SELECT DISTINCT post_id FROM ".$wpdb->prefix."postmeta where `meta_key` = 'package_tours' AND `meta_value` LIKE '%".$post->ID."%'";  

    if( ($attributes['name']=='pods_meta_package_tours') &&($get_values = (array)$wpdb->get_col($qry))  )
    {
        foreach (array_merge($args->value,$get_values) as $key => $item) {
            $value[$item]=$item;
        } 
        $args->value= $value;
        $PodsField = new PodsField_Pick;
        $data['fieldItemData'] = $PodsField->build_dfv_field_item_data( $args );   
    }
return $data;
},10,3);*/


// Rating meta box------------------>
add_action( 'add_meta_boxes_comment', function ( $comment ) {
    if (
        ( get_post_type( $comment->comment_post_ID ) == 'tour' ) ||
        ( $comment->comment_type == 'tour_review ' )
    ) {
        add_meta_box( 'title', __( 'Rating', 'guai-aid' ), function ( $comment ) {
            $rating = get_comment_meta( $comment->comment_ID, 'rating', true );
            wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false );
            echo '<table class="form-table editcomment">';
            foreach ( guai_aid_tour_rating_options() as $key => $option ) {
                $rating_select = '';
                for ( $i = 1; $i <= 5; $i++ ) {
                    if ( isset( $rating[ $key ] ) && ( $rating[ $key ] == $i ) ) {
                        $rating_select .= '<option value="' . $i . '" selected>' . $i . '</option>';
                    } else {
                        $rating_select .= '<option value="' . $i . '">' . $i . '</option>';
                    }
                }
                echo '<tr>
                            <th><label for="option-' . $key . '">' . $option . '</label></th>
                            <td><select id="option-' . $key . '" name="rating[' . $key . ']" class="widefat">' . $rating_select . '</select></td>
                        </tr>';
            }
            echo '</table>';
        }, 'comment', 'normal', 'high' );
    }
} );
// Updating Rating meta box------------------> 
add_filter( 'comment_save_pre', function ( $comment_content ) {
    global $wpdb;
    $comment = ( object )array_filter( $_POST );
    if (
        (
            ( get_post_type( $comment->comment_post_ID ) == 'tour' ) ||
            ( $comment->comment_type == 'tour_review ' )
        ) &&
        isset( $comment->rating ) &&
        ( $rating = array_filter( $comment->rating, 'trim' ) )

    ) {
        if ( !$post = get_post( $comment->comment_post_ID ) ) {
            return $comment_content;
        }
        update_comment_meta( $comment->comment_ID, 'rating', $rating );
        wp_update_comment_count( $comment->comment_post_ID );
    }
    return $comment_content;
} );


// function tax_term_fileds(){	
// 	echo '<input type="text" name="term_last_updated" id="term_last_updated" value="'.time().'">';
// }
// add_action( 'tour_destination_add_form_fields', 'tax_term_fileds', 10, 2 );
// add_action( 'tour_destination_edit_form_fields', 'tax_term_fileds', 10, 2 );


add_action( 'edit_term',function($term_id, $tt_id, $taxonomy){
   update_term_meta( $term_id, 'term_last_updated', time() );
}, 10, 3 );


// Social media profile links fields in user profile page  ------------------>
add_filter('user_contactmethods', function ($profile_fields) {
    $profile_fields['guai_aid_twitter'] = __('Twitter Username', 'guai-aid');
    $profile_fields['guai_aid_facebook'] = __('Facebook URL', 'guai-aid');
    $profile_fields['guai_aid_instagram'] = __('Instagram URL', 'guai-aid');
    $profile_fields['guai_aid_gplus'] = __('Google+ URL', 'guai-aid');
    $profile_fields['guai_aid_flickr'] =__( 'Flickr URL', 'guai-aid');
    $profile_fields['guai_aid_github'] =__( 'Github URL', 'guai-aid');
    $profile_fields['guai_aid_pinterest'] =__( 'Pinterest URL', 'guai-aid');
    $profile_fields['guai_aid_tumblr'] =__( 'Tumblr URL', 'guai-aid');
    $profile_fields['guai_aid_medium'] =__( 'Medium URL', 'guai-aid');
    return $profile_fields;
});

    
?>