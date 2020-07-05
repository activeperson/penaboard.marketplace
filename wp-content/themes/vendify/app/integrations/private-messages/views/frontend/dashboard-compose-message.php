<?php
/**
 * Dashboard - Compose New Message
 *
 * Displayed in the [private_messages] when creating a new message.
 * Also displayed in [private_message_compose] shortcode.
 *
 * @since 1.0.0
 * @version 1.8.0
 */

namespace Astoundify\Vendify;

use WP_User; ?>

<form action="" method="post" enctype="multipart/form-data" encoding="multipart/form-data">

	<div class="row">
		<p class="pm-form__row pm-form__row--recipient col-12 col-md-6 form-group">
			<label for="pm-recipient" class="pm-form__label label"><?php _e( 'To:', 'vendify' ); ?></label>

			<select id="pm-recipient" name="pm_recipient" class="pm-form__input custom-select" <?php disabled( true, $disable_to ); ?>>
				<?php
				if ( $recipient ) :
					$recipient = new WP_User( $recipient );
					?>
					<option value="<?php echo absint( $recipient->ID ); ?>">
						<?php echo esc_attr( pm_get_user_display_name( $recipient ) ); ?>
					</option>
				<?php else : ?>
					<option value=""><?php _e( 'Select a Recipient', 'vendify' ); ?></option>
				<?php endif; ?>
			</select>
		</p>

		<p class="pm-form__row pm-form__row--subject col-12 col-md-6 form-group">
			<label for="pm-subject" class="pm-form__label label"><?php _e( 'Subject:', 'vendify' ); ?></label>
			<input id="pm-subject" type="text" name="pm_subject" value="<?php echo esc_attr( $subject ); ?>" class="pm-form__input form-control" placeholder="<?php _e( 'Subject', 'vendify' ); ?>">
		</p>
	</div>

		<div class="card pm-form">
			<div class="pm-form">
				<?php pm_message_editor( $message ); ?>
			</div>

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

		</div>

</form>
