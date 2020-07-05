<?php
/**
 * Attendees tab.
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
?>

<div id="event-attendees" class="gallery gallery-columns-5 gallery-size-thumbnail">

	<?php foreach ( $product->get_attendees() as $attendee ) : ?>

		<figure class="gallery-item">
			<div class="gallery-icon landscape">
				<?php echo get_avatar( $attendee->get_email(), 150 ); ?>
			</div><!-- .gallery-icon -->
			<figcaption class="wp-caption-text gallery-caption"><?php echo $attendee->get_name(); ?></figcaption><!-- .gallery-caption -->
		</figure>

	<?php endforeach; ?>

</div><!-- .gallery -->
