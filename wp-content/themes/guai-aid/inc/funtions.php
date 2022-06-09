<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

function guai_aid_is_live_site() {
    if ( strpos( home_url(), 'guai-aid.com', 5 ) == true ) {
        return true;
    }
    return false;
}

if ( !function_exists( 'get_curr_page_url' ) ) {
    function get_curr_page_url() {
        global $wp;
        return esc_url( home_url( $wp->request ) . '/' );
    }
}

function guai_aid_post_type(){
    $post_type = trim(get_post_type());
    if(empty($post_type)){
        $post_type=get_query_var('post_type');
    }
    return $post_type;
}

function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}

// home page validation --------------->
function guai_aid_is_home_page() {
    if ( ( str_replace( array( 'templates/', '.php' ), '', get_page_template_slug( get_queried_object_id() ) ) ) == 'home' ) {
        return true;
    } elseif ( is_home() && is_front_page() ) {
        return true;
    } else {
        return false;
    }
}


function print_r_html($array=array()){
    if(is_array($array)){
        echo '<!-- ';
        print_r($array);
        echo '-->';
    }
}

if ( !function_exists( 'money_format' ) ) 
{
    function money_format( $format, $number ) 
    {
        $regex = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?'.'(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';
        $locale = localeconv();
        preg_match_all( $regex, $format, $matches, PREG_SET_ORDER );
        foreach ( $matches as $fmatch ) 
        {
            $value = floatval( $number );
            $flags = array(
                'fillchar' => preg_match( '/\=(.)/', $fmatch[ 1 ], $match ) ? $match[ 1 ] : ' ',
                'nogroup' => preg_match( '/\^/', $fmatch[ 1 ] ) > 0,
                'usesignal' => preg_match( '/\+|\(/', $fmatch[ 1 ], $match ) ? $match[ 0 ] : '+',
                'nosimbol' => preg_match( '/\!/', $fmatch[ 1 ] ) > 0,
                'isleft' => preg_match( '/\-/', $fmatch[ 1 ] ) > 0
            );
            $width = trim( $fmatch[ 2 ] ) ? ( int )$fmatch[ 2 ] : 0;
            $left = trim( $fmatch[ 3 ] ) ? ( int )$fmatch[ 3 ] : 0;
            $right = trim( $fmatch[ 4 ] ) ? ( int )$fmatch[ 4 ] : $locale['int_frac_digits'];
            $conversion = $fmatch[ 5 ];

            $positive = true;
            if ( $value < 0 ) {
                $positive = false;
                $value *= -1;
            }
            $letter = $positive ? 'p' : 'n';
            $prefix = $suffix = $cprefix = $csuffix = $signal = '';
            $signal = $positive ? $locale['positive_sign'] : $locale['negative_sign'];
            switch ( true ) 
            {
                case $locale[ "{$letter}_sign_posn" ] == 1 && $flags['usesignal'] == '+':
                    $prefix = $signal;
                    break;
                case $locale[ "{$letter}_sign_posn" ] == 2 && $flags['usesignal'] == '+':
                    $suffix = $signal;
                    break;
                case $locale[ "{$letter}_sign_posn" ] == 3 && $flags['usesignal'] == '+':
                    $cprefix = $signal;
                    break;
                case $locale[ "{$letter}_sign_posn" ] == 4 && $flags['usesignal'] == '+':
                    $csuffix = $signal;
                    break;
                case $flags['usesignal'] == '(':
                case $locale[ "{$letter}_sign_posn" ] == 0:
                    $prefix = '(';
                    $suffix = ')';
                    break;
            }
            if ( !$flags['nosimbol'] ) {
                $currency = $conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol'];
                if($locale['currency_symbol']=='?'){
                    $currency = $cprefix .($locale['int_curr_symbol']) .$csuffix;
                }
                $currency = $cprefix .( $currency ) .$csuffix;
            } else {
                $currency = '';
            }
            $space = $locale[ "{$letter}_sep_by_space" ] ? ' ' : '';

            $value = number_format( $value, $right, $locale['mon_decimal_point'],
                $flags['nogroup'] ? '' : $locale['mon_thousands_sep'] );
            $value = @explode( $locale['mon_decimal_point'], $value );

            $n = strlen( $prefix ) + strlen( $currency ) + strlen( $value[ 0 ] );
            if ( $left > 0 && $left > $n ) {
                $value[ 0 ] = str_repeat( $flags['fillchar'], $left - $n ) . $value[ 0 ];
            }

            $value = implode( $locale['mon_decimal_point'], $value );
            if ( $locale[ "{$letter}_cs_precedes" ] ) {
                $value = $prefix . $currency . $space . $value . $suffix;
            } else {
                $value = $prefix . $value . $space . $currency . $suffix;
            }
            if ( $width > 0 ) {
                $value = str_pad( $value, $width, $flags['fillchar'], $flags['isleft'] ?
                    STR_PAD_RIGHT : STR_PAD_LEFT );
            }
            $format = str_replace( $fmatch[ 0 ], $value, $format );
        }
        return $format;
    }
}

function guai_aid_asset( $directory = 'css', $file = '' ) {
    $directory = trim( $directory );
    $file = trim( $file );
    $path = get_template_directory() . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . $file;
    $url = get_template_directory_uri() . '/assets/';
    if ( file_exists( $path ) ) {
        return $url . $directory . '/' . $file;
    }
    return $url;
}


// Adds a message for unsuccessful theme switch.
function guai_aid_version_msg() {
    return sprintf( __( 'Guai-Aid requires at least WordPress version 5.0. You are running version %s. Please upgrade and try again.', 'guai-aid' ), $GLOBALS['wp_version'] );
}


// Check is there any active sidebars  --------------->
function guai_aid_active_sidebars() {
    if ( is_active_sidebar( 'guai-aid-sidebar' ) || is_active_sidebar( 'guai-aid-filter' )  ) {
        return true;
    } else {
        return false;
    }
}

// Post entery metas --------------->
function guai_aid_entry_meta( $class = '', $ul_class="" ) {
    echo '<div class="post-meta-wrapper post-meta-single post-meta-single-top ' . trim( $class ) . '">
        <ul class="post-meta list-group list-group-horizontal list-unstyled m-0 p-0 '.trim($ul_class).'">';
    // sticky post ------------->   
    if ( is_sticky() && is_home() && !is_paged() ) {
        echo '<li class="item list-group-item border-0 bg-transparent sticky-post"><i class="fa fa-bookmark"></i>' . esc_html__( 'Featured', 'guai-aid' ) . '</li>';
    }

    // post format ------------->
    $format = get_post_format();
    $formats_class = array(
        'aside' => 'file-text',
        'image' => 'image',
        'video' => 'video',
        'quote' => 'quote-left',
        'link' => 'link',
        'gallery' => 'image',
        'status' => 'thumb-tack',
        'audio' => 'music',
        'chat' => 'commenting-o',
    );

    if ( current_theme_supports( 'post-formats', $format ) ) {
        echo '<li class="item list-group-item border-0 bg-transparent entry-format ' . esc_attr( $format ) . '">       
                <span class="screen-reader-text sr-only">' . esc_html__( 'Format:', 'guai-aid' ) . '</span>
                <a href="' . esc_url( get_post_format_link( $format ) ) . '" title="' . esc_attr( $format ) . ' post"><i class="fa fa-' . esc_attr( $formats_class[ $format ] ) . '"></i>' . esc_html( get_post_format_string( $format ) ) . '</a></li>';
    }

    // Time ------------->
    echo '<li class="item list-group-item border-0 bg-transparent posted-on post-date">                  
                    <span class="screen-reader-text sr-only">' . esc_html__( 'Posted on:', 'guai-aid' ) . '</span>               
                    <i class="fa fa-calendar-alt meta-icon"></i>
                        <time class="entry-date published dt-published"  datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . get_the_date() . '</time>
                        <time class="entry-date updated dt-updated screen-reader-text sr-only"  datetime="' . esc_attr( get_the_modified_date( 'c' ) ) . '">' . esc_html( get_the_modified_date() ) . '</time>
                </li>';
    if ( !is_tax() ) {
        if ( !is_single() ) {
            // Author ---->
            echo '<li class="post-author bypostauthor item list-group-item border-0 bg-transparent byline author p-author vcard hcard h-card">                   
                            <span class="screen-reader-text sr-only">' . esc_html__( 'Author:', 'guai-aid' ) . '</span>
                            <span class="screen-reader-text sr-only">' . get_avatar( get_the_author_meta( 'ID' ), 40 ) . '</span>
                            <a class="url u-url" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author" >
                            <i class="fa fa-user meta-icon"></i>
                            <span  class="meta-text fn p-name" >' . esc_html( get_the_author() ) . '</span></a>
                        </li>';
        }

        // categories ---->
        if ( ( $categories_list = get_the_category_list( ', ' ) ) && guai_aid_categorized_blog() ) {
            echo '<li class="item list-group-item border-0 bg-transparent cat-links">
                        <span class="screen-reader-text sr-only">' . esc_html__( 'Categories:', 'guai-aid' ) . '</span>
                        <i class="fa fa-folder-open"></i>
                        ' . ent2ncr( $categories_list ) . '
                    </li>';
        }

        // tags ---->
        // if ( $tags_list = get_the_tag_list( '', ', ' ) ) {
        //     echo '<li class="item list-group-item border-0 bg-transparent tag-links">
        //                 <span class="screen-reader-text sr-only">' . esc_html__( 'Tags:', 'guai-aid' ) . '</span>
        //                 <i class="fa fa-tags"></i>' . ent2ncr( $tags_list ) . '
        //             </li>';
        // }

        // attachemnt ---->
        if ( is_attachment() && wp_attachment_is_image() ) {
            // Retrieve attachment metadata.
            $metadata = wp_get_attachment_metadata();
            echo '<li class="item list-group-item border-0 bg-transparent full-size-link">               
                        <span class="screen-reader-text sr-only">' . esc_html__( 'Full size link:', 'guai-aid' ) . '</span>
                        <a href="' . esc_url( wp_get_attachment_url() ) . '"><i class="fa fa-link"></i>' . esc_html( $metadata['width'] ) . ' &times; ' . esc_html( $metadata['height'] ) . '</a>
                    </li>';
        }

        // Comments ---->
        if ( !is_single() && !post_password_required() && ( comments_open() || get_comments_number() ) ) {
            echo '<li class="item list-group-item border-0 bg-transparent comment">
                        <i class="fa fa-comments"></i>';
            comments_popup_link( __( 'Leave a comment', 'guai-aid' ) . '<span class="screen-reader-text sr-only">:&nbsp;' . get_the_title() . '</span>' );
            echo '</li>';
        }

        // Edit Link ---->
        edit_post_link( __( 'Edit', 'guai-aid' ), '<li class="edit-link item list-group-item border-0 bg-transparent" ><i class="fa fa-edit"></i>', '</li>' );
    }
    echo '</ul></div>';
}

function guai_aid_categorized_blog() {
    if ( false === ( $all_the_cool_cats = get_transient( 'guai_aid_categories' ) ) ) {
        // Create an array of all the categories that are attached to posts.
        $all_the_cool_cats = get_categories(
            array(
                'fields' => 'ids',
                'hide_empty' => 1,
                'number' => 2,
            )
        );
        // Count the number of categories that are attached to the posts.
        $all_the_cool_cats = count( $all_the_cool_cats );
        set_transient( 'guai_aid_categories', $all_the_cool_cats );
    }
    if ( $all_the_cool_cats > 1 ) {
        return true;
    } else {
        return false;
    }
}




// Displays the optional custom logo --------------->
function guai_aid_the_custom_logo($is_footer=false) {
    if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
        $image = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
        echo ' 
            <div class="navbar-brand logo-active site-logo m-0 p-0 d-block">
                <a href="' . esc_url( home_url( '/' ) ) . '" rel="home">
                    <img src="' . esc_url( $image[ 0 ] ) . '" width="' . esc_attr( $image[ 1 ] ) . '" height="' . esc_attr( $image[ 2 ] ) . '" alt="site-logo" class="img-fluid" id="logo" />';
        if ( guai_aid_is_home_page() && $is_footer==false) {
            echo '<h1 class="site-title sr-only">' . esc_html( get_bloginfo( 'name' ) ) . ' </h1>';
        }
        echo '</a> 
             </div>
            ';
    } else {
        echo ' <div class="navbar-brand">';
        echo '<h1 class="site-title>
                    <a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . esc_html( get_bloginfo( 'name' ) ) . '</a>
                </h1>';
        if ( $description = get_bloginfo( 'description', 'display' ) ) {
            $class = "";
            if ( !is_customize_preview() ) {
                $class = "says";
            }
            echo '<p class="m-0 site-description ' . esc_attr( $class ) . '">' . esc_html( $description ) . '</p>';
        }
        echo '</div>';
    }


} 
//  Adds postMessage support for site title and description for the Customizer. --------------->
function guai_aid_customize_partial_blogname() {
    bloginfo( 'name' );
}

function guai_aid_customize_partial_blogdescription() {
    bloginfo( 'description' );
}

/**
 * Returns true if comment is by author of the post.
 * @see get_comment_class()
 */
function guai_aid_is_comment_by_post_author( $comment = null ) {
    if ( is_object( $comment ) && $comment->user_id > 0 ) {
        $user = get_userdata( $comment->user_id );
        $post = get_post( $comment->comment_post_ID );
        if ( !empty( $user ) && !empty( $post ) ) {
            return $comment->user_id === $post->post_author;
        }
    }
    return false;
}

/**
 * Returns information about the current post's discussion, with cache support.
 */
function guai_aid_get_discussion_data() {
    static $discussion, $post_id;

    $current_post_id = get_the_ID();
    if ( $current_post_id === $post_id ) {
        return $discussion; /* If we have discussion information for post ID, return cached object */
    } else {
        $post_id = $current_post_id;
    }

    $comments = get_comments(
        array(
            'post_id' => $current_post_id,
            'orderby' => 'comment_date_gmt',
            'order' => get_option( 'comment_order', 'desc' ), /* Respect comment order from Settings » Discussion. */
            'status' => 'approve',
            'number' => 10, /* Only retrieve the last 20 comments, as the end goal is just 6 unique authors */
        )
    );

    $authors = array();
    foreach ( $comments as $comment ) {
        $discussion[ $comment->comment_ID ] = ( object )array(
            'id' => $comment->comment_ID,
            'name' => $comment->comment_author,
            'comment' => esc_html( $comment->comment_content ),
            'published' => $comment->comment_date,
            'rating' => 0,
        );
        if ( $ratings = get_comment_meta( $comment->comment_ID, 'rating', true ) ) {
            $rating = ( array_sum( $ratings ) / count( $ratings ) );
            $discussion[ $comment->comment_ID ]->rating = round( $rating, 2 );
        }
    }
    return $discussion;
}

/**
 * Fire the wp_body_open action.
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
 */
if ( !function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
}

// Custom css generator ---------->
function guai_aid_custom_css() {
    // Only include custom colors in customizer or frontend.
    if ( is_admin() ) {
        return;
    }
    $css = '';
    if ( $guai_aid_text_color = get_theme_mod( 'guai_aid_text_color' ) ) {
        $css .= 'body{
                color:' . $guai_aid_text_color . ';
            }';

    }
    if ( $guai_aid_link_color = get_theme_mod( 'guai_aid_link_color' ) ) {
        $css .= '
            body a {
                color:' . $guai_aid_link_color . ';
            }
            #primary-nav li button.dropdown-toggle{
                background:' . $guai_aid_link_color . ';
            }';
    }
    return $css;
}

// Determines if post thumbnail can be displayed.
function guai_aid_can_show_post_thumbnail() {
    return apply_filters( 'guai_aid_can_show_post_thumbnail', !post_password_required() && !is_attachment() && has_post_thumbnail() );
}

// Post featured image --------------->
function guai_aid_post_thumbnail( $size = 'large', $class = '' ) {
    $size = trim( $size );
    if ( !guai_aid_can_show_post_thumbnail() ) {
        return;
    }
    echo '<div class="post-thumbnail entry-media card-image featured-media">
        <a href="' . esc_url( get_the_permalink() ) . '" aria-hidden="true" tabindex="-1" class="post-thumbnail-inner d-block">';
    the_post_thumbnail( $size,
        array(
            'alt' => get_the_title(),
            'class' => 'd-block img-fluid wp-post-image size-post-' . $size . ' ' . $class,
            'loading' => "lazy"
        ) );
    echo '</a>
        </div>';
}

function guai_aid_thumbnail_src( $post_id, $size = 'large', $meta = null, $placeholder = '' ) 
{
    $size = trim( $size );
    $post_id = trim($post_id);
    $img_src=array();

    if ( $placeholder = trim( $placeholder ) ) {
        $img_src = array( $placeholder, '1000', '1000' );
    } else if($placeholder==true) {
        $img_src = array( guai_aid_asset( 'images', 'placeholder.png' ), '1000', '1000' );
    }  
    
    if ( isset( $meta ) && isset( $meta->banner_image ) && ( $img_id = trim( $meta->banner_image ) ) ) {
        $img_src = wp_get_attachment_image_src( $img_id, $size );

    }else if ( isset( $meta ) && isset( $meta->thumbnail_id ) && ( $img_id = trim( $meta->thumbnail_id ) ) ) {
        $img_src = wp_get_attachment_image_src( $img_id, $size );

    }else if ( isset( $meta ) && isset( $meta->featured_image ) && ( $img_id = trim( $meta->featured_image ) ) ) {
        $img_src = wp_get_attachment_image_src( $img_id, $size );

    }else if ( $img_id = get_post_thumbnail_id( $post_id ) ) {
        $img_src = wp_get_attachment_image_src( $img_id, $size );
    }
    return ( array )$img_src;
}


function guai_aid_thumbnail( $post_id =null, $size = 'large', $class = '', $meta = null, $call_user_func = null , $title='', $placeholder=false) 
{
    if( ($post_id=trim($post_id))=='' ){  
        $post_id =get_the_ID(); 
    }   

    if( !($title=trim($title)) ){ 
        $title = get_the_title(); 
    }

    if(( $img_src = guai_aid_thumbnail_src($post_id, $size, $meta,$placeholder )) && isset($img_src) && count($img_src)>0){
        echo '<div class="post-thumbnail entry-media card-image featured-media ' . $class . '">
                    <img src="' . $img_src[ 0 ] . '" class="img-fluid" alt="' . $title . '" width="' . $img_src[ 1 ] . '" height="' . $img_src[ 2 ] . '" loading="lazy">';
        if ( isset( $call_user_func ) ) {
            call_user_func( $call_user_func, $meta );
        }
        echo '</div>';
    }
}


// Modified version of paginate_links() https://developer.wordpress.org/reference/functions/paginate_links/
function guai_aid_paginate_links( $args = '' ) 
{
    global $wp_query, $wp_rewrite;

    // Setting up default values based on the current URL.
    $pagenum_link = html_entity_decode( get_pagenum_link() );
    $url_parts = explode( '?', $pagenum_link );

    // Get max pages and current page out of the current query, if available.
    $total = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
    $current = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;

    // Append the format placeholder to the base URL.
    $pagenum_link = trailingslashit( $url_parts[ 0 ] ) . '%_%';

    // URL base depends on permalink settings.
    $format = $wp_rewrite->using_index_permalinks() && !strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
    $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

    $defaults = array(
        'base' => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
        'format' => $format, // ?page=%#% : %#% is replaced by the page number
        'total' => $total,
        'current' => $current,
        'aria_current' => 'page',
        'show_all' => false,
        'prev_next' => true,
        'prev_text' => esc_html__( 'Previous Page', 'guai-aid' ),
        'next_text' => esc_html__( 'Next Page', 'guai-aid' ),
        'end_size' => 1,
        'mid_size' => 6,
        'type' => 'list',
        'add_args' => array(), // array of query args to add
        'add_fragment' => '',
        'before_page_number' => '<span class="meta-nav screen-reader-text sr-only">' . __( 'Page:', 'guai-aid' ) . ' </span>',
        'after_page_number' => '',
        'screen_reader_text' => esc_html__( 'Pagination', 'guai-aid' )
    );

    $args = wp_parse_args( $args, $defaults );

    if ( !is_array( $args['add_args'] ) ) {
        $args['add_args'] = array();
    }

    // Merge additional query vars found in the original URL into 'add_args' array.
    if ( isset( $url_parts[ 1 ] ) ) {
        // Find the format argument.
        $format = explode( '?', str_replace( '%_%', $args['format'], $args['base'] ) );
        $format_query = isset( $format[ 1 ] ) ? $format[ 1 ] : '';
        wp_parse_str( $format_query, $format_args );

        // Find the query args of the requested URL.
        wp_parse_str( $url_parts[ 1 ], $url_query_args );

        // Remove the format argument from the array of query arguments, to avoid overwriting custom format.
        foreach ( $format_args as $format_arg => $format_arg_value ) {
            unset( $url_query_args[ $format_arg ] );
        }

        $args['add_args'] = array_merge( $args['add_args'], urlencode_deep( $url_query_args ) );
    }

    // Who knows what else people pass in $args
    $total = ( int )$args['total'];
    if ( $total < 2 ) {
        return;
    }
    $current = ( int )$args['current'];
    $end_size = ( int )$args['end_size']; // Out of bounds?  Make it the default.
    if ( $end_size < 1 ) {
        $end_size = 1;
    }
    $mid_size = ( int )$args['mid_size'];
    if ( $mid_size < 0 ) {
        $mid_size = 2;
    }
    $add_args = $args['add_args'];
    $r = '';
    $page_links = array();
    $dots = false;

    if ( $args['prev_next'] && $current && 1 < $current ):
        $link = str_replace( '%_%', 2 == $current ? '' : $args['format'], $args['base'] );
    $link = str_replace( '%#%', $current - 1, $link );
    if ( $add_args ) {
        $link = add_query_arg( $add_args, $link );
    }
    $link .= $args['add_fragment'];
    $page_links[] = '<li class="page-link-item"><a class="page-link prev page-numbers" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '"><i class="fas fa-chevron-left mr-1"></i><span>' . $args['prev_text'] . '</span></a></li>';
    endif;
    for ( $n = 1; $n <= $total; $n++ ):
        if ( $n == $current ):
            $page_links[] = "<li class='page-link-item active'><a href='#' aria-current='" . esc_attr( $args['aria_current'] ) . "' class='page-link page-numbers current'>" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . '<span class="sr-only">(current)</span></a></li>';
    $dots = true;
    else :
        if ( $args['show_all'] || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ):
            $link = str_replace( '%_%', 1 == $n ? '' : $args['format'], $args['base'] );
    $link = str_replace( '%#%', $n, $link );
    if ( $add_args ) {
        $link = add_query_arg( $add_args, $link );
    }
    $link .= $args['add_fragment'];

    /** This filter is documented in wp-includes/general-template.php */
    $page_links[] = "<li class='page-link-item'><a class='page-link page-numbers' href='" . esc_url( apply_filters( 'paginate_links', $link ) ) . "'>" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . '</a></li>';
    $dots = true;
    elseif ( $dots && !$args['show_all'] ):
        $page_links[] = '<li class="page-link-item"><span class="page-link page-link page-numbers dots">&hellip;</span></li>';
    $dots = false;
    endif;
    endif;
    endfor;
    if ( $args['prev_next'] && $current && $current < $total ):
        $link = str_replace( '%_%', $args['format'], $args['base'] );
    $link = str_replace( '%#%', $current + 1, $link );
    if ( $add_args ) {
        $link = add_query_arg( $add_args, $link );
    }
    $link .= $args['add_fragment'];

    /** This filter is documented in wp-includes/general-template.php */
    $page_links[] = '<li class="page-link-item"><a class="page-link next page-numbers" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '"><span>' . $args['next_text'] . '</span><i class="fas fa-chevron-right ml-1"></i></a></li>';
    endif;
    switch ( $args['type'] ) {
        case 'array':
            return $page_links;

        case 'list':
            $r = '<nav id="archive-pagination" class="clear">
                <p class="screen-reader-text sr-only sr-only">' . $args['screen_reader_text'] . '</p>
                        <ul class="pagination justify-content-center">
                        ' . join( '', $page_links ) . '
                        </ul> 
                 </nav>';
            break;

        default:
            $r = join( "\n", $page_links );
            break;
    }
    return $r;
}



function is_blog() {
    return ( ( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag() ) && 'post' == guai_aid_post_type());
}


function guai_aid_custom_fields( $id = '' ) {
    $c_fields = array();
    if ( !( $id = trim( $id ) ) ) {
        $id = get_the_ID();
    }
    if ( function_exists( 'get_fields' ) ) {
        $c_fields = ( object )get_fields( $id );
    }
    return $c_fields;
}

function guai_aid_expand_meta_data( $meta ) {
    $new_meta = array();
    foreach ( $meta as $ind => $item ) {
        if ( is_serialized( $item[ 0 ] ) && ( $item = unserialize( $item[ 0 ] ) ) ) {
            $new_meta[ $ind ] = $item;

        } elseif ( is_array( $item ) && count( $item ) > 1 ) {
            $new_meta[ $ind ] = $item;

        } else {
            $new_meta[ $ind ] = trim( $item[ 0 ] );
        }
    }
    return ( object )$new_meta;
}

function guai_aid_get_meta( $meta_name, $term = NULL ) {
    if ( ( $meta_name = trim( $meta_name ) ) && function_exists( 'get_field' ) ) {
        return get_field( $meta_name, $term );
    }
    return false;
}

function guai_aid_all_term_meta( $term_id, $tax = '' ) {
    if ( ( $meta = get_metadata( 'term', $term_id ) ) && count( $meta ) > 0 ) {
        return guai_aid_expand_meta_data( $meta );
    }
    return ( object )array();
}

function guai_aid_all_post_meta( $id ) {
    if ( ( $meta = get_metadata( 'post', $id ) ) && count( $meta ) > 0 ) {
        return guai_aid_expand_meta_data( $meta );
    }
    return ( object )array();
}



function guai_aid_get_settings( $option = '' ) {
    $out = array();
    if ( $option = trim( $option ) ) 
    {
        $val = get_option( 'guai_aid_settings_' . $option );
        if ( is_array( $val ) && count( $val ) == 1 ) {
           return  $val[ 0 ];
        } else {
            return $val;
        }

    }else{

        if ( function_exists( 'pods_api' ) && ( $my_settings = pods_api()->load_pod( array( 'name' => 'guai_aid_settings' ) ) ) && isset( $my_settings['fields'] ) ) 
        {
            foreach ( $my_settings['fields'] as $ind => $field ) 
            {
                $val = get_option( 'guai_aid_settings_' . $ind );    
                if ( is_array( $val ) && count( $val ) == 1 ) {
                    $out[ $ind ] = $val[ 0 ];
                } else {
                    $out[ $ind ] = $val;
                }
            }
        }
        return ( object )$out;
    }   
}

// Modified version of wp_link_pages() https://developer.wordpress.org/reference/functions/wp_link_pages/
function guai_aid_wp_link_pages( $args = array() ) 
{
    global $page, $numpages, $multipage, $more;

    $defaults = array(
        'before' => '<nav id="post-pagination" class="clear">
            <ul class="pagination post-pages-links list-group list-group-horizontal">
                            <li class="item list-group-item border-0 bg-transparent "><span class="page-link page-numbers border-0 bg-transparent pl-0">' . __( 'Continue Reading:', 'guai-aid' ) . '</span></li>',
        'after' => '</ul> </nav>',
        'link_before' => '',
        'link_after' => '',
        'aria_current' => 'page',
        'next_or_number' => 'number',
        'separator' => ' ',
        'nextpagelink' => __( 'Next page', 'guai-aid' ),
        'previouspagelink' => __( 'Previous page', 'guai-aid' ),
        'pagelink' => '<span class="screen-reader-text sr-only">' . __( 'Page:', 'guai-aid' ) . ' </span>%',
        'echo' => 1,
    );

    $params = wp_parse_args( $args, $defaults );
    $r = apply_filters( 'wp_link_pages_args', $params );
    $output = '';
    if ( $multipage ) {
        if ( 'number' == $r['next_or_number'] ) {
            $output .= $r['before'];
            for ( $i = 1; $i <= $numpages; $i++ ) {
                $link = $r['link_before'] . str_replace( '%', $i, $r['pagelink'] ) . $r['link_after'];
                if ( $i != $page || !$more && 1 == $page ) {
                    $link = '<li class="item list-group-item border-0 bg-transparent ">' . guai_aid_wp_link_page( $i ) . $link . '</a></li>';
                } elseif ( $i === $page ) {
                    $link = '<li class="item list-group-item border-0 bg-transparent current active"><span class="page-link page-numbers" aria-current="' . esc_attr( $r['aria_current'] ) . '">' . $link . '</span></li> ';
                }
                $link = apply_filters( 'wp_link_pages_link', $link, $i );

                $output .= ( 1 === $i ) ? ' ' : $r['separator'];
                $output .= $link;
            }
            $output .= $r['after'];

        } elseif ( $more ) {
            $output .= $r['before'];
            $prev = $page - 1;
            if ( $prev > 0 ) {
                $link = _wp_link_page( $prev ) . $r['link_before'] . $r['previouspagelink'] . $r['link_after'] . '</a>';

                /** This filter is documented in wp-includes/post-template.php */
                $output .= apply_filters( 'wp_link_pages_link', $link, $prev );
            }
            $next = $page + 1;
            if ( $next <= $numpages ) {
                if ( $prev ) {
                    $output .= $r['separator'];
                }
                $link = _wp_link_page( $next ) . $r['link_before'] . $r['nextpagelink'] . $r['link_after'] . '</a>';

                /** This filter is documented in wp-includes/post-template.php */
                $output .= apply_filters( 'wp_link_pages_link', $link, $next );
            }
            $output .= $r['after'];
        }
    }
    $html = apply_filters( 'wp_link_pages', $output, $args );
    if ( $r['echo'] ) {
        echo $html;
    }
    return $html;
}

function guai_aid_wp_link_page( $i ) {
    global $wp_rewrite;
    $post = get_post();
    $query_args = array();

    if ( 1 == $i ) {
        $url = get_permalink();
    } else {
        if ( '' == get_option( 'permalink_structure' ) || in_array( $post->post_status, array( 'draft', 'pending' ) ) ) {
            $url = add_query_arg( 'page', $i, get_permalink() );
        } elseif ( 'page' == get_option( 'show_on_front' ) && get_option( 'page_on_front' ) == $post->ID ) {
            $url = trailingslashit( get_permalink() ) . user_trailingslashit( "$wp_rewrite->pagination_base/" . $i, 'single_paged' );
        } else {
            $url = trailingslashit( get_permalink() ) . user_trailingslashit( $i, 'single_paged' );
        }
    }

    if ( is_preview() ) {
        if ( ( 'draft' !== $post->post_status ) && isset( $_GET['preview_id'], $_GET['preview_nonce'] ) ) {
            $query_args['preview_id'] = wp_unslash( $_GET['preview_id'] );
            $query_args['preview_nonce'] = wp_unslash( $_GET['preview_nonce'] );
        }
        $url = get_preview_post_link( $post, $query_args, $url );
    }
    return '<a href="' . esc_url( $url ) . '" class="page-link page-numbers">';
}




function guai_aid_comment_form( $args = array(), $post_id = null ) {
    if ( null === $post_id ) {
        $post_id = get_the_ID();
    }

    if ( !comments_open( $post_id ) ) {
        do_action( 'comment_form_comments_closed' );
        return;
    }

    $commenter = wp_get_current_commenter();
    $user = wp_get_current_user();
    $user_identity = $user->exists() ? $user->display_name : '';

    $args = wp_parse_args( $args );
    if ( !isset( $args['format'] ) ) {
        $args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';
    }

    $req = get_option( 'require_name_email' );
    $html_req = ( $req ? " required='required'" : '' );
    $html5 = 'html5' === $args['format'];

    $fields = array(
        'author' => sprintf(
            '<p class="comment-form-author">%s %s</p>',
            sprintf(
                '<label for="author">%s%s</label>',
                __( 'Name', 'guai-aid' ),
                ( $req ? ' <span class="required">*</span>' : '' )
            ),
            sprintf(
                '<input id="author" name="author" type="text" value="%s" size="30" maxlength="245"%s />',
                esc_attr( $commenter['comment_author'] ),
                $html_req
            )
        ),
        'email' => sprintf(
            '<p class="comment-form-email">%s %s</p>',
            sprintf(
                '<label for="email">%s%s</label>',
                __( 'Email', 'guai-aid' ),
                ( $req ? ' <span class="required">*</span>' : '' )
            ),
            sprintf(
                '<input id="email" name="email" %s value="%s" size="30" maxlength="100" aria-describedby="email-notes"%s />',
                ( $html5 ? 'type="email"' : 'type="text"' ),
                esc_attr( $commenter['comment_author_email'] ),
                $html_req
            )
        ),
        'url' => sprintf(
            '<p class="comment-form-url">%s %s</p>',
            sprintf(
                '<label for="url">%s</label>',
                __( 'Website', 'guai-aid' )
            ),
            sprintf(
                '<input id="url" name="url" %s value="%s" size="30" maxlength="200" />',
                ( $html5 ? 'type="url"' : 'type="text"' ),
                esc_attr( $commenter['comment_author_url'] )
            )
        ),
    );

    if ( has_action( 'set_comment_cookies', 'wp_set_comment_cookies' ) && get_option( 'show_comments_cookies_opt_in' ) ) {
        $consent = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

        $fields['cookies'] = sprintf(
            '<p class="comment-form-cookies-consent">%s %s</p>',
            sprintf(
                '<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"%s />',
                $consent
            ),
            sprintf(
                '<label for="wp-comment-cookies-consent">%s</label>',
                __( 'Save my name, email, and website in this browser for the next time I comment.', 'guai-aid' )
            )
        );
        if ( isset( $args['fields'] ) && !isset( $args['fields']['cookies'] ) ) {
            $args['fields']['cookies'] = $fields['cookies'];
        }
    }

    $required_text = sprintf( ' ' . __( 'Required fields are marked %s', 'guai-aid' ), '<span class="required">*</span>' );
    $fields = apply_filters( 'comment_form_default_fields', $fields );
    $defaults = array(
        'fields' => $fields,
        'comment_field' => sprintf(
            '<p class="comment-form-comment">%s %s</p>',
            sprintf(
                '<label for="comment">%s</label>',
                _x( 'Comment', '','guai-aid' )
            ),
            '<textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea>'
        ),
        'must_log_in' => sprintf(
            '<p class="must-log-in">%s</p>',
            sprintf(
                /* translators: %s: Login URL. */
                __( 'You must be <a href="%s">logged in</a> to post a comment.', 'guai-aid' ),
                /** This filter is documented in wp-includes/link-template.php */
                wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ), $post_id ) )
            )
        ),
        'logged_in_as' => sprintf(
            '<p class="logged-in-as">%s</p>',
            sprintf(
                /* translators: 1: Edit user link, 2: Accessibility text, 3: User name, 4: Logout URL. */
                __( '<a href="%1$s" aria-label="%2$s">Logged in as %3$s</a>. <a href="%4$s">Log out?</a>', 'guai-aid' ),
                get_edit_user_link(),
                /* translators: %s: User name. */
                esc_attr( sprintf( __( 'Logged in as %s. Edit your profile.', 'guai-aid' ), $user_identity ) ),
                $user_identity,
                /** This filter is documented in wp-includes/link-template.php */
                wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ), $post_id ) )
            )
        ),
        'comment_notes_before' => sprintf(
            '<p class="comment-notes">%s%s</p>',
            sprintf(
                '<span id="email-notes">%s</span>',
                __( 'Your email address will not be published.', 'guai-aid' )
            ),
            ( $req ? $required_text : '' )
        ),
        'comment_notes_after' => '',
        'action' => home_url( '/wp-comments-post.php' ),
        'id_form' => 'commentform',
        'id_submit' => 'submit',
        'class_form' => 'comment-form',
        'class_submit' => 'submit',
        'name_submit' => 'submit',
        'title_reply' => __( 'Leave a Reply', 'guai-aid' ),
        /* translators: %s: Author of the comment being replied to. */
        'title_reply_to' => __( 'Leave a Reply to %s', 'guai-aid' ),
        'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
        'title_reply_after' => '</h3>',
        'cancel_reply_before' => ' <small>',
        'cancel_reply_after' => '</small>',
        'cancel_reply_link' => __( 'Cancel reply', 'guai-aid' ),
        'label_submit' => __( 'Post Comment', 'guai-aid' ),
        'submit_button' => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
        'submit_field' => '<p class="form-submit">%1$s %2$s</p>',
        'format' => 'xhtml',
    );
    $args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );
    $args = array_merge( $defaults, $args );
    if ( false === strpos( $args['comment_notes_before'], 'id="email-notes"' ) ) {
        $args['fields']['email'] = str_replace(
            ' aria-describedby="email-notes"',
            '',
            $args['fields']['email']
        );
    }
    ?>
    <div id="respond" class="comment-respond">
        <?php
        do_action( 'comment_form_before' );
        echo $args['title_reply_before'];
        comment_form_title( $args['title_reply'], $args['title_reply_to'] );
        echo $args['cancel_reply_before'];
        cancel_comment_reply_link( $args['cancel_reply_link'] );
        echo $args['cancel_reply_after'];
        echo $args['title_reply_after'];

        if ( get_option( 'comment_registration' ) && !is_user_logged_in() ):
            echo $args['must_log_in'];
        do_action( 'comment_form_must_log_in_after' );
        else :
            printf(
                '<form action="%s" method="post" id="%s" class="%s"%s>',
                esc_url( $args['action'] ),
                esc_attr( $args['id_form'] ),
                esc_attr( $args['class_form'] ),
                ( $html5 ? ' novalidate' : '' )
            );
        do_action( 'comment_form_top' );
        if ( is_user_logged_in() ):
            echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity );
        do_action( 'comment_form_logged_in_after', $commenter, $user_identity );
        else :
            echo $args['comment_notes_before'];
        endif;
        $comment_fields = array( 'comment' => $args['comment_field'] ) + ( array )$args['fields'];
        $comment_fields = apply_filters( 'comment_form_fields', $comment_fields );
        $comment_field_keys = array_diff( array_keys( $comment_fields ), array( 'comment' ) );
        $first_field = reset( $comment_field_keys );
        $last_field = end( $comment_field_keys );

        foreach ( $comment_fields as $name => $field ) {
            if ( 'comment' === $name ) {
                echo apply_filters( 'comment_form_field_comment', $field );
                echo $args['comment_notes_after'];
            } elseif ( !is_user_logged_in() ) {

                if ( $first_field === $name ) {
                    do_action( 'comment_form_before_fields' );
                }
                echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
                if ( $last_field === $name ) {
                    do_action( 'comment_form_after_fields' );
                }
            }
        }
        $submit_button = sprintf(
            $args['submit_button'],
            esc_attr( $args['name_submit'] ),
            esc_attr( $args['id_submit'] ),
            esc_attr( $args['class_submit'] ),
            esc_attr( $args['label_submit'] )
        );
        $submit_button = apply_filters( 'comment_form_submit_button', $submit_button, $args );
        $submit_field = sprintf(
            $args['submit_field'],
            $submit_button,
            get_comment_id_fields( $post_id )
        );
        echo apply_filters( 'comment_form_submit_field', $submit_field, $args );
        do_action( 'comment_form', $post_id );
        echo '</form>';
        endif;
        do_action( 'comment_form_after' );
        ?>
    </div> <!-- #respond -->
    <?php
}



function guai_aid_content_replace( $content ) {
    $content = str_replace( '<table>', '<table class="table table-striped table-borderless my-3">', $content );
    $content = str_replace( '<thead>', '<thead class="thead-yellow">', $content );
    $content = str_replace( array( 'INR ', 'INR', 'inr' ), '<i class="fas fa-rupee-sign" title="Indian Rupee"><span class="sr-only">Rs.</span></i>', $content );
    $content = str_replace( array( '“', '”' ), '"', $content );
    $content = str_replace( '’', "'", $content );
    return $content;
}

function guai_aid_the_content( $content = '', $echo = true, $read_more=false, $meta=array() ) 
{
    if ( $content = @trim( $content ) ) 
    {
        $content = apply_filters( 'the_content', $content );
        

        if( ($read_more==true) && isset($meta->long_description) && ($desc=trim($meta->long_description))){
           $content .= '<p class="text-center mb-0 mt-4"><a href="#entry-content" class="btn btn-outline-secondary btn-sm px-4 py-2 hash-link">'.__('Continue Reading','guai-aid').'</a></p>';
        }

        if ( $echo ) {
            echo $content;
        } else {
            return $content;
        }
    }
    return '';
}


function guai_aid_social_share( $show=false,$meta = null ) 
{
    if ( !is_singular( 'page' ) || $show==true) 
    {
        
        if ( is_tax() ) {
            $term = get_queried_object();
            $title = $term->name;
            $url = urlencode( get_term_link( $term ) );
            $img = ( array )guai_aid_thumbnail_src( null,'full', guai_aid_all_term_meta( $term->term_id ) );
        } else {
            $img = ( array )guai_aid_thumbnail_src( get_the_ID(), 'full', $meta );
            $title = urlencode( get_the_title() );
            $url = urlencode( get_the_permalink() );
        }
        $desc = $title . ' - ' . $url;

        $out = '<div class="social-share d-print-none">
                    <ul class="list-group list-group-horizontal list-unstyled m-0">
                         <li class="item list-group-item border-0 bg-transparent share">                     
                            <span class="">' . __( 'Share', 'guai-aid' ) . '</span>
                        </li>
                        <li class="item list-group-item border-0 bg-transparent">
                            <a href="https://www.facebook.com/sharer.php?u=' . $url . '&t=' . $title . '" class="facebook" rel="noopener nofollow noreferrer" target="_blank"  title="' . __( 'Share To Facebook', 'guai-aid' ) . '"><i class="fab fa-facebook-f"></i>
                            <span class="sr-only">' . __( 'Share To Facebook', 'guai-aid' ) . '</span>
                            </a>
                        </li>

                        <li class="item list-group-item border-0 bg-transparent">
                            <a href="https://twitter.com/intent/tweet?via=Guai-AidHolidays&text=' . $title . '&url=' . $url . '" class="twitter" rel="noopener nofollow noreferrer" target="_blank"  title="' . __( 'Share To Twitter', 'guai-aid' ) . '"><i class="fab fa-twitter"></i>
                            <span class="sr-only">' . __( 'Share To Twitter', 'guai-aid' ) . '</span>
                            </a>
                        </li>

                        <li class="item list-group-item border-0 bg-transparent">
                            <a href="https://in.pinterest.com/pin/create/button/?url=' . $url . '&media=' . urlencode( $img[ 0 ] ) . '&description=' . $desc . '" class="pinterest" rel="noopener nofollow noreferrer" target="_blank"  title="' . __( 'Share To Pinterest', 'guai-aid' ) . '"><i class="fab fa-pinterest"></i>
                            <span class="sr-only">' . __( 'Share To Pinterest', 'guai-aid' ) . '</span>
                            </a>
                        </li>

                        <li class="item list-group-item border-0 bg-transparent ">
                            <a href="https://api.whatsapp.com/send?text=' . $desc . '" class="whatsapp" rel="nofollow noopener noreferrer" target="_blank"  title="' . __( 'Share on WhatsApp', 'guai-aid' ) . '" ><i class="fab fa-whatsapp"></i>
                            <span class="sr-only">' . __( 'Share on WhatsApp', 'guai-aid' ) . '</span>
                            </a>
                        </li>

                         <li class="item list-group-item border-0 bg-transparent ">
                            <a href="#" class="print"  onclick="window.print();" title="' . __( 'Print', 'guai-aid' ) . '"><i class="fas fa-print"></i>
                            <span class="sr-only">' . __( 'Print', 'guai-aid' ) . '</span>
                            </a>
                        </li>
                    </ul>
            </div>';
        echo $out;
    }
}

function guai_aid_custom_excerpt( $text ) {
    $excerpt_length = apply_filters( 'excerpt_length', 55 );
    $excerpt_more = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );
    $text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
    $text = apply_filters( 'get_the_excerpt', $text );
    return $text;
}


function guai_aid_clean_string($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
?>