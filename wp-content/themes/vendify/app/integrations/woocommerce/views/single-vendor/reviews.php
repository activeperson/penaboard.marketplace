<?php
/**
 * Single vendor reviews.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

use WP_Comment_Query;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$vendor_id = get_queried_object_id();
$products  = get_vendor_product_ids( $vendor_id );

if ( empty( $products ) ) {
	$products = [ 999999 ]; // Avoid querying all posts.
}

$comments_query      = new WP_Comment_Query();
$comments_query_args = [
	'post__in'  => $products,
	'post_type' => 'product',
	'parent'    => 0,
	'status'    => 'approve',
	'number'    => 10,
];

$reviews = $comments_query->query( $comments_query_args ); ?>

<div class="review-list">

	<?php
	if ( ! empty( $reviews ) ) :
		foreach ( $reviews as $review ) :
			get_review(
				$review,
				[
					'avatar_size' => 24,
				],
				0
			);

			echo '</div>';
		endforeach;
	else :
		esc_html_e( 'No reviews.', 'vendify' );
	endif; ?>

</div>
