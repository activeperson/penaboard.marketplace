<?php
/**
 * Sortable List: Schedule Product Data Templates.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category View
 * @author Astoundify
 */

global $product_object;

// @todo make a function
$timezone = method_exists( $product_object, 'get_schedule_timezone' ) && $product_object->get_schedule_timezone() ? $product_object->get_schedule_timezone() : false;
$current_offset = method_exists( $product_object, 'get_schedule_utc_offset' ) && $product_object->get_schedule_utc_offset() ? $product_object->get_schedule_utc_offset() : false;

if ( ! $timezone && $current_offset ) {
	if ( 0 === $current_offset ) {
		$timezone = 'UTC+0';
	} elseif ( $current_offset < 0 ) {
		$timezone = 'UTC' . $current_offset;
	} else {
		$timezone = 'UTC+' . $current_offset;
	}
}
?>

<?php
/**
 * Toolbar to Add New schedule item.
 *
 * @since 1.0.0
 */
?>
<script id="tmpl-scheduleAddToolbar" type="text/html">
	<select id="timezone_string" name="wc_themes_schedule_timezone">
		<?php echo wp_timezone_choice( $timezone, get_user_locale() ); // WPCS: XSS ok. ?>
	</select>

	<a id="add-item" class="button"><?php esc_html_e( 'Add Day', 'astoundify-wc-themes' ); ?></a>

	<span class="expand-close">
		<a href="#" class="expand_all"><?php esc_html_e( 'Expand', 'astoundify-wc-themes' ); ?></a> / <a href="#" class="close_all"><?php esc_html_e( 'Close', 'astoundify-wc-themes' ); ?></a>
	</span>
</script>

<?php
/**
 * Extendable Item Header for Day
 *
 * @since 1.0.0
 */
?>
<script id="tmpl-dayTimeHeader" type="text/html">
	<a href="#" data-cid="{{data.cid}}" class="delete"><?php esc_attr_e( 'Remove', 'astoundify-wc-themes' ); ?></a>
	<div class="handlediv" aria-label="<?php esc_attr_e( 'Click to toggle', 'astoundify-wc-themes' ); ?>"></div>
	<strong><# if ( data.date ) { #>{{data.date}}<# } else { #>Day<# } #></strong>
</script>

<?php
/**
 * Extendable Item Content for External Attendee.
 *
 * @since 1.0.0
 */
?>
<script id="tmpl-dayTime" type="text/html">
	<div class="data">

		<div>
			<p class="form-row hide_if_variation_virtual form-row-full">
				<label><?php esc_html_e( 'Date', 'astoundify-wc-themes' ); ?></label>
				<input type="text" class="short schedule-date date_field_input" name="wc_themes_schedule[{{data.cid}}][date]" value="{{data.date}}" data-property="date" data-cid="{{data.cid}}" />
			</p>
		</div>

		<p class="form-field form-row form-row-first">
			<label><?php esc_html_e( 'Start Time', 'astoundify-wc-themes' ); ?></label>
			<input type="time" class="short schedule-time-start" name="wc_themes_schedule[{{data.cid}}][start]" value="{{data.start}}" data-property="start" data-cid="{{data.cid}}" />
		</p>

		<p class="form-field form-row form-row-last">
			<label><?php esc_html_e( 'End Time', 'astoundify-wc-themes' ); ?></label>
			<input type="time" class="short schedule-time-end"  name="wc_themes_schedule[{{data.cid}}][end]" value="{{data.end}}" data-property="end" data-cid="{{data.cid}}" />
		</p>

	</div><!-- .data -->
</script>
