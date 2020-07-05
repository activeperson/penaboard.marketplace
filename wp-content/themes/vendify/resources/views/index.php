<?php
/**
 * Blog index.
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

view( 'global/header' );

partial( 'blog/sticky' ); ?>

<div class="main-content main-content--single-section">
	<div class="container">

		<?php if ( have_posts() ) { ?>
			<section class="blog-grid js-reveal-container">
				<?php
				while ( have_posts() ) : the_post();
					if ( is_sticky() ) {
						continue;
					}
					partial( 'content' );
				endwhile; ?>
			</section>

			<?php
			partial( 'content/pagination' );
		} else {
			partial( 'content/none' );
		} ?>

	</div>
</div>

<?php
view( 'global/footer' );
