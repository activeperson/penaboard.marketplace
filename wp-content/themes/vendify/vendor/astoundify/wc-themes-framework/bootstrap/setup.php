<?php
/**
 * Plugin Setup
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Bootstrap
 * @author Astoundify
 */

/**
 * Plugin Setup
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_setup() {

	// Setup Confuguration.
	$config = array(
		'id'           => 'astoundify-wc-themes-setup',
		'capability'   => 'manage_options',
		'menu_title'   => esc_html__( 'WC Themes Setup', 'astoundify-wc-themes' ),
		'page_title'   => esc_html__( 'Astoundify WC Themes Setup', 'astoundify-wc-themes' ),
		'redirect'     => true,
		'steps'        => array(), // Steps must be using 1, 2, 3... in order, last step have no handler.
		'labels'       => array(
			'next_step_button' => esc_html__( 'Submit', 'astoundify-wc-themes' ),
			'skip_step_button' => esc_html__( 'Skip', 'astoundify-wc-themes' ),
		),
	);
	$steps = apply_filters( 'astoundify_wc_themes_setup_steps', $config['steps'] );

	// Thank you.
	$steps[] = array(
		'view'     => 'astoundify_wc_themes_setup_thank_you',
		'handler'  => '__return_false',
		'priority' => 99,
	);

	// Sort by priority.
	uasort( $steps, function( $a, $b ) {
		if ( $a['priority'] === $b['priority'] ) {
			return 0;
		}
		return ( $a['priority'] < $b['priority'] ) ? -1 : 1;
	} );

	// Format keys.
	$i = 0;
	foreach ( $steps as $step ) {
		$i++;
		$config['steps'][$i] = $step;
	}

	require_once( ASTOUNDIFY_WC_THEMES_PATH . 'vendor/astoundify/plugin-setup/astoundify-pluginsetup.php' );
	new Astoundify_PluginSetup( $config );
}
add_action( 'init', 'astoundify_wc_themes_setup' ); // Need to be loaded late, because events loaded on `after_setup_theme`.

/**
 * Setup Thank You
 *
 * @since 1.0.0
 */
function astoundify_wc_themes_setup_thank_you() {
?>
<h2 class="title"><?php esc_html_e( 'Setup Complete', 'astoundify-wc-themes' ); ?></h2>
<p><?php esc_html_e( "Looks like you're all set. Astoundify WC Themes plugin is ready to use.", 'astoundify-wc-themes' ); ?></p>
<?php
}
