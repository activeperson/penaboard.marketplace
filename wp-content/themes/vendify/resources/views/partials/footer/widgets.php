<?php
/**
 * Footer widgets.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

ob_start();

dynamic_sidebar( 'footer-sidebar');

$footer_widgets = ob_get_clean();

if ( '' === trim( $footer_widgets ) ) {
	return;
}
?>

<nav class="site-footer__nav">
	<?php echo $footer_widgets; // WPCS: XSS ok. ?>
</nav>
