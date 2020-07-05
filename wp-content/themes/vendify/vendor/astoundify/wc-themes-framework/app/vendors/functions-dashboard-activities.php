<?php
/**
 * Vendor Dashboard Activity Functions
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Vendors
 * @author Astoundify
 */

/**
 * Dashboard Activity List Ordered by Timestamp
 *
 * @since 1.0.0
 *
 * @param array $args Activities Args.
 * @param array $activities_data Useful if data already loaded.
 * @return array
 */
function astoundify_wc_themes_vendors_get_activities_by_timestamp( $args = array(), $activities_data = array() ) {
	$defaults = array(
		'list_limit'     => 5, // Use different key, so it won't effect activities by group.
		'vendor_id'      => WC_Product_Vendors_Utils::get_logged_in_vendor(),
	);

	$args = wp_parse_args( $args, $defaults );

	// All activities by groups.
	$_activities = $activities_data;

	if ( ! $activities_data ) {
		$_activities = astoundify_wc_themes_vendors_get_activities_by_groups( $args );
	}

	$activities = array();

	foreach ( $_activities as $group => $group_data ) {
		foreach ( $group_data['activities'] as $activity ) {
			$defaults = array(
				'timestamp'         => 0,
				'type'              => $group, // Type: "reviews", "orders".
				'content'           => '',
				'user_id'           => '',
				'user_email'        => '',
				'user_name'         => '',
				'user_avatar'       => '',
				'user_url'          => '',
				'product_id'        => '',
				'product_name'      => '',
				'product_url'       => '',
				'product_thumbnail' => '',
			);

			$activities[] = wp_parse_args( $activity, $defaults );
		}
	}

	// Sort by timestamp.
	uasort( $activities, function( $a, $b ) {
		if ( $a['timestamp'] === $b['timestamp'] ) {
			return 0;
		}
		return ( $a['timestamp'] > $b['timestamp'] ) ? -1 : 1;
	} );

	if ( $args['list_limit'] > 0 ) {
		$activities = array_slice( $activities, 0, absint( $args['list_limit'] ) );
	}

	return apply_filters( 'astoundify_wc_themes_vendors_activities_by_timestamp', $activities, $args );
}

/**
 * Dashboard Activity By Groups
 *
 * @since 1.0.0
 *
 * @param array $args Activities Args.
 * @return array
 */
function astoundify_wc_themes_vendors_get_activities_by_groups( $args = array() ) {
	$defaults = array(
		'limit'     => 10,
		'vendor_id' => WC_Product_Vendors_Utils::get_logged_in_vendor(),
	);

	$args = wp_parse_args( $args, $defaults );

	// Use cached data if available.
	$cache_key = md5( serialize( $args ) );
	$activities = wp_cache_get( $cache_key, 'astoundify_wc_themes_vendors_vendor_activities' );
	if ( false !== $activities && is_array( $activities ) && $activities ) {
		return $activities;
	}

	$activities = array(
		'reviews' => array(
			'label'      => esc_html__( 'Reviews', 'astoundify-wc-themes' ),
			'activities' => astoundify_wc_themes_get_activities_reviews( $args ),
		),
		'orders' => array(
			'label'      => esc_html__( 'Orders', 'astoundify-wc-themes' ),
			'activities' => astoundify_wc_themes_get_activities_orders( $args ),
		),
	);

	wp_cache_set( $cache_key, $activities, 'astoundify_wc_themes_vendors_vendor_activities', HOUR_IN_SECONDS );

	return apply_filters( 'astoundify_wc_themes_vendors_activities_by_group', $activities, $args );
}

/* === UTILITY === */

/**
 * Format Activity Content
 *
 * Replace activity content tags with actual HTML in template.
 *
 * @since 1.0.0
 *
 * @param array $activity Activity item.
 * @return string
 */
function astoundify_wc_themes_vendors_activity_get_content( $activity ) {
	ob_start();

	switch ( $activity['type'] ) {
		case 'orders':
			astoundify_wc_themes_get_template( 'vendor-dashboard/activity/order.php', $activity );
			break;
		case 'reviews':
			astoundify_wc_themes_get_template( 'vendor-dashboard/activity/review.php', $activity );
			break;
	}

	$content = ob_get_clean();

	return apply_filters( 'astoundify_wc_themes_vendors_activity_content', $content, $activity );
}

/* === ACTIVITIES === */

/**
 * Dashboard Latest Reviews
 *
 * @since 1.0.0
 *
 * @param array $args Activities Reviews Args.
 * @return array
 */
function astoundify_wc_themes_get_activities_reviews( $args = array() ) {
	$defaults = array(
		'limit'     => 10,
		'vendor_id' => WC_Product_Vendors_Utils::get_logged_in_vendor(),
	);

	$args = wp_parse_args( $args, $defaults );

	$products = WC_Product_Vendors_Utils::get_vendor_product_ids( $args['vendor_id'] );

	if ( empty( $products ) ) {
		$products = array( 999999 ); // Avoid querying all posts.
	}

	$comments_query = new WP_Comment_Query;
	$comments_query_args = array(
		'post__in'   => $products,
		'post_type'  => 'product',
		'parent'     => 0,
		'status'     => 'approve',
		'number'     => $args['limit'],
	);

	$reviews = $comments_query->query( $comments_query_args );

	// Format for activities.
	$activities = array();

	foreach ( $reviews as $k => $comment ) {
		$product = wc_get_product( $comment->comment_post_ID );

		$activities[ $k ] = array(
			'timestamp'         => strtotime( $comment->comment_date ),
			'type'              => 'reviews',
			'star_count'        => intval( get_comment_meta( $comment->comment_ID, 'rating', true ) ),
			'user_id'           => $comment->user_id,
			'user_email'        => $comment->author_email,
			'user_name'         => $comment->comment_author,
			'user_avatar'       => get_avatar( $comment->user_id ? $comment->user_id : $comment->author_email ),
			'user_url'          => $comment->user_id ? get_author_posts_url( $comment->user_id ) : $comment->author_url,
			'product_id'        => $product ? $product->get_id() : $item->product_id,
			'product_name'      => $product ? $product->get_name() : $item->product_name,
			'product_url'       => $product ? $product->get_permalink() . '#comment-' . $comment->comment_ID : '',
			'product_thumbnail' => $product ? $product->get_image( 'thumbnail' ) : '', // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}

	return apply_filters( 'astoundify_wc_themes_vendors_activities_reviews', $activities, $args );
}

/**
 * Dashboard Latest Orders
 *
 * @since 1.0.0
 *
 * @param array $args Activities Orders Args.
 * @return array
 */
function astoundify_wc_themes_get_activities_orders( $args = array() ) {
	$defaults = array(
		'limit'     => 10,
		'vendor_id' => WC_Product_Vendors_Utils::get_logged_in_vendor(),
	);

	$args = wp_parse_args( $args, $defaults );

	$order_query = new Astoundify\WC_Themes\Vendors\Order_Query( array(
		'limit'     => absint( $args['limit'] ),
		'vendor_id' => absint( $args['vendor_id'] ),
	) );

	$orders = $order_query->get_orders();

	$activities = array();

	foreach ( $orders as $k => $item ) {
		$product = wc_get_product( absint( ! empty( $item->variation_id ) ? $item->variation_id : $item->product_id ) );
		$order = wc_get_order( $item->order_id );

		if ( ! $order ) {
			continue;
		}

		$user = $order->get_user();

		$activities[ $k ] = array(
			'timestamp'         => strtotime( $item->order_date ),
			'type'              => 'orders',
			'user_id'           => $user ? $user->ID : '',
			'user_email'        => $user ? $user->user_email : '',
			'user_name'         => $user ? $user->display_name : 'Guest',
			'user_avatar'       => get_avatar( $user ? $user->user_email : '' ),
			'user_url'          => $user ? get_author_posts_url( $user->ID ) :  '',
			'product_id'        => $product ? $product->get_id() : $item->product_id,
			'product_name'      => $product ? $product->get_name() : $item->product_name,
			'product_url'       => astoundify_wc_themes_vendors_get_dashboard_endpoint_url( 'vendor-view-order', $order->get_order_number() ),
			'product_thumbnail' => $product ? $product->get_image( 'thumbnail' ) : '', // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}

	return apply_filters( 'astoundify_wc_themes_vendors_activities_orders', $activities, $args, $orders );
}
