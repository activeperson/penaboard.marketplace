<?php
/**
 * WooCommerce Template
 *
 * Functions for the templating system.
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
 * Turn off transparent header on the account page.
 *
 * @since 1.0.0
 *
 * @param bool $transparent Current status.
 * @return bool
 */
function woocommerce_is_transparent_header( $transparent ) {
	if ( is_account_page() ) {
		return false;
	}

	return $transparent;
}

/**
 * Load login/register screen for guests.
 *
 * @since 1.0.0
 */
function woocommerce_login_register_screen() {
	if ( is_user_logged_in() ) {
		return;
	}

	wc_get_template( 'modals/login-register.php' );
}

/**
 * Add login modal link triggers.
 *
 * @since 1.0.0
 *
 * @param array $args i18n Arguments.
 * @return array
 */
function woocommerce_i18n( $args ) {
	if ( ! isset( $args['woocommerce'] ) ) {
		$args['woocommerce'] = [];
	}

	$args['woocommerce']['showCart'] = isset( $_POST['add-to-cart'] );
	$args['woocommerce']['shopUrl'] = wc_get_page_permalink( 'shop' );

	if ( ! is_user_logged_in() ) {
		$wc_account_url = get_option( 'woocommerce_myaccount_page_id' );

		if ( $wc_account_url ) {
			$wc_account_url = get_permalink( $wc_account_url );

			$args['loginRegisterModalLinks'][] = '[href="' . untrailingslashit( $wc_account_url ) . '"]';
			$args['loginRegisterModalLinks'][] = '[href="' . untrailingslashit( $wc_account_url ) . '#sign-in"]';
			$args['loginRegisterModalLinks'][] = '[href="' . untrailingslashit( $wc_account_url ) . '#sign-up"]';
			$args['loginRegisterModalLinks'][] = '[href="' . untrailingslashit( wp_login_url() ) . '#sign-in"]';

			$args['loginRegisterModalLinks'][] = '[href="' . trailingslashit( $wc_account_url ) . '"]';
			$args['loginRegisterModalLinks'][] = '[href="' . trailingslashit( $wc_account_url ) . '#sign-in"]';
			$args['loginRegisterModalLinks'][] = '[href="' . trailingslashit( $wc_account_url ) . '#sign-up"]';
			$args['loginRegisterModalLinks'][] = '[href="' . trailingslashit( wp_login_url() ) . '#sign-in"]';
		}

		// Autoplay overlay gallery.
		$setting = absint( get_theme_mod( 'login-register-gallery-autoplay', 4.5 ) );
		$args['woocommerce']['loginRegisterModalAutoplay'] = 0 !== $setting ? absint( $setting * 1000 ) : false;
	}

	return $args;
}

/**
 * Update custom cart template parts.
 *
 * @since 1.0.0
 *
 * @param array $fragments Fragments to update.
 * @return array $fragments
 */
function woocommerce_cart_count_fragments( $fragments ) {
	$cart_count = (int) WC()->cart->get_cart_contents_count();

	// Translators: %d Number of items in the cart.
	$fragments['.wc-cart-count--string'] = '<span class="wc-cart-count--string">' . sprintf( esc_attr( _n( '%d item', '%d items', $cart_count, 'vendify' ) ), absint( $cart_count ) ) . '</span>';

	$fragments['.wc-cart-count'] = '<span class="wc-cart-count icon-badge" ' . ( 0 === $cart_count ? ' style="display: none;"' : null ) . '>' . $cart_count . '</span>';

	return $fragments;
}

/**
 * Generate a class to use for rating HTML.
 *
 * 4.38 -> 4-0
 * 3.89 -> 4-0
 *
 * @since 1.0.0
 *
 * @param int $rating Current rating.
 * @return string
 */
function woocommerce_rating_class( $rating ) {
	return str_replace( '.', '-', number_format( floor( $rating * 2 ) / 2, 1 ) );
}

/**
 * Rating HTML.
 *
 * @since 1.0.0
 *
 * @param string $html Current HTML.
 * @param float  $rating Rating of product.
 * @param int    $count Number of ratings.
 * @return string
 */
function woocommerce_get_star_rating_html( $html, $rating, $count ) {
	$class = woocommerce_rating_class( $rating );

	if ( 0 < $count ) {
		/* translators: 1: rating 2: rating count */
		$string = sprintf( _n( 'Rated %1$s out of 5 based on %2$s customer rating', 'Rated %1$s out of 5 based on %2$s customer ratings', $count, 'vendify' ), $rating, $count );
	} else {
		/* translators: %s: rating */
		$string = sprintf( esc_html__( 'Rated %s out of 5', 'vendify' ), $rating );
	}

	$html = sprintf(
		'<div class="rating__stars rating__stars--%s" title="%s"></div>',
		$class,
		$string
	);

	return $html;
}

/**
 * Append a `form-control` class to all inputs.
 *
 * @since 1.0.0
 */
add_filter( 'woocommerce_form_field_args', function ( $args ) {
		switch ( $args['type'] ) {
			case 'textarea':
			case 'password':
			case 'text':
			case 'email':
			case 'tel':
			case 'number':
				$args['input_class'][] = 'form-control';
				break;
			case 'select':
				$args['input_class'][] = 'custom-select';
				break;
		}

		if ( is_array( $args['label_class'] ) ) {
			$args['label_class'] = array_merge( $args['label_class'], array('label') );
		}

		if ( $args['required'] ) {
			$args['label_class'] = array_merge( $args['label_class'], array('label--required') );
		}

		return $args;
}, 99 );

/**
 * Take the comment field and push it and the end to fit the design.
 * @param $fields
 *
 * @return mixed
 */
function push_reviews_text_field_at_the_end( $fields ){
	// this should happen only on products or reviews.
	if( function_exists('is_product') && is_product()  ){
		$comment_field = $fields['comment'];
		unset( $fields['comment'] );
		$fields['comment'] = $comment_field;
	}
	return $fields;
}

/**
 * Determine if we are only front page of the Shop.
 *
 * This excludes categories, searches, etc.
 *
 * @return bool
 */
function woocommerce_is_front_page() {
	if ( isset( $_GET ) && ! empty( $_GET ) ) { // WPCS: input var okay, CSRF okay.
		return false;
	}

	if ( get_query_var( 's' ) ) {
		return false;
	}

	if ( get_query_var( 'page' ) ) {
		return false;
	}

	if ( is_product_category() || is_product_tag() ) {
		return false;
	}

	return true;
}

/**
 * Redirect cart page if optimized checkout is used.
 *
 * @since 1.0.0
 */
function woocommerce_redirect_cart() {
	if ( is_cart() && ! WC()->cart->is_empty() ) {
		wp_safe_redirect( esc_url_raw( wc_get_checkout_url() ) );
		exit();
	}
}

/**
 * Determine if we are on the final step of the checkout.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function woocommerce_is_order_received() {
	global $wp;

	if ( is_checkout() && ! empty( $wp->query_vars['order-received'] ) ) {
		return true;
	}

	return false;
}

/**
 * Get featured shop products.
 *
 * @since 1.0.0
 *
 * @return array
 */
function woocommerce_featured_products() {
	$args = [
		'limit'    => 5,
		'featured' => true,
	];

	if ( is_product_category() ) {
		$category = get_queried_object();

		$args['category'] = [ $category->slug ];
	}

	return wc_get_products( $args );
}

/**
 * Adjust breadcrumb output.
 *
 * @since 1.0.0
 *
 * @param array $args Breadcrumb arguments.
 * @return array
 */
function woocommerce_breadcrumb_defaults( $args ) {
	$args['home']      = esc_html__( 'Shop', 'vendify' );
	$args['delimiter'] = get_svg(
		[
			'icon'    => 'caret-slider-right',
			'classes' => [ 'ico--xs' ],
		]
	);

	return $args;
}

/**
 * Adjust breadcrumb "Home" URL to the actual shop.
 *
 * @since 1.0.0
 *
 * @param string $url Current URL.
 * @return string
 */
function woocommerce_breadcrumb_home_url( $url ) {
	return esc_url( get_permalink( wc_get_page_id( 'shop' ) ) );
}

/**
 * Modify gallery output based on customizer settings.
 *
 * @since 1.0.0
 *
 * @param array $args Flexslider arguments.
 * @return array
 */
function woocommerce_single_product_carousel_options( $args ) {
	if ( 2 === (int) get_theme_mod( 'product-gallery-style', is_multiple_vendors() ? 1 : 2 ) ) {
		$args['directionNav'] = true;
		$args['controlNav']   = true;

		$args['nextText'] = get_svg( 'caret-slider-right' );
		$args['prevText'] = get_svg( 'caret-slider-left' );
	}

	return $args;
}

/**
 * Add a class to the Flexslider wrapper based on customizer setting.
 *
 * @since 1.0.0
 *
 * @param array $classes Classes for wrapper.
 * @return array
 */
function woocommerce_single_product_image_gallery_classes( $classes ) {
	$classes[] = 'woocommerce-product-gallery--' . get_theme_mod( 'product-gallery-style', is_multiple_vendors() ? 1 : 2 );

	return $classes;
}

/**
 * Output policy tab template.
 *
 * @since 1.0.0
 */
function woocommerce_product_policies_tab() {
	wc_get_template( 'single-product/tabs/policies.php' );
}

/**
 * Customer activity.
 *
 * @since 1.0.0
 *
 * @return array
 */
function woocommerce_get_customer_activity() {
	$activities = [
		'orders'  => [],
		'reviews' => [],
	];

	$activities = apply_filters( 'vendify_woocommerce_get_customer_activity', $activities );

	// Probably an awful way to do this...
	$all = [];

	foreach ( $activities as $group => $items ) {
		foreach ( $items as $item ) {
			$all[] = $item;
		}
	}

	uasort(
		$all,
		function( $a, $b ) {
			if ( $a['timestamp'] === $b['timestamp'] ) {
				return 0;
			}

			return ( $a['timestamp'] > $b['timestamp'] ) ? -1 : 1;
		}
	);

	return array_merge( [ 'all' => array_slice( $all, 0, absint( 5 ) ) ], $activities );
}

/**
 * Add orders to activities.
 *
 * @since 1.0.o
 *
 * @param array $activities Customer activities.
 * @return array
 */
function woocommerce_customer_activity_orders( $activities ) {
	$orders = wc_get_orders(
		apply_filters(
			'woocommerce_my_account_my_orders_query',
			[
				'customer' => get_current_user_id(),
				'page'     => 1,
				'paginate' => false,
				'limit'    => 5,
			]
		)
	);

	if ( ! empty( $orders ) ) {
		foreach ( $orders as $order ) {
			$order = wc_get_order( $order );

			$activities['orders'][] = [
				'type'      => 'order',
				'icon'      => 'sales',
				'link'      => $order->get_view_order_url(),
				'price'     => wc_price( $order->get_total() ),
				'count'     => $order->get_item_count(),
				'timestamp' => $order->get_date_created()->getTimestamp(),
			];
		}
	}

	return $activities;
}

/**
 * Add reviews to activities.
 *
 * @since 1.0.0
 *
 * @param array $activities Customer activities.
 * @return array
 */
function woocommerce_customer_activity_reviews( $activities ) {
	$reviews = get_comments(
		[
			'user_id'     => get_current_user_id(),
			'number'      => 5,
			'status'      => 'approve',
			'post_status' => 'publish',
			'post_type'   => 'product',
			'parent'      => 0,
		]
	);

	if ( ! empty( $reviews ) ) {
		foreach ( $reviews as $comment ) {
			$product = wc_get_product( $comment->comment_post_ID );

			$activities['reviews'][] = [
				'type'              => 'review',
				'icon'              => 'star',
				'timestamp'         => strtotime( $comment->comment_date ),
				'star_count'        => intval( get_comment_meta( $comment->comment_ID, 'rating', true ) ),
				'user_id'           => $comment->user_id,
				'user_email'        => $comment->author_email,
				'user_name'         => $comment->comment_author,
				'user_avatar'       => get_avatar( $comment->author_email ),
				'user_url'          => $comment->user_id ? get_author_posts_url( $comment->user_id ) : $comment->author_url,
				'product_id'        => $product ? $product->get_id() : $item->product_id,
				'product_name'      => $product ? $product->get_name() : $item->product_name,
				'product_url'       => $product ? $product->get_permalink() . '#comment-' . $comment->comment_ID : '',
				'product_thumbnail' => $product ? $product->get_image( 'thumbnail' ) : '', // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			];
		}
	}

	return $activities;
}

/**
 * Adjust the WooCommerce navigation bar labels.
 */
function woocommerce_filter_navigation_labels( $items, $endpoints ){

	$items['orders'] = __( 'Purchases', 'woocommerce' );

	return $items;
}

/**
 * Update cart data via AJAX.
 *
 * @since 1.0.0
 */
function update_order_quantity_ajax() {
	$values = [];
	parse_str( $_POST['checkout'], $values ); // @codingStandardsIgnoreLine

	$cart = $values['cart'];

	foreach ( $cart as $cart_key => $cart_value ) {
		WC()->cart->set_quantity( $cart_key, $cart_value['quantity'] );
	}

	wp_send_json_success();
}

/**
 * Outputs a review in the HTML5 format.
 *
 * @since 1.0.0
 *
 * @see wp_list_comments()
 *
 * @param WP_Comment $comment Comment to display.
 * @param array      $args    An array of arguments.
 * @param int        $depth   Depth of the current comment.
 */
function get_review( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; // @codingStandardsIgnoreLine ?>

<div id="comment-<?php comment_ID(); ?>" <?php comment_class( 'review-item' ); ?>>

	<header class="review-item__header">
		<span class="review-item__logo">
			<?php echo get_avatar( $comment->user_id ? $comment->user_id : $comment->comment_author_email, $args['avatar_size'] ); ?>
		</span>

		<span class="review-item__author">
			<?php echo get_comment_author_link( $comment ); ?>
		</span>

		<span class="review-item__date">
			<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
			<?php
			/* Translators: 1: comment date, 2: comment time */
			$time_title = sprintf( esc_html__( '%1$s at %2$s', 'vendify' ), get_comment_date( '', $comment ), get_comment_time() );

			/* Translators: 1: Time ago */
			$time_label = sprintf( __( '%s ago', 'vendify' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) );

			printf(
				'<time datetime="%1$s" title="%2$s">%3$s</time>',
				get_comment_time( 'c' ),
				$time_title,
				$time_label
			); ?>
			</a>
		</span>
	</header>

	<div class="review__item">
		<div class="review-item__body">
			<?php comment_text(); ?>
		</div>
	</div>

	<footer class="review-item__footer">
		<span class="review-item__category">
			<?php esc_html_e( 'Rating', 'vendify' ); ?>
			<span class="review-badge active">
				<?php
				svg(
					[
						'icon'    => 'star',
						'classes' => [ 'ico--xs' ],
					]
				);
				echo intval( get_comment_meta( $comment->comment_ID, 'rating', true ) ); ?>
			</span>
		</span>
	</footer>

	<?php
}

/**
 * Review comment content field.
 *
 * @since 1.0.0
 */
function comment_form_review_comment_field() {
	ob_start(); ?>

	<p class="form-group">
		<label for="comment" class="screen-reader-text"><?php esc_html_e( 'Comment', 'vendify' ); ?></label>
		<textarea class="form-control comment-field js-autogrow-field" name="comment" id="comment" required="required" placeholder="<?php esc_attr_e( 'Leave a review...', 'vendify' ); ?>"></textarea>
	</p>

	<?php if ( wc_review_ratings_enabled() ) : ?>
	<div class="comment-form-rating">
		<label for="rating" class="has-text-color has-gray500-color">
			<?php
			// Translators: %s product title.
			printf(
				esc_html__( 'Give your rating for %s',
				'vendify' ),
				get_the_title()
			); ?>
		</label>
		<select name="rating" id="rating" aria-required="true" required>
			<option value=""><?php esc_html_e( 'Rate&hellip;', 'vendify' ); ?></option>
			<option value="5"><?php esc_html_e( 'Perfect', 'vendify' ); ?></option>
			<option value="4"><?php esc_html_e( 'Good', 'vendify' ); ?></option>
			<option value="3"><?php esc_html_e( 'Average', 'vendify' ); ?></option>
			<option value="2"><?php esc_html_e( 'Not that bad', 'vendify' ); ?></option>
			<option value="1"><?php esc_html_e( 'Very poor', 'vendify' ); ?></option>
		</select>
	</div>
	<?php endif; ?>

	<button name="submit" type="submit" id="submit" class="btn btn-primary btn-submit-review" value="1">
		<?php esc_html_e( 'Submit Review', 'vendify' ); ?>
	</button>

	<?php
	return ob_get_clean();
}

/**
 * Prints a privacy approval checkbox.
 *
 * @since 1.0.0
 */
function registration_privacy_policy() {
	woocommerce_form_field( 'privacy_policy_registration', array(
		'type'          => 'checkbox',
		'label_class'   => array( 'woocommerce-form__label woocommerce-form__label-for-checkbox custom-control custom-checkbox custom-checkbox-privacy' ),
		'input_class'   => array( 'woocommerce-form__input woocommerce-form__input-checkbox custom-control-input' ),
		'required'      => true,
		'label'         => sprintf(
			esc_html__( '%1$sI\'ve read and accept the %2$sterms & conditions%3$s', 'vendify' ),
			'<span class="custom-control-indicator"></span><span class="custom-control-description"><span>',
			'</span><a href="' . esc_url( get_privacy_policy_url() )  . '">',
			'</a></span>'
		),
	));
}

/**
 * Validation function for the privacy policy.
 *
 * @since 1.0.0
 *
 * @return array
 */
function validate_privacy_registration( $errors, $username, $email ) {
	if ( ! is_checkout() ) {
		if ( ! (int) isset( $_POST['privacy_policy_registration'] ) ) {
			$errors->add( 'privacy_policy_registration_error', esc_html__( 'Please read and accept the terms and conditions to proceed with your registration.', 'vendify' ) );
		}
	}
	return $errors;
}

/**
 * Instead of overwriting /woocommerce/single-product/share.php we'll output the share buttons via `woocommerce_share`
 *
 * @since 1.0.0
 */
function add_woocommerce_share() {
	global $product; ?>

	<div class="product-sidebar__social product-sidebar__social-link">
		<?php
		if ( has_integration( 'favorites' ) ) {
			echo astoundify_favorites_link( $product->get_id() );
		} ?>

		<div class="dropdown dropdown--share">
			<button class="product-sidebar__social-link btn--blank has-icon"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?php
				svg(
					[
						'icon'    => 'share',
						'classes' => [ 'ico--sm' ],
					]
				); ?>

				<span>
					<?php esc_html_e( 'Share', 'vendify' ); ?>
				</span>
			</button>

			<div class="dropdown-menu dropdown-menu-right dropdown-menu--has-icons">
				<a class="dropdown-item" href="<?php echo esc_url( add_query_arg( 'url', rawurlencode( get_permalink() ), 'https://twitter.com/share' ) ); ?>" rel="nofollow">
					<?php
					svg(
						[
							'icon'    => 'twitter',
							'classes' => [ 'ico--sm' ],
						]
					);

					esc_html_e( 'Twitter', 'vendify' ); ?>
				</a>

				<a class="dropdown-item" href="<?php echo esc_url( add_query_arg( 'u', rawurlencode( get_permalink() ), 'https://facebook.com/sharer.php' ) ); ?>" rel="nofollow">
					<?php
					svg(
						[
							'icon'    => 'facebook',
							'classes' => [ 'ico--sm' ],
						]
					);

					esc_html_e( 'Facebook', 'vendify' ); ?>
				</a>

				<a class="dropdown-item" href="<?php echo esc_url( add_query_arg( 'url', rawurlencode( get_permalink() ), 'https://pinterest.com/pin/create/button/' ) ); ?>" rel="nofollow">
					<?php
					svg(
						[
							'icon'    => 'pinterest',
							'classes' => [ 'ico--sm' ],
						]
					);

					esc_html_e( 'Pinterest', 'vendify' ); ?>
				</a>
			</div>
		</div>

	</div>

<?php }
add_action( 'woocommerce_share', 'Astoundify\Vendify\add_woocommerce_share' );

/**
 * Filter the WooCommerce Products Block card output.
 *
* @param $html
* @param $data
* @param $product
 *
 * @return false|string
 */
function woocommerce_products_grid_item( $html, $data, $product ){
	global $post;

	$product_data = get_post( $product->get_id() );
	$product = is_object( $product_data ) && in_array( $product_data->post_type, array( 'product', 'product_variation' ), true ) ? wc_setup_product_data( $product_data ) : false;

	if ( empty( $product ) ) {
		return $html;
	}

	if ( ! method_exists( $product, 'get_id' ) || ! method_exists( $product, 'is_on_sale' ) ) {
		return $html;
	}

	$args = [
		'product'   => $product,
		'is_vendor' => false,
		'block_data' => $data
	];

	$is_vendor  = is_multiple_vendors() && woocommerce_product_vendors_get_vendor_by_product( $product->get_id() );
	$card_style = get_theme_mod( 'product-catalog-style', 1 );

	if ( $is_vendor && ! is_tax( WC_PRODUCT_VENDORS_TAXONOMY ) ) {
		$vendor_data = get_vendor_meta( $product->get_id(), 'product_id' );

		$args['is_vendor']   = true;
		$args['vendor_data'] = $vendor_data;
		$args['vendor_logo'] = $vendor_data['logo_image'];
		$args['vendor_link'] = $vendor_data['link'];
		$args['vendor_name'] = $vendor_data['name'];

		$show_vendor = isset( $show_vendor ) ? $show_vendor : true;

		if ( ! $show_vendor ) {
			$args['is_vendor'] = false;
		}
	}

	ob_start(); ?>

	<div <?php wc_product_class( 'js-reveal product-item-style--' . $card_style, $product ); ?>>
		<?php wc_get_template( "product-cards/card-$card_style.php", $args ); ?>
	</div>

	<?php

	wc_setup_product_data( $post );

	return ob_get_clean();
}
