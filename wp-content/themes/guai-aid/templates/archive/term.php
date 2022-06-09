<?php
    global $dest_term_data;
    $term = $dest_term_data[ 0 ];
    $meta = guai_aid_all_term_meta( $term->term_id );
    $link = get_term_link( $term );
  
    if($edit_term=get_edit_term_link( $term->term_id, $term->taxonomy )){
        echo '<a class="btn btn-outline-dark text-center edit-button" href="<?php echo $edit_term;?>"><i class="fas fa-edit mr-1"></i>'. __('Edit Destination', 'guai-aid').'</a>';
    }
 ?>
<a href="<?php echo $link;?>" class="card-link d-block h-100" title="<?php _e('Continue Reading', 'guai-aid');?> <?php echo $term->name;?>">
    <div id="term-<?php echo $term->term_id; ?>" class="card card-item archive-item archive-destination-item">
        <div class="row m-0">
            <div class="col-md-4 col-lg-3 p-0">
                <?php guai_aid_thumbnail($term->term_id,'guai-aid-post-archive','',$meta); ?>
            </div>
            <div class="col-md-8 col-lg-9 p-0">
                <div class="card-body">
                    <h2 class="card-title mt-0">
                        <?php echo $term->name;?>
                    </h2>
                    <div class="card-summary m-0">
                        <?php 
                    if( isset($meta->packages_page_content) && ($desc=trim($meta->packages_page_content))){
                        guai_aid_the_content($desc);
                    } else if( $desc=trim($term->description)) { 
                        guai_aid_the_content($desc);
                    }?>
                        <div class="text-right">
                            <span class="more-link read-more btn btn-outline-danger">
                                <?php _e('Continue Reading', 'guai-aid');?>
                                <span class="screen-reader-text sr-only">
                                    <?php echo $term->name;?>
                                </span>
                                <i class="fa fa-arrow-right"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</a>