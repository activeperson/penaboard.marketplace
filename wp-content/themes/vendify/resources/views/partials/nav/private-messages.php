<?php
/**
 * Nav private messages.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

use Private_Messages_Templates;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// No integration.
if ( ! has_integration( 'private-messages' ) || ! display_header_icon( 'header-private-messages', 'user-only' ) ) {
	return;
}

$messages = pm_get_conversations(
	[
		'limit' => 5,
	]
); ?>

<div class="sh-dropdown d-none d-md-flex ml-fluid">
	<button class="sh-dropdown__toggle" data-toggle="dropdown">
		<?php
		svg( 'message' );

		if ( 0 !== (int) pm_get_unread_count( get_current_user_id() ) ) { ?>
			<span class="icon-badge"><?php echo esc_html( pm_get_unread_count( get_current_user_id() ) ); ?></span>
		<?php } ?>
	</button>

	<div class="dropdown-menu dropdown-menu-right dropdown--private-messages">
		<?php if ( empty( $messages['threads'] ) ) { ?>
			<div class="msg-preview"><?php esc_html_e( 'You have no messages.', 'vendify' ); ?></div>
		<?php } else {
			foreach ( $messages['threads'] as $thread ) {
				$thread       = pm_get_thread( $thread->ID );
				$recipient    = $thread->get_recipient();
				$messages     = $thread->get_messages();
				$last_message = array_pop( $messages );

				if ( empty( $last_message ) ) {
					continue;
				} ?>
				<div class="msg-preview">
					<?php
					echo Private_Messages_Templates::get_template(
						'frontend/dashboard-messages-recipient.php',
						[
							'thread'       => $thread,
							'recipient'    => $recipient,
							'last_message' => $last_message,
						]
					);

					echo Private_Messages_Templates::get_template(
						'frontend/dashboard-messages-overview.php',
						[
							'thread'       => $thread,
							'recipient'    => $recipient,
							'last_message' => $last_message,
							'type'         => 'simple',
						]
					); ?>
				</div>
			<?php }
		} ?>

		<div class="dropdown-menu__more">
			<a href="<?php echo esc_url( pm_get_permalink( 'dashboard' ) ); ?>">
				<span class="link link-cta text-xs">
					<?php esc_html_e( 'View All', 'vendify' ); ?>
				</span>
				<?php
					svg(
						[
							'icon'    => 'long-arrow-right',
							'classes' => [ 'ico--xs', 'ml-2' ],
						]
					); ?>
			</a>
		</div>
	</div>

</div>
