<?php
/**
 * Dashboard - Filters
 *
 * @since 1.0.0
 * @version 1.0.0
 */

namespace Astoundify\Vendify;

$url = add_query_arg(
	[
		'pm_mark_all_as_read' => wp_create_nonce( 'pm_mark_all_as_read' ),
	],
	get_permalink()
); ?>

<div class="d-flex align-items-center">

	<ul class="nav nav-tabs nav-tabs--flush ml-5">
		<li class="nav-item <?php echo ! isset( $_GET['pm_order'] ) || ( isset( $_GET['pm_order'] ) && 'desc' === $_GET['pm_order'] ) ? 'is-active' : null; ?>">
			<a href="<?php echo esc_url( add_query_arg( 'pm_order', 'desc', pm_get_permalink( 'dashboard' ) ) ); ?>" class="nav-link">
				<?php esc_html_e( 'Newest', 'vendify' ); ?>
			</a>
		</li>

		<li class="nav-item <?php echo isset( $_GET['pm_order'] ) && 'asc' === $_GET['pm_order'] ? 'is-active' : null; ?>">
			<a href="<?php echo esc_url( add_query_arg( 'pm_order', 'asc', pm_get_permalink( 'dashboard' ) ) ); ?>" class="nav-link">
				<?php esc_html_e( 'Oldest', 'vendify' ); ?>
			</a>
		</li>
	</ul>

	<div class="msg-toggles mr-5">

		<?php if ( isset( $_GET['pm_showing'] ) && 'starred' === $_GET['pm_showing'] ) : ?>
		<a href="<?php echo esc_url( remove_query_arg( 'pm_showing', pm_get_permalink( 'dashboard' ) ) ); ?>">
			<?php
			svg(
				[
					'icon'    => 'star',
					'classes' => [ 'ico--sm', 'is-active' ],
				]
			);

			esc_html_e( 'Starred', 'vendify' ); ?>
		</a>
		<?php else : ?>
		<a href="<?php echo esc_url( add_query_arg( 'pm_showing', 'starred', pm_get_permalink( 'dashboard' ) ) ); ?>">
			<?php
			svg(
				[
					'icon'    => 'star-outline',
					'classes' => [ 'ico--sm' ],
				]
			);

			esc_html_e( 'Starred', 'vendify' ); ?>
		</a>
		<?php endif; ?>

		<div class="ml-5">
			<?php if ( isset( $_GET['pm_showing'] ) && 'unread' === $_GET['pm_showing'] ) : ?>
			<a href="<?php echo esc_url( remove_query_arg( 'pm_showing', pm_get_permalink( 'dashboard' ) ) ); ?>">
				<?php
				svg(
					[
						'icon'    => 'unread',
						'classes' => [ 'ico--sm' ],
					]
				);

				esc_html_e( 'Unread', 'vendify' ); ?>
			</a>
			<?php else : ?>
			<a href="<?php echo esc_url( add_query_arg( 'pm_showing', 'unread', pm_get_permalink( 'dashboard' ) ) ); ?>">
				<?php
				svg(
					[
						'icon'    => 'unread',
						'classes' => [ 'ico--sm', 'is-active' ],
					]
				);

				esc_html_e( 'Unread', 'vendify' ); ?>
			</a>
			<?php endif; ?>
		</div>

		<div class="ml-5">
			<?php echo pm_get_mark_all_as_read_link(); ?>
		</div>

		<?php if ( pm_can_compose_from_dashboard() ) { ?>
		<div class="ml-5">
			<a href="<?php echo esc_url( pm_get_new_message_url() ); ?>" class="badge badge-outline-gray-400 btn-sm"><?php _e( 'New Message', 'vendify' ); ?></a>
		</div>
		<?php } ?>

	</div>

</div>
