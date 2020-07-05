<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;

if ( ! comments_open() ) {
	return;
}

if ( get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
}
?>

<div id="reviews" class="woocommerce-Reviews">
	<div class="discussion">
		<header class="reviews__header">

			<div class="rating">
				<?php woocommerce_template_single_rating(); ?>
				<div class="rating__count">
					<?php comments_number( __( '0 Reviews', 'vendify' ), __( '1 Review', 'vendify' ), __( '% Reviews', 'vendify' ) ); ?>
				</div>
			</div>
		</header>

		<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>

			<div id="review_form_wrapper">
				<div id="review_form">
					<?php
					$commenter = wp_get_current_commenter();

					$comment_form = [
						'title_reply'          => '',
						'title_reply_to'       => '',
						'title_reply_before'   => '',
						'title_reply_after'    => '',
						'cancel_reply_before'  => '',
						'cancel_reply_after'   => '',
						'comment_notes_before' => '',
						'submit_button'        => '',
						'comment_field'        => comment_form_review_comment_field(),
					];

					if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
						$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'vendify' ), esc_url( $account_page_url ) ) . '</p>';
					}

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
					?>
				</div>
			</div>

		<?php else : ?>

			<p class="woocommerce-verification-required"><?php _e( 'Only logged in customers who have purchased this product may leave a review.', 'vendify' ); ?></p>

		<?php endif; ?>

		<?php if ( have_comments() ) : ?>
			<section id="comments" class="comment-list">
				<?php
					wp_list_comments(
						[
							'max_depth'   => 1,
							'style'       => 'div',
							'avatar_size' => 24,
							'callback'    => 'Astoundify\Vendify\get_review',
						]
					);
				?>
			</section>

			<?php
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links(
					apply_filters(
						'woocommerce_comment_pagination_args',
						array(
							'prev_text' => '&larr;',
							'next_text' => '&rarr;',
							'type'      => 'list',
						)
					)
				);
				echo '</nav>';
			endif;
			?>

		<?php endif; ?>
	</div>

</div>
