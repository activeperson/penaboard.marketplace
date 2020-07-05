<?php
/**
 * Shop filters.
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

if ( defined( 'WC_PRODUCT_VENDORS_TAXONOMY' ) && is_tax( WC_PRODUCT_VENDORS_TAXONOMY ) ) :
	return;
endif;
?>

<header class="filter">
	<?php get_product_search_form(); ?>
	<?php woocommerce_catalog_ordering(); ?>
</header>

<?php woocommerce_breadcrumb(); ?>
