<?php
/**
 * Vendor Settings (taxonomy edit).
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Vendors
 * @author Astoundify
 */

/**
 * Add extra fields when editing a vendor in the admin panel.
 *
 * @since 1.0.0
 *
 * @param WP_Term $term Current term.
 */
function astoundify_wc_themes_vendors_admin_edit_form_fields( $term ) {
	$featured = get_term_meta( $term->term_id, 'vendor_featured', true );
?>

<tr class="form-field">
	<th scope="row" valign="top"><label for="wcpv-vendor-featured"><?php esc_html_e( 'Featured', 'astoundify-wc-themes' ); ?></label></th>

	<td>
		<input type="checkbox" name="vendor_data[featured]" value="1" <?php checked(1, $featured, true ); ?> />
		<p><?php esc_html_e( 'Feature this vendor? Used to highlight the vendor around your store.', 'astoundify-wc-themes' ); ?></p>
	</td>
</tr>

<?php
}
add_action( WC_PRODUCT_VENDORS_TAXONOMY . '_edit_form_fields', 'astoundify_wc_themes_vendors_admin_edit_form_fields', 90 );

/**
 * Save extra vendor data when editing in the admin panel.
 *
 * @since 1.0.0
 *
 * @param int $term_id ID of vendor editing.
 */
function astoundify_wc_themes_vendors_admin_save_vendor_fields( $term_id ) {
	if ( empty( $_POST['vendor_data'] ) ) {
		return;
	}

	$featured = isset( $_POST['vendor_data']['featured'] );

	if ( $featured ) {
		update_term_meta( $term_id, 'vendor_featured', $featured );
	} else {
		delete_term_meta( $term_id, 'vendor_featured' );
	}
}

add_action( 'edited_' . WC_PRODUCT_VENDORS_TAXONOMY, 'astoundify_wc_themes_vendors_admin_save_vendor_fields' );

/**
 * The settings page of a Vendor is static HTML so the only way we can add an extra field is to hook it this way.
 *
 * We are also forced to add our own custom JavaScript for media upload since the one used in the plugin is
 * targeted specifically for the logo.
 *
 * @param $term
 */
function astoundify_wc_themes_vendor_admin_add_cover_field ( $term ) {
	$vendor_data = get_term_meta( $term->term_id, 'vendor_data', true );

	$cover = ! empty( $vendor_data['cover'] ) ? $vendor_data['cover'] : '';

	$cover_image_size = ( has_image_size( 'cover' ) ? 'cover' : 'full' );

	$cover_image = isset( $vendor_data['cover'] ) ? wp_get_attachment_image_url( $vendor_data['cover'], $cover_image_size ) : false;

	$hide_remove_image_link = '';

	if ( empty( $cover_image ) ) {
		$hide_remove_image_link = 'display:none;';
	} ?>

	<tr class="form-field">
		<th scope="row" valign="top"><label for="wcpv-vendor-cover"><?php esc_html_e( 'Vendor Cover', 'astoundify-wc-themes' ); ?></label></th>

		<td>
			<input type="hidden" name="vendor_data[cover]" value="<?php echo esc_attr( $cover ); ?>" />
			<a href="#" class="wcpv-upload-cover button"><?php esc_html_e( 'Upload Cover', 'astoundify-wc-themes' ); ?></a>
			<br />
			<br />
			<?php if ( ! empty( $cover_image ) ) { ?>
				<img src="<?php echo esc_url( $cover_image ); ?>" class="wcpv-cover-preview-image" style="max-width: 100%"/>
			<?php } else { ?>
				<img src="" class="wcpv-cover-preview-image hide" />
			<?php } ?>

			<a href="#" class="wcpv-remove-cover dashicons dashicons-no" style="<?php echo esc_attr( $hide_remove_image_link ); ?>" title="<?php esc_attr_e( 'Click to remove image', 'astoundify-wc-themes' ); ?>"></a>
		</td>

		<script>
            jQuery('.taxonomy-wcpv_product_vendors, .toplevel_page_wcpv-vendor-settings').on('click', '.wcpv-upload-cover', function (e) {
                e.preventDefault();

                // create the media frame
                var i18n = wcpv_admin_local,
                    inputField = jQuery(this).parents('.form-field').find('input[name="vendor_data[cover]"]'),
                    previewField = jQuery(this).parents('.form-field').find('.wcpv-cover-preview-image'),
                    mediaFrame = wp.media.frames.mediaFrame = wp.media({
                        title: i18n.modalLogoTitle,
                        button: {
                            text: i18n.buttonLogoText
                        },
                        // only images
                        library: {
                            type: 'image'
                        },
                        multiple: false
                    });

                // after a file has been selected
                mediaFrame.on('select', function () {
                    var selection = mediaFrame.state().get('selection');

                    selection.map(function (attachment) {

                        attachment = attachment.toJSON();

                        if (attachment.id) {

                            // add attachment id to input field
                            inputField.val(attachment.id);

                            // show preview image
                            previewField.prop('src', attachment.url).removeClass('hide');

                            // show remove image icon
                            jQuery(inputField).parents('.form-field').find('.wcpv-remove-cover').show();
                        }
                    });
                });

                // open the modal frame
                mediaFrame.open();
            });

            jQuery('.taxonomy-wcpv_product_vendors, .toplevel_page_wcpv-vendor-settings').on('click', '.wcpv-remove-cover', function (e) {
                e.preventDefault();

                jQuery(this).hide();
                jQuery(this).parents('.form-field').find('.wcpv-cover-preview-image').prop('src', '').addClass('hide');
                jQuery('input[name="vendor_data[cover]"]').val('');
            });
		</script>
	</tr>

	<?php
}
add_action( WC_PRODUCT_VENDORS_TAXONOMY . '_edit_form_fields', 'astoundify_wc_themes_vendor_admin_add_cover_field', 5, 1 );
