<?php echo Private_Messages_Templates::get_template( 'frontend/dashboard-filters.php' ); ?>

<div class="card">

	<?php if ( ! empty( $my_messages ) ) : ?>

		<?php foreach ( $my_messages as $key => $row ) : ?>
			
			<div class="msg-preview">
				<?php foreach ( $row as $key => $column ) : ?>
					<?php echo sprintf( '%s', $column ); ?>
				<?php endforeach; ?>
			</div>

		<?php endforeach; ?>

	<?php else : ?>

		<p class="pm-no-messages"><?php _e( 'No Messages', 'vendify' ); ?></p>

	<?php endif; ?>

</div>
