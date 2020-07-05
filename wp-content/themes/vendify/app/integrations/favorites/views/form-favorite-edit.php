<?php
/**
 * Edit Favorite Item
 * User can change the list and edit note of a favorite here.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @var object $favorite \Astoundify\Favorites\Favorite Class.
 * @var string $nonce Nonce Action "astoundify_favorites_edit_{$favorite_id}".
 * @var string $redirect Redirect URL after submit.
 */
?>

<?php astoundify_favorites_notices(); ?>

<div class="modal-content">
	<header class="modal-header">
		<h4 class="modal-title text-center">
			<?php echo esc_html_e( 'Edit', 'vendify' ); ?>
		</h4>
	</header>

	<div class="modal-body">

		<form class="astoundify-favorites-form-favorite-edit" method="post">

			<?php astoundify_favorites_note_field( [ 'note' => $favorite->get_note() ] ); ?>
			<?php astoundify_favorites_list_field( [ 'selected' => $favorite->get_list_id() ] ); ?>

			<div class="astoundify-favorites-submit-field">
				<button type="submit" class="btn btn-primary"><?php _e( 'Save', 'vendify' ); ?></button>
				<a href="<?php echo esc_url( $favorite->get_remove_url() ); ?>" class="btn btn-outline-danger"><?php esc_html_e( 'Remove', 'vendify' ); ?></a>
			</div>

			<input type="hidden" name="_favorite" value="<?php echo esc_attr( $favorite->get_id() ); ?>"/>
			<input type="hidden" name="_target" value="<?php echo esc_attr( $favorite->get_target_id() ); ?>"/>
			<input type="hidden" name="_redirect" value="<?php echo esc_url( $redirect ); ?>"/>
			<?php wp_nonce_field( $nonce, '_nonce' ); ?>

		</form>

	</div>
</div>
