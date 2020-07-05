<?php
/**
 * Product Filters - Keyword Field
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

<div class="event-filters-keyword">
	<p class="form-row">
		<label for="event-keyword-field"><?php esc_html_e( 'Keyword:', 'astoundify-wc-themes' ); ?></label>
		<input type="search" id="event-keyword-field" placeholder="<?php esc_attr_e( 'Search event&hellip;', 'astoundify-wc-themes' ); ?>" value="<?php echo esc_attr( $value ); ?>" name="s" />
	</p>
</div>
