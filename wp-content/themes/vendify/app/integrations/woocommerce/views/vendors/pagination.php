<?php
/**
 * Find a vendor pagination.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$per_page = apply_filters( 'vendify_find_vendor_per_page', 16 );
$big      = 99999;
$total    = ceil( count( $results ) / $per_page );
$current  = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
$base     = str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) );

if ( $total <= 1 ) {
	return;
}
?>

<div class="woocommerce">
	<nav class="woocommerce-pagination">
	<?php
	echo paginate_links(
		apply_filters(
			'woocommerce_pagination_args',
			[ // WPCS: XSS ok.
				'base'      => $base,
				'add_args'  => false,
				'current'   => max( 1, $current ),
				'total'     => $total,
				'prev_text' => '&larr;',
				'next_text' => '&rarr;',
				'type'      => 'list',
				'end_size'  => 3,
				'mid_size'  => 3,
			]
		)
	);
	?>
	</nav>
</div>
