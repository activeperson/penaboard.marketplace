<?php
/**
 * Shop title. Only shows when the hero is hidden.
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

if ( ! empty( woocommerce_featured_products() ) ) {
	return;
}

if ( ! apply_filters( 'woocommerce_show_page_title', true ) ) {
	return;
} ?>

<div class="hero hero--archive has-gradient--top">
	<div class="hero__content hero__content--center content--blog container">
		<h1 class="hero--blog-post__title page-title"><?php woocommerce_page_title(); ?></h1>
	</div>
</div>
