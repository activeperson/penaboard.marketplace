<?php
/**
 * Blog search.
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

view( 'global/header' ); ?>

<div class="hero hero--archive has-gradient--top">
	<div class="hero__content hero__content--center content--blog container">
		<h1 class="hero--blog-post__title page-title">&ldquo;<?php echo esc_attr( get_search_query() ); ?>&rdquo;</h1>
	</div>
</div>

<div class="main-content main-content--single-section">
	<div class="container">

		<?php if ( have_posts() ) { ?>
			<section class="blog-grid">
				<?php
				while ( have_posts() ) : the_post();
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
