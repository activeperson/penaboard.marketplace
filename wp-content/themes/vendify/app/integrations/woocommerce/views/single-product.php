<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

	<?php do_action( 'woocommerce_before_main_content' ); ?>

		<?php
		while ( have_posts() ) :
			the_post();

			if ( ! is_multiple_vendors() || ! woocommerce_product_vendors_get_vendor_by_product( get_the_ID() ) ) :
				wc_get_template_part( 'content', 'single-product' );
			else :
				wc_get_template_part( 'content', 'single-product-vendor' );
			endif;
		endwhile;
		?>

	<?php do_action( 'woocommerce_after_main_content' ); ?>

<?php
get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */