<?php
/**
 * Vendors Plugin Setup
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Event
 * @author Astoundify
 */

// Do not access this file directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Vendors Plugin Setup
 *
 * @since 1.0.0
 *
 * @param array $steps Setup Steps.
 * @return array
 */
function astoundify_wc_themes_vendors_setup_steps( $steps ) {
	$steps[] = array(
		'title'    => esc_html__( 'Vendors Setup', 'astoundify-wc-themes' ),
		'view'     => 'astoundify_wc_themes_vendors_setup_view',
		'handler'  => 'astoundify_wc_themes_vendors_setup_handler',
		'priority' => 15,
	);

	return $steps;
}
add_filter( 'astoundify_wc_themes_setup_steps', 'astoundify_wc_themes_vendors_setup_steps' );

/**
 * Vendors Setup View
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_vendors_setup_view() {
	$url = add_query_arg( array(
		'page'    => 'wc-settings',
		'tab'     => 'account',
		'section' => 'astoundify_wc_themes_vendors_dashboard_settings',
	), admin_url( 'admin.php' ) ); ?>
<h2 class="title"><?php esc_html_e( 'Vendors Page Setup', 'astoundify-wc-themes' ); ?></h2>

<?php if ( get_option( 'astoundify_wc_themes_vendors_dashboard_page_id' ) ) : ?>

	<p><?php printf( __( 'Vendor dashboard page is set. You can edit the settings in <a target="_blank" href="%s">WooCommerce Product Display Settings</a>.', 'astoundify-wc-themes' ), esc_url( $url ) ); ?></p>

<?php else : ?>

	<p><?php esc_html_e( 'You can create dashboard page for your Vendors using the form below.', 'astoundify-wc-themes' ); ?></p>

	<table class="widefat">
		<thead>
			<tr>
				<th><?php esc_html_e( 'Page Title', 'astoundify-wc-themes' ); ?></th>
				<th><?php esc_html_e( 'Content Shortcode', 'astoundify-wc-themes' ); ?></th>
				<th><?php esc_html_e( 'Register Form', 'astoundify-wc-themes' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><input type="text" class="widefat" value="<?php esc_attr_e( 'My Dashboard', 'astoundify-wc-themes' ); ?>" name="vendor-dashboard-page" /></td>
				<td><code><?php esc_html_e( 'Must have the Vendor Dashboard block', 'astoundify-wc-themes' ); ?></code></td>
				<td><label><input name="vendor-dashboard-registration" type="checkbox" value="1" <?php checked( get_option( 'astoundify_wc_themes_vendors_dashboard_enable_registration' ), 'yes' ); ?>> <?php esc_html_e( 'Enable vendor registration.', 'astoundify-wc-themes' ); ?></label></td>
			</tr>
		</tbody>
	</table>

	<p><?php printf( __( 'Or you can skip this step, and create and select the page manually in <a target="_blank" href="%s">WooCommerce Vendors Dashboard Settings</a>.', 'astoundify-wc-themes' ), esc_url( $url ) ); ?></p>

<?php endif;

}

/**
 * Vendors Setup Handler
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_vendors_setup_handler() {
	if ( ! isset( $_POST['vendor-dashboard-page'] ) ) {
		return;
	}

	// Form data.
	$title = $_POST['vendor-dashboard-page'] ? esc_html( $_POST['vendor-dashboard-page'] ) : esc_html__( 'My Dashboard', 'astoundify-wc-themes' );
	$enable_registration = isset( $_POST['vendor-dashboard-registration'] ) && $_POST['vendor-dashboard-registration'] ? true : false;

	// Create page.
	$page_data = array(
		'post_status'    => 'publish',
		'post_type'      => 'page',
		'post_author'    => get_current_user_id(),
		'post_name'      => sanitize_title( $title ),
		'post_title'     => $title,
		'post_content'   => '',
		'post_parent'    => 0,
		'comment_status' => 'closed',
	);
	$page_id = wp_insert_post( $page_data );

	// Update Option.
	$updated = is_wp_error( $page_id ) ? false : update_option( 'astoundify_wc_themes_vendors_dashboard_page_id', intval( $page_id ) );

	if ( $enable_registration ) {
		update_option( 'astoundify_wc_themes_vendors_dashboard_enable_registration', 'yes' );
	} else {
		delete_option( 'astoundify_wc_themes_vendors_dashboard_enable_registration' );
	}

	// Add notice.
	add_action( 'admin_notices', function() use ( $updated ) {
		$url = add_query_arg( array(
			'page'    => 'wc-settings',
			'tab'     => 'account',
			'section' => 'astoundify_wc_themes_vendors_dashboard_settings',
		), admin_url( 'admin.php' ) );
		?>

		<?php if ( $updated ) : ?>

			<div class="notice notice-success">
				<p><?php esc_html_e( 'Vendor dashboard page successfully created.', 'astoundify-wc-themes' ); ?></p>
			</div>

		<?php else : ?>

			<div class="notice notice-error">
				<p><?php printf( __( 'Fail to create vendor dashboard page. Please select the page manually in <a target="_blank" href="%s">WooCommerce Product Display Settings</a>.', 'astoundify-wc-themes' ), esc_url( $url ) ); ?></p>
			</div>

		<?php endif; ?>

		<?php
	} );
}
