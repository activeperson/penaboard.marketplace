<?php
/**
 * Template Name: Favorites
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

if ( ! has_integration( 'favorites' ) ) {
	wp_die( esc_html__( 'Please reactivate the Favorites plugin.', 'vendify' ) );
}

view( 'global/header' ); ?>

<main class="main-content main-content--single-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-10 ml-md-auto mr-md-auto">

				<?php while ( have_posts() ) : the_post(); ?>

					<h1 class="text-center messages__heading"><?php the_title(); ?></h1>
					<?php
					the_content();

				endwhile; ?>

			</div>
		</div>
	</div>
</main>

<?php
view( 'global/footer' );
