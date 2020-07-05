<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

view( 'global/header--minimal' ); ?>

<div class="hero">
	<div class="hero__content hero__content--center content--blog container">
		<h1 class="hero--blog-post__title page-title mx-auto"><?php esc_html_e( 'This page is lost', 'vendify' ); ?></h1>
		<p><?php esc_html_e( 'This page was not found. You may have mistyped the address or the page may have moved.', 'vendify' ); ?></p>
	</div>
</div>

<div class="main-content main-content--single-section">
	<div class="container text-center">
		<div class="icon__item"></div>
		<a href="<?php echo esc_url( home_url() ); ?>" class="btn btn-primary" ><?php esc_html_e('Go back home', 'vendify'); ?></a>
	</div>
</div>

<?php wp_footer(); ?>

	</body>
</html>

