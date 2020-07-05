<?php
/**
 * Vendor Dashboard Products Functions
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Vendors
 * @author Astoundify
 */

/* === PRODUCTS COLUMNS === */

/**
 * Get Vendors Products Columns
 *
 * @since 1.0.0
 *
 * @return array
 */
function astoundify_wc_themes_vendors_get_dashboard_products_columns() {
	$columns = array(
		'product-thumb'       => esc_html__( 'Image', 'astoundify-wc-themes' ),
		'product-name'        => esc_html__( 'Name', 'astoundify-wc-themes' ),
		'product-sku'         => esc_html__( 'SKU', 'astoundify-wc-themes' ),
		'product-stock'       => esc_html__( 'Stock', 'astoundify-wc-themes' ),
		'product-price'       => esc_html__( 'Price', 'astoundify-wc-themes' ),
		'product-type'        => esc_html__( 'Type', 'astoundify-wc-themes' ),
		'actions'             => esc_html__( 'Actions', 'astoundify-wc-themes' ),
	);

	return apply_filters( 'astoundify_wc_themes_vendors_dashboard_products_columns', $columns );
}

/* === UTILITY === */

/**
 * Product Edit Link
 *
 * @since 1.0.0
 *
 * @param WC_Product $product Product Object/ID.
 * @return string|false
 */
function astoundify_wc_themes_vendors_get_edit_product_link( $product ) {
	$product = wc_get_product( $product );
	$edit_url = $product ? get_edit_post_link( $product->get_id() ) : false;
	return esc_url( apply_filters( 'astoundify_wc_themes_vendors_edit_product_link', $edit_url, $product ) );
}

/* === PRODUCTS COLUMNS OUTPUT/CALLBACK === */

/**
 * Product Thumbnail.
 *
 * @since 1.0.0
 *
 * @param WC_Product $product Product Object.
 */
function astoundify_wc_themes_vendors_dashboard_products_columns_product_thumb( $product ) {?>
	<a class="vendor-dashboard-column-thumbnail-link" href="<?php echo astoundify_wc_themes_vendors_get_edit_product_link( $product ); ?>">
		<?php echo $product->get_image( 'thumbnail' ); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</a>
<?php }
add_action( 'astoundify_wc_themes_vendors_products_column_product-thumb', 'astoundify_wc_themes_vendors_dashboard_products_columns_product_thumb' );

/**
 * Product Name.
 *
 * @since 1.0.0
 *
 * @param WC_Product $product Product Object.
 */
function astoundify_wc_themes_vendors_dashboard_products_columns_product_name( $product ) {
?>
	<a href="<?php echo esc_url( astoundify_wc_themes_vendors_get_edit_product_link( $product ) ); ?>">
		<?php echo $product->get_title(); ?>
	</a>
<?php
}
add_action( 'astoundify_wc_themes_vendors_products_column_product-name', 'astoundify_wc_themes_vendors_dashboard_products_columns_product_name' );

/**
 * Product SKU.
 *
 * @since 1.0.0
 *
 * @param object   $item Commision Item.
 * @param WC_Order $order Order Object.
 */
function astoundify_wc_themes_vendors_dashboard_products_columns_product_sku( $product ) {
?>
	<?php echo $product->get_sku(); ?>
<?php
}
add_action( 'astoundify_wc_themes_vendors_products_column_product-sku', 'astoundify_wc_themes_vendors_dashboard_products_columns_product_sku' );

/**
 * Product Stock.
 *
 * @since 1.0.0
 *
 * @param WC_Product $product Product Object.
 */
function astoundify_wc_themes_vendors_dashboard_products_columns_product_stock( $product ) {
	if ( $product->is_in_stock() ) {
		$stock_html = '<mark class="instock">' . __( 'In stock', 'astoundify-wc-themes' ) . '</mark>';
	} else {
		$stock_html = '<mark class="outofstock">' . __( 'Out of stock', 'astoundify-wc-themes' ) . '</mark>';
	}

	if ( $product->managing_stock() ) {
		$stock_html .= ' (' . wc_stock_amount( $product->get_stock_quantity() ) . ')';
	}

	echo $stock_html;
}
add_action( 'astoundify_wc_themes_vendors_products_column_product-stock', 'astoundify_wc_themes_vendors_dashboard_products_columns_product_stock' );

/**
 * Product Price.
 *
 * @since 1.0.0
 *
 * @param object   $item Commision Item.
 * @param WC_Order $order Order Object.
 */
function astoundify_wc_themes_vendors_dashboard_products_columns_product_price( $product ) {
	echo $product->get_price_html() ? $product->get_price_html() : '<span class="na">&ndash;</span>';
}
add_action( 'astoundify_wc_themes_vendors_products_column_product-price', 'astoundify_wc_themes_vendors_dashboard_products_columns_product_price' );

/**
 * Product Type.
 *
 * @since 1.0.0
 *
 * @param WC_Product $product Product Object.
 */
function astoundify_wc_themes_vendors_dashboard_products_columns_product_type( $product ) {
	$type = '';

	if ( $product->is_type( 'grouped' ) ) {
		$type = esc_attr__( 'Grouped', 'astoundify-wc-themes' );
	} elseif ( $product->is_type( 'external' ) ) {
		$type = esc_attr__( 'External/Affiliate', 'astoundify-wc-themes' );
	} elseif ( $product->is_type( 'simple' ) ) {

		if ( $product->is_virtual() ) {
			$type = esc_attr__( 'Virtual', 'astoundify-wc-themes' );
		} elseif ( $product->is_downloadable() ) {
			$type = esc_attr__( 'Downloadable', 'astoundify-wc-themes' );
		} else {
			$type = esc_attr__( 'Simple', 'astoundify-wc-themes' );
		}
	} elseif ( $product->is_type( 'variable' ) ) {
		$type = esc_attr__( 'Variable', 'astoundify-wc-themes' );
	} else {
		$type = esc_attr( sanitize_html_class( $product->get_type() ) );
	}

	echo $type;
}
add_action( 'astoundify_wc_themes_vendors_products_column_product-type', 'astoundify_wc_themes_vendors_dashboard_products_columns_product_type' );

/**
 * Product Actions.
 *
 * @since 1.0.0
 *
 * @param WC_Product $product Product Object.
 */
function astoundify_wc_themes_vendors_dashboard_products_columns_actions( $product ) {

	// Trash URL.
	$trash_url = astoundify_wc_themes_vendors_get_dashboard_endpoint_url( 'vendor-products' );
	$trash_url = add_query_arg( array(
		'action'     => 'trash',
		'product_id' => $product->get_id(),
		'_nonce'     => wp_create_nonce( 'vendors-product-actions' ),
	), $trash_url );

	// Actions.
	$actions = array(
		'view' => array(
			'text' => esc_html__( 'View', 'astoundify-wc-themes' ),
			'url'  => $product->get_permalink(),
		),
		'edit' => array(
			'text' => esc_html__( 'Edit', 'astoundify-wc-themes' ),
			'url'  => astoundify_wc_themes_vendors_get_edit_product_link( $product ),
		),
		'trash' => array(
			'text' => esc_html__( 'Trash', 'astoundify-wc-themes' ),
			'url'  => esc_url( $trash_url ),
		),
	);
	$actions = apply_filters( 'astoundify_wc_themes_vendors_dashboard_products_actions', $actions, $product );
?>

	<?php foreach ( $actions as $key => $action ) : ?>

		<?php echo '<a class="woocommerce-button button" href="' . esc_url( $action['url'] ) . '">' . $action['text'] . '</a>'; ?>

	<?php endforeach; ?>
<?php
}
add_action( 'astoundify_wc_themes_vendors_products_column_actions', 'astoundify_wc_themes_vendors_dashboard_products_columns_actions' );

/* === PROCESS PRODUCTS ACTIONS === */

/**
 * Process Trash Status
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_vendors_dashboard_products_process_trash_action() {
	// Check endpoint and request.
	if ( ! astoundify_wc_themes_vendors_is_dashboard( 'vendor-products' ) || ! isset( $_GET['action'], $_GET['_nonce'], $_GET['product_id'] ) || ! wp_verify_nonce( $_GET['_nonce'], 'vendors-product-actions' ) ) {
		return;
	}

	$product_ids = astoundify_wc_themes_vendors_get_draft_and_published_products();

	if ( ! in_array( $_GET['product_id'], $product_ids ) ) {
		wc_add_notice( esc_html__( 'Unable to delete product. Product not found.', 'astoundify-wc-themes' ), 'error' );
	} else {
		$trashed = wp_trash_post( $_GET['product_id'] );
		if ( $trashed ) {
			wc_add_notice( esc_html__( 'Product deleted.', 'astoundify-wc-themes' ), 'success' );
		} else {
			wc_add_notice( esc_html__( 'Unable to delete product.', 'astoundify-wc-themes' ), 'error' );
		}
	}

	// Redirect back for cleaner URL.
	$url = astoundify_wc_themes_vendors_get_dashboard_endpoint_url( 'vendor-products' );
	wp_safe_redirect( esc_url_raw( $url ) );
	exit;
}
add_action( 'template_redirect', 'astoundify_wc_themes_vendors_dashboard_products_process_trash_action' );
