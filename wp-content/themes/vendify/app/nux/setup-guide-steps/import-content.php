<?php
/**
 * Import content and plugins.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Setup
 * @author Astoundify
 */

namespace Astoundify\Vendify;

use Astoundify_ContentImporter;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$demos = [
	'default' => esc_html__( 'Classic', 'Vendify' ),
	'tasti'   => esc_html__( 'Tasti', 'Vendify' ),
	'royale'  => esc_html__( 'Royale', 'Vendify' ),
	'crafty'  => esc_html__( 'Crafty', 'Vendify' ),
	'bloom'   => esc_html__( 'Bloom', 'Vendify' ),
	'mymlm'   => esc_html__( 'MYMLM', 'Vendify' ),
];

$available = [ 'default', 'royale' ];
?>

<div id="content-pack">

	<?php foreach ( $demos as $key => $label ) { ?>

		<label for="<?php echo esc_attr( $key ); ?>" class="content-pack <?php if ( ! in_array( $key, $available ) ) { ?>coming-soon" disabled="disabled"<?php } else {?>"<?php }?>>
			<span class="content-pack-label"><?php echo esc_html( $label ); ?></span>

			<input type="radio" value="vendify_<?php echo esc_attr( $key ); ?>" name="demo_style" id="<?php echo esc_attr( $key ); ?>" <?php echo ( $key === 'default' ) ? 'checked="checked"' : ''; ?> />

			<span class="content-pack-img">
				<span class="dashicons dashicons-yes"></span>
				<img src="<?php echo get_parent_theme_file_uri('resources/assets/images/customize/' . $key . '.png' ); ?>" />
			</span>
		</label>
	<?php } ?>

</div>

<div id="plugins-to-import">
	<p><?php esc_html_e( 'Vendify requires the following plugins to be active in order to import content.', 'vendify' ); ?></p>

	<ul>
	<?php foreach ( content_importer_get_required_plugins() as $key => $plugin ) : ?>
	<li>
		<?php if ( $plugin['condition'] ) : ?>
			<span class="active"><span class="dashicons dashicons-yes"></span></span>
		<?php else : ?>
			<span class="inactive"><span class="dashicons dashicons-no"></span></span>
		<?php endif; ?>

		<?php echo wp_kses_post( $plugin['label'] ); ?>

		<?php if ( ! $plugin['condition'] ) : ?>
		&mdash; <span class="inactive"><?php esc_html_e( 'Demo content for this plugin will not be imported.', 'vendify' ); ?></span>
		<?php endif; ?>
	</li>
	<?php endforeach; ?>
	</ul>

	<p><?php printf( esc_html__( 'Want extra features on your site? Activate the following plugins for even more demo content; saving you setup time! Visit your %1$splugins page%2$s to activate any premium plugins you have installed.', 'vendify' ), '<a href="' . esc_url( admin_url( 'plugins.php' ) ) . '">', '</a>' ); ?></p>

	<ul id="astoundify-recommended-plugins">
	<?php foreach ( content_importer_get_recommended_plugins() as $key => $plugin ) : ?>

	<li data-pack="<?php echo esc_attr( implode( ' ', $plugin['pack'] ) ); ?>">
		<?php if ( $plugin['condition'] ) : ?>
			<span class="active dashicons dashicons-yes"></span>
		<?php else : ?>
			<span class="dashicons dashicons-minus" style="color: #b4b9be;"></span>
		<?php endif; ?>

		<?php echo wp_kses_post( $plugin['label'] ); ?>

		<?php if ( ! $plugin['condition'] ) : ?>
		<em>(<?php esc_html_e( 'Demo content will not be imported for this inactive plugin', 'vendify' ); ?>)</em>
		<?php endif; ?>
	</li>

	<?php endforeach; ?>
	</ul>
</div>

<?php echo Astoundify_ContentImporter::get_importer_html( [], 'vendify_default' ); ?>

<script type="text/javascript">
jQuery( document ).ready( function($) {

	// Change style based on demo pack.
	$( 'input[name="demo_style"]' ).change( function() {
		var pack = $(this).val();

		$( 'input[name="astoundify_ci_pack"]' ).val( pack );

		togglePlugins( pack );
	});

	function togglePlugins( pack ) {
		// Toggle relevant plugins.
		$( '#astoundify-recommended-plugins li' ).hide().filter( function() {
			var safePack = pack.replace( 'vendify_', '' );
			var showFor = $(this).data( 'pack' ).split( ' ' );

			return showFor.indexOf( safePack ) != -1;
		} ).show();
	}

	togglePlugins( 'default' );

} );
</script>
