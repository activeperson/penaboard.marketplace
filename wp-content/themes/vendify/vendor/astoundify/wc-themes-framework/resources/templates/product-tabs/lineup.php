<?php
/**
 * Lineup tab.
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

<div id="event-lineup" class="gallery gallery-columns-5 gallery-size-thumbnail">

	<?php foreach ( $product->get_lineup() as $person ) : ?>

		<figure class="gallery-item">
			<div class="gallery-icon landscape">
				<?php if ( $person->get_image() ) :  ?>
					<?php echo wp_get_attachment_image( $person->get_image() ); ?>
				<?php else : ?>
					<?php echo get_avatar( $person->get_email(), 150 ); ?>
				<?php endif; ?>
			</div><!-- .gallery-icon -->
			<figcaption class="wp-caption-text gallery-caption">
				<?php if ( $person->get_url() ) :  ?>
					<a href="<?php echo esc_url( $person->get_url() ); ?>"><?php echo $person->get_name(); ?></a>
				<?php else : ?>
					<?php echo $person->get_name(); ?>
				<?php endif; ?>
			</figcaption><!-- .gallery-caption -->
		</figure>

	<?php endforeach; ?>

</div><!-- .gallery -->
