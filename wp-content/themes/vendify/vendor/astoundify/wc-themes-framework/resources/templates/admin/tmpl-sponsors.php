<?php
/**
 * Sortable List: Sponsors Product Data Templates.
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
 * Toolbar to Add New Sponsor.
 *
 * @since 1.0.0
 */
?>
<script id="tmpl-sponsorAddToolbar" type="text/html">
	<a id="add-item" class="button"><?php esc_html_e( 'Add Sponsor', 'astoundify-wc-themes' ); ?></a>

	<span class="expand-close">
		<a href="#" class="expand_all"><?php esc_html_e( 'Expand', 'astoundify-wc-themes' ); ?></a> / <a href="#" class="close_all"><?php esc_html_e( 'Close', 'astoundify-wc-themes' ); ?></a>
	</span>

	<input type="search" name="filter" id="filter" placeholder="<?php esc_html_e( 'Filter...', 'astoundify-wc-themes' ); ?>" />
</script>

<?php
/**
 * Extendable Item Header for Sponsor.
 *
 * @since 1.0.0
 */
?>
<script id="tmpl-sponsorHeader" type="text/html">
	<a href="#" data-cid="{{data.cid}}" class="delete"><?php esc_attr_e( 'Remove', 'astoundify-wc-themes' ); ?></a>
	<div class="handlediv" aria-label="<?php esc_attr_e( 'Click to toggle', 'astoundify-wc-themes' ); ?>"></div>
	<strong><# if ( data.name ) { #>{{{data.name}}}<# } else { #><?php esc_attr_e( 'Sponsor', 'astoundify-wc-themes' ); ?><# } #></strong>
</script>

<?php
/**
 * Extendable Item Content for External Sponsor.
 *
 * @since 1.0.0
 */
?>
<script id="tmpl-sponsorExternal" type="text/html">
	<div class="data">

		<p class="form-field form-row form-row-first upload_image">
			<a href="#" class="upload_image_button<# if ( data.image.thumbnail ) { #> remove<# } #>" data-cid="{{data.cid}}">
				<# if ( data.image.thumbnail ) { #>
					<img src="{{data.image.thumbnail}}">
				<# } else { #>
					<img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>">
				<# } #>
				
				<input type="hidden" name="wc_themes_sponsors[{{data.cid}}][image]" data-property="image" value="{{data.image.id}}" />
			</a>
		</p>

		<p class="form-field form-row form-row-last">
			<label><?php esc_html_e( 'Name', 'astoundify-wc-themes' ); ?></label>
			<input type="text" class="item-name short" name="wc_themes_sponsors[{{data.cid}}][name]" value="{{data.name}}" data-property="name" data-cid="{{data.cid}}" />
		</p>

		<p class="form-field form-row form-row-first">
			<label><?php esc_html_e( 'Email', 'astoundify-wc-themes' ); ?></label>
			<input type="text" class="sponsor-email short" name="wc_themes_sponsors[{{data.cid}}][email]" value="{{data.email}}" data-property="email" data-cid="{{data.cid}}" />
		</p>

		<p class="form-field form-row form-row-last">
			<label><?php esc_html_e( 'URL', 'astoundify-wc-themes' ); ?></label>
			<input type="text" class="sponsor-url short" name="wc_themes_sponsors[{{data.cid}}][url]" value="{{data.url}}" data-property="url" data-cid="{{data.cid}}" />
		</p>

	</div><!-- .data -->
</script>
