<?php
/**
 * Astoundify Favorites Dashboard Activity Functions
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Vendors
 * @author Astoundify
 */

/**
 * Add Favorites Activity.
 *
 * @since 1.0.0
 *
 * @param array $activities Activities list.
 * @param array $args       Activities args.
 * @return array
 */
function astoundify_wc_themes_vendors_favorites_add_activities( $activities, $args ) {
	$activities['favorites'] = array(
		'label'      => esc_html__( 'Favorites', 'astoundify-wc-themes' ),
		'activities' => astoundify_wc_themes_vendors_favorites_get_activities( $args ),
	);

	return $activities;
}
add_filter( 'astoundify_wc_themes_vendors_activities_by_group', 'astoundify_wc_themes_vendors_favorites_add_activities', 10, 2 );

/**
 * Add Favorite Activity Content Template.
 *
 * @since 1.0.0
 *
 * @param string $content  Activity content.
 * @param array  $activity Activity data.
 * @return array
 */
function astoundify_wc_themes_vendors_favorites_add_activity_content( $content, $activity ) {
	if ( 'favorites' === $activity['type'] ) {
		ob_start();
		astoundify_wc_themes_get_template( 'vendor-dashboard/activity/favorite.php', $activity );
		$content = ob_get_clean();
	}

	return $content;
}
add_filter( 'astoundify_wc_themes_vendors_activity_content', 'astoundify_wc_themes_vendors_favorites_add_activity_content', 10, 2 );

/**
 * Dashboard Latest Favorites to Activities.
 *
 * @since 1.0.0
 *
 * @param array $args Activities Orders Args.
 * @return array
 */
function astoundify_wc_themes_vendors_favorites_get_activities( $args = array() ) {
	$defaults = array(
		'limit'     => 10,
		'vendor_id' => WC_Product_Vendors_Utils::get_logged_in_vendor(),
	);

	$args = wp_parse_args( $args, $defaults );

	// Output.
	$activities = array();

	// Products.
	$products = WC_Product_Vendors_Utils::get_vendor_product_ids( $args['vendor_id'] );

	// Favorite activity for Products.
	if ( $products ) {

		$favorites = astoundify_favorites_get_favorites( array(
			'user_id'       => false,
			'target_id'     => $products,
			'target_type'   => 'post',
			'item_per_page' => absint( $args['limit'] ),
		) );

		// Add to activities.
		foreach ( $favorites as $k => $favorite ) {
			$product = wc_get_product( absint( $favorite->get_target_id() ) );
			$user = $favorite->get_author();

			$activities[ $k ] = array(
				'timestamp'         => strtotime( $favorite->post->post_date ),
				'type'              => 'favorites',
				'user_id'           => $user ? $user->ID : '',
				'user_email'        => $user ? $user->user_email : '',
				'user_name'         => $user ? $user->display_name : 'Guest',
				'user_avatar'       => get_avatar( $user ? $user->user_email : '' ),
				'user_url'          => $user ? get_author_posts_url( $user->ID ) :  '',
				'product_id'        => $product ? $product->get_id() : $item->product_id,
				'product_name'      => $product ? $product->get_name() : $item->product_name,
				'product_url'       => $product->get_permalink(),
				'product_thumbnail' => $product ? $product->get_image( 'thumbnail' ) : '', // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			);
		}
	}

	// Vendor/Shop.
	$favorites = astoundify_favorites_get_favorites( array(
		'user_id'       => false,
		'target_id'     => $args['vendor_id'],
		'target_type'   => 'wcpv_product_vendors',
		'item_per_page' => absint( $args['limit'] ),
	) );

	// Add to activities.
	foreach ( $favorites as $k => $favorite ) {
		$vendor = $favorite->get_target();
		$user = $favorite->get_author();

		$activities[ $k ] = array(
			'timestamp'         => strtotime( $favorite->post->post_date ),
			'type'              => 'favorites',
			'user_id'           => $user ? $user->ID : '',
			'user_email'        => $user ? $user->user_email : '',
			'user_name'         => $user ? $user->display_name : 'Guest',
			'user_avatar'       => get_avatar( $user ? $user->user_email : '' ),
			'user_url'          => $user ? get_author_posts_url( $user->ID ) :  '',
			'product_id'        => $vendor ? $vendor->get_id() : '',
			'product_name'      => esc_html__( 'Your Shop', 'astoundify-wc-themes' ),
			'product_url'       => $vendor->get_permalink(),
			'product_thumbnail' => '',
		);
	}


	return apply_filters( 'astoundify_wc_themes_vendors_activities_favorites', $activities, $args, $favorites );
}
