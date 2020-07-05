<?php
/**
 * Get involved.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Setup
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<p><?php esc_html_e( 'Help improve Vendify by translating the theme to as many languages as possible!', 'vendify' ); ?></p>

<p>
	<a href="https://astoundify.com/support/" class="button button-secondary"><?php esc_html_e( 'Translate Vendify', 'vendify' ); ?></a>
</p>

<?php if ( ! get_option( 'astoundify_setup_guide_hidden', false ) ) : ?>
<p>
	<a href="<?php echo esc_url( Astoundify_Setup_Guide::get_hide_menu_item_url() ); ?>"><em><?php esc_html_e( 'Move this guide under the "Appearance" menu item', 'vendify' ); ?></em></a>
</p>
<?php endif; ?>
