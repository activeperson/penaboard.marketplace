<?php
/**
 * Product Filters - Date Field
 *
 * @var string $value
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */
?>

<div class="event-filters-date">

	<p class="form-row form-row-first">
		<label for="event-schedule-start-field"><?php esc_html_e( 'Date From:', 'astoundify-wc-themes' ); ?></label>
    <input id="event-schedule-start-field" type="text" name="schedule_start" value="<?php echo esc_attr( $value['schedule_start'] ); ?>">
	</p>

	<p class="form-row form-row-last">
		<label for="event-schedule-end-field"><?php esc_html_e( 'Date To:', 'astoundify-wc-themes' ); ?></label>
    <input id="event-schedule-end-field" type="text" name="schedule_end" value="<?php echo esc_attr( $value['schedule_end'] ); ?>">
	</p>

</div><!-- .event-filters-date -->
