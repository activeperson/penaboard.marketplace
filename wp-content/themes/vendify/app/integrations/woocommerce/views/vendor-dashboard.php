<?php
/**
 * Template Name: Vendor Dashboard
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! has_integration( 'woocommerce-product-vendors' ) ) {
	wp_die( esc_html__( 'Please reactivate the WooCommerce Product Vendors plugin.', 'vendify' ) );
}

view( 'global/header' );

while ( have_posts() ) : the_post();

	wc_get_template( 'vendor-dashboard/hero.php' ); ?>

	<main class="main-content main-content--single-section">
		<div class="container">
			<?php if ( current_user_can( 'manage_options' ) ) { ?>
			<div class="notice" role="alert">
				<?php
				svg( 'alert-notice' );

				esc_html_e( 'Hey there! The vendor registration form is not showing since you\'re logged in as an Administrator. If you\'d like to verify the form is working, please log out and view this page again.', 'vendify' ); ?>
			</div>
			<?php }

			the_content(); ?>
		</div>
	</main>

	<?php
endwhile;

view( 'global/footer' );
