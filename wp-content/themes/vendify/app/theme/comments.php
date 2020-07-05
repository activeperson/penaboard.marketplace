<?php
/**
 * Comments
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Outputs a comment in the HTML5 format.
 *
 * @since 1.0.0
 *
 * @see wp_list_comments()
 *
 * @param WP_Comment $comment Comment to display.
 * @param array      $args    An array of arguments.
 * @param int        $depth   Depth of the current comment.
 */
function show_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; // WPCS: override ok. ?>

	<?php if ( 1 === $depth ) : ?>
	<div id="comment-<?php comment_ID(); ?>" <?php comment_class( ! empty( $comment->get_children() ) ? 'parent' : '', $comment ); ?>>
<?php else : ?>
	<div id="comment-<?php comment_ID(); ?>" <?php comment_class( 'comment__item comment__item--reply', $comment ); ?>>
<?php endif; ?>

	<header class="comment__header">
		<span class="comment__avatar">
			<?php echo get_avatar( $comment->user_id ? $comment->user_id : $comment->comment_author_email, $args['avatar_size'] ); ?>
		</span>

		<span class="comment__author">
			<?php echo get_comment_author_link( $comment ); ?>
		</span>

		<span class="comment__date">
			<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
				<time datetime="<?php comment_time( 'c' ); ?>" title="
				<?php
				/* Translators: 1: comment date, 2: comment time */
				printf( esc_html__( '%1$s at %2$s', 'vendify' ), get_comment_date( '', $comment ), get_comment_time() );
				?>
				"><?php /* Translators: 1: Time ago */ echo esc_attr( sprintf( __( '%s ago', 'vendify' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ) ); ?></time>
			</a>
		</span>
	</header>


	<?php if ( 1 === $depth ) { ?>
	<div class="comment__thread <?php if ( is_singular( 'product' ) ) { ?> comment__thread--alt<?php } ?>">
		<div id="comment__item-<?php comment_ID(); ?>" class="comment__item">
	<?php } ?>

			<div class="comment__text">
				<?php comment_text(); ?>
			</div>

			<?php if ( ! empty( $comment->get_children() ) || 1 === $depth ) : ?>
			<div class="comment__actions">
				<?php if ( ! empty( $comment->get_children() ) ) : ?>
				<button class="comment__toggle-replies">
					<?php
					svg(
						[
							'icon'    => 'message',
							'classes' => [ 'ico--sm' ],
						]
					);

					esc_html_e( 'View Replies', 'vendify' ); ?>
				</button>
				<?php endif;

				comment_reply_link(
					array_merge(
						$args,
						[
							'add_below' => 'comment__item',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<span class="comment__btn-reply">',
							'after'     => '</span>',
						]
					)
				); ?>
			</div>
			<?php endif; ?>

	<?php if ( 1 === $depth ) { ?>
		</div>
	<?php }

}

/**
 * Respond comment content field.
 *
 * @since 1.0.0
 */
function get_comment_form_comment_field() {
	ob_start(); ?>

	<p class="form-group">
		<label for="comment" class="screen-reader-text"><?php esc_html_e( 'Comment', 'vendify' ); ?></label>
		<textarea class="form-control comment-field js-autogrow-field" name="comment" id="comment" required="required" placeholder="<?php esc_attr_e( 'Leave a reply...', 'vendify' ); ?>"></textarea>

		<button name="submit" type="submit" id="submit" class="comment-form-send btn-icon" value="1">
			<?php svg( 'send' ); ?>
			<span class="screen-reader-text"><?php esc_html_e( 'Submit', 'vendify' ); ?></span>
		</button>

	</p>

	<?php
	return ob_get_clean();
}


function filter_comment_form_fields( $fields ){
	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? " aria-required='true'" : '' );
	$html_req  = ( $req ? " required='required'" : '' );

	$fields['author'] = sprintf(
		'<div class="row">
			<div class="col-12 col-md-6 form-group">
				<label for="author" class="screen-reader-text">%1$s</label>
				<input id="author" name="author" type="text" value="%2$s" maxlength="245" %3$s %4$s class="form-control" placeholder="%5$s" />
			</div>',
		esc_html__( 'Name', 'vendify' ),
		esc_attr( $commenter['comment_author'] ),
		$aria_req,
		$html_req,
		esc_html__( 'Name', 'vendify' )
	);

	$fields['email'] = sprintf(
		'<div class="col-12 col-md-6 form-group">
				<label for="email" class="screen-reader-text">%1$s</label>
				<input id="email" name="email" type="text" value="%2$s" maxlength="245" %3$s %4$s class="form-control" placeholder="%5$s" />
			</div>
		</div>',
		esc_html__( 'Email', 'vendify' ),
		esc_attr( $commenter['comment_author_email'] ),
		$aria_req,
		$html_req,
		esc_html__( 'Email Address', 'vendify' )
	);

	$fields['url'] = sprintf(
		'<div class="form-group">
			<label for="url" class="screen-reader-text">%1$s</label>
			<input id="url" name="url" type="text" value="%2$s" class="form-control" placeholder="%1$s" />
		</div>',
		esc_html__( 'URL', 'vendify' ),
		esc_attr( $commenter['comment_author_url'] )
	);

	if ( isset( $fields['cookies' ] ) ) {
		$consent = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

		$fields['cookies'] = sprintf(
			'<div class="form-group comment-form-cookies-consent checkbox custom-control custom-checkbox">
				<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" %1$s class="custom-control-input input-checkbox"/>
				<span class="custom-control-indicator"></span>
				<label for="wp-comment-cookies-consent" class="custom-control-description">%2$s</label>
			</div>',
			$consent,
			esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'vendify' )
		);
	}

	return $fields;
}
add_filter( 'comment_form_default_fields', 'Astoundify\Vendify\filter_comment_form_fields' );
