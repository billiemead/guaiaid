<?php

    /* Template Name: Contact Page  */

    if ( !defined( 'ABSPATH' ) ) { exit; }

    get_header();

    while ( have_posts() ):

    the_post();

    $post_type=guai_aid_post_type();

    $meta=guai_aid_all_post_meta( get_the_ID());

    $image=@get_the_post_thumbnail_url(get_the_ID(),'full');

    $custom_f = guai_aid_custom_fields();

?>
<article id="page-<?php the_ID(); ?>" <?php post_class('m-0'); ?> >
    <header class="entry-header page-header position-relative m-0" style="background-image:url('<?php echo $image;?>')">
        <div class="container">
            <h1 class="entry-title page-title">
                <?php the_title();?>
            </h1>
        </div>
    </header>
    <div class="entry-content" id="contact-page-cont">
        <?php if ( !empty( get_the_content() ) ){  ?>
        <div class="container py-5">
            <?php the_content(); ?>
            <div class="clear"></div>
        </div>
        <?php }?>
        <div class="container py-5">
            <ul class="contact-info list-inline d-flex flex-md-row flex-column justify-content-between align-items-between bg-white">
                <li><i class="flaticon-location"></i><span>Address:</span>
                    <?php echo $custom_f->address;?>
                    <span class="contact-icon"><i class="flaticon-location"></i></span>
                </li>
                <li class="theme-bg "><i class="flaticon-call"></i><span>Phone:</span>
                    <?php echo $custom_f->phone;?>
                    <span class="contact-icon"><i class="flaticon-call"></i></span>
                </li>
                <li><i class="flaticon-email"></i><span>Email</span>
                    <?php echo $custom_f->email;?>
                    <span class="contact-icon"><i class="flaticon-email"></i></span>
                </li>
            </ul>
            <div class="row bg-white map-form-section m-0">
                <div class="col-md-12 col-lg-4 p-0">
                    <div class="map h-100">
                        <iframe src="<?php echo $custom_f->map_link;?>" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" class="h-100 w-100"></iframe>
                    </div>
                </div>
                <div class="col-md-12 col-lg-8 p-0">
                    <div class="contact-main white-bg">
                        <?php echo do_shortcode('[contact-form-7 id="'. $custom_f->contact_us_form[0].'" title="Contact form"]');?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>
<?php 

    endwhile; 

    get_footer();

?>