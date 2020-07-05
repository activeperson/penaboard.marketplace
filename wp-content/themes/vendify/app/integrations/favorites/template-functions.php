<?php
/**
 * Favorites template.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify\Favorites;

use function \Astoundify\Vendify\svg as svg;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Look in our custom directory for a template.
 *
 * @since 1.0.0
 *
 * @param string $template      Template to load.
 * @param string $template_name Template file name.
 * @return string
 */
function get_template( $template, $template_name ) {
	$try = locate_template( [ 'app/integrations/favorites/views/' . $template_name . '.php' ], false, false );

	if ( $try ) {
		return $try;
	}

	return $template;
}

/**
 * Filter returned page templates.
 *
 * @since 1.0.0
 *
 * @param array $post_templates The current list of templates.
 * @return array
 */
function assign_page_templates( $templates ) {
	$add     = [];
	$page_id = astoundify_favorites_get_option( 'dashboard-page' );

	if ( $page_id && is_page( $page_id ) ) {
		$add[] = 'app/integrations/favorites/views/page-template.php';
	}

	if ( ! empty( $add ) ) {
		$templates = array_merge( $add, $templates );
	}

	return $templates;
}

/**
 * Allow favorites to be output on products.
 *
 * @since 1.0.0
 *
 * @param array $types Post types.
 * @return array
 */
function post_types( $types ) {
	$types[] = 'product';

	return $types;
};

/**
 * Modify favorites link text.
 *
 * @since 1.0.0
 *
 * @param string $text Default text.
 * @param int    $target_id Target ID.
 * @param bool   $is_favorited If the current target is favorited or not.
 * @param string $target_type Target type.
 * @return string
 */
function link_text( $text, $target_id, $is_favorited, $target_type ) {
	$classes = [ 'ico' ];

	ob_start();

	if ( 'post' === $target_type ) { ?>

<svg class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<use class="fav-heart" xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?php echo get_template_directory_uri(); ?>/public/images/icons.svg#heart<?php echo is_singular( 'product' ) ? esc_attr( '-outline' ) : null; ?>"></use>
	<use class="fav-heart-inner" xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?php echo get_template_directory_uri(); ?>/public/images/icons.svg#heart"></use>
</svg>

		<?php
	} else {
		svg(
			[
				'icon'    => 'plus',
				'classes' => [ 'ico--xs', 'mr-2' ],
			]
		);
	} ?>

<span>
	<?php
	if ( $is_favorited ) {
		esc_html_e( 'Favorited', 'vendify' );
	} else {
		esc_html_e( 'Favorite', 'vendify' );
	}
	?>
</span>

	<?php
	return ob_get_clean();
}

/**
 * Update link class types for vendors.
 *
 * @since 1.0.0
 *
 * @param array $atts Attributes
 * @return array
 */
function link_atts( $atts, $target_id, $target_type, $is_favorited, $count ) {
	if ( 'wcpv_product_vendors' === $target_type ) {
		$atts['class'] = $atts['class'] . ' btn btn-sm btn-outline-light';
	}

	return $atts;
}

/**
 * Output on product cards.
 *
 * @since 1.0.0
 *
 * @param $product WC_Product current product.
 */
function shop_loop_item_header( $product ) {
	echo astoundify_favorites_link( $product->get_id() );
}

/**
 * Add favorites to customer activity.
 *
 * @since 1.0.0
 *
 * @param array $activities Current activities.
 * @return array
 */
function activity( $activities ) {
	$activities['favorites'] = [];

	$favorites = astoundify_favorites_get_favorites(
		[
			'user_id'        => get_current_user_id(),
			'items_per_page' => 5,
		]
	);

	foreach ( $favorites as $favorite ) {
		$activities['favorites'][] = [
			'type'      => 'favorite',
			'icon'      => 'heart',
			'title'     => $favorite->get_target_title(),
			'link'      => $favorite->get_target_link(),
			'thumbnail' => 'post' == $favorite->get_target_type() ? wc_get_product( $favorite->get_target_id() )->get_image( 'thumbnail' ) : get_avatar( $favorite->get_target_id(), 150 ),
			'timestamp' => strtotime( $favorite->post->post_date ),
		];
	}

	return $activities;
}

/**
 * When the user is logged out and he tries to mark a product as favorite, we'll open the modal instead of
 * redirect him to dashboard.
 *
 * @param array $atts
 *
 * @return array $atts
 */
function fav_link_while_logged_out( $atts ) {

	if ( ! is_user_logged_in() ) {
		$atts['href'] = trailingslashit( wp_login_url() ) . '#sign-in';
	}

	return $atts;
}
