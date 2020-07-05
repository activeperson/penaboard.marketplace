<?php
/**
 * Vendor Dashboard Functions
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Vendors
 * @author Astoundify
 */

/**
 * Redirect WooCommerce user logins that have a "Vendor Admin" role
 * to the vendor dashboard.
 *
 * @since 1.0.0
 *
 * @param string  $url URL to redirect to.
 * @param WP_User $user Logged in user.
 * @return string
 */
function astoundify_wc_themes_vendor_login_redirect( $url, $user ) {
	$dashboard = wc_get_page_permalink( 'astoundify_wc_themes_vendors_dashboard' );

	if ( ! $dashboard ) {
		return $url;
	}

	if ( in_array( 'wc_product_vendors_admin_vendor', (array) $user->roles, true ) ) {
		return $dashboard;
	}

	return $url;
}
add_filter( 'woocommerce_login_redirect', 'astoundify_wc_themes_vendor_login_redirect', 10, 2 );

/**
 * Set Dashboard Page ID
 *
 * So we can use WooCommerce function to get page ID and URL.
 * `wc_get_page_id( 'astoundify_wc_themes_vendors_dashboard' );`
 * `wc_get_page_permalink( 'astoundify_wc_themes_vendors_dashboard' );`
 *
 * @since 1.0.0
 *
 * @param int $page_id Vendor dashboard page ID.
 * @return int|null
 */
function astoundify_wc_themes_vendors_set_dashboard_page_id( $page_id ) {
	return get_option( 'astoundify_wc_themes_vendors_dashboard_page_id', '' );
}
add_filter( 'woocommerce_get_astoundify_wc_themes_vendors_dashboard_page_id', 'astoundify_wc_themes_vendors_set_dashboard_page_id' );

/**
 * Is Dashboard Page
 *
 * @since 1.0.0
 *
 * @param string $endpoint Dashboard endpoint.
 * @return bool
 */
function astoundify_wc_themes_vendors_is_dashboard( $endpoint = '' ) {
	$page_id = wc_get_page_id( 'astoundify_wc_themes_vendors_dashboard' );

	if ( 0 > $page_id || ! is_page( $page_id ) ) {
		return false;
	}

	if ( $endpoint ) {
		$current = WC()->query->get_current_endpoint();
		$current = $current ? $current : 'vendor-dashboard';

		return $current === $endpoint;
	}

	return true;
}

/**
 * Is Dashboard Registration Enabled
 *
 * @since 1.0.0
 *
 * @return bool
 */
function astoundify_wc_themes_vendors_dashboard_registration_enabled() {
	return 'yes' === get_option( 'astoundify_wc_themes_vendors_dashboard_enable_registration', 'yes' );
}

/**
 * Enqueue Script
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_vendors_scripts() {

	// Dashboard Script.
	if ( astoundify_wc_themes_vendors_is_dashboard() ) {

		// Script Vars.
		$debug = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? true : false;

		$version = $debug ? time() : ASTOUNDIFY_WC_THEMES_VERSION;

		/* === CSS === */

		$deps = array();
		$url = ASTOUNDIFY_WC_THEMES_URL . 'public/assets/css/vendor-dashboard.min.css';
		if ( $debug ) {
			$deps[] = 'astoundify-wc-themes-date-picker' ;
			$url = ASTOUNDIFY_WC_THEMES_URL . 'resources/assets/css/vendor-dashboard.css';
		}
		wp_enqueue_style( 'astoundify-wc-themes-vendors-dashboard', $url, $deps, $version );

		/* === JS === */

		if ( function_exists( 'gutenberg_extend_wp_api_backbone_client' ) ) {
			gutenberg_extend_wp_api_backbone_client();
		}

		// Always Enqueue Media JS in Dashboard.
		wp_enqueue_media();

		// Enqueue dashboard script.
		$deps = array( 'wp-api', 'wp-backbone' );

		$url = ASTOUNDIFY_WC_THEMES_URL . 'public/assets/js/vendor-dashboard.min.js';

		if ( $debug ) {
			$url = ASTOUNDIFY_WC_THEMES_URL . 'resources/assets/js/vendor-dashboard.js';
		}

		wp_enqueue_script( 'astoundify-wc-themes-vendors-dashboard', $url, $deps, $version );

		wp_localize_script( 'astoundify-wc-themes-vendors-dashboard', 'astoundifyWcThemesVendorsDashboard', array(
			'i18n' => array(),
		) );

		// Register Overview Section Script. Enqueued in template.
		$url = ASTOUNDIFY_WC_THEMES_URL . 'public/assets/js/vendor-dashboard-overview.min.js';

		if ( $debug ) {
			$url = ASTOUNDIFY_WC_THEMES_URL . 'resources/assets/js/vendor-dashboard-overview.js';
		}

		wp_register_script( 'astoundify-wc-themes-vendors-dashboard-overview', $url, array( 'astoundify-wc-themes-vendors-dashboard' ), $version );

		// Register Report by Date Section Script. Enqueued in template.
		$url = ASTOUNDIFY_WC_THEMES_URL . 'public/assets/js/vendor-dashboard-report-by-date.min.js';

		if ( $debug ) {
			$url = ASTOUNDIFY_WC_THEMES_URL . 'resources/assets/js/vendor-dashboard-report-by-date.js';
		}

		wp_register_script( 'astoundify-wc-themes-vendors-dashboard-report-by-date', $url, array( 'astoundify-wc-themes-vendors-dashboard', 'moment', 'chartjs', 'jquery-ui-datepicker' ), $version );
	}// End if().
}
add_action( 'wp_enqueue_scripts', 'astoundify_wc_themes_vendors_scripts' );

/**
 * Dashboard Endpoints.
 *
 * Need to be separate functions, because WC didn't apply filters on rewrite.
 *
 * @since 1.0.0
 *
 * @return array
 */
function astoundify_wc_themes_vendors_endpoints() {
	$endpoints = array(
		'vendor-orders'         => get_option( 'astoundify_wc_themes_vendors_dashboard_orders_endpoints', 'vendor-orders' ),
		'vendor-view-order'     => get_option( 'astoundify_wc_themes_vendors_dashboard_view_order_endpoints', 'vendor-view-order' ),
		'vendor-products'       => get_option( 'astoundify_wc_themes_vendors_dashboard_view_products_endpoints', 'vendor-products' ),
		'vendor-store-settings' => get_option( 'astoundify_wc_themes_vendors_dashboard_view_store_settings_endpoints', 'vendor-store-settings' ),
	);
	return apply_filters( 'astoundify_wc_themes_vendors_endpoints', $endpoints );
}

/**
 * Add WooCommerce Endpoints.
 *
 * @since 1.0.0
 *
 * @param array $vars Query Vars.
 * @return array
 */
function astoundify_wc_themes_vendors_dashboard_add_wc_endpoints( $vars ) {
	return $vars + astoundify_wc_themes_vendors_endpoints();
}
add_filter( 'woocommerce_get_query_vars', 'astoundify_wc_themes_vendors_dashboard_add_wc_endpoints' );

/**
 * Add Rewrite Endpoints.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_vendors_dashboard_add_rewrite_endpoints() {
	$endpoints = astoundify_wc_themes_vendors_endpoints();

	foreach ( $endpoints as $key => $var ) {
		add_rewrite_endpoint( $var, EP_PAGES );
	}
}
add_action( 'init', 'astoundify_wc_themes_vendors_dashboard_add_rewrite_endpoints' );

/**
 * Add WooCommerce Body Class on Vendor Dashboard Page
 *
 * @since 1.0.0
 *
 * @param array $classes Body Classes.
 * @return array
 */
function astoundify_wc_themes_vendors_body_class( $classes ) {
	$page_id = wc_get_page_id( 'astoundify_wc_themes_vendors_dashboard' );

	// Bail, if page is not set.
	if ( 0 > $page_id ) {
		return $classes;
	}

	if ( is_page( $page_id ) ) {
		$classes[] = 'woocommerce';
		$classes[] = 'woocommerce-account';
		$classes[] = 'astoundify-wc-themes-vendor-dashboard';
	}

	return $classes;
}
add_filter( 'body_class', 'astoundify_wc_themes_vendors_body_class' );

/**
 * Load Navigation Template
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_vendors_dashboard_navigation() {
	astoundify_wc_themes_get_template( 'vendor-dashboard/navigation.php', array() );
}
add_action( 'astoundify_wc_themes_vendors_dashboard_navigation', 'astoundify_wc_themes_vendors_dashboard_navigation' );

/**
 * Dashboard Navigation Menu Items
 *
 * @since 1.0.0
 *
 * @return array
 */
function astoundify_wc_themes_vendors_get_dashboard_menu_items() {
	$items = array(
		'vendor-dashboard'      => esc_html__( 'Dashboard', 'astoundify-wc-themes' ),
		'vendor-orders'         => esc_html__( 'Purchases', 'astoundify-wc-themes' ),
		'vendor-products'       => esc_html__( 'Products', 'astoundify-wc-themes' ),
		'vendor-store-settings' => esc_html__( 'Store Settings', 'astoundify-wc-themes' ),
	);
	return apply_filters( 'astoundify_wc_themes_vendors_dashboard_menu_items', $items );
}

/**
 * Dashboard Navigation Menu Item HTML Classes.
 *
 * @since 1.0.0
 *
 * @param string $endpoint Dashboard endpoint.
 * @return string
 */
function astoundify_wc_themes_get_vendors_dashboard_menu_item_classes( $endpoint ) {
	$classes = array(
		'astoundify-wc-themes-VendorDashboard-navigation-link',
	);

	// Active state.
	$current = WC()->query->get_current_endpoint();
	$current = $current ? $current : 'vendor-dashboard';
	if ( $endpoint === $current ) {
		$classes[] = 'is-active';
	}

	$classes = apply_filters( 'astoundify_wc_themes_vendors_dashboard_menu_item_classes', $classes, $endpoint, $current );

	return implode( ' ', array_map( 'sanitize_html_class', $classes ) );
}

/**
 * Get Dashboard End Point URL
 *
 * @since 1.0.0
 *
 * @param string $endpoint Dashboard endpoint.
 * @param string $value    Endpoint value. Could be page, could be item id, etc.
 * @return string
 */
function astoundify_wc_themes_vendors_get_dashboard_endpoint_url( $endpoint, $value = '' ) {
	$page_url = wc_get_page_permalink( 'astoundify_wc_themes_vendors_dashboard' );
	$endpoints = astoundify_wc_themes_vendors_endpoints();

	// Dashboard, no endpoint.
	if ( ! $endpoint || 'vendor-dashboard' === $endpoint || ! array_key_exists( $endpoint, $endpoints ) ) {
		return esc_url_raw( $page_url );
	}

	// Pretty permalink.
	if ( get_option( 'permalink_structure' ) ) {
		$page_url = trailingslashit( $page_url ) . $endpoints[ $endpoint ];
		if ( $value ) {
			$page_url = user_trailingslashit( trailingslashit( $page_url ) . $value );
		}
	} else { // Ugly Permalink.
		$page_url = add_query_arg( $endpoints[ $endpoint ], $value, $page_url );
	}

	return esc_url_raw( $page_url );
}

/**
 * Check if the current page is the vendor dashboard.
 *
 * @since 1.0.0
 *
 * @param boolean $is_account_page While used with the `woocommerce_is_account_page` filter, this parameter is the previous value.
 *
 * @return boolean
 */
function astoundify_wc_is_vendor_dashboard ( $is_account_page = false ){

	if ( wc_get_page_id( 'astoundify_wc_themes_vendors_dashboard' ) === get_the_ID() ) {
		return true;
	}

	return $is_account_page;
}
add_filter( 'woocommerce_is_account_page', 'astoundify_wc_is_vendor_dashboard' );

/**
 * Endpoints Page titles.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_vendors_dashboard_set_endpoints_page_title() {

	// Get menu item label as title.
	$titles = astoundify_wc_themes_vendors_get_dashboard_menu_items();

	// Implement each menu title.
	foreach ( $titles as $endpoint => $endpoint_title ) {
		add_filter( "woocommerce_endpoint_{$endpoint}_title", function( $title ) use ( $endpoint_title ) {
			return $endpoint_title;
		} );
	}

	// Internal pages title.
	// Orders (Paged).
	add_filter( 'woocommerce_endpoint_vendor-orders_title', function( $title ) {
		global $wp;
		if ( ! empty( $wp->query_vars['vendor-orders'] ) && absint( $wp->query_vars['vendor-orders'] ) > 1 ) {
			/* Translators: %s: page. */
			$title = sprintf( esc_html__( 'Orders (page %d)', 'astoundify-wc-themes' ), intval( $wp->query_vars['vendor-orders'] ) );
		}
		return $title;
	} );

	// View Order.
	add_filter( 'woocommerce_endpoint_vendor-view-order_title', function( $title ) {
		global $wp;

		$order_id = '';
		if ( isset( $wp->query_vars['vendor-view-order'] ) ) {

			// Check if order exists and current user can access it.
			$can_access = astoundify_wc_themes_vendors_can_user_access_order( $wp->query_vars['vendor-view-order'] );
			if ( $can_access ) {
				$order_id = "#{$wp->query_vars['vendor-view-order']}";
			}
		}
		// Translators: %s is Order ID.
		return sprintf( esc_html__( 'Order %s', 'astoundify-wc-themes' ), $order_id );
	} );
}
add_action( 'init', 'astoundify_wc_themes_vendors_dashboard_set_endpoints_page_title' );

/* === DASHBOARD CONTENT CALLBACK === */

/**
 * Dasboard Content
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_vendors_dashboard_content() {
	global $wp;

	foreach ( $wp->query_vars as $key => $value ) {
		// Ignore pagename param.
		if ( 'pagename' === $key ) {
			continue;
		}

		if ( has_action( 'astoundify_wc_themes_vendors_dashboard_' . $key . '_endpoint' ) ) {
			do_action( 'astoundify_wc_themes_vendors_dashboard_' . $key . '_endpoint', $value );
			return;
		}
	}
}
add_action( 'astoundify_wc_themes_vendors_dashboard_content', 'astoundify_wc_themes_vendors_dashboard_content' );

/**
 * Dashboard Overview
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_vendors_dashboard_overview() {

	// Activities by groups.
	$activities = astoundify_wc_themes_vendors_get_activities_by_groups();

	// Activities by timestamp.
	$activities_list = astoundify_wc_themes_vendors_get_activities_by_timestamp( array(), $activities );

	// No endpoint found? Default to dashboard.
	astoundify_wc_themes_get_template( 'vendor-dashboard/dashboard.php', array(
		'activities_by_groups'    => $activities,
		'activities_by_timestamp' => $activities_list,
	) );
}
add_action( 'astoundify_wc_themes_vendors_dashboard_page_endpoint', 'astoundify_wc_themes_vendors_dashboard_overview' );

/**
 * Dashboard Orders
 *
 * @since 1.0.0
 *
 * @param string $current_page Current page pagination.
 */
function astoundify_wc_themes_vendors_dashboard_orders( $current_page ) {

	// Load template.
	astoundify_wc_themes_get_template( 'vendor-dashboard/orders.php', array(
		'order_query' => new \Astoundify\WC_Themes\Vendors\Order_Query( array(
			'page'  => $current_page ? $current_page : 1,
			'limit' => apply_filters( 'astoundify_wc_themes_vendors_orders_per_page', 10 ),
		) ),
	) );
}
add_action( 'astoundify_wc_themes_vendors_dashboard_vendor-orders_endpoint', 'astoundify_wc_themes_vendors_dashboard_orders' );

/**
 * Dashboard View Order
 *
 * @since 1.0.0
 *
 * @param string $current_page Current page pagination.
 */
function astoundify_wc_themes_vendors_dashboard_view_order( $order_id ) {
	$order_id = absint( $order_id );

	// Check if order exists and current user can access it.
	$can_access = astoundify_wc_themes_vendors_can_user_access_order( $order_id );
	if ( ! $can_access ) {
		astoundify_wc_themes_get_template( 'vendor-dashboard/view-order-404.php', array() );
		return;
	}

	astoundify_wc_themes_get_template( 'vendor-dashboard/view-order.php', array(
		'order_id' => absint( $order_id ),
		'order'    => wc_get_order( absint( $order_id ) ),
	) );
}
add_action( 'astoundify_wc_themes_vendors_dashboard_vendor-view-order_endpoint', 'astoundify_wc_themes_vendors_dashboard_view_order' );

/**
 * Dashboard Products
 *
 * @since 1.0.0
 *
 * @param string $current_page Current page pagination.
 */
function astoundify_wc_themes_vendors_dashboard_products( $current_page ) {

	// Current Page.
	$paged = $current_page ? $current_page : 1;

	// Get vendor owned products IDs.
	$product_ids = astoundify_wc_themes_vendors_get_draft_and_published_products();

	// Product Query with Pagination Support.
	$product_query = wc_get_products( array(
		'paginate'  => true, // Enable pagination.
		'paged'     => $paged,
		'limit'     => absint( get_option( 'posts_per_page', 10 ) ),
		'include'   => $product_ids ? $product_ids : array( -1 ), // Use -1 to make sure no results when no products IDs found.
		'status'    => array( 'publish', 'draft' ),
	) );

	// Get template.
	astoundify_wc_themes_get_template( 'vendor-dashboard/products.php', array(
		'product_query' => $product_query,
		'paged'         => $paged,
	) );
}
add_action( 'astoundify_wc_themes_vendors_dashboard_vendor-products_endpoint', 'astoundify_wc_themes_vendors_dashboard_products' );

/**
 * Get all draft and published vendor products.
 *
 * @since 1.0.0
 *
 * @return array ID of products.
 */
function astoundify_wc_themes_vendors_get_draft_and_published_products() {
	$vendor = WC_Product_Vendors_Utils::get_logged_in_vendor();

	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => -1,
		'post_status'    => array( 'draft', 'publish' ),
		'fields'    => 'ids',
		'tax_query' => array(
			array(
				'taxonomy' => WC_PRODUCT_VENDORS_TAXONOMY,
				'field'    => 'id',
				'terms'    => $vendor,
			),
		),
		'suppress_filters' => true,
	);

	$query = new WP_Query( $args );

	wp_reset_postdata();

	return $query->posts;
}

/**
 * Dashboard Store Settings
 *
 * @since 1.0.0
 *
 * @param string $current_page Current page pagination.
 */
function astoundify_wc_themes_vendors_dashboard_store_settings( $current_page ) {
	$vendor_id   = WC_Product_Vendors_Utils::get_logged_in_vendor();
	$vendor_data = WC_Product_Vendors_Utils::get_vendor_data_from_user();

	// Make sure all data required are set.
	$defaults = array(
		'logo'              => '',
		'cover'             => '',
		'email'             => '',
		'paypal'            => '',
		'vendor_commission' => get_option( 'wcpv_vendor_settings_default_commission', '0' ),
		'timezone'          => WC_Product_Vendors_Utils::get_default_timezone_string(),
	);

	// Add contact methods.
	$contact_methods = astoundify_wc_themes_get_additional_contact_methods();
	foreach ( $contact_methods as $method => $label ) {
		$defaults["contact_method_{$method}"] = '';
	}
	$defaults['contact_methods'] = $contact_methods;

	$vendor_data = wp_parse_args( $vendor_data, $defaults );

	// Add Images
	$logo_image  = isset( $vendor_data['logo'] ) ? wp_get_attachment_image_url( $vendor_data['logo'], 'thumbnail' ) : false;

	$cover_image_size = ( has_image_size( 'cover' ) ? 'cover' : 'full' );
	$cover_image = isset( $vendor_data['cover'] ) ? wp_get_attachment_image_url( $vendor_data['cover'], $cover_image_size ) : false;

	$vendor_data['logo_url']    = esc_url( $logo_image ? $logo_image : '' );
	$vendor_data['cover_image'] = esc_url( $cover_image ? $cover_image : '' );

	// Sanitize Timezone.
	$vendor_data['timezone'] = $vendor_data['timezone'] ? $vendor_data['timezone'] : $defaults['timezone'];

	// Store in separate meta.
	foreach ( [ 'vendor_profile', 'shipping_policy', 'return_policy', 'vendor_tagline', 'vendor_location', 'vendor_name' ] as $meta ) {
		$vendor_data[ $meta ] = get_term_meta( $vendor_id, $meta, true );
	}

	// Load template.
	astoundify_wc_themes_get_template( 'vendor-dashboard/store-settings.php', apply_filters( 'astoundify_wc_themes_vendor_dashboard_store_settings_data', $vendor_data ) );
}
add_action( 'astoundify_wc_themes_vendors_dashboard_vendor-store-settings_endpoint', 'astoundify_wc_themes_vendors_dashboard_store_settings' );

/**
 * Hide Vendor Dashboard Link in Account Page.
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_vendors_hide_admin_dashboard_link() {
	if ( ! is_account_page() ) {
		return;
	} ?>
<style id="astoundify-wc-themes-vendors-hide-admin-dashboard-link">.vendor-dashboard-link { display: none !important; }</style>
<?php
}
add_action( 'wp_head', 'astoundify_wc_themes_vendors_hide_admin_dashboard_link' );

/**
 * Login Form
 *
 * @since 2.1.0
 */
function astoundify_wc_themes_vendors_dashboard_login_form() {
	if ( is_user_logged_in() ) {
		return;
	}

	// Load login form template.
	astoundify_wc_themes_get_template( 'vendor-dashboard/form-login.php' );
}
