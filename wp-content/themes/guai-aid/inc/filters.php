<?php 
    if (!defined('ABSPATH')) { 
        exit; 
    } 


   // Adding body class --------------->
    add_filter('body_class', function( $classes ) 
    {
        $classes[] = get_theme_mod( 'guai_aid_columns', 'multi' ) . '-column';

        if (is_multi_author() ) {
            $classes[] = 'group-blog';
        }else{
            $classes[] = 'single-author';
        }
        if (!guai_aid_active_sidebars()) {
            $classes[] = 'no-sidebar';
        }
        if ( is_singular() ) {
            $classes[] = 'singular';
        }
        return $classes;
    });

    // Adds custom classes to the array of post classes. ------------------>
    add_filter( 'post_class', function ( $classes, $class, $post_id  ) 
    {
        $classes = array_diff( $classes, array( 'hentry' ) );
        if( in_array(guai_aid_post_type(),array('post','page','package') ) ){
            $classes[] = 'hentry';  
        } 

        if( is_single() || ('page' === guai_aid_post_type()) ){
            $classes[] = 'single-item single-item-'.guai_aid_post_type();
        } 
        return array_unique( $classes );
    }, 10, 3 );


    // Adding comment class --------------->
    add_filter( 'comment_class', function ( $classes ) {
        $classes[] = 'comment';
        return array_unique( $classes );
    }, 99 );



    // Avatar  -------------->
    add_filter( 'pre_get_avatar_data', function( $args, $id_or_email )
    {
        if ( ! isset( $args['class'] ) ) {
            $args['class'] = array();
        }
        $args['class'] = array_unique( array_merge( $args['class'], array( 'u-photo full-border img-fluid' ) ) );
        $args['alt']="author photo";
        return $args;
    }, 99, 2 );
    add_filter( 'get_avatar_comment_types', function($allowed_comment_types){
        $allowed_comment_types[]='tour_review';
       return $allowed_comment_types;
    },10, 2);


    // Excerpt more --------------->
    add_filter('excerpt_more', function ( $more ) {
        $link='';
        if(! is_admin() && in_array(guai_aid_post_type(),array('post','page')) ) {
           // $link = sprintf('<span class="clearfix clear d-block"></span><a href="%1$s" class="more-link read-more btn btn-outline-danger mt-4" rel="bookmark">%2$s</a>', esc_url(get_permalink(get_the_ID())), sprintf(__('Continue Reading %s', 'guai-aid'), '<span class="screen-reader-text sr-only">'.get_the_title(get_the_ID()).'</span><i class="fa fa-arrow-right"></i>'));
            return '&hellip; ' . $link;
        }
    });


    // Excerpt character length --------------->
    add_filter('excerpt_length', function ( $length ) 
    {
        return 15;
    }, 999);


    // Archive title --------------------->
    add_filter('get_the_archive_title', function($title )
    {
        
        $rss='';
        if (is_search()) {
            $title = __('Searching for:', 'guai-aid');
            $type=get_search_query();

        }elseif (is_category() ) {
            $title = single_cat_title('', false) ;
            $type= __('Category', 'guai-aid');
            $rss=get_category_feed_link(get_query_var('cat'));

        } elseif (is_tag() ) {
            $title = single_tag_title('', false) ;
            $type=__('Tag Archive', 'guai-aid');
            $rss=get_tag_feed_link(get_query_var('tag_id')); 

        } elseif (is_author() ) {
            $title = get_the_author()  ;
            $type= __('Author', 'guai-aid');
            $rss= get_author_feed_link(get_the_author_meta('ID'));

        } elseif (is_year() ) {
            $title = get_the_date(__('Y', 'guai-aid'))   ;
            $type=__('Yearly Archives', 'guai-aid');

        } elseif (is_month() ) {
            $title = get_the_date(__('F Y', 'guai-aid'))   ;
            $type=__('Monthly Archives ', 'guai-aid');

        } elseif (is_day() ) {
            $title = get_the_date(__('F j, Y', 'guai-aid'))   ;
            $type=__('Daily Archives', 'guai-aid');

        } elseif (is_post_type_archive() ) {
            $title = post_type_archive_title('', false);
            $type='';
            $rss=get_post_type_archive_feed_link(get_query_var('post_type'));

        } elseif (is_tax() ) {
            $tax = get_taxonomy(get_queried_object()->taxonomy);
            $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            $title = single_term_title('', false) ;
            $type=$tax->labels->singular_name;
            $rss=get_term_feed_link($term->term_id, get_query_var('taxonomy')); 

        }else {
            $title = '' ;//__( '<span>Blog Archives:</span> <strong>All Posts</strong>' );
            $type='';
            $rss=get_bloginfo('rss2_url');
        }
        
        if(guai_aid_post_type()=='post' && $title) {
            $title='<strong>'.$title.'</strong>';
            $title .='&nbsp; <span class="type">'.$type.'</span>';
            if($rss){
                $title .='<a href="'.$rss.'" title="'.esc_attr(__('Subscribe this', 'guai-aid')).'" class="subscribe btn btn-sm" rel="noopener noreferrer" target="_blank"><i class="fas fa-rss mr-2"></i><strong class="">'.__('Subscribe', 'guai-aid').'</strong></a>   ';
            }
        }
        return $title;
    });  



    // add the filter for search widget title ....
    add_filter( 'widget_title', function( $instance_title='', $instance='',$this_id_base='') 
    { 
        if($this_id_base=='search' || $this_id_base=='woocommerce_product_search'){
            $instance_title = ! empty( $instance['title'] ) ? $instance['title'] :__('Search','guai-aid');
        } 
        else if($this_id_base=='media_audio'){
            $instance_title = ! empty( $instance['title'] ) ? $instance['title'] :__('Audio','guai-aid');
        } 
        else if($this_id_base=='media_video'){
            $instance_title = ! empty( $instance['title'] ) ? $instance['title'] :__('Video','guai-aid');
        }
        else if($this_id_base=='media_gallery'){
            $instance_title = ! empty( $instance['title'] ) ? $instance['title'] :__('Gallery','guai-aid');
        }
        else if($this_id_base=='media_image'){
            $instance_title = ! empty( $instance['title'] ) ? $instance['title'] :__('Image','guai-aid');
        } 
        else if($this_id_base=='calendar'){
            $instance_title = ! empty( $instance['title'] ) ? $instance['title'] :__('Calendar','guai-aid');
        } 
        return $instance_title; 
    } , 10, 3 );


    add_filter( 'nav_menu_link_attributes', function ( $atts, $item, $args, $depth ) 
    {
        // Add [aria-haspopup] and [aria-expanded] to menu items that have children
        $item_has_children = in_array( 'menu-item-has-children', $item->classes );
        if ( $item_has_children ) {
            $atts['aria-haspopup'] = 'true';
            $atts['aria-expanded'] = 'false';
        }
        return $atts;
    }, 10, 4 );

   

    add_filter( 'walker_nav_menu_start_el', function ( $output, $item, $depth, $args ) 
    {
        // Only add class to 'top level' items on the 'primary' menu.
        if ( ! isset( $args->theme_location ) || 'menu-1' !== $args->theme_location ) {
            return $output;
        }    if ( in_array( 'mobile-parent-nav-menu-item', $item->classes, true ) && isset( $item->original_id ) ) 
        {
            // Inject the keyboard_arrow_left SVG inside the parent nav menu item, and let the item link to the parent item.
            // @todo Only do this for nested submenus? If on a first-level submenu, then really the link could be "#" since the desire is to remove the target entirely.
            $link = sprintf(
                '<button class="menu-item-link-return" tabindex="-1">%s',
                guai_aid_get_icon_svg( 'chevron_left', 24 )
            );        // replace opening <a> with <button>
            $output = preg_replace('/<a\s.*?>/', $link, $output, 1 );        // replace closing </a> with </button>
            $output = preg_replace('#</a>#i','</button>',$output, 1 );    } elseif ( in_array( 'menu-item-has-children', $item->classes, true ) ) {
            $output .= '<button class="submenu-expand" tabindex="-1"><i class="fas fa-down-arraow"></i></button>';
        }    return $output;
    }, 10, 4 );



    add_filter( 'wp_nav_menu_objects', function ( $sorted_menu_items, $args ) 
    {
        static $pseudo_id = 0;
        if ( ! isset( $args->theme_location ) || 'menu-1' !== $args->theme_location ) {
            return $sorted_menu_items;
        }
        $amended_menu_items = array();
        foreach ( $sorted_menu_items as $nav_menu_item ) {
            $amended_menu_items[] = $nav_menu_item;
            if ( in_array( 'menu-item-has-children', $nav_menu_item->classes, true ) ) {
                $parent_menu_item                   = clone $nav_menu_item;
                $parent_menu_item->original_id      = $nav_menu_item->ID;
                $parent_menu_item->ID               = --$pseudo_id;
                $parent_menu_item->db_id            = $parent_menu_item->ID;
                $parent_menu_item->object_id        = $parent_menu_item->ID;
                $parent_menu_item->classes          = array( 'mobile-parent-nav-menu-item' );
                $parent_menu_item->menu_item_parent = $nav_menu_item->ID;
                $amended_menu_items[] = $parent_menu_item;
            }
        }
        return $amended_menu_items;
    }, 10, 2 );



    // pagination Markup filter ----------------->
    add_filter( 'navigation_markup_template', function ( $template, $class ){
        $template = guai_aid_paginate_links();
        return $template;
    }, 10, 2 );

    // Tag cloud 
    /*    add_filter( 'widget_tag_cloud_args', function($args){
       $args = array(        //'format' => 'list', 
        );
        return $args;
    });*/
    add_filter( 'wp_tag_cloud', function($return, $args ) 
    {    $return= preg_replace('/class="tag-cloud-link/', 'class="tag-cloud-link btn btn-sm btn-outline-dark m-1', $return);
        $return= preg_replace("/style='font-size:.+pt;'/", '', $return);
        $return= preg_replace('/style="font-size:.+pt;"/', '', $return);    return $return;
    }, 10, 2 );
    
    add_filter('get_image_tag_class',  function ($class){
        $class .= ' img-fluid';
        return $class;
    });

    // Styling tags ------------>
    add_filter( "term_links-post_tag", function($links){
        $new_lainks=array();
        if(count($links)>0){
            foreach ($links as $key => $link) {
                $new_lainks[]=str_replace('rel="tag"',' rel="tag" class="btn btn-sm btn-outline-dark mr-2"', $link);
            }
            return $new_lainks;
        }
        return $links;
    });


    // Gallery 
    add_filter( 'post_gallery', function($attr=array(),$arr=array(),$instance='' ) 
    {
        global $post;
        if( isset($attr) && is_array($attr) && count($attr)>0){    
            $atts=array_filter($attr);
        }else if( isset($arr) && is_array($arr) && count($arr)>0){    
            $atts=array_filter($arr);
        }else{ 
            $atts=array();
        }

        $defaults=array(
                'order'      => 'ASC',
                'orderby'    => 'menu_order ID',        
                'ids'         =>'',        
                'post__in' => '',        
                'columns'    => 3,        
                'size'       => 'thumbnail',        
                'include'    => '',        
                'exclude'    => '',        
                'link'       => '',        
                'id'         => $post->ID
            );
        $atts  = shortcode_atts( $defaults,$atts,'gallery');
        $id = intval( $atts['id'] );

        $args=array( 
                'post_status'    => 'inherit', 
                'post_type'      => 'attachment',
                'post_mime_type' => 'image',
                'order'          => $atts['order'],
                'orderby'        => $atts['orderby']
            );

        if ( ! empty( $atts['ids'] ) ) {   
            $args['include']=$atts['ids'];

        } elseif ( ! empty( $atts['post__in'] ) ) {    
            $args['post__in']=$atts['post__in'];

        } elseif ( ! empty( $atts['include'] ) ) {    
            $args['include']=$atts['include'];

        } elseif ( ! empty( $atts['exclude'] ) ) {   
            $args['post_parent']=$id;    
            $args['exclude']=$atts['exclude']; 

        } else {    
            $args['post_parent']=$id;
        }

        $attachments = get_posts($args);
        if ( empty($attachments) )    { 
            return ''; 
        }

        if ( is_feed() ) {    
            $output = "\n";    
            foreach ( $attachments as $att_id => $attachment ){       
                $output .= wp_get_attachment_link($attachment->ID, $size, true) . "\n";   
            }
            return $output;
        }
        $columns=array('0'=>'0', '1'=>'12', '2'=>'6', '3'=>'4', '4'=>'3', '5'=>'2', '6'=>'1');
        $column   = intval( $atts['columns'] );
        $itemwidth = $column > 0 ? floor( 100 / $column ) : 100;
        $float     = is_rtl() ? 'right' : 'left';
        $selector = "gallery-{$instance}";
        $gallery_style = '';
        $size_class  = sanitize_html_class( $atts['size'] );
        $i = 0;
        $output = "<div class=\"clear clearfix\">
        <div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$column} gallery-size-{$size_class}'><div class='row'>";
        
        foreach ( $attachments as $id => $attachment ) 
        {    
            $attr=array();
            if( trim( $attachment->post_excerpt ) ) {
                $attr['aria-describedby'] ="$selector-$id"; 
            }
            $attr['class']='img-fluid w-100';

            if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {        
                $image_output = wp_get_attachment_link( $attachment->ID, $atts['size'], false, false, false, $attr );
                $image_output=str_replace('href=', 'rel="gall-img-group" class="fancy-box-a" href=', $image_output);

            } elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {        
                $image_output = wp_get_attachment_image( $attachment->ID, $atts['size'], false, $attr );
            } else {        
                $image_output = wp_get_attachment_link( $attachment->ID, $atts['size'], true, false, false, $attr );            
            }  

            $image_meta = wp_get_attachment_metadata( $attachment->ID );
            $orientation = '';    
            if ( isset( $image_meta['height'], $image_meta['width'] ) ) {        
                $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';    
            }   
            $output .= '<div class="col-sm-6 col-md-6 col-lg-'.$columns[$column].' col-xl-'.$columns[$column].' gallery-item-wrap">    
            <figure class="gallery-item">               
             <div class="gallery-icon bg-grey '.$orientation.'">'.$image_output.'</div>';    
             if ( trim( $attachment->post_excerpt ) ) {        
                $output .= "<figcaption class='wp-caption-text gallery-caption' id='$selector-$id'>" .wptexturize( $attachment->post_excerpt ) . "</figcaption>";    
            }    
            $output .= "</figure>     </div>"; 
        }
        $output .= " </div>    </div>\n";
        return $output;
    }, 10, 3 );

    
    // Comments & tour reviews -------------->
        add_filter( 'edit_comment_link', function($link, $comment_ID, $text ){
            $link=str_replace('comment-edit-link', 'comment-edit-link nav-link', $link);
            return $link;
        }, 10, 3);

        add_filter( 'comment_reply_link', function($link, $args , $comment ,$post  ){
            $link=str_replace('comment-reply-link', 'comment-reply-link nav-link', $link);
            return $link;
        }, 10, 4);

        add_filter( 'cancel_comment_reply_link', function($formatted_link, $link , $text  ){
            $formatted_link=str_replace('rel="nofollow"', 'rel="nofollow" class="btn btn-sm btn-danger text-white"', $formatted_link);
            return $formatted_link;
        }, 10, 3);
         
        add_filter( 'get_comment_link', function($link, $comment, $args, $cpage)
        {
            if( 
                  (get_post_type($comment->comment_post_ID)=='tour') ||
                  ($comment->comment_type=='tour_review ')
              ){
                $link=str_replace('#comment-'.$comment->comment_ID, '#reviews-tab',$link);
            }
           return $link;
        }, 10 , 4 );




  

    
    // the_content() filter ---------------->
    add_filter('the_content',function( $content)
    {
        $content=guai_aid_content_replace($content);
        if($content && is_singular('tour')){
           $content= '<div class="entry-content-wrap">'.$content.'<div class="clearfix"></div></div>';
        }  
        return $content;      
    });
   
    // Outbound links plugin  --------->
    add_filter('whitelist_outbound_domains',function($domains){
        $domains[]='guai-aid.com';
        return $domains;
    });


    //add rel="preload"  attribute from CSS & JS
    add_filter('style_loader_tag', function($tag, $handle){
        preg_match_all('/<link[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $tag, $result);
        if (!empty($result)) {
            return '<link rel="preload" as="style" href="'.$result['href'][0].'">'."\n".$tag; 
        }     
        return $tag;    
        //return preg_replace( "/rel=['\"]text\/(css)['\"]/", '', $tag );
    }, 10, 2);

    // add_filter('script_loader_tag', function($tag, $handle){
    //    preg_match_all('/<script[^>]+src=([\'"])(?<src>.+?)\1[^>]*>/i', $tag, $result);
    //     if (!empty($result)) {
    //         $tag .='<link rel="preload" as="script" href="'.$result['src'][0].'">'; 
    //     }   
    //     return $tag; 
    //    //return preg_replace( "/type=['\"]text\/(javascript)['\"]/", '', $tag );
    // }, 10, 2);


   
    // Yoas seo -------------->
    add_filter( 'wpseo_json_ld_output', '__return_false' );

    add_filter( 'wpseo_sitemap_entry',  function( $url, $type, $term ) { 
        if( in_array($term->taxonomy,array( 'tour_destination' )) &&  ($dates=guai_aid_get_term_last_updated_dates($term)) && isset($dates['updated']) ){
           $url['mod']=date('c',$dates['updated']);
        }  
        return $url; 
    } , 10, 3 );

    add_filter( 'wpseo_twitter_title',  function( $title ) { 
        $title =trim($title);
        global $post,$wp_query;
        if(empty($title) && isset($post) && !isset($wp_query->query_vars['taxonomy'])){
           return get_post_meta($post->ID, '_yoast_wpseo_title', true);
        }
       return $title;
    });

    add_filter( 'wpseo_twitter_description',  function( $description ) { 
        $description =trim($description);
        global $post,$wp_query;
        if(empty($description) && isset($post) && !isset($wp_query->query_vars['taxonomy'])){
           return get_post_meta($post->ID, '_yoast_wpseo_metadesc', true);
        }
        return $description;
    });

    add_filter( 'wpseo_twitter_image',  function( $image ) { 
        $image =trim($image);
        global $post,$wp_query;
        if( empty($image) && isset($wp_query->query_vars['taxonomy']) && ($img=guai_aid_thumbnail_src('','large',$wp_query->queried_object->meta))) {
            return $img[0];
        }else if(empty($image) && isset($post)){
            return get_the_post_thumbnail_url($post->ID, 'full');
        }
        return $image;
    });

    add_filter( 'wpseo_next_rel_link', '__return_false' );
    add_filter( 'wpseo_prev_rel_link', '__return_false' );
    add_filter('wpseo_canonical',function($canonical){
        //global $wp_query;
        return $canonical;
    }, 10, 1 );
?>