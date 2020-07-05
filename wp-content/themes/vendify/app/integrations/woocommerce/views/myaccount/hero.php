<?php
/**
 * Hero
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<section class="hero hero--animatable hero--dashboard has-half-gradient--bottom">
	<div class="hero__content hero__content--horizontal container">
		<?php if ( is_user_logged_in() ) : ?>
			<span class="hero--dashboard__logo"><?php echo get_avatar( get_current_user_id(), 64 ); ?></span>
		<?php endif; ?>

		<h1 class="page-title"><?php the_title(); ?></h1>
	</div>

	<div class="hero__image-holder" aria-hidden="true">
		<div class="hero__image" style="background-image: url(<?php echo esc_url( hero_image_src() ); ?>);"></div>
	</div>
</section>

<?php woocommerce_account_navigation(); ?>
