<?php
/**
 * User Favorite Lists Query
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @vars object $favorite_list_query \Astoundify\Favorites\Favorite_List_Query
 */
?>

<?php
astoundify_favorites_get_template(
	'dashboard-view-tabs',
	[
		'active_tab'          => 'lists',
		'favorite_list_query' => $favorite_list_query,
	]
);
?>

<?php astoundify_favorites_notices(); ?>

<div class="card">

	<p id="astoundify-favorite-0" class="pm-no-messages" style="display:<?php printf( '%s', $favorite_list_query->lists ? 'none;' : 'block' ); ?>">
		<?php
		// Translators: %s is favorites.
		printf( __( 'You currently have no %s', 'vendify' ), astoundify_favorites_label( 'lists' ) );
		?>
	</p>

	<?php foreach ( $favorite_list_query->lists as $list ) : ?>
		<?php
		astoundify_favorites_get_template(
			'dashboard-list-item',
			[
				'list' => $list,
			]
		);
		?>
	<?php endforeach; ?>

</div><!-- #astoundify-favorites-dashboard-lists -->
