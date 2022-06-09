<?php
    /* Template Name: Home */
    if ( !defined( 'ABSPATH' ) ) {
        exit;
    }
    get_header();
    $posts_per_page = 8;
    $custom_f = guai_aid_custom_fields();
?>
<div id="site-content" class="p-0 m-0">
    <div class="home-section-group position-relative">
        <?php 
// Slider ------------>
if (  isset( $custom_f->slider ) && ( $slider = $custom_f->slider ) ) {
    ?>
        <div id="home-slider" class="page-section home-page-section p-0 bg-grey position-relative ">
            <div class="slick-arrows">
                <button class="slick-arrow prevArrow"><i class="fas fa-chevron-left"></i> <span class="sr-only">
                        <?php _e('Prev','guai-aid');?></span></button>
                <button class="slick-arrow nextArrow"><i class="fas fa-chevron-right"></i> <span class="sr-only">
                        <?php _e('Next','guai-aid');?></span></button>
            </div>
            <div class="slides rounded-0">
                <?php  foreach($slider as $index=>$slide)
             {
                $slider_link='#';
                if(isset($slide['slider_link']) && ($slider_link= trim($slide['slider_link']))){
                    $slider_link=$slider_link;
                }
                if(wp_is_mobile()){ 
                    if( isset($slide['mobile_image']) && ($img=trim($slide['mobile_image']))){
                        $img_src=wp_get_attachment_image_src($img, 'full');
                    }else{
                        $img_src=wp_get_attachment_image_src(trim($slide['slider_image']), 'large');
                    }
                }else{
                    $img_src=wp_get_attachment_image_src(trim($slide['slider_image']), 'full');
                }
            ?>
                <div class="slide-item bg-grey">
                    <a href="<?php echo $slider_link;?>">
                        <img src="<?php echo $img_src[0];?>" width="<?php echo $img_src[0];?>" height="<?php echo $img_src[0];?>" alt="image" class="slider-img">
                        <span class="btn btn-theme btn-iconic animated5">
                            <span>Shop Now <i class="fas fa-shopping-cart"></i></span>
                        </span>
                    </a>
                </div>
                <?php 
            }  
            ?>
            </div>
        </div>
        <?php } 
?>
        <div id="home-content" class="page-section home-page-section">
            <div class="container">
                <div class="text">
                    <?php the_content();?>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-12">
                        <div class="featured-item wow fadeInDown">
                            <i class="featured-icon flaticon-shipped"></i>
                            <div class="featured-desc">
                                <h5 class="featured-title text-uppercase">Fast Delivery</h5>
                                <p>All orders are shipped same business day when place before 1:00 PM EST</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 md-mt-5">
                        <div class="featured-item wow fadeInUp">
                            <i class="featured-icon flaticon-free-delivery"></i>
                            <div class="featured-desc">
                                <h5 class="featured-title text-uppercase">Free Shipping</h5>
                                <p>All U.S. orders are shipped free via USPS first class mail</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 md-mt-5">
                        <div class="featured-item wow fadeInDown">
                            <i class="featured-icon flaticon-location"></i>
                            <div class="featured-desc">
                                <h5 class="featured-title text-uppercase">International Orders</h5>
                                <p>Orders shipped to most countries where permitted</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php            
//-- Featured products section -->
    if (  isset( $custom_f->featured_products ) && ( $featured_products = (array)@array_filter($custom_f->featured_products,'trim') ) )
    {
       $post_args=array(
            'post_type' => 'product', 
            'posts_per_page' => $posts_per_page,
            'orderby' => 'post__in',
            'order'    => 'ASC',
            'no_found_rows'=>true,
            'post__in'=>$featured_products,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'ignore_pto'=>true,
        );
        query_posts($post_args);
        if (have_posts()) 
        {
    ?>
        <div id="home-products" class="page-section home-page-section">
            <div class="container position-relative">
                <h2 class="home-title wow zoomIn">GUAI-AID <span>PRODUCTS</span></h2>
                <div class="slick-arrows">
                    <button class="slick-arrow prevArrow"><i class="flaticon-back"></i> <span class="sr-only">
                            <?php _e('Prev','guai-aid');?></span></button>
                    <button class="slick-arrow nextArrow"><i class="flaticon-next"></i> <span class="sr-only">
                            <?php _e('Next','guai-aid');?></span></button>
                </div>
                <div class="card-items slides row m-0 mt-5">
                    <?php while (have_posts()) : the_post(); ?>
                    <div class="card-item-col col-12 col-md-4 col-lg-3 p-2">
                        <?php get_template_part('templates/cards/product' );  ?>
                    </div>
                    <?php
                        endwhile;
                        wp_reset_query();
                    ?>
                </div>
            </div>
        </div>
        <?php
        }
    }
?>
        <?php            
//-- Reviews -->
 
       $post_args=array(
            'type' => 'review', 
            'number' => 3,
            'status'=>'approve',
            'no_found_rows'=>true,
            'orderby'=>'comment_ID',
            'order'=>'DESC',
            'update_comment_meta_cache' => false,
            'update_comment_post_cache' => false,
            'ignore_pto'=>true,
        );
       $comments_query = new WP_Comment_Query( $post_args );
        if ($comments_query->comments) 
        {
    ?>
        <div id="home-reviews" class="page-section home-page-section">
            <div class="container position-relative text-center">
                <h2 class="home-title">Testimonials from<span><a href="https://www.amazon.com/Guai-Aid%C2%AE-Ultra-Pure-Guaifenesin-Gelatin-Capsules/dp/B00C39DFEE/ref=sr_1_2_sspa?crid=23B2AEK9AZBUV&keywords=guai-aid&qid=1647971204&sprefix=guai-aid%2Caps%2C104&sr=8-2-spons&psc=1&spLa=ZW5jcnlwdGVkUXVhbGlmaWVyPUExQThZU0s0TzhGMDhCJmVuY3J5cHRlZElkPUEwNDMxNTQ3UDZKOVJDOUpBSkREJmVuY3J5cHRlZEFkSWQ9QTA3NjQ1ODcyT1NCNzIyVEg5WFRMJndpZGdldE5hbWU9c3BfYXRmJmFjdGlvbj1jbGlja1JlZGlyZWN0JmRvTm90TG9nQ2xpY2s9dHJ1ZQ==#customerReviews" target="_blank">Our Many Amazon Customers</a></span></h2>
                <div class="tab">
                    <div class="tab-content" id="nav-tabContent">
                        <?php 
                    $nav_tabs=$class='';
                    $i=1;
                    foreach ( $comments_query->comments as $comment )
                    {  
                    //print_r( $comment);
                        $aria='false';
                        $class='';
                        if($i==1){
                            $class="show active";
                            $aria='true';
                        }
                        $nav_tabs .='<a class="nav-item nav-link '.$class.'" id="nav-tab'.$comment->comment_ID.'" data-bs-toggle="tab" href="#tab1-'.$comment->comment_ID.'"  data-bs-target="#tab1-'.$comment->comment_ID.'" role="tab" aria-controls="tab1-'.$comment->comment_ID.'" aria-selected="'.$aria.'">'.get_avatar($comment->comment_author_email,70).'</a>';
                    ?>
                        <div class="tab-pane fade <?php echo $class;?>" id="tab1-<?php echo $comment->comment_ID;?>" role="tabpanel" aria-labelledby="tab1-<?php echo $comment->comment_ID;?>-tab">
                            <div class="testimonial-content"> <i class="fas fa-quote-left"></i>
                                <?php echo wpautop($comment->comment_content);?>
                            </div>
                            <h6 class="testimonial-caption">
                                <?php echo $comment->comment_author;?>
                            </h6>
                        </div>
                        <?php
                        $i++; 
                    }?>
                    </div>
                    <div class="nav nav-tabs mt-5 border-0" id="nav-tab" role="tablist">
                        <?php echo $nav_tabs;?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
?>
        <?php            
//-- Blog Post section -->
 
       $post_args=array(
            'post_type' => 'post', 
            'posts_per_page' => 3,
            'no_found_rows'=>true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'ignore_pto'=>true,
        );
        query_posts($post_args);
        if (have_posts()) 
        {
    ?>
        <div id="home-blog" class="page-section home-page-section">
            <div class="container position-relative text-center">
                <h2 class="home-title wow text-center">LATEST <span>BLOGS</span></h2>
                <div class="card-items row mt-5">
                    <?php while (have_posts()) : the_post(); ?>
                    <div class="card-item-col col-12 col-sm-6 col-md-4 mb-4">
                        <?php get_template_part('templates/cards/post-home' );  ?>
                    </div>
                    <?php
                        endwhile;
                        wp_reset_query();
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
?>
    </div>
</div>
<?php
get_footer();
?>