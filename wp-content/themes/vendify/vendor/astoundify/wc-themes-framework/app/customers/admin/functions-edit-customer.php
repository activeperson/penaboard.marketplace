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
 * Add extra fields when editing a customer in the admin panel.
 *
 * @since 1.0.0
 *
 * @param WP_User $user Current user.
 */
function astoundify_wc_themes_customers_extra_profile_fields( $user ) {
?>

<h3><?php esc_html_e( 'Additional Information', 'astoundify-wc-themes' ); ?></h3>

<table class="form-table">
	<tr>
		<th>
			<label for="additional-role"><?php esc_html_e( 'Additional Role', 'astoundify-wc-themes' ); ?></label>
		</th>
		<td>
			<input type="text" name="additional-role" value="<?php echo esc_attr( get_the_author_meta( 'additional-role', $user->ID ) ); ?>" class="regular-text" />
		</td>
	</tr>
</table>

<?php
}
add_action( 'show_user_profile', 'astoundify_wc_themes_customers_extra_profile_fields' );
add_action( 'edit_user_profile', 'astoundify_wc_themes_customers_extra_profile_fields' );

/**
 * Save extra fields when editing a customer in the admin panel.
 *
 * @since 1.0.0
 *
 * @param WP_User $user Current user.
 */
function astoundify_wc_themes_customers_save_extra_profile_fields( $user_id ) {
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	if ( isset( $_POST['additional-role'] ) ) {
		update_user_meta( $user_id, 'additional-role', wp_kses_data( $_POST['additional-role'] ) );
	}
}
add_action( 'personal_options_update', 'astoundify_wc_themes_customers_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'astoundify_wc_themes_customers_save_extra_profile_fields' );
