<?php
/**
 * List Item
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @vars object $list \Astoundify\Favorites\Favorite_List
 */

namespace Astoundify\Vendify;

?>

<div class="msg-preview favorite-preview">
	<div class="msg-preview__content">
		<header class="msg-preview__header">
			<span class="msg-preview__sender">
				<a href="<?php echo esc_url( $list->get_url() ); ?>">
					<?php echo esc_html( $list->get_name() ); ?>
				</a>
			</span>

			<span class="msg-preview__date">

				<button class="sh-dropdown__toggle ml-auto mr-auto" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
					<?php svg( 'more' ); ?>
				</button>

				<div class="dropdown-menu dropdown-menu-right dropdown-menu--has-icons">
					<a href="<?php echo esc_url( $list->get_edit_url() ); ?>" class="dropdown-item astoundify-favorites-edit-list" data-af_list_id="<?php echo absint( $list->get_id() ); ?>" data-_nonce="<?php echo wp_create_nonce( 'astoundify_favorites_edit_' . $list->get_id() ); ?>">
						<?php
						svg(
							[
								'icon'    => 'edit',
								'classes' => [ 'ico--xs' ],
							]
						);

						esc_html_e( 'Edit', 'vendify' ); ?>
					</a>

					<a href="<?php echo esc_url( $list->get_remove_url() ); ?>" class="dropdown-item dropdown-item--delete astoundify-favorites-remove-list" data-af_list_id="<?php echo absint( $list->get_id() ); ?>" data-_nonce="<?php echo wp_create_nonce( 'astoundify_favorites_remove_' . $list->get_id() ); ?>">
						<?php
						svg(
							[
								'icon'    => 'delete',
								'classes' => [ 'ico--xs' ],
							]
						);

						esc_html_e( 'Remove', 'vendify' ); ?>
					</a>
				</div>
			</span>
		</header>

		<div class="msg-preview-body">
			<a href="<?php echo esc_url( $list->get_url() ); ?>"><?php printf( esc_html__( '%s items in this list', 'vendify' ), $list->get_count() ); ?></a>
		</div>
	</div>
</div>
