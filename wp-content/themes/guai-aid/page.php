<?php
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
    <div class="entry-content">
        <?php if ( !empty( get_the_content() ) ){  ?>
        <div class="container py-5">
            <?php the_content(); ?>
            <div class="clear"></div>
        </div>
        <?php }

        // rows 
        if(isset($custom_f->page_rows) && count($custom_f->page_rows)>0)
        {
            echo '<div class="page-rows">';
            $i=1;
            foreach ($custom_f->page_rows as $key => $page_row) 
            {
            ?>
                <div class="page-row">
                    <div class="container">
                        <div class="row m-0">
                        <?php 
                            $img='';
                            $col='col-md-6 px-4';
                            if( isset($page_row['width']) && (trim($page_row['width'])=='full')){
                                $col='col-md-12 px-4';
                            }
                            if( isset($page_row['image']) && (!empty($page_row['image']))){
                                $img_src = wp_get_attachment_image_src(trim($page_row['image']), 'full' );
                                $img= '<div class="'.$col.' img-col"><img src="'.$img_src[0].'" alt="image" width="'.$img_src[1].'" height="'.$img_src[2].'" class="img-fluid"></div>';
                            }
                            if($i%2==0){
                                echo $img;
                            }
                            echo '<div class="'.$col.' text-col">';
                                if( isset($page_row['title']) && (!empty($page_row['title']))){
                                   echo '<h2 class="page-row-title mt-0 mb-4">'.($page_row['title']).'</h2>';
                                }
                                if( isset($page_row['content']) && (!empty($page_row['content']))){
                                   echo wpautop($page_row['content']);
                                }
                            echo '</div>';
                            if($i%2!=0){
                                echo $img;
                            }
                        ?>
                        </div>
                    </div>
                </div>
        <?php 
                $i++;
            }
            echo '</div>';
        }



        ?>
    </div>
</article>
<?php 
    endwhile; 
    get_footer();
?>