<?php
/**
 * Private message alert.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Theme
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<div class="notice" role="alert">
	<?php svg( 'alert-notice' ); ?>

	<ul>
		<li><?php echo wp_kses_post( $notice ); ?></li>
	</ul>
</div>
