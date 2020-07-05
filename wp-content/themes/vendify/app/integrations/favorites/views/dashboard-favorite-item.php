<?php
/**
 * Favorite Item
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @var object $favorite \Astoundify\Favorites\Favorite
 */

namespace Astoundify\Vendify;

$type  = $favorite->get_target()->get_type();
$image = null;

if ( 'product' === $type ) {
	$product = wc_get_product( $favorite->get_target_id() );
	$image   = $product->get_image( 40 ); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped
} elseif ( has_integration( 'woocommerce-product-vendors' ) ) {
	$vendor = get_vendor_meta( $favorite->get_target_id() );
	$image = sprintf(
		'<img src="%s" alt="%s" />',
		isset( $vendor['logo_image'] ) ? esc_url( $vendor['logo_image'] ) : null,
		esc_html__( 'Logo', 'vendify' )
	);
} ?>

<div class="msg-preview favorite-preview">
	<div class="msg-preview__img">
		<?php echo $image; ?>
	</div>

	<div class="msg-preview__content">
		<header class="msg-preview__header">
			<span class="msg-preview__sender">
				<?php echo $favorite->get_target_link(); ?>
			</span>

			<span class="msg-preview__date">

				<button class="sh-dropdown__toggle ml-auto mr-auto" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
					<?php svg( 'more' ); ?>
				</button>

				<div class="dropdown-menu dropdown-menu-right dropdown-menu--has-icons">
					<a href="<?php echo esc_url( $favorite->get_edit_url() ); ?>" class="dropdown-item astoundify-favorites-edit-favorite" data-af_favorite_id="<?php echo absint( $favorite->get_id() ); ?>" data-_nonce="<?php echo wp_create_nonce( 'astoundify_favorites_create_' . $favorite->get_target_id() ); ?>" data-af_data="<?php echo absint( $favorite->get_target_id() ); ?>">
						<?php
						svg(
							[
								'icon'    => 'edit',
								'classes' => [ 'ico--xs' ],
							]
						);

						esc_html_e( 'Edit', 'vendify' ); ?>
					</a>

					<a href="<?php echo esc_url( $favorite->get_remove_url() ); ?>" class="dropdown-item dropdown-item--delete astoundify-favorites-remove-favorite" data-af_favorite_id="<?php echo absint( $favorite->get_id() ); ?>" data-_nonce="<?php echo wp_create_nonce( 'astoundify_favorites_remove_' . $favorite->get_target_id() ); ?>" data-af_data="<?php echo absint( $favorite->get_target_id() ); ?>">
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
			<?php echo $favorite->get_note_html(); // WPCS: XSS ok. ?>
		</div>
	</div>
</div>
