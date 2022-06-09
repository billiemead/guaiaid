<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Comment API: Guai_Aid_Comment_Walker class
 *
 */
class Guai_Aid_Comment_Walker extends Walker {

    public $tree_type = 'comment';

    public $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );

    public
    function start_lvl( & $output, $depth = 0, $args = array() ) {
        $GLOBALS[ 'comment_depth' ] = $depth + 1;
        $output .= '<div class="comment-children">' . "\n";
    }

    public
    function end_lvl( & $output, $depth = 0, $args = array() ) {
        $GLOBALS[ 'comment_depth' ] = $depth + 1;
        $output .= "</div><!-- .children -->\n";
    }

    public
    function display_element( $element, & $children_elements, $max_depth, $depth, $args, & $output ) {
        if ( !$element )
            return;
        $id_field = $this->db_fields[ 'id' ];
        $id = $element->$id_field;
        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
        if ( $max_depth <= $depth + 1 && isset( $children_elements[ $id ] ) ) {
            foreach ( $children_elements[ $id ] as $child )
                $this->display_element( $child, $children_elements, $max_depth, $depth, $args, $output );
            unset( $children_elements[ $id ] );
        }
    }

    public
    function start_el( & $output, $comment, $depth = 0, $args = array(), $id = 0 ) {
        $depth++;
        $GLOBALS[ 'comment_depth' ] = $depth;
        $GLOBALS[ 'comment' ] = $comment;
        ob_start();
        $this->html5_comment( $comment, $depth, $args );
        $output .= ob_get_clean();

    }

    public
    function end_el( & $output, $comment, $depth = 0, $args = array() ) {
        if ( !empty( $args[ 'end-callback' ] ) ) {
            ob_start();
            call_user_func( $args[ 'end-callback' ], $comment, $args, $depth );
            $output .= ob_get_clean();
            return;
        }
        $output .= "</div><!-- #comment-## -->\n";

    }

    protected
    function html5_comment( $comment, $depth, $args ) {
    	$class="";
    	if( isset($depth['has_children'])){
    		$class="parent";
    	}
        ?>
        <div id="comment-<?php comment_ID(); ?>" <?php comment_class($class,$comment); ?>>
            <div id="comment-item-<?php comment_ID(); ?>" class="comment-contents media">
                <div class="comment-author">
                    <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
                </div>
                <div class="media-body ml-3">
                    <h4 class="comment-author-name">
                        <?php echo get_comment_author_link( $comment ); ?> <span class="says sr-only">says:</span>
                    </h4>
                    <ul class="nav comment-meta">
                        <li>
                            <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>" class="nav-link">
	                        <i class="fas fa-clock mr-1"></i>
	                        <time datetime="<?php comment_time( 'c' ); ?>">
	                            <?php printf( __( '%1$s at %2$s' ,'guai-aid'), get_comment_date( '', $comment ), get_comment_time() );
	                                ?>
	                        </time>
	                    </a>
                        
                        </li>
                        <li>
                            <?php edit_comment_link('<i class="fas fa-edit mr-1"></i>'.__( 'Edit','guai-aid' ), '', '' ); ?>
                        </li>
                        <li>
                            <?php comment_reply_link( array_merge( $args, array(
			                    'add_below' => 'comment-item',
			                    'depth'     => $depth,
			                    'max_depth' => $args['max_depth'],
			                    'before'    => '',
			                    'after'     => '',
			                    'reply_text'    =>'<i class="fas fa-comment mr-1"></i>'. __( 'Reply' ,'guai-aid'),
			                ) ) );
	                ?>
                        </li>
                    </ul>
                    <?php if ( '0' == $comment->comment_approved ) : ?>
                    <div class="alert alert-warning comment-awaiting-moderation">
                        <p class="m-0">
                            <?php _e( 'Your comment is awaiting moderation.','guai-aid' ); ?>
                        </p>
                    </div>
                    <?php endif; ?>
                    <div class="comment-content">
                        <?php comment_text(); ?>
                    </div>
                </div>
            </div>
            <!-- .comment-body -->
            <?php
            }
            }
            ?>