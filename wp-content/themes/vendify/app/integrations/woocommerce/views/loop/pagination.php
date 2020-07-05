<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$total = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );

if ( $total <= 1 ) {
	return;
}
?>
<nav class="woocommerce-pagination">
	<?php if ( get_next_posts_link() ) : ?>
		<?php next_posts_link( esc_html__( 'Previous', 'vendify' ) ); ?>
	<?php endif; ?>

	<?php if ( get_previous_posts_link() ) : ?>
		<?php previous_posts_link( esc_html__( 'Next', 'vendify' ) ); ?>
	<?php endif; ?>
</nav>
