<?php
/**
 * Dashboard - View Message
 *
 * Display a single message. Includes:
 *
 * - Link to Dashboard.
 * - List of replies in the message.
 * - Compose Reply form.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Theme
 * @author Astoundify
 *
 * @var array  $messages
 * @var object $thread
 */

namespace Astoundify\Vendify;

use Private_Messages_Templates;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
} ?>

<header class="cnv__title">
	<a href="<?php the_permalink(); ?>" class="btn-icon">
		<?php
		svg(
			[
				'icon'    => 'caret-slider-left',
				'classes' => [ 'ico--lg' ],
			]
		); ?>
	</a>

	<h3><?php echo esc_attr( get_the_title( $thread->ID ) ); ?></h3>
</header>

<div class="cnv__card">

	<header class="cnv__header">
		<?php if ( get_option( 'show_avatars', true ) ) { ?>
			<div class="cnv__sender__avatar">
				<?php echo pm_get_avatar( $thread->get_recipient_id(), 56 ); // WPCS: XSS ok. ?>
			</div>
		<?php } ?>

		<div class="cnv__sender__body">
			<?php
			if ( has_integration( 'woocommerce-product-vendors' ) ) {
				$vendor_meta = get_vendor_meta( $thread->get_recipient_id(), 'user_id' );

				if ( $vendor_meta['term_id'] ) { ?>

					<span class="cnv__sender__name"><?php echo esc_html( $vendor_meta['display_name'] ); ?></span>

					<?php if ( $vendor_meta['location'] ) { ?>
						<span class="cnv__sender__city"><?php echo esc_html( $vendor_meta['location'] ); ?></span>
					<?php }

				} else { ?>

					<span class="cnv__sender__name"><?php echo esc_html( $thread->get_recipient()->display_name ); ?></span>

				<?php }
			} ?>
		</div>
	</header>

	<div class="cnv__body">
		<div class="cnv_message-wrap">

			<?php
			foreach ( $messages as $id => $message ) :

				if ( $message->is_deleted() ) {
					continue; // Skip if message is deleted/archived by user.
				} ?>

				<div class="cnv-message <?php echo esc_attr( (int) $message->get_author_id() === get_current_user_id() ? 'is-from-current-user' : null ); ?>" id="message-<?php echo esc_attr( $id ); ?>">
					<header class="cnv__message__header">
						<?php if ( get_option( 'show_avatars', true ) ) { ?>
							<span class="cnv__sender__avatar">
								<?php echo pm_get_avatar( $message->get_author_id(), 26 ); // WPCS: XSS ok. ?>
							</span>
						<?php } ?>

						<span class="cnv__sender__name"><?php echo esc_attr( $message->get_author_name() ); ?></span>

						<span class="cnv__sender__date">
							<?php
							// Translators: %s message date.
							echo esc_attr( sprintf( __( '%s ago', 'vendify' ), human_time_diff( strtotime( $message->get_date() . $message->get_time() ), current_time( 'timestamp' ) ) ) );

							echo Private_Messages_Templates::get_template( // WPCS: XSS ok.
								'frontend/dashboard-message-actions-delete.php',
								[
									'message' => $message,
								]
							); ?>
						</span>
					</header>

					<div class="cnv__message__body">
						<?php echo apply_filters( 'the_content', $message->get_content() ); // WPCS: XSS ok. ?>
					</div>
				</div>

				<?php
				if ( pm_get_option( 'pm_allow_attachments', true ) ) {

					echo Private_Messages_Templates::get_template( // WPCS: XSS ok.
						'frontend/dashboard-message-attachments.php',
						[
							'message' => $message,
						]
					);
				}

			endforeach; ?>

		</div>
	</div>

	<?php
	$receiver = get_current_user_id() === $thread->get_author_id() ? $thread->get_recipient_id() : $thread->get_author_id();

	if ( ! $thread->is_deleted( $receiver ) ) {
		echo Private_Messages_Templates::get_template( // WPCS: XSS ok.
			'frontend/dashboard-compose-reply.php',
			[
				'message' => '',
			]
		);
	} ?>

</div>
