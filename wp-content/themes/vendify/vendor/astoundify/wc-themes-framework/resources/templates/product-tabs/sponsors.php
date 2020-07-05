<?php
/**
 * Sponsors tab.
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

<div id="event-sponsors" class="gallery gallery-columns-5 gallery-size-thumbnail">

	<?php foreach ( $product->get_sponsors() as $sponsor ) : ?>

		<figure class="gallery-item">
			<div class="gallery-icon landscape">
				<?php if ( $sponsor->get_image() ) :  ?>
					<?php echo wp_get_attachment_image( $sponsor->get_image() ); ?>
				<?php else : ?>
					<?php echo get_avatar( $sponsor->get_email(), 150 ); ?>
				<?php endif; ?>
			</div><!-- .gallery-icon -->
			<figcaption class="wp-caption-text gallery-caption">
				<?php if ( $sponsor->get_url() ) :  ?>
					<a href="<?php echo esc_url( $sponsor->get_url() ); ?>"><?php echo esc_html( $sponsor->get_name() ); ?></a>
				<?php else : ?>
					<?php echo esc_html( $sponsor->get_name() ); ?>
				<?php endif; ?>
			</figcaption><!-- .gallery-caption -->
		</figure>

	<?php endforeach; ?>

</div><!-- .gallery -->
