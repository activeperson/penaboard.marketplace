<?php
/**
 * Search vendor results.
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

$results  = woocommerce_product_vendors_find_vendor_search();
$per_page = apply_filters( 'vendify_find_vendor_per_page', 16 );
$page     = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
$offset   = ( $page - 1 ) * $per_page; ?>

<div id="search-results" class="col-sm-12" style="width: 100%;">
	<div class="navigation--shop-listing mx-auto"></div>

<?php
if ( ! empty( $results ) ) :
	echo '<section class="seller-grid js-dynamic-slider">';

	foreach ( array_slice( $results, $offset, ( 4 >= $per_page ? $per_page : 4 ) ) as $vendor ) :
		wc_get_template(
			'vendors/seller-list-top.php',
			[
				'vendor' => $vendor->vendor_id,
			]
		);
	endforeach;

	echo '</section>';

	if ( 4 <= $per_page ) :
		echo '<section class="seller-list">';

		foreach ( array_slice( $results, ( $offset + 4 ), $per_page ) as $vendor ) :
			wc_get_template(
				'vendors/seller-list.php',
				[
					'vendor' => $vendor->vendor_id,
				]
			);
		endforeach;

		echo '</section>';
	endif;

	wc_get_template(
		'vendors/pagination.php',
		[
			'results' => $results,
		]
	);
else :
	esc_html_e( 'No vendors found.', 'vendify' );
endif; ?>

</div>
