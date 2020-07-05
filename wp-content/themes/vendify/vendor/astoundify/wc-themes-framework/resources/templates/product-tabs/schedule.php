<?php
/**
 * Schedule tab.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @var object $product WooCommerce Product Object.
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */

// WP Time Format.
$date_format = get_option( 'date_format' );
$time_format = get_option( 'time_format' );
?>

<ul id="event-schedule">

	<?php foreach ( $product->get_schedule() as $item ) : ?>
		<li>
			<?php
				/* translators: %1$s is the date, %2$s is start time and %3$s is end time */
				printf( esc_html__( '%1$s (%2$s - %3$s)', 'astoundify-wc-themes' ),
					$item['date']->date( $date_format ),
					$item['start']->date( $time_format ),
					$item['end']->date( $time_format )
				);
			?>
		</li>
	<?php endforeach; ?>

</ul><!-- .event-schedule -->
