<?php
/**
 * Sortable List: Attendees Product Data Templates.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category View
 * @author Astoundify
 */
?>

<?php
/**
 * Toolbar to Add New Attendee.
 *
 * @since 1.0.0
 */
?>
<script id="tmpl-attendeeAddToolbar" type="text/html">
	<select id="attendee-type">
		<option value="external" selected="selected"><?php esc_html_e( 'External User', 'astoundify-wc-themes' ); ?></option>
		<option value="user"><?php esc_html_e( 'Registered User', 'astoundify-wc-themes' ); ?></option>
	</select>

	<a id="add-item" class="button"><?php esc_html_e( 'Add Attendee', 'astoundify-wc-themes' ); ?></a>

	<span class="expand-close">
		<a href="#" class="expand_all"><?php esc_html_e( 'Expand', 'astoundify-wc-themes' ); ?></a> / <a href="#" class="close_all"><?php esc_html_e( 'Close', 'astoundify-wc-themes' ); ?></a>
	</span>

	<input type="search" name="filter" id="filter" placeholder="<?php esc_html_e( 'Filter...', 'astoundify-wc-themes' ); ?>" />
</script>

<?php
/**
 * Extendable Item Header for Attendee.
 *
 * @since 1.0.0
 */
?>
<script id="tmpl-attendeeHeader" type="text/html">
	<a href="#" data-cid="{{data.cid}}" class="delete"><?php esc_attr_e( 'Remove', 'astoundify-wc-themes' ); ?></a>
	<div class="handlediv" aria-label="<?php esc_attr_e( 'Click to toggle', 'astoundify-wc-themes' ); ?>"></div>
	<strong><# if ( data.name ) { #>{{{data.name}}}<# } else { #><?php esc_attr_e( 'Attendee', 'astoundify-wc-themes' ); ?><# } #></strong>
</script>

<?php
/**
 * Extendable Item Content for External Attendee.
 *
 * @since 1.0.0
 */
?>
<script id="tmpl-attendeeExternal" type="text/html">
	<div class="data">

		<p class="form-field form-row form-row-first">
			<label><?php esc_html_e( 'Name', 'astoundify-wc-themes' ); ?></label>
			<input type="text" class="item-name short" name="wc_themes_attendees[{{data.cid}}][name]" value="{{data.name}}" data-property="name" data-cid="{{data.cid}}" />
		</p>
		<p class="form-field form-row form-row-last">
			<label><?php esc_html_e( 'Email', 'astoundify-wc-themes' ); ?></label>
			<input type="text" class="attendee-email short" name="wc_themes_attendees[{{data.cid}}][email]" value="{{data.email}}" data-property="email" data-cid="{{data.cid}}" />
		</p>
		<div>
			<p class="form-row hide_if_variation_virtual form-row-full">
				<label><?php esc_html_e( 'Location', 'astoundify-wc-themes' ); ?></label>
				<input type="text" class="attendee-location short" name="wc_themes_attendees[{{data.cid}}][location]" value="{{data.location}}" data-property="location" data-cid="{{data.cid}}" />
			</p>
		</div>

	</div><!-- .data -->
</script>

<?php
/**
 * Extendable Item Content for Regisered Attendee.
 *
 * @since 1.0.0
 */
?>
<script id="tmpl-attendeeUser" type="text/html">
	<div class="data">

		<p class="form-row hide_if_variation_virtual form-row-full">
			<label><?php esc_html_e( 'Select user', 'astoundify-wc-themes' ); ?></label>
			<select class="wc-customer-search attendee-user_id" name="wc_themes_attendees[{{data.cid}}]" data-placeholder="<?php esc_attr_e( 'Guest', 'astoundify-wc-themes' ); ?>" data-allow_clear="true" data-property="user_id" data-cid="{{data.cid}}" >
				<# if ( data.user_id ) { #>
					<option value="{{data.user_id}}" selected="selected">{{data.name}}</option>
				<# } #>
			</select>
		</p>

	</div>
</script>
