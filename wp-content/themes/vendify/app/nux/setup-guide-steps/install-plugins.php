<?php
/**
 * Install plugins.
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

astoundify_plugininstaller_enqueue_scripts();
?>

<div class="astoundify-setupguide-install-plugins-more">
	<div class="astoundify-setupguide-install-plugins-list">

		<?php astoundify_plugininstaller_list(); ?>

	</div>
</div>
