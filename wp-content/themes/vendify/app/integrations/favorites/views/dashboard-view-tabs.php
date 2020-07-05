<?php
/**
 * Dashboard View Tabs
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @var string $active_tab "favorites" or "lists"
 *
 * @package Favorites
 * @category Template
 * @author Astoundify
 */
?>

<div class="d-flex align-items-center">

	<ul class="nav nav-tabs nav-tabs--flush ml-5">
		<li class="nav-item <?php echo ( 'favorites' === $active_tab ) ? 'is-active' : ''; ?>">
			<a href="<?php echo esc_url( astoundify_favorites_dashboard_url( 'favorites' ) ); ?>" class="nav-link">
				<?php echo astoundify_favorites_label( 'Favorites' ); ?>
			</a>
		</li>

		<li class="nav-item <?php echo ( 'lists' === $active_tab ) ? 'is-active' : ''; ?>">
			<a href="<?php echo esc_url( astoundify_favorites_dashboard_url( 'lists' ) ); ?>" class="nav-link">
				<?php echo astoundify_favorites_label( 'Lists' ); ?>
			</a>
		</li>
	</ul>

	<?php if ( $favorite_list_query ) : ?>
	<div class="ml-auto mr-5">
		<a href="<?php echo esc_url( $favorite_list_query->get_create_list_url() ); ?>" class="badge badge-outline btn-sm astoundify-favorites-create-list" data-_nonce="<?php echo wp_create_nonce( 'astoundify_favorites_create_list' ); ?>"><?php esc_html_e( 'New List', 'vendify' ); ?></a>
	</div>
	<?php endif; ?>

</div>
