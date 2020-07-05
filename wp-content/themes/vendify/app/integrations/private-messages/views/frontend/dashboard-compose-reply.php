<?php
/**
 * Dashboard - Compose Reply
 *
 * Displayed in the [private_messages] when replying a message.
 *
 * @since 1.0.0
 * @version 1.0.0
 */

namespace Astoundify\Vendify;

?>

<footer class="cnv__footer">

	<form action="" method="POST" class="pm-form pm-form--compose-message" enctype="multipart/form-data" encoding="multipart/form-data">
		<?php pm_message_editor( $message ); ?>

		<div class="cnv__actions">
			<div class="ml-auto"></div>

			<?php if ( pm_can_upload_attachments() ) : ?>
				<label for="pm_attachments">
					<span class="screen-reader-text"><?php _e( 'Attachments:', 'vendify' ); ?></span>
					<input id="pm_attachments" name="pm_attachments[]" multiple="multiple" type="file" class="custom-file-input" />

					<?php
					svg(
						[
							'icon'    => 'attachment',
							'classes' => [ 'ico--sm' ],
						]
					)
					?>
				</label>
			<?php endif; ?>

			<button id="pm_send_message" type="submit" class="btn-icon cnv__btn-send">
				<?php
				svg(
					[
						'icon'    => 'send',
						'classes' => [ 'ico--sm' ],
					]
				)
				?>
			</button>

			<?php wp_nonce_field( 'pm_message_nonce', 'pm_message_nonce' ); ?>
		</div>
	</form>

</footer>
