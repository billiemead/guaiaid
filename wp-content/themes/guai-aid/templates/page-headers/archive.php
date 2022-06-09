<div class="page-header position-relative">
    <h2 class="page-title">
        <?php
            if ( is_search() ) {
                _e( 'Search', 'guai-aid' );
            } else if ( guai_aid_post_type() == 'tour' ) {
                _e( 'Tours', 'guai-aid' );
            } else if ( guai_aid_post_type() == 'job'  ) {
                _e( 'Careers', 'guai-aid' );
            } else {
                _e( 'Blog', 'guai-aid' );
            }
            ?>
    </h2>
    <?php 
    if(is_search()){
        get_search_form();
    }
?>
    <hr>
</div>