<?php
/**
 * Template Name: Private Messages
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

if ( ! has_integration( 'private-messages' ) ) {
	wp_die( esc_html__( 'Please reactivate the Private Messages plugin.', 'vendify' ) );
}

view( 'global/header' );

while ( have_posts() ) : the_post();

	if ( ! isset( $_GET['view_message'] ) ) { // WPCS: input var, CSRF ok. ?>

		<main class="main-content main-content--single-section">
			<div class="container">
				<div class="row">
					<div class="col-lg-10 ml-md-auto mr-md-auto">
						<h1 class="text-center messages__heading"><?php the_title(); ?></h1>
						<?php the_content(); ?>
					</div>
				</div>
			</div>
		</main>

	<?php } else { ?>

		<div class="cnv">
			<main class="main-content main-content--single-section">
				<section class="cnv__container">
					<?php the_content(); ?>
				</section>
			</main>
		</div>

	<?php }

endwhile;

view( 'global/footer' );
