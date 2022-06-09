<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
?>
<form method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <?php $id ='search-input-'.str_replace(' ','-',microtime());?>
    <div class="input-group">
        <div class="input-group-prepend">
            <label class="input-group-text m-0" for="<?php echo $id;?>">
                <span class="screen-reader-text sr-only">
                    <?php echo _x( 'Search for:', 'label', 'guai-aid' ); ?></span>
                <i class="fas fa-search"></i>
            </label>
        
        </div>
        <input id="<?php echo $id;?>" type="search" class="form-control search-field" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder', 'guai-aid'); ?>&hellip;" value="<?php echo get_search_query();?>" name="s" title="<?php echo _x( 'Search', 'submit button', 'guai-aid'); ?>" required>
        <div class="input-group-append">
            <button type="submit" class="search-submit btn btn-secondary">
                <?php echo _x( 'Search', 'submit button',  'guai-aid'); ?>
            </button>
        </div>
    </div>
</form>