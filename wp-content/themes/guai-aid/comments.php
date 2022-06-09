<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
if ( post_password_required() ) {
    return;
}
$required_text = '';
?>
<div id="comments-area" class="card d-print-none">
    <div id="comments">
        <h3 class="title">
            <i class="far fa-comments mr-2"></i>
            <?php
            _e('Comments','guai-aid');
   /*     $comments_number = get_comments_number();
         if (1 === $comments_number ) {
               translators: %s: post title 
              printf(esc_html('One thought on &ldquo;%s&rdquo;',  'guai-aid'), get_the_title());
         } else {
              printf(
                  esc_html(
            translators: 1: number of comments, 2: post title 
                      _nx(
                          'Comments(%1$s) ',
                          'Comments',
                          $comments_number,
                          'comments title',
                          'guai-aid'
                      )
                  ),
                  esc_html(number_format_i18n($comments_number)),
                  get_the_title()
              );
         }*/
    ?>
        </h3>
    

        <?php if (have_comments() ){ ?>
        <div class="comments-list">
            <?php wp_list_comments(array( 'style' => 'ol', 'short_ping' => false,'avatar_size' => 50,  'walker'=>new Guai_Aid_Comment_Walker )); ?>
        </div>
        <?php the_comments_navigation();
   

    } else  if (! comments_open() && get_comments_number() && post_type_supports(guai_aid_post_type(), 'comments') ) {
             // If comments are closed and there are comments, let's leave a little note, shall we?
        ?>
        <div class="alert alert-info no-comments">
            <p class="m-0">
                <?php esc_html_e('Comments are closed.', 'guai-aid'); ?>
            </p>
        </div>
        <?php }else{ ?>
        <div class="comment-notes alert alert-info">
            <p class="m-0">
                <?php _e('No comments were posted yet.','guai-aid');?>
            </p>
        </div>
        <?php } ?>
    </div>
    <!-- .comments-area -->
    <?php
    $args = array(
        'fields' => array(
            'author' => '<div class="col-md-6"><div class="form-group comment-form-author">
                            <label for="author">' . __( 'Name', 'guai-aid' ) . '<span class="text-danger required">*</span></label> 
                            <input id="author" name="author" type="text" value="" size="30" maxlength="245" required="required" class="form-control" />
                        </div></div>',

            'email' => '<div class="col-md-6"><div class="form-group comment-form-email">
                        <label for="email">' . __( 'Email', 'guai-aid' ) . '<span class="text-danger required">*</span></label> 
                        <input id="email" name="email" type="email" value="" size="30" maxlength="100" aria-describedby="email-notes" required="required" class="form-control" />
                    </div></div>',

            'url' => '<div class="col-md-6"><div class="form-group comment-form-url">
                    <label for="url">' . __( 'Website', 'guai-aid' ) . '</label> 
                    <input id="url" name="url" type="url" value="" size="30" maxlength="200" class="form-control" />
                </div></div>',

            'cookies' => '<div class="col-md-12"> <hr>
                        <div class="form-group comment-form-cookies-consent">              
                                <div class="form-check">
                                     <input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" class="form-check-input"  />
                                     <label for="wp-comment-cookies-consent" class="form-check-label">' . __( 'Save my name, email, and website in this browser for the next time I comment.', 'guai-aid' ) . '</label>
                                </div> 
                            </div>
                        </div>'
        ),
        'must_log_in' => '<div class="alert alert-info must-log-in"><p class="m-0">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'guai-aid' ), wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p></div>',

        'must-log-in' => '<div class="alert alert-info logged-in-as"><p class="m-0">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'guai-aid' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p></div>',

        'comment_notes_before' => '<div class="alert alert-info comment-notes"><p class="m-0">' . __( 'Your email address will not be published.', 'guai-aid' ) . ( $req ? $required_text : '' ) . '</p></div>',

        // 'comment_notes_after'=>'<div class="alert alert-warning form-allowed-tags"><p class="m-0">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <code>' . allowed_tags() . '</code>' ) . '</p></div>',  

        'logged_in_as' => '<div class="alert alert-info logged-in-as"><p class="m-0">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'guai-aid' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p></div>',

        'comment_field' => '<div class="form-group comment-form-comment">
                <label for="comment">' . __( 'Comment', 'guai-aid' ) . '</label> 
                <textarea id="comment" name="comment" cols="45" rows="4" maxlength="65525" required="required" class="form-control"></textarea>
            </div>',

        'submit_field' => '<div class="form-group form-submit">%1$s %2$s</div>',
        'submit_button' => '<hr><button name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s">%4$s</button>',
        'class_submit' => 'btn btn-danger  btn-booking',
        'title_reply_before' => '<h4 id="reply-title" class="title">',
        'title_reply_after' => '</h4>',
        'title_reply' => __( 'Leave a Comment', 'guai-aid' ),
        'title_reply_to' => __( 'Leave a Reply to %s', 'guai-aid' ),
        'cancel_reply_link' => __( 'Cancel Reply', 'guai-aid' ),
        'label_submit' => __( 'Post Comment', 'guai-aid' ),
        'cancel_reply_before' => '',
        'cancel_reply_after' => '',
        'id_form' => 'commentform',
        'class_form' => 'comment-form',
        'id_submit' => 'submit',
        'name_submit' => 'submit',
    );
    guai_aid_comment_form( $args );
    ?>
</div>