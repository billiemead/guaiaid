<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( version_compare( $GLOBALS[ 'wp_version' ], '5.0', '<' ) ) 
{
    //Prevent switching to Guai-Aid on old versions of WordPress. Switches to the default theme.
    add_action( 'after_switch_theme', function () {
        switch_theme( WP_DEFAULT_THEME );
        unset( $_GET[ 'activated' ] );
        add_action( 'admin_notices', function () {
            printf( '<div class="error"><p>%s</p></div>', guai_aid_version_msg() );
        } );
    } );
    //Prevents the Customizer from being loaded on WordPress versions prior to 5.0
    add_action( 'load-customize.php', function () {
        wp_die( guai_aid_version_msg(), '', array( 'back_link' => true ) );
    } );
}

add_action( 'send_headers', function () {
    if ( is_user_logged_in() ) {
        header( "cache-control: no-cache, must-revalidate, max-age=0" );
    } else {
        header( "Cache-Control: public, max-age=86400" );
    }
} );



// Changing default search url---------------------->
add_action( 'template_redirect', function ($template) {
    
     global $wp_query;

    // Prevents the Theme Preview from being loaded on WordPress versions prior to 5.0
    if ( isset( $_GET[ 'preview' ] ) && version_compare( $GLOBALS[ 'wp_version' ], '5.0', '<' ) ) {
        wp_die( guai_aid_version_msg() );
    }

    if (isset($wp_query->query['lost-password'])  && is_user_logged_in() ) {
        wp_redirect( home_url() );
        exit();
    }
});

add_action( 'init', function () 
{

    if ( is_admin() ) {
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );
    } else {
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_action( 'wp_footer', 'woocommerce_demo_store' );
        
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

        wp_dequeue_script( 'jquery' );
        wp_deregister_script( 'jquery' );
    }

    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
    remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
    remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
    remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
    remove_action( 'wp_head', 'index_rel_link' ); // index link
    remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
    remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
    remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
    remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version


    // Remove from TinyMCE
    //add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );

    // Cron Timing ------->
    if ( !wp_next_scheduled( 'guai_aid_cron_jobs' ) ) {
        wp_schedule_event(time(), 'weekly', 'guai_aid_cron_jobs' );
    }

});



// guai-aid setup --------------->
add_action( 'after_setup_theme', function () 
{
    if ( !isset( $content_width ) ) {
        $content_width = 1200;
    }
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'html5', array( 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style','navigation-widgets' ) );
    add_theme_support( 'customize-selective-refresh-widgets' ); // Add theme support for selective refresh for widgets.
    add_theme_support( 'align-wide' ); // Add support for full and wide align images.
    add_theme_support( 'responsive-embeds' ); // Add support for responsive embedded content.
    add_theme_support( 'custom-line-height' );// Add support for custom line height controls.
    add_theme_support( 'experimental-link-color' ); // Add support for experimental link color control.
    add_theme_support( 'custom-spacing' ); // Add support for experimental cover block spacing.
    add_theme_support( 'custom-units' );// Add support for custom units.  // This was removed in WordPress 5.6 but is still required to properly support WP 5.5.
    add_theme_support( 'woocommerce' );
    
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 150, 150, true );
    add_image_size( 'guai-aid-thumb', 300, 425, true );
    add_image_size( 'guai-aid-home-thumb', 340, 425, true );
    add_image_size( 'guai-aid-post-archive', 600, 600, true );
    add_image_size( 'guai-aid-post-wide', 2000, 600, true );

    add_theme_support( 'custom-logo',
        array(
            'flex-height' => true,
            'flex-width' => true,
        )
    );
    add_theme_support( "custom-header");
    add_theme_support( "custom-background");

    register_nav_menus(
        array(
            'primary' => __( 'Primary Menu', 'guai-aid' ),
            'category' => __( 'Categories', 'guai-aid' ),
            'social' => __( 'Social Menu', 'guai-aid' ),
            'footer' => __( 'Footer Menu', 'guai-aid' ),
        )
    );
    add_editor_style();

    // Disables the block editor from managing widgets in the Gutenberg plugin.
    add_filter( 'gutenberg_use_widgets_block_editor', '__return_false', 100 );

    // Disables the block editor from managing widgets. renamed from wp_use_widgets_block_editor
    add_filter( 'use_widgets_block_editor', '__return_false' );
} );


// Then, remove each CSS file, one at a time
add_action( 'wp_print_styles', function () 
{
    wp_deregister_style( 'AtD_style' ); // After the Deadline
    wp_deregister_style( 'jetpack_likes' ); // Likes
    wp_deregister_style( 'jetpack_related-posts' ); //Related Posts
    wp_deregister_style( 'jetpack-carousel' ); // Carousel
    wp_deregister_style( 'grunion.css' ); // Grunion contact form
    wp_deregister_style( 'the-neverending-homepage' ); // Infinite Scroll
    wp_deregister_style( 'infinity-twentyten' ); // Infinite Scroll - Twentyten Theme
    wp_deregister_style( 'infinity-twentyeleven' ); // Infinite Scroll - Twentyeleven Theme
    wp_deregister_style( 'infinity-twentytwelve' ); // Infinite Scroll - Twentytwelve Theme
    wp_deregister_style( 'noticons' ); // Notes
    wp_deregister_style( 'post-by-email' ); // Post by Email
    wp_deregister_style( 'publicize' ); // Publicize
    wp_deregister_style( 'sharedaddy' ); // Sharedaddy
    wp_deregister_style( 'sharing' ); // Sharedaddy Sharing
    wp_deregister_style( 'stats_reports_css' ); // Stats
    wp_deregister_style( 'jetpack-widgets' ); // Widgets
    wp_deregister_style( 'jetpack-slideshow' ); // Slideshows
    wp_deregister_style( 'presentations' ); // Presentation shortcode
    wp_deregister_style( 'jetpack-subscriptions' ); // Subscriptions
    wp_deregister_style( 'tiled-gallery' ); // Tiled Galleries
    wp_deregister_style( 'widget-conditions' ); // Widget Visibility
    wp_deregister_style( 'jetpack_display_posts_widget' ); // Display Posts Widget
    wp_deregister_style( 'gravatar-profile-widget' ); // Gravatar Widget
    wp_deregister_style( 'widget-grid-and-list' ); // Top Posts widget
    wp_deregister_style( 'jetpack-widgets' ); // Widgets

} );


add_action( 'edit_category', function () {
    delete_transient( 'guai_aid_categories' );
} );

add_action( 'save_post', function () {
    delete_transient( 'guai_aid_categories' );
} );


// guai-aid widgets init --------------->
add_action( 'widgets_init', function () 
{
    register_sidebar( array(
        'name' => __( 'Guai-Aid Widget Area', 'guai-aid' ),
        'id' => 'guai-aid-sidebar',
        'description' => __( 'Add widgets here to appear in your sidebar.', 'guai-aid' ),
        'before_widget' => '<div id="%1$s" class="card widget full-border mb-5 %2$s">',
        'before_title' => '<div class="card-header widget-header bg-grey p-2"><h4 class="card-title widget-title m-0"><i class="fas fab"></i> ',
        'after_title' => '</h4></div><div class="card-body widget-body mb-0 p-3">',
        'after_widget' => '<div class="clear"></div></div></div>',
    ) );

    if( wp_is_mobile()){
        $before_title='<div class="card-header widget-header bg-transparent" id="h-"><h4 class="card-title widget-title m-0 collapsed" data-toggle="collapse" data-target="#b-" aria-expanded="false" aria-controls="">';
        $after_title='<i class="fas fa-chevron-up btn btn-dark"></i></h4></div> <div class="collapse" id="b-" aria-labelledby="h-" ><div class="card-body widget-body">';
    }else{
        $before_title='<div class="card-header widget-header bg-transparent" id="h-"><h4 class="card-title widget-title m-0 " data-toggle="collapse" data-target="#b-" aria-expanded="false" aria-controls="">';
        $after_title='<i class="fas fa-chevron-up btn btn-dark"></i></h4></div> <div class="collapse show" id="b-" aria-labelledby="h-" ><div class="card-body widget-body">';
    }

    register_sidebar( array(
        'name' => __( 'Guai-Aid Product Filter Widget', 'guai-aid' ),
        'id' => 'guai-aid-filter',
        'description' => __( 'Add widgets here to appear in your sidebar.', 'guai-aid' ),
        'before_widget' => '<div id="%1$s" class="card widget %2$s collapsable">',
        'before_title' => $before_title,
        'after_title' => $after_title,
        'after_widget' => '<div class="clear"></div></div></div></div>',
    ));
});

// Adding scripts and CSS --------------->
add_action( 'wp_enqueue_scripts', function ()
{
    // CSSs--------------------->
    wp_enqueue_style( 'guai-aid-all', guai_aid_asset( 'css', 'all.css' ), array(), NULL, 'all' );
    wp_enqueue_style( 'guai-aid-style', get_stylesheet_uri(), array(), NULL, 'all' );
    wp_enqueue_style( 'guai-aid-woocommerce', guai_aid_asset( 'css', 'woocommerce.css' ), array(), NULL, 'screen' );
    wp_enqueue_style( 'guai-aid-responsive', guai_aid_asset( 'css', 'responsive.css' ), array(), NULL, 'screen' );
    wp_enqueue_style( 'guai-aid-print', guai_aid_asset( 'css', 'print.css' ), array(), NULL, 'print' );
        
    if(!is_robot() &&  !is_admin())
    {
        wp_register_script( 'jquery', guai_aid_asset( 'js', 'jquery-latest.min.js' ), false, NULL, true );
        wp_enqueue_script( 'jquery' );

        // Load JSs if it's browser not a bot --------------------->      
        wp_enqueue_script( 'guai-aid-all-script', guai_aid_asset( 'js', 'all.js' ), array( 'jquery' ), NULL, true );
        wp_enqueue_script( 'guai-aid-script', guai_aid_asset( 'js', 'main.js' ), array( 'jquery' ), NULL, true );
        
        if ( guai_aid_is_live_site() ) {
        }
    }        
});

add_action( 'wp_head', function () {
}, 0 );


// Fix skip link focus in IE11.
add_action( 'wp_print_footer_scripts', function () {
} );


// Enqueue supplemental block editor styles.
add_action( 'enqueue_block_editor_assets', function () {
});

// Customizer ----------->
add_action( 'customize_register', function ( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial(
            'blogname', array(
                'selector' => '.site-title a',
                'container_inclusive' => false,
                'render_callback' => 'guai_aid_customize_partial_blogname',
            )
        );
        $wp_customize->selective_refresh->add_partial(
            'blogdescription', array(
                'selector' => '.site-description',
                'container_inclusive' => false,
                'render_callback' => 'guai_aid_customize_partial_blogdescription',
            )
        );
    }

}, 11 );
add_action( 'customize_preview_init', function () {
    wp_enqueue_script( 'guai-aid-customize-preview', guai_aid_asset( 'js', 'customize-preview.js' ), array( 'customize-preview' ), wp_get_theme()->get( 'Version' ), true );
} );
add_action( 'customize_controls_enqueue_scripts', function () {
    wp_enqueue_script( 'guai-aid-customize-controls', guai_aid_asset( 'js', 'customize-controls.js' ), array(), wp_get_theme()->get( 'Version' ), true );

} );




// Disable Self-Pingbacks ------------->
add_action( 'pre_ping', function( &$links ) 
{
    foreach ( $links as $l => $link ){
        if ( 0 === strpos( $link, get_option( 'home' ) ) ){
            unset($links[$l]);
        }
    }
} );


?>