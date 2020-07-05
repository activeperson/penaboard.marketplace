<?php
/**
 * Shop sidebar.
 *
 * @since 1.0.0
 * @version 1.6.4
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! is_active_sidebar( 'shop' ) ) {
	return;
}
?>

<aside class="find-sidebar col-xs-12 col-md-4 col-xl-3" role="complementary">
	<?php dynamic_sidebar( 'shop' ); ?>
</aside>
