<?php
/**
 * Child Comment Form
 *
 * This file calls the defines the output for the HTML5 blog comment form.
 *
 * @category     Child
 * @package      Structure
 * @author       Web Savvy Marketing
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since        2.0.0
 */


/** Edit comments form text **/

add_filter( 'comment_form_defaults', 'wsm_genesis_comment_form_args' );

function wsm_genesis_comment_form_args( $defaults ) {

	global $user_identity, $id;

	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? ' aria-required="true"' : '' );

	$author = '<p class="comment-form-author">' .
			 '<input id="author" name="author" type="text" placeholder="' . __( 'Name', 'richard' ) .   ( $req ? '*' : '' ) .'" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" tabindex="31"' . $aria_req . ' />' . // With Placeholder
			 // '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" tabindex="1"' . $aria_req . ' />' . // No Placeholder
			 '<label for="author">' . __( 'Name', 'richard' ) .   ( $req ? '<span class="required">*</span>' : '' ) .'</label> ' .
			 '</p><!-- .comment-form-author -->';

	$email = '<p class="comment-form-email">' .
			'<input id="email" name="email" type="text" placeholder="' . __( 'Email', 'richard' ) .   ( $req ? '*' : '' ) .'" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" tabindex="32"' . $aria_req . ' />' . //With Placeholder
			//'<input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" tabindex="2"' . $aria_req . ' />' . // No Placeholder
			'<label for="email">' . __( 'Email', 'richard' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label> ' .
			'</p><!-- .comment-form-email -->';

		$url = '<p class="comment-form-url">' .
			'<input id="url" name="url" type="text" placeholder="' . __( 'Website', 'richard' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" tabindex="33" />' . // With Placeholder
			// '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" tabindex="2" />' . // No Placeholder
	         '<label for="url">' . __( 'Website', 'richard' ) . '</label> ' .
	         '</p><!-- .comment-form-url -->';

	$comment_field = '<p class="comment-form-comment">' .
					'<label for="comment">' . __( 'Comment', 'richard' ) . '</label>' .
	                  '<textarea id="comment" name="comment" placeholder="' . __( 'Comment', 'richard' ) . '" cols="45" rows="8" tabindex="30" aria-required="true"></textarea>' . // With placeholder
	                  // '<textarea id="comment" name="comment" cols="45" rows="8" tabindex="4" aria-required="true"></textarea>' . // No Placeholder
	                 '</p>';

	$args = array(
		'fields'               => array(
			'author' => $author,
			'email'  => $email,
			'url'    => $url,
		),
		'comment_field'        => $comment_field,
		'title_reply'          => __( 'Leave a Comment', 'richard' ),
		'label_submit' => __( 'Post', 'richard' ), //default='Post Comment'
		'title_reply_to' => __( 'Reply', 'richard' ), //Default: __( 'Leave a Reply to %s' )
		'cancel_reply_link' => __( 'Cancel', 'richard' ),//Default: __( 'Cancel reply' )
		'comment_notes_before' => '',
		'comment_notes_after'  => '',
	);

	/** Merge $args with $defaults */
	$args = wp_parse_args( $args, $defaults );

		/** Return filterable array of $args, along with other optional variables */
	return apply_filters( 'genesis_comment_form_args', $args, $user_identity, $id, $commenter, $req, $aria_req );

}