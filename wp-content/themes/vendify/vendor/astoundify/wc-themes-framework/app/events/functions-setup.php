<?php
/**
 * Events Plugin Setup
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
 * Events Plugin Setup
 *
 * @since 1.0.0
 *
 * @param array $steps Setup Steps.
 * @return array
 */
function astoundify_wc_themes_events_setup_steps( $steps ) {
	$steps[] = array(
		'title'    => esc_html__( 'Events Setup', 'astoundify-wc-themes' ),
		'view'     => 'astoundify_wc_themes_events_setup_view',
		'handler'  => 'astoundify_wc_themes_events_setup_handler',
		'priority' => 10,
	);

	return $steps;
}
add_filter( 'astoundify_wc_themes_setup_steps', 'astoundify_wc_themes_events_setup_steps' );

/**
 * Events Setup View
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_events_setup_view() {
	$url = add_query_arg( array(
		'page'    => 'wc-settings',
		'tab'     => 'products',
		'section' => 'display',
	), admin_url( 'admin.php' ) );
?>
<h2 class="title"><?php esc_html_e( 'Events Page Setup', 'astoundify-wc-themes' ); ?></h2>

<?php if ( get_option( 'astoundify_wc_themes_events_page_id' ) ) : ?>

	<p><?php printf( __( 'Events page is set. You can edit the settings in <a target="_blank" href="%s">WooCommerce Product Display Settings</a>.', 'astoundify-wc-themes' ), esc_url( $url ) ); ?></p>

<?php else : ?>

	<p><?php esc_html_e( 'With Astoundify WC Themes you can create Event Product in WooCommerce. In this step you can sets the base page of your events products - this is where your events archive will be.', 'astoundify-wc-themes' ); ?></p>

	<table class="widefat">
		<thead>
			<tr>
				<th><?php esc_html_e( 'Page Title', 'astoundify-wc-themes' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><input type="text" class="widefat" value="<?php echo esc_attr__( 'Events', 'astoundify-wc-themes' ); ?>" name="events-archive-page" /></td>
			</tr>
		</tbody>
	</table>

	<p><?php printf( __( 'Or you can skip this step, and create and select the page manually in <a target="_blank" href="%s">WooCommerce Product Display Settings</a>.', 'astoundify-wc-themes' ), esc_url( $url ) ); ?></p>

<?php endif; ?>

<?php
}

/**
 * Events Setup Handler
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_events_setup_handler() {
	if ( ! isset( $_POST['events-archive-page'] ) ) {
		return;
	}

	// Page Title.
	$title = $_POST['events-archive-page'] ? esc_html( $_POST['events-archive-page'] ) : esc_html__( 'Events', 'astoundify-wc-themes' );

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
	$updated = is_wp_error( $page_id ) ? false : update_option( 'astoundify_wc_themes_events_page_id', intval( $page_id ) );

	// Add notice.
	add_action( 'admin_notices', function() use ( $updated ) {
		$url = add_query_arg( array(
			'page'    => 'wc-settings',
			'tab'     => 'products',
			'section' => 'display',
		), admin_url( 'admin.php' ) );
		?>

		<?php if ( $updated ) : ?>

			<div class="notice notice-success">
				<p><?php esc_html_e( 'Events page successfully created.', 'astoundify-wc-themes' ); ?></p>
			</div>

		<?php else : ?>

			<div class="notice notice-error">
				<p><?php printf( __( 'Fail to create event page. Please select the page manually in <a target="_blank" href="%s">WooCommerce Product Display Settings</a>.', 'astoundify-wc-themes' ), esc_url( $url ) ); ?></p>
			</div>

		<?php endif; ?>

		<?php
	} );
}
