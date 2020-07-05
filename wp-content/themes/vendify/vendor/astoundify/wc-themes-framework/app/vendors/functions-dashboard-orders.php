<?php
/**
 * Vendor Dashboard Orders Functions
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Vendors
 * @author Astoundify
 */

/* === ORDERS COLUMNS === */

/**
 * Get Vendors Orders Columns
 *
 * @since 1.0.0
 *
 * @return array
 */
function astoundify_wc_themes_vendors_get_dashboard_orders_columns() {
	$columns = array(
		'order-number'                  => esc_html__( 'Order', 'astoundify-wc-themes' ),
		'order-status'                  => esc_html__( 'Status', 'astoundify-wc-themes' ),
		'order-date'                    => esc_html__( 'Date', 'astoundify-wc-themes' ),
		'order-shipping'                => esc_html__( 'Shipping', 'astoundify-wc-themes' ),
		'order-product-purchased'       => esc_html__( 'Purchased', 'astoundify-wc-themes' ),
		'commission-total'              => esc_html__( 'Commision', 'astoundify-wc-themes' ),
		'commission-status'             => esc_html__( 'Status', 'astoundify-wc-themes' ),
		'commission-paid-date'          => esc_html__( 'Paid Date', 'astoundify-wc-themes' ),
		'commission-fulfillment-status' => esc_html__( 'Fulfillment', 'astoundify-wc-themes' ),
		'actions'                       => esc_html__( 'Actions', 'astoundify-wc-themes' ),
	);

	return apply_filters( 'astoundify_wc_themes_vendors_dashboard_orders_columns', $columns );
}

/**
 * Get Order Items Columns
 *
 * @since 1.0.0
 *
 * @return array
 */
function astoundify_wc_themes_vendors_get_dashboard_order_items_columns() {
	$columns = array(
		'order-product'                 => esc_html__( 'Product', 'astoundify-wc-themes' ),
		'commission-total'              => esc_html__( 'Commision', 'astoundify-wc-themes' ),
		'commission-status'             => esc_html__( 'Status', 'astoundify-wc-themes' ),
		'commission-paid-date'          => esc_html__( 'Paid Date', 'astoundify-wc-themes' ),
		'commission-fulfillment-status' => esc_html__( 'Fulfillment', 'astoundify-wc-themes' ),
		'actions'                       => esc_html__( 'Actions', 'astoundify-wc-themes' ),
	);

	return apply_filters( 'astoundify_wc_themes_vendors_dashboard_order_items_columns', $columns );
}

/* === UTILITY === */

/**
 * Check if order can be accessed by current user.
 *
 * @since 1.0.0
 *
 * @param int $order_id Order ID.
 * @param int $user_id  User ID.
 * @return bool
 */
function astoundify_wc_themes_vendors_can_user_access_order( $order_id, $user_id = null ) {
	// If param not passed use current user.
	if ( null === $user_id ) {
		$user_id = get_current_user_id();
	}

	// Get order.
	$order = wc_get_order( $order_id );

	// Not found.
	if ( ! $order || ! is_a( $order, 'WC_Order' ) ) {
		return false;
	}

	// Check if current user is vendor admin or manager.
	if ( ! ( WC_Product_Vendors_Utils::is_admin_vendor() || WC_Product_Vendors_Utils::is_manager_vendor() ) ) {
		return false;
	}

	$vendors_from_order = WC_Product_Vendors_Utils::get_vendors_from_order( $order );

	// Check if vendor have access to order page.
	if ( ! in_array( WC_Product_Vendors_Utils::get_user_active_vendor(), array_keys( $vendors_from_order ), true ) ) {
		return false;
	}

	return true;
}

/**
 * Set Order Fullfilment Status
 *
 * @since 1.0.0
 *
 * @param int    $order_item_id Order Item ID.
 * @param string $status        Status to set. Default to "unfulfilled".
 * @return bool
 */
function astoundify_wc_themes_vendors_set_order_fulfillment_status( $order_item_id, $status = 'unfulfilled' ) {
	// Bail if invalid.
	if ( ! in_array( $status, array( 'unfulfilled', 'fulfilled' ), true ) ) {
		return false;
	}

	return wc_update_order_item_meta( $order_item_id, '_fulfillment_status', $status );
}

/* === COLUMNS OUTPUT/CALLBACK === */

/**
 * Order Number (ID).
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
	$url = astoundify_wc_themes_vendors_get_dashboard_endpoint_url( 'vendor-view-order', $order->get_order_number() );
?>
	<a href="<?php echo esc_url( $url ); ?>">
		<?php echo esc_html_x( '#', 'hash before order number', 'astoundify-wc-themes' ) . $order->get_order_number(); // WPCS: XSS ok. ?>
	</a>
<?php
}
add_action( 'astoundify_wc_themes_vendors_orders_column_order-number', 'astoundify_wc_themes_vendors_dashboard_orders_columns_order_number', 10, 2 );

/**
 * Order Status.
 *
 * @since 1.0.0
 *
 * @param object   $item Commision Item.
 * @param WC_Order $order Order Object.
 */
function astoundify_wc_themes_vendors_dashboard_orders_columns_order_status( $item, $order ) {
	if ( ! is_a( $order, 'WC_Order' ) ) {
		return;
	}
	echo esc_html( wc_get_order_status_name( $order->get_status() ) );
}
add_action( 'astoundify_wc_themes_vendors_orders_column_order-status', 'astoundify_wc_themes_vendors_dashboard_orders_columns_order_status', 10, 2 );

/**
 * Order Date.
 *
 * @since 1.0.0
 *
 * @param object   $item Commision Item.
 * @param WC_Order $order Order Object.
 */
function astoundify_wc_themes_vendors_dashboard_orders_columns_order_date( $item, $order ) {
	if ( ! is_a( $order, 'WC_Order' ) ) {
		return;
	}
?>
	<time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>
<?php
}
add_action( 'astoundify_wc_themes_vendors_orders_column_order-date', 'astoundify_wc_themes_vendors_dashboard_orders_columns_order_date', 10, 2 );

/**
 * Order Shipping.
 *
 * @since 1.0.0
 *
 * @param object   $item Commision Item.
 * @param WC_Order $order Order Object.
 */
function astoundify_wc_themes_vendors_dashboard_orders_columns_order_shipping( $item, $order ) {
	if ( ! is_a( $order, 'WC_Order' ) ) {
		return;
	}
	$address      = $order->get_address( 'shipping' );
	$show_address = false;

	foreach ( $address as $line => $value ) {
		if ( ! empty( $value ) ) {
			$show_address = true;
		}
	}

	if ( $show_address ) {
		echo implode( ' ', $address ); // WPCS: XSS ok.

		if ( $order->get_shipping_method() ) {
			// Translators: %s is shipping method.
			echo '<br /><small class="wcpv-shipping-method">' . sprintf( esc_html__( 'Via %s', 'astoundify-wc-themes' ), $order->get_shipping_method() ) . '</small>'; // WPCS: XSS ok.
		}
	}
}
add_action( 'astoundify_wc_themes_vendors_orders_column_order-shipping', 'astoundify_wc_themes_vendors_dashboard_orders_columns_order_shipping', 10, 2 );

/**
 * Order Product Purchased (Total Quantity).
 *
 * @since 1.0.0
 *
 * @param object   $item Commision Item.
 * @param WC_Order $order Order Object.
 */
function astoundify_wc_themes_vendors_dashboard_orders_columns_order_product_purchased( $item, $order ) {
	if ( ! is_a( $order, 'WC_Order' ) ) {
		return;
	}

	// Translators: %s is item quantity.
	echo esc_attr( sprintf( _n( '%s item', '%s items', absint( $item->product_quantity ), 'astoundify-wc-themes' ), number_format_i18n( $item->product_quantity ) ) );
}
add_action( 'astoundify_wc_themes_vendors_orders_column_order-product-purchased', 'astoundify_wc_themes_vendors_dashboard_orders_columns_order_product_purchased', 10, 2 );

/**
 * Order Product Purchased (Total Quantity).
 *
 * @since 1.0.0
 *
 * @param object   $item Commision Item.
 * @param WC_Order $order Order Object.
 */
function astoundify_wc_themes_vendors_dashboard_orders_columns_order_product( $item, $order ) {
	if ( ! is_a( $order, 'WC_Order' ) ) {
		return;
	}
	$quantity       = absint( $item->product_quantity );
	$var_attributes = '';
	$sku            = '';

	// Check if product is a variable product.
	if ( ! empty( $item->variation_id ) ) {
		$product = wc_get_product( absint( $item->variation_id ) );
	} else {
		$product = wc_get_product( absint( $item->product_id ) );
	}

	echo $quantity . 'x ' . sanitize_text_field( $product->get_name() ); // WPCS: XSS ok.
}

add_action( 'astoundify_wc_themes_vendors_orders_column_order-product', 'astoundify_wc_themes_vendors_dashboard_orders_columns_order_product', 10, 2 );

/**
 * Total Commission.
 *
 * @since 1.0.0
 *
 * @param object   $item Commision Item.
 * @param WC_Order $order Order Object.
 */
function astoundify_wc_themes_vendors_dashboard_orders_columns_order_commission_total( $item, $order ) {
	if ( ! is_a( $order, 'WC_Order' ) ) {
		return;
	}

	echo wc_price( sanitize_text_field( $item->total_commission_amount ) ); // WPCS: XSS ok.
}
add_action( 'astoundify_wc_themes_vendors_orders_column_commission-total', 'astoundify_wc_themes_vendors_dashboard_orders_columns_order_commission_total', 10, 2 );

/**
 * Commission Status.
 *
 * @since 1.0.0
 *
 * @param object   $item Commision Item.
 * @param WC_Order $order Order Object.
 */
function astoundify_wc_themes_vendors_dashboard_columns_order_commission_status( $item, $order ) {
	if ( ! is_a( $order, 'WC_Order' ) ) {
		return;
	}

	$status = esc_html__( 'N/A', 'astoundify-wc-themes' );

	if ( 'unpaid' === $item->commission_status ) {
		$status = '<span class="wcpv-unpaid-status">' . esc_html__( 'UNPAID', 'astoundify-wc-themes' ) . '</span>';
	}
	if ( 'paid' === $item->commission_status ) {
		$status = '<span class="wcpv-paid-status">' . esc_html__( 'PAID', 'astoundify-wc-themes' ) . '</span>';
	}
	if ( 'void' === $item->commission_status ) {
		$status = '<span class="wcpv-void-status">' . esc_html__( 'VOID', 'astoundify-wc-themes' ) . '</span>';
	}

	echo $status; // WPCS: XSS ok.
}
add_action( 'astoundify_wc_themes_vendors_orders_column_commission-status', 'astoundify_wc_themes_vendors_dashboard_columns_order_commission_status', 10, 2 );

/**
 * Commission Paid Date
 *
 * @since 1.0.0
 *
 * @param object   $item Commision Item.
 * @param WC_Order $order Order Object.
 */
function astoundify_wc_themes_vendors_dashboard_orders_columns_order_commission_paid_date( $item, $order ) {
	if ( ! is_a( $order, 'WC_Order' ) ) {
		return;
	}

	$vendor_data = WC_Product_Vendors_Utils::get_vendor_data_from_user();
	$timezone = ! empty( $vendor_data['timezone'] ) ? sanitize_text_field( $vendor_data['timezone'] ) : '';

	$date = WC_Product_Vendors_Utils::format_date( sanitize_text_field( $item->paid_date ), $timezone );

	echo '0000-00-00 00:00:00' === $date ? '' : $date; // WPCS: XSS ok.
}
add_action( 'astoundify_wc_themes_vendors_orders_column_commission-paid-date', 'astoundify_wc_themes_vendors_dashboard_orders_columns_order_commission_paid_date', 10, 2 );

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
	$status = WC_Product_Vendors_Utils::get_fulfillment_status( $item->order_item_id );
	$product = wc_get_product( $item->product_id );

	if ( is_object( $product ) && ( $product->is_virtual() || $product->is_downloadable() ) ) {
		return esc_html__( 'N/A', 'astoundify-wc-themes' );
	}

	if ( $status && 'unfulfilled' === $status ) {
		$status = '<span class="wcpv-unfulfilled-status">' . esc_html__( 'Unfulfilled', 'astoundify-wc-themes' ) . '</span>';

	} elseif ( $status && 'fulfilled' === $status ) {
		$status = '<span class="wcpv-fulfilled-status">' . esc_html__( 'Fulfilled', 'astoundify-wc-themes' ) . '</span>';

	} else {
		$status = esc_html__( 'N/A', 'astoundify-wc-themes' );
	}

	echo $status; // WPCS: XSS ok.
}
add_action( 'astoundify_wc_themes_vendors_orders_column_commission-fulfillment-status', 'astoundify_wc_themes_vendors_dashboard_orders_columns_order_commission_fulfillment_status', 10, 2 );

/**
 * Get Orders Actions.
 *
 * @since 1.0.0
 *
 * @param object   $item Commision Item.
 * @param WC_Order $order Order Object.
 */
function astoundify_wc_themes_vendors_dashboard_orders_columns_order_actions( $item, $order ) {
	if ( ! is_a( $order, 'WC_Order' ) ) {
		return;
	}

	// Status need to be set.
	$status = WC_Product_Vendors_Utils::get_fulfillment_status( $item->order_item_id );
	if ( ! $status ) {
		return;
	}

	// Current URL.
	$endpoint_orders = get_query_var( 'vendor-orders' );
	$endpoint_view_order = get_query_var( 'vendor-view-order' );

	// In view order page.
	if ( get_query_var( 'vendor-view-order' ) ) {
		$id = get_query_var( 'vendor-view-order' ) ? absint( get_query_var( 'vendor-view-order' ) ) : false;
		$url = astoundify_wc_themes_vendors_get_dashboard_endpoint_url( 'vendor-view-order', $id );
	} else { // In orders page.
		$page = get_query_var( 'vendor-orders' ) ? absint( get_query_var( 'vendor-orders' ) ) : false;
		$page = 1 < $page ? $page : false;
		$url = astoundify_wc_themes_vendors_get_dashboard_endpoint_url( 'vendor-orders', $page );
	}

	// Add order ID.
	$url = add_query_arg( 'order_item_id', absint( $item->order_item_id ), $url );

	// Nonce.
	$url = add_query_arg( '_nonce', wp_create_nonce( 'vendors_actions' ), $url );

	// Action based on current fulfillment status.
	if ( 'fulfilled' === $status ) {
		$url = add_query_arg( 'action', 'unfulfilled', $url );
		echo '<a href="' . esc_url( $url ) . '" class="woocommerce-button button mark-unfullfilled">' . esc_html__( 'Mark Unfulfilled', 'astoundify-wc-themes' ) . '</a>';
	} elseif ( 'unfulfilled' === $status ) {
		$url = add_query_arg( 'action', 'fulfilled', $url );
		echo '<a href="' . esc_url( $url ) . '" class="woocommerce-button button mark-fulfilled">' . esc_html__( 'Mark Fulfilled', 'astoundify-wc-themes' ) . '</a>';
	}
}
add_action( 'astoundify_wc_themes_vendors_orders_column_actions', 'astoundify_wc_themes_vendors_dashboard_orders_columns_order_actions', 10, 2 );

/* === PROCESS DASHBOARD ACTIONS === */

/**
 * Process Fulfillment Status
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_vendors_dashboard_orders_process_fulfillment_status() {
	// @codingStandardsIgnoreStart
	if ( ! isset( $_GET['order_item_id'], $_GET['action'], $_GET['_nonce'] ) || ! wp_verify_nonce( $_GET['_nonce'], 'vendors_actions' ) ) {
		return;
	}

	// On view order page.
	if ( get_query_var( 'vendor-view-order' ) ) {
		$id = get_query_var( 'vendor-view-order' ) ? absint( get_query_var( 'vendor-view-order' ) ) : false;
		$url = astoundify_wc_themes_vendors_get_dashboard_endpoint_url( 'vendor-view-order', $id );
	} else { // On orders page.
		$page = get_query_var( 'vendor-orders' ) ? absint( get_query_var( 'vendor-orders' ) ) : false;
		$page = 1 < $page ? $page : false;
		$url = astoundify_wc_themes_vendors_get_dashboard_endpoint_url( 'vendor-orders', $page );
	}

	$order_item_id = absint( $_GET['order_item_id'] );
	$action = esc_attr( $_GET['action'] );
	// @codingStandardsIgnoreEnd

	$item = WC_Order_Factory::get_order_item( $order_item_id );

	// Bail if user do not have access.
	if ( ! astoundify_wc_themes_vendors_can_user_access_order( $item->get_order_id() ) ) {
		wc_add_notice( esc_html__( 'You do not have permission to update this order.', 'astoundify-wc-themes' ), 'error' );

		wp_safe_redirect( esc_url_raw( $url ) );
		exit;
	}

	// Change the fulfillment status.
	$set_status = astoundify_wc_themes_vendors_set_order_fulfillment_status( $order_item_id, $action );

	// Add Notice.
	if ( $set_status ) {
		wc_add_notice( esc_html__( 'Order fulfillment status updated.', 'astoundify-wc-themes' ), 'success' );
	} else {
		wc_add_notice( esc_html__( 'Sorry there was a problem updating order fulfillment status.', 'astoundify-wc-themes' ), 'error' );
	}

	// Redirect back for cleaner URL.
	wp_safe_redirect( esc_url_raw( $url ) );
	exit;
}
add_action( 'template_redirect', 'astoundify_wc_themes_vendors_dashboard_orders_process_fulfillment_status' );


/**
 * Process Fulfillment Status
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_vendors_dashboard_orders_process_add_note() {
	// Get current order in view order endpoint.
	$order_id = get_query_var( 'vendor-view-order' );

	// If add note form is submitted.
	// @codingStandardsIgnoreStart
	if ( ! $order_id || ! isset( $_POST['order_note'], $_POST['order_note_type'], $_POST['_nonce'] ) || ! wp_verify_nonce( $_POST['_nonce'], 'vendors-order-add-note' ) ) {
		return;
	}
	// @codingStandardsIgnoreEnd

	// Do not process if note empty.
	if ( ! trim( $_POST['order_note'] ) || ! $_POST['order_note_type'] ) {
		wc_add_notice( esc_html__( 'You cannot create empty note.', 'astoundify-wc-themes' ), 'error' );
		wp_safe_redirect( esc_url_raw( astoundify_wc_themes_vendors_get_dashboard_endpoint_url( 'vendor-view-order', $order_id ) ) );
		exit;
	}

	// Get order.
	$order = wc_get_order( $order_id );

	if ( ! astoundify_wc_themes_vendors_can_user_access_order( $order_id ) ) {
		return;
	}

	// In WC non admin cannot add note, but as vendors, we need to force enable it.
	$note_filter = function( $args ) {
		$user = get_user_by( 'id', get_current_user_id() );
		$args['comment_author'] = $user->display_name;
		$args['comment_author_email'] = $user->user_email;
		return $args;
	};
	add_filter( 'woocommerce_new_order_note_data', $note_filter );

	// Add order note. wp_insert_comment() will eventually sanitize this.
	// @codingStandardsIgnoreStart
	$add_note = $order->add_order_note(
		$note             = wp_kses_post( $_POST['order_note'] ),
		$is_customer_note = $_POST['order_note_type'] === 'customer',
		$added_by_user    = true
	);
	// @codingStandardsIgnoreEnd

	// Add Notice.
	if ( $add_note ) {
		wc_add_notice( esc_html__( 'Note added.', 'astoundify-wc-themes' ), 'success' );
	} else {
		wc_add_notice( esc_html__( 'Sorry there was a problem adding note.', 'astoundify-wc-themes' ), 'error' );
	}

	// Remove the filter.
	remove_filter( 'woocommerce_new_order_note_data', $note_filter );

	// Redirect back to page. This is needed, so the form will not be re-posted on refresh.
	wp_safe_redirect( esc_url_raw( astoundify_wc_themes_vendors_get_dashboard_endpoint_url( 'vendor-view-order', $order_id ) ) );
	exit;
}
add_action( 'template_redirect', 'astoundify_wc_themes_vendors_dashboard_orders_process_add_note' );
