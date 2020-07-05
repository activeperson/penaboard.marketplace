<?php
/**
 *
 */
?>

<div class="msg-preview__content">
	<header class="msg-preview__header">
		<span class="msg-preview__sender">
			<a href="<?php echo esc_url( $thread->get_url() ); ?>#message-<?php echo esc_attr( $last_message->ID ); ?>">
				<?php echo esc_attr( pm_get_user_display_name( $recipient ) ); ?>
			</a>
		</span>

		<span class="msg-preview__date">
			<?php
			printf( esc_html__( '%s ago', 'vendify' ), human_time_diff( strtotime( $last_message->data->comment_date ), current_time( 'timestamp' ) ) );

			if ( ! isset( $type ) ) :
				echo Private_Messages_Templates::get_template(
					'frontend/dashboard-messages-actions-star.php',
					[
						'starred' => $thread->is_starred(),
						'thread'  => $thread,
					]
				);

				echo Private_Messages_Templates::get_template(
					'frontend/dashboard-messages-actions-delete.php',
					[
						'thread' => $thread,
					]
				);
			endif;
			?>
		</span>
	</header>

	<div class="msg-preview-body">
		<a href="<?php echo esc_url( $thread->get_url() ); ?>#message-<?php echo esc_attr( $last_message->ID ); ?>">
			<?php echo esc_html( $last_message->get_content( 20 ) ); ?>
		</a>
	</div>
</div>
