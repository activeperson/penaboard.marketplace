<?php
/**
 * User Favorites Query
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @vars object $favorite_query \Astoundify\Favorites\Favorite_Query
 */
?>

<?php astoundify_favorites_notices(); ?>

<div id="astoundify-favorites-dashboard-favorites">
	<?php
	astoundify_favorites_get_template(
		'dashboard-view-tabs',
		[
			'active_tab'          => 'favorites',
			'favorite_list_query' => false,
		]
	);
	?>

	<div class="card">
		<p id="astoundify-favorite-0" class="pm-no-messages" style="<?php if ( $favorite_query->favorites ) echo 'display:none;'; ?>">
			<?php
			// Translators: %s is favorites.
			printf( esc_html__( 'You currently have no %s', 'vendify' ), astoundify_favorites_label( 'favorites' ) );
			?>
		</p>

		<?php foreach ( $favorite_query->favorites as $favorite ) : ?>
			<?php
			astoundify_favorites_get_template(
				'dashboard-favorite-item',
				[
					'favorite' => $favorite,
				]
			);
			?>
		<?php endforeach; ?>
	</div>

</div><!-- #astoundify-favorites-dashboard-favorites -->

<?php $favorite_query->pagination(); ?>
