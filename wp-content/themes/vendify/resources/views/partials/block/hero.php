<?php
/**
 * Hero
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 *
 * @var $attributes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$classes = [
	'wp-block-vendify-hero',
	'alignfull',
	'hero',
	'hero--home',
	'has-gradient-top',
];

if ( ! empty( $attributes['className'] ) ) {
	$classes[] = esc_attr( $attributes['className'] );
}

if ( ! empty( $attributes['dimRatio'] ) ) {
	$classes[] = 'has-background-dim';
	$classes[] = 'has-background-dim-' . $attributes['dimRatio'];
}

if ( ! empty( $attributes['hasAnimation'] ) ) {
	$classes[] = 'hero--animatable';
}

$content_classes = [
	'hero__content',
	'hero-block__content',
	'container',
	'has-' . $attributes['contentAlign'] . '-content',
];

if ( 0 === $attributes['paddingTop'] ) {
	$content_classes[] = 'has-flush-top';
}

if ( 0 === (int) $attributes['paddingBottom'] ) {
	$content_classes[] = 'has-flush-bottom';
} ?>

<section class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="hero__image-holder" aria-hidden="true">
		<div class="hero__image <?php echo esc_attr( $attributes['hasParallax'] ? 'has-parallax' : null ); ?>" style="background-image: url(<?php echo esc_url( $attributes['url'] ); ?>)"></div>
	</div>

	<div
		class="<?php echo esc_attr( implode( ' ', $content_classes ) ); ?>"
		style="padding-top: <?php echo esc_attr( $attributes['paddingTop'] ); ?>px; padding-bottom: <?php echo esc_attr( $attributes['paddingBottom'] ); ?>px;"
	>
		<?php echo sprintf( '%s', $content ); ?>
	</div>
</section>
