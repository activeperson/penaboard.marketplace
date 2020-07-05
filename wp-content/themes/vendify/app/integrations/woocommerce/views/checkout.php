<?php
/**
 * Checkout.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Theme
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="initial-scale=1">

		<link rel="profile" href="http://gmpg.org/xfn/11">

		<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
			<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php endif; ?>

		<?php wp_head(); ?>
	</head>

	<body <?php body_class( 'vendify' ); ?>>

		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<?php wc_get_template( 'checkout/partials/title.php' ); ?>

		<main class="main-content main-content--single-section">
			<div class="container">
				<?php wc_get_template( 'checkout/partials/tabs.php' ); ?>
			</div>
		</main>

		<?php endwhile; ?>

		<?php wp_footer(); ?>

	</body>
</html>
