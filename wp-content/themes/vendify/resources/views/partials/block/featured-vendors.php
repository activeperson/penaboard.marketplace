<?php
/**
 * Featured Vendors
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

$number = $attributes['rows'] * 4;
$featured = woocommerce_product_vendors_get_featured_vendors(
	[
		'number' => $number,
	]
);

$view_more_btn_class = 'link link-cta text-xs has-icon';

if ( $attributes['visitButtonStyle'] !== 'classic' ) {
	$view_more_btn_class = 'btn btn-default ' . $attributes['visitButtonStyle'];
}

if ( empty( $featured ) ) {
	return esc_html__( 'No matching vendors.', 'vendify' );
} ?>

<div class="wp-block-vendify-featured-vendors">
	<div class="seller-list">

	<?php
	foreach ( $featured as $vendor ) :
		wc_get_template(
			'vendors/seller-list-top.php',
			[
				'vendor' => $vendor->term_id,
			]
		);
	endforeach; ?>
	</div>

	<?php if ( isset( $attributes['linkText'] ) ) : ?>
		<div class="section__link-wrap">
			<a href="<?php echo esc_url( $attributes['link'] ); ?>" class="link link-cta text-xs has-icon <?php echo esc_attr( $view_more_btn_class ); ?>">
				<?php

				echo esc_html( $attributes['linkText'] );

				svg(
					[
						'icon'    => 'long-arrow-right',
						'classes' => [
							'ico--xs',
							'ml-2',
						],
					]
				); ?>
			</a>
		</div>
	<?php endif; ?>
</div>
