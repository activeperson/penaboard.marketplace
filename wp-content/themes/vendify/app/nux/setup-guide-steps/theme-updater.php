<?php
/**
 * The view template for the themeforest-update panel.
 *
 * @since 1.0.0
 */

namespace Astoundify\Vendify;

use Astoundify_Envato_Market_API;

$library = get_template_directory() . '/vendor/astoundify/themeforest-updater';

// Quit early if therer is no library.
if ( ! file_exists( $library . '/app/class-astoundify-themeforest-updater.php' ) ) {
	return;
}

// Load library.
include_once $library . '/app/class-envato-market-api.php';

$api               = Astoundify_Envato_Market_API::instance();
$is_valid_token    = $api->can_make_request_with_token();
$is_valid_purchase = apply_filters( 'astoundify_ci_allow_import', false ); ?>

<div id="step-status-theme-updater" class="step-status step-<?php ( ! $is_valid_token || ! $is_valid_purchase ) ? esc_attr_e( 'in', 'vendify' ) : ''; ?>complete" data-string-complete="<?php esc_html_e( 'Completed', 'vendify' ); ?>" data-string-incomplete="<?php esc_html_e( 'Not Complete', 'vendify' ); ?>">
	<?php if ( $is_valid_token && $is_valid_purchase ) {
		esc_html_e( 'Complete', 'vendify' );
	} else {
		esc_html_e( 'Not Complete', 'vendify' );
	} ?>
</div>

<p><?php esc_html_e( 'In order to receive automatic updates for your purchase please generate a personal token from ThemeForest.', 'vendify' ); ?></p>

<p><a href="https://build.envato.com/create-token/?purchase:download=t&purchase:verify=t&purchase:list=t" target="_blank" class="button"><?php esc_html_e( 'Generate a Token', 'vendify' ); ?></a></p>

<p><?php esc_html_e( 'Once generated, add the token below:', 'vendify' ); ?></p>

<form action="post" name="astoundify-updates-step" id="astoundify-add-update-token">
	<p>
		<strong><label for="token"><?php esc_html_e( 'Personal Token:', 'vendify' ); ?></label></strong><br />
		<input name="token" value="<?php echo esc_attr( get_option( '_vendify_themeforest_updater_token', false ) ); ?>" style="width: 60%;" />
		<?php submit_button( esc_html__( 'Save Token', 'vendify' ), 'primary', 'submit', false ); ?>
		<span class="button button-secondary" id="astoundify-updater-remove-token"><?php esc_html_e( 'Remove Token', 'vendify' ); ?></span>
		<?php wp_nonce_field( 'astoundify-add-token' ); ?>
	</p>
	<div class="spinner"></div>
</form>

<p class="api-connection">
	<?php esc_html_e( 'API Connection:', 'vendify' ); ?>
	<strong class="astoundify-setup-<?php echo $is_valid_token ? 'green' : 'red'; // WPCS: XSS ok. ?>">
		<?php echo esc_attr( $api->connection_status_label() ); ?>
	</strong>
</p>

<p class="purchase-status-display">
	<?php esc_html_e( 'Purchase Status:', 'vendify' ); ?>
	<strong class="astoundify-setup-<?php echo $is_valid_purchase ? 'green' : 'red'; // WPCS: XSS ok. ?>">
		<?php if ( $is_valid_purchase ) {
			esc_html_e( 'Valid', 'vendify' );
		} else {
			esc_html_e( 'Invalid', 'vendify' );
		} ?>
	</strong>
</p>

<script>
	jQuery(document).ready(function($) {
		$( '#astoundify-add-update-token' ).on( 'submit', function(e) {
			e.preventDefault();

			$form = $(this);

			var args = {
				action: 'astoundify_updater_set_token',
				token: $form.find( 'input[name=token]' ).val(),
				security: '<?php echo wp_create_nonce( 'astoundify-add-token' ); ?>'
			};

			$stepTitle = $( '#step-status-theme-updater' );
			$spinner = $( '#theme-updater .spinner' );
			$spinner.addClass( 'is-active' );

			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: args,
				dataType: 'json',
				success: function(response) {
					$status = $( '#theme-updater .api-connection strong' );

					if ( response.data.can_request ) {
						$stepTitle.text( $stepTitle.data( 'string-complete' ) ).removeClass( 'step-incomplete' ).addClass( 'step-complete' );
						$status.removeClass( 'astoundify-setup-red' ).addClass( 'astoundify-setup-green' );
					} else {
						$stepTitle.text( $stepTitle.data( 'string-incomplete' ) ).removeClass( 'step-complete' ).addClass( 'step-incomplete' );
						$status.removeClass( 'astoundify-setup-green' ).addClass( 'astoundify-setup-red' );
					}

					$purchase_status = $('.purchase-status-display strong');

					$purchase_status.removeClass( 'astoundify-setup-green astoundify-setup-red' );
					$('.wrap.setup-guide-steps').removeClass( 'purchase-status-valid purchase-status-invalid' );

					if( response.data.valid_purchase ) {
						$('.wrap.setup-guide-steps').addClass( 'purchase-status-valid' );
						$purchase_status.addClass( 'astoundify-setup-green' );
						$purchase_status.text( '<?php esc_html_e( 'Valid', 'vendify' ); ?>' );
					} else {
						$('.wrap.setup-guide-steps').addClass( 'purchase-status-invalid' );
						$purchase_status.addClass( 'astoundify-setup-red' );
						$purchase_status.text( '<?php esc_html_e( 'Invalid', 'vendify' ); ?>' );
					}

					$status.text( response.data.request_label );
					$spinner.removeClass( 'is-active' );
				}
			});
		});

		$( '#astoundify-updater-remove-token' ).on( 'click', function(e) {
			e.preventDefault();

			var confirm = window.confirm( '<?php esc_html_e( "Are you sure that you want to delete the token? Do not forget to keep a copy of the token, because Envato does not provide a way to recover it.", 'vendify' ); ?>' );

			if ( ! confirm ) {
				return;
			}

			var args = {
				action: 'astoundify_updater_remove_token',
				security: '<?php echo wp_create_nonce( 'astoundify-remove-token' ); ?>'
			};

			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: args,
				dataType: 'json',
				success: function(response) {
					window.location.reload();
				}
			});
		});

		$('.wrap.setup-guide-steps').addClass( 'purchase-status-<?php echo ($is_valid_purchase ? 'valid' : 'invalid' ); ?>' );
	});
</script>

<style>
#theme-updater .spinner {
	float: none;
	display: inline-block;
	margin-top: -2px;
	vertical-align: middle;
}

#astoundify-add-update-token p {
	display: inline-block;
	width: 100%;
}
.purchase-status-invalid #import-actions {
	display: none;
}
</style>
