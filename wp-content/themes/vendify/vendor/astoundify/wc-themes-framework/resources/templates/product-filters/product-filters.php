<?php
/**
 * Product Filters
 *
 * @var array $main_fields     Main Filter Fields.
 * @var array $extended_fields Extended Filter Fields.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */
?>

<div class="astoundify-wc-themes-events-filters">

	<form id="astoundify-wc-themes-events-filters-form" method="GET" action="<?php echo esc_url( home_url() ); ?>">

		<?php foreach ( $main_fields as $field ) : ?>
			<?php do_action( "astoundify_wc_themes_events_product_filters_{$field}_field" ); ?>
		<?php endforeach; ?>

		<?php if ( $extended_fields ) : ?>
			<div class="extended-filter-fields">
				<?php foreach ( $extended_fields as $field ) : ?>
					<?php do_action( "astoundify_wc_themes_events_product_filters_{$field}_field" ); ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="event-filters-submit">
			<p>
				<input type="submit" value="<?php esc_attr_e( 'Update Results', 'astoundify-wc-themes' ); ?>"/>
				<input type="hidden" name="post_type" value="product">
				<input type="hidden" name="product_type[]" value="event">
				<input type="hidden" name="current_base" value="<?php global $wp; echo add_query_arg( array(), $wp->request ); ?>" />
				<input type="hidden" name="page" id="page" value="<?php absint( isset( $_GET['page'] ) ? $_GET['page'] : 1 ); ?>" />
			</p>
		</div><!-- .event-filters-submit -->

	</form>

</div><!-- .astoundify-wc-themes-events-filters -->
