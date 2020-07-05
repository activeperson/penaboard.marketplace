<?php
/**
 * Find a vendor front page tabs.
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

$tabs = woocommerce_product_vendors_find_vendor_tabs(); ?>

<nav class="navigation navigation--shop-listing alignwide">
	<ul class="nav nav-tabs">
		<?php
		$i = 0;
		foreach ( $tabs as $key => $tab ) { ?>
			<li class="nav-item">
				<a href="#tab-<?php echo esc_attr( $key ); ?>"
				   class="nav-link <?php echo esc_attr( 0 === $i ? 'active' : null ); ?>" role="tab"
				   data-toggle="tab"><?php echo esc_html( $tab['label'] ); ?></a>
			</li>
			<?php
			$i ++;
		}
		$i = 0; ?>
	</ul>
</nav>

<div class="tab-content" style="width: 100%;">

	<?php foreach ( $tabs as $key => $tab ) : ?>

	<div class="tab-pane <?php echo esc_attr( 0 === $i ? 'active' : null ); ?>" role="tabpanel" id="tab-<?php echo esc_attr( $key ); ?>">
		<?php
		if ( ! empty( $tab['data'] ) ) :
			echo '<section class="seller-grid js-dynamic-slider">';

			foreach ( array_slice( $tab['data'], 0, 4 ) as $vendor ) :
				wc_get_template(
					'vendors/seller-list-top.php',
					[
						'vendor' => $vendor->vendor_id,
					]
				);
			endforeach;

			echo '</section><section class="seller-list">';

			foreach ( array_slice( $tab['data'], 4, isset( $limit ) ? $limit : null ) as $vendor ) :
				wc_get_template(
					'vendors/seller-list.php',
					[
						'vendor' => $vendor->vendor_id,
					]
				);
			endforeach;

			echo '</section>';
		else :
			echo '<p style="margin-bottom: 45px;">';
			esc_html_e( 'No matching vendors.', 'vendify' );
			echo '</p>';
		endif; ?>
	</div>

		<?php
		$i++;
	endforeach;
?>

</div>
