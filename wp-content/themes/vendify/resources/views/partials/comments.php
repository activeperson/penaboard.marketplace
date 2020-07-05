<?php
/**
 * Blog comments.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( comments_open() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
} ?>

<div class="discussion">
	<header class="discussion__header">
		<h3 class="display-3"><?php esc_html_e( 'Discussion', 'vendify' ); ?></h3>
		<div><?php comments_number( esc_html__( '0 people talking', 'vendify' ), esc_html__( '1 person talking', 'vendify' ), esc_html__( '% people talking', 'vendify' ) ); ?></div>
	</header>

	<?php
	comment_form(
		[
			'title_reply'          => '',
			'title_reply_to'       => '',
			'title_reply_before'   => '',
			'title_reply_after'    => '',
			'cancel_reply_link'    => esc_html__( 'Cancel', 'vendify' ),
			'comment_notes_before' => '',
			'submit_button'        => '',
			'comment_field'        => get_comment_form_comment_field(),
			'class_submit'         => 'discussion-submit',
			'end-callback'         => function() {
				echo '</div></div>';
			},
			'must_log_in'          => '<p class="must-log-in text-center">' . sprintf(
					__( 'You must be <a href="%s">logged in</a> to post a comment.', 'vendify' ),
			trailingslashit( wp_login_url() ) . '#sign-in'
				) . '</p>',
		]
	);

	if ( have_comments() ) : ?>
	<section id="comments" class="comment-list">
		<?php
		wp_list_comments(
			[
				'max_depth'   => 2,
				'style'       => 'div',
				'avatar_size' => 24,
				'callback'    => 'Astoundify\Vendify\show_comment',
				'short_ping'  => true,
			]
		);

		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
			<nav id="comment-nav-below" class="comment-navigation">
				<h3 class="screen-reader-text"><?php _e( 'Comment navigation', 'vendify' ); ?></h3>
				<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'vendify' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'vendify' ) ); ?></div>
			</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>
	</section>
	<?php endif; ?>

</div>
