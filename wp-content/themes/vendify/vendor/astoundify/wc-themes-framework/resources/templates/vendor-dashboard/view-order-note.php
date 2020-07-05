<?php
/**
 * View Single Note Order
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @var object $note
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<li class="woocommerce-OrderUpdate comment <?php echo esc_attr( $note->customer_note ? 'note customer-note' : 'note' );?>">
	<div class="woocommerce-OrderUpdate-inner comment_container">
		<div class="woocommerce-OrderUpdate-text comment-text">
			<p class="woocommerce-OrderUpdate-meta meta">

				<?php
				/* Translators: %1$s is date, %2$s is note creator. */
				printf( esc_html__( 'Added on %1$s by %2$s', 'astoundify-wc-themes' ),  $note->date_created->date( 'l jS \o\f F Y, h:ia' ), $note->added_by );
				?>

			</p>
			<div class="woocommerce-OrderUpdate-description description">
				<?php echo wpautop( wptexturize( wp_kses_post( $note->content ) ) ); ?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
</li>
