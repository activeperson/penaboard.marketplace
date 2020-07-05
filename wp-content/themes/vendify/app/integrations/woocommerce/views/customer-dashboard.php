<?php
/**
 * Template Name: Dashboard
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

if ( ! has_integration( 'woocommerce' ) ) {
	wp_die( esc_html__( 'Please reactivate the WooCommerce plugin.', 'vendify' ) );
}

view( 'global/header' );

while ( have_posts() ) : the_post();

	wc_get_template( 'myaccount/hero.php' ); ?>

	<main class="main-content main-content--single-section">
		<div class="container">
			<?php the_content(); ?>
		</div>
	</main>

<?php endwhile;

view( 'global/footer' );
