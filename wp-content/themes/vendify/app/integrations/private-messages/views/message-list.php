<?php
/**
 * Simple message list for current user.
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

if ( ! has_integration( 'private-messages' ) ) :
	return;
endif;

$messages = pm_get_conversations(
	[
		'limit' => 5,
	]
); ?>

<aside class="dashboard__sidebar">
	<h4 class="mb-4"><?php esc_html_e( 'Recent Messages', 'vendify' ); ?></h4>

	<div class="dashboard__messages">
		<?php if ( empty( $messages['threads'] ) ) : ?>
			<div class="msg-preview"><?php esc_html_e( 'You have no messages.', 'vendify' ); ?></div>
		<?php else : ?>
			<?php
			foreach ( $messages['threads'] as $thread ) :
				$thread       = pm_get_thread( $thread->ID );
				$recipient    = $thread->get_recipient();
				$messages     = $thread->get_messages();
				$last_message = array_pop( $messages ); ?>
				<div class="msg-preview">
					<?php
					echo Private_Messages_Templates::get_template( // WPCS: XSS ok.
						'frontend/dashboard-messages-recipient.php',
						[
							'thread'       => $thread,
							'recipient'    => $recipient,
							'last_message' => $last_message,
						]
					);

					echo Private_Messages_Templates::get_template( // WPCS: XSS ok.
						'frontend/dashboard-messages-overview.php',
						[
							'thread'       => $thread,
							'recipient'    => $recipient,
							'last_message' => $last_message,
							'type'         => 'simple',
						]
					); ?>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</aside>
