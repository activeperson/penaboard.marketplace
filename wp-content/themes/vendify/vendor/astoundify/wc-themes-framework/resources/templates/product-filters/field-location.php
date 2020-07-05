<?php
/**
 * Product Filters - Location Field
 *
 * @var array $value
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */
?>

<div class="event-filters-location">
	<p class="form-row">
		<label for="event-location-field"><?php esc_html_e( 'Location:', 'astoundify-wc-themes' ); ?></label>

		<input id="event-location-field" type="text" name="location" value="<?php echo esc_attr( $value['location'] ); ?>">
	</p>

	<p class="form-row">
		<label for="event-location-radius-field"><?php esc_html_e( 'Radius:', 'astoundify-wc-themes' ); ?> <span class="location-radius-field-value"></span></label>

		<div id="event-location-radius-field-slider"></div>

		<input id="event-location-radius-field" class="location-radius-field" type="range" name="radius" value="<?php echo esc_attr( $value['radius'] ); ?>" min="10" max="100" step="10">

		<input id="event-location-lat-field" type="hidden" name="lat" value="<?php echo esc_attr( $value['lat'] ); ?>">
		<input id="event-location-lng-field" type="hidden" name="lng" value="<?php echo esc_attr( $value['lng'] ); ?>">
	</p>
</div>
