<?php
/**
 * Edit customer avatar.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$user = wp_get_current_user();

// Load scripts.
// @see https://github.com/stuttter/wp-user-avatars/blob/master/wp-user-avatars/includes/admin.php#L118-L121
// URL & Version
$url = wp_user_avatars_get_plugin_url();
$ver = wp_user_avatars_get_asset_version();

// Enqueue
wp_enqueue_script( 'wp-user-avatars', $url . 'assets/js/user-avatars.js', [ 'jquery' ], $ver, true );
wp_enqueue_style( 'wp-user-avatars', $url . 'assets/css/user-avatars.css', [], $ver );

if ( is_rtl() ) {
	wp_enqueue_style( 'wp-user-avatars-rtl', $url . 'assets/css/user-avatars-rtl.css', [ 'wp-user-avatars' ], $ver );
}

// Localize
wp_localize_script(
	'wp-user-avatars',
	'i10n_WPUserAvatars',
	[
		'insertMediaTitle' => esc_html__( 'Choose an Avatar', 'vendify' ),
		'insertIntoPost'   => esc_html__( 'Set as avatar', 'vendify' ),
		'deleteNonce'      => wp_create_nonce( 'remove_wp_user_avatars_nonce' ),
		'mediaNonce'       => wp_create_nonce( 'assign_wp_user_avatars_nonce' ),
		'user_id'          => $user->ID,
	]
);

// User needs additional caps to upload avatars
if ( ! current_user_can( 'upload_avatar', $user->ID ) ) :
	return;
endif;

$remove_url = add_query_arg(
	[
		'user_id'  => $user->ID,
		'_wpnonce' => wp_create_nonce( 'remove_wp_user_avatars_nonce' ),
	],
	wc_get_account_endpoint_url( 'edit-account' )
);

wp_user_avatars_admin_enqueue_scripts();
?>

<h3 class="dashboard__subheading"><?php esc_html_e( 'Account Photo', 'vendify' ); ?></h3>

<div class="vendors-upload-field form-group form-group--upload">
	<div class="upload">
		<img class="upload__placeholder vendors-upload-thumbnail" src="<?php echo esc_url( ! empty( $user->wp_user_avatars ) ? get_avatar_url( $user->ID ) : get_template_directory_uri() . '/public/images/editor-avatar-placeholder.svg' ); ?>" alt="<?php esc_attr_e( 'User Avatar.', 'vendify' ) ?>" width="90" />
	</div>

	<div class="upload-info">
		<label class="custom-file" for="wp-user-avatars">
			<span class="button btn btn-sm btn-primary">
				<?php esc_html_e( 'Upload Photo', 'vendify' ); ?>
			</span>

			<a href="<?php echo esc_url( $remove_url ); ?>" class="avatar-remove btn-icon btn-icon--close" 
								<?php
								if ( empty( $user->wp_user_avatars ) ) {
									echo ' style="display:none;"';}
								?>
>
				<?php
				svg(
					[
						'icon'    => 'close',
						'classes' => [ 'ico--xs' ],
					]
				);
				?>
			</a>

			<input type="file" name="wp-user-avatars" id="wp-user-avatars" style="display: none;" />
		</label>

		<?php esc_html_e( '300px &times; 300px square recommended.', 'vendify' ); ?>
	</div>
</div>

<?php wp_nonce_field( 'wp_user_avatars_nonce', '_wp_user_avatars_nonce', false ); ?>

<script>
( function( $ ) {
	function getTempUrl( input ) {
		var reader = new FileReader();

		if ( input.files && input.files[0] ) {
			reader.readAsDataURL( input.files[0] );
		}

		return reader;
	}

	$( '#wp-user-avatars' ).change( function() {
		var url = getTempUrl(this);

		url.onload = function(e) {
			$( '.upload__placeholder' ).attr( 'src', e.target.result );
			$( '.avatar-remove' ).show();
		}
	} );
} )( jQuery );
</script>
