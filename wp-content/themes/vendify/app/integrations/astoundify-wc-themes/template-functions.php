<?php
/**
 * Astoundify WC Themes Template
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

use WC_Product_Vendors_Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Custom template loader definitions.
 *
 * @since 1.0.0
 *
 * @param string $template Current template.
 * @param string $template_name Template name.
 * @param string $template_path Template path.
 * @return string
 */
function astoundify_wc_themes_locate_template( $template, $template_name, $template_path ) {
	$try = locate_template( [ 'app/integrations/astoundify-wc-themes/views/' . $template_name ], false, false );

	if ( $try ) {
		return $try;
	}

	return $template;
}

/**
 * Remove frontend styles.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_enqueue_scripts() {
	wp_dequeue_style( 'astoundify-wc-themes-vendors-dashboard' );
}

/**
 * Add registered contact methods to admin area.
 *
 * @since 1.0.0
 *
 * @param array $methods Existing contact methods.
 * @return array $methods
 */
function astoundify_wc_themes_contact_methods( $methods ) {
	remove_filter( 'user_contactmethods', 'Astoundify\Vendify\astoundify_wc_themes_contact_methods' );
	$new = astoundify_wc_themes_get_additional_contact_methods();
	add_filter( 'user_contactmethods', 'Astoundify\Vendify\astoundify_wc_themes_contact_methods' );

	unset( $new['url'] );

	foreach ( $new as $method => $label ) {
		$methods[ $method ] = $label;
	}

	return $methods;
}

/**
 * Create new product URL. Defaults to using React editor.
 *
 * @since 1.0.0
 *
 * @return string
 */
function woocommerce_product_vendors_new_product_url() {
	return esc_url(
		apply_filters( 'vendify_woocommerce_product_vendors_new_product_url',
			add_query_arg(
				[
					'post_type' => 'product',
				],
				admin_url( 'post-new.php' )
			)
		)
	);
}

/**
 * Modify vendor dashboard chart styles based on color scheme.
 *
 * @since 1.0.0
 *
 * @param array $data Chart data.
 * @return array
 */
function astoundify_wc_themes_report_by_date_chart( $data ) {
	$light = astoundify_themecustomizer_get_colorscheme_mod( 'color-light' );

	$is_light = 1;

	if ( astoundify_hex_is_light( $light ) ) {
		$is_light = -1;
	}
	
	$gray100 = astoundify_themecustomizer_darken_hex($light, 5 * $is_light );
	$gray300 = astoundify_themecustomizer_darken_hex($light, 44 * $is_light );

	$data['datasets'][0]['backgroundColor']      = $gray100;
	$data['datasets'][0]['borderColor']          = $gray300;
	$data['datasets'][0]['pointBackgroundColor'] = '#ffffff';
	$data['datasets'][0]['pointBorderWidth']     = 2;

	return $data;
}

/**
 * Product actions for vendor dashboard.
 *
 * @since 1.0.0
 *
 * @param WC_Product $product Current product.
 */
function astoundify_wc_themes_vendors_dashboard_products_actions( $product ) {
	// Trash URL.
	$trash_url = astoundify_wc_themes_vendors_get_dashboard_endpoint_url( 'vendor-products' );
	$trash_url = add_query_arg(
		[
			'action'     => 'trash',
			'product_id' => $product->get_id(),
			'_nonce'     => wp_create_nonce( 'vendors-product-actions' ),
		],
		$trash_url
	);

	$actions = [
		'view'  => [
			'text' => esc_html__( 'View', 'vendify' ),
			'url'  => $product->get_permalink(),
			'icon' => 'view',
		],
		'edit'  => [
			'text' => esc_html__( 'Manage', 'vendify' ),
			'url'  => astoundify_wc_themes_vendors_get_edit_product_link( $product ),
			'icon' => 'edit',
		],
		'trash' => [
			'text' => esc_html__( 'Trash', 'vendify' ),
			'url'  => esc_url( $trash_url ),
			'icon' => 'delete',
		],
	];

	$actions = apply_filters( 'astoundify_wc_themes_vendors_dashboard_products_actions', $actions, $product );

	foreach ( $actions as $key => $action ) {
		$icon = get_svg(
			[
				'icon'    => $action['icon'],
				'classes' => [ 'ico--xs' ],
			]
		);

		echo '<a href="' . esc_url( $action['url'] ) . '" class="dropdown-item">' . $icon . $action['text'] . '</a>';
	}
}

/**
 * Adjust order table columns.
 *
 * @since 1.0.0
 *
 * @param array $columns
 * @return array
 */
function astoundify_wc_themes_vendors_dashboard_orders_columns( $columns ) {
	$columns = [
		'order-number'            => esc_html__( 'Order', 'vendify' ),
		'order-product-purchased' => esc_html__( 'Purchased', 'vendify' ),
		'order-date'              => esc_html__( 'Date', 'vendify' ),
		'commission-total'        => esc_html__( 'Earnings', 'vendify' ),
		'actions'                 => esc_html__( 'Actions', 'vendify' ),
	];

	return $columns;
}

/**
 * Order Number and general information.
 *
 * @since 1.0.0
 *
 * @param object   $item Commision Item.
 * @param WC_Order $order Order Object.
 */
function astoundify_wc_themes_vendors_dashboard_orders_columns_order_number( $item, $order ) {
	if ( ! is_a( $order, 'WC_Order' ) ) {
		return;
	}

	$product = wc_get_product( $item->product_id );

	if ( ! $product ) {
		return;
	}

	$url = astoundify_wc_themes_vendors_get_dashboard_endpoint_url( 'vendor-view-order', $order->get_order_number() );

	echo $product->get_image( 'thumbnail' ); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

	<div>
		<a href="<?php echo esc_url( $url ); ?>">
			<?php printf( esc_html__( 'Order #%d', 'vendify' ), $order->get_order_number() ); ?>
		</a>
		<span>
			<?php printf( esc_html__( 'By %s', 'vendify' ), $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() ); ?>
		</span>
	</div>
	<?php
}

/**
 * Get Orders Actions.
 *
 * @since 1.0.0
 *
 * @param object   $item Commision Item.
 * @param WC_Order $order Order Object.
 */
function wc_themes_vendors_orders_column_actions( $item, $order ) {
	if ( ! is_a( $order, 'WC_Order' ) ) {
		return;
	}

	// Status need to be set.
	$status = WC_Product_Vendors_Utils::get_fulfillment_status( $item->order_item_id );

	if ( ! $status ) {
		return;
	}

	// Current URL.
	$endpoint_orders     = get_query_var( 'vendor-orders' );
	$endpoint_view_order = get_query_var( 'vendor-view-order' );

	// In view order page.
	if ( get_query_var( 'vendor-view-order' ) ) {
		$id  = get_query_var( 'vendor-view-order' ) ? absint( get_query_var( 'vendor-view-order' ) ) : false;
		$url = astoundify_wc_themes_vendors_get_dashboard_endpoint_url( 'vendor-view-order', $id );
	} else { // In orders page.
		$page = get_query_var( 'vendor-orders' ) ? absint( get_query_var( 'vendor-orders' ) ) : false;
		$page = 1 < $page ? $page : false;
		$url  = astoundify_wc_themes_vendors_get_dashboard_endpoint_url( 'vendor-orders', $page );
	}

	// Add order ID.
	$url = add_query_arg( 'order_item_id', absint( $item->order_item_id ), $url );

	// Nonce.
	$url = add_query_arg( '_nonce', wp_create_nonce( 'vendors_actions' ), $url );

	// Action based on current fulfillment status.
	if ( 'fulfilled' === $status ) {
		$url = add_query_arg( 'action', 'unfulfilled', $url );

		$icon = get_svg(
			[
				'icon'    => 'processing',
				'classes' => [ 'ico--xs' ],
			]
		);

		$quickaction = '<a href="' . esc_url( $url ) . '" class="dropdown-item">' . $icon . esc_html__( 'Mark Unfulfilled', 'vendify' ) . '</a>';
	} elseif ( 'unfulfilled' === $status ) {
		$url = add_query_arg( 'action', 'fulfilled', $url );

		$icon = get_svg(
			[
				'icon'    => 'complete',
				'classes' => [ 'ico--xs' ],
			]
		);

		$quickaction = '<a href="' . esc_url( $url ) . '" class="dropdown-item">' . $icon . esc_html__( 'Mark Fulfilled', 'vendify' ) . '</a>';
	}

	$view = astoundify_wc_themes_vendors_get_dashboard_endpoint_url( 'vendor-view-order', $order->get_order_number() ); ?>

	<button class="sh-dropdown__toggle ml-auto mr-auto" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
		<?php svg( 'more' ); ?>
	</button>

	<div class="dropdown-menu dropdown-menu-right dropdown-menu--has-icons">
		<?php if ( ! get_query_var( 'vendor-view-order' ) ) { ?>
			<a href="<?php echo esc_url( $view ); ?>" class="dropdown-item">
				<?php
				svg(
					[
						'icon'    => 'view',
						'classes' => [ 'ico--xs' ],
					]
				);
				esc_html_e( 'View', 'vendify' ); ?>
			</a>
		<?php }

		echo $quickaction; ?>
	</div

	<?php
}

/**
 * Commission Status.
 *
 * @since 1.0.0
 *
 * @param object   $item Commision Item.
 * @param WC_Order $order Order Object.
 */
function wc_themes_vendors_dashboard_columns_order_commission_status( $item, $order ) {
	if ( ! is_a( $order, 'WC_Order' ) ) {
		return;
	}

	$status = esc_html__( 'N/A', 'vendify' );

	if ( 'unpaid' === $item->commission_status ) {
		$status = '<span class="badge badge-outline-warning">' . esc_html__( 'Unpaid', 'vendify' ) . '</span>';
	}

	if ( 'paid' === $item->commission_status ) {
		$status = '<span class="badge badge-success">' . esc_html__( 'Paid', 'vendify' ) . '</span>';
	}

	if ( 'void' === $item->commission_status ) {
		$status = '<span class="badge badge-outline">' . esc_html__( 'Void', 'vendify' ) . '</span>';
	}

	echo $status; // WPCS: XSS ok.
}

/**
 * Commission Fulfillment Status
 *
 * @since 1.0.0
 *
 * @param object   $item Commision Item.
 * @param WC_Order $order Order Object.
 */
function astoundify_wc_themes_vendors_dashboard_orders_columns_order_commission_fulfillment_status( $item, $order ) {
	if ( ! is_a( $order, 'WC_Order' ) ) {
		return;
	}

	$status  = WC_Product_Vendors_Utils::get_fulfillment_status( $item->order_item_id );
	$product = wc_get_product( $item->product_id );

	if ( $status && 'unfulfilled' === $status ) {
		$status = '<span class="badge badge--unfulfilled">' . esc_html__( 'Unfulfilled', 'vendify' ) . '</span>';
	} elseif ( $status && 'fulfilled' === $status ) {
		$status = '<span class="badge badge--completed">' . esc_html__( 'Fulfilled', 'vendify' ) . '</span>';
	} else {
		$status = esc_html__( 'N/A', 'vendify' );
	}

	if ( is_object( $product ) && ( $product->is_virtual() || $product->is_downloadable() ) ) {
		$status = esc_html__( 'N/A', 'vendify' );
	}

	echo $status; // WPCS: XSS ok.
}
