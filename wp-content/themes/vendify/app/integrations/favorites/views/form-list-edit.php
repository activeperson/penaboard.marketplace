<?php
/**
 * List Edit
 * This will display create/edit form
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @var object $list \Astoundify\Favorites\Favorite_List
 * @var string $nonce Nonce Action "astoundify_favorites_create_list" / "astoundify_favorites_edit_{$list_id}"
 * @var string $redirect Redirect URL after submit.
 */
?>

<?php astoundify_favorites_notices(); ?>

<div class="modal-content">
	<header class="modal-header">
		<h4 class="modal-title text-center">
			<?php echo '' === $list->get_name() ? esc_html__( 'New List', 'vendify' ) : $list->get_name(); ?>
		</h4>
	</header>

	<div class="modal-body">

		<form class="astoundify-favorites-form-list-edit" method="post">

			<div class="form-group">
				<?php astoundify_favorites_list_name_field( [ 'list_name' => $list->get_name() ] ); ?>
			</div>

			<div class="astoundify-favorites-submit-field">
				<button type="submit" class="btn btn-primary"><?php _e( 'Save', 'vendify' ); ?></button>

				<a href="<?php echo esc_url( $list->get_remove_url() ); ?>" class="btn btn-outline-danger"><?php esc_html_e( 'Remove', 'vendify' ); ?></a>
			</div><!-- . astoundify-favorites-submit-field -->

			<input type="hidden" name="_list" value="<?php echo esc_attr( $list->get_id() ); ?>"/>
			<input type="hidden" name="_redirect" value="<?php echo esc_url( $redirect ); ?>"/>
			<?php wp_nonce_field( $nonce, '_nonce' ); ?>

		</form><!-- .astoundify-favorites-form-list-edit -->
	
	</div>
</div>
