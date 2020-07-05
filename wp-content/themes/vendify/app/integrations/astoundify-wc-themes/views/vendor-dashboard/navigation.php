<?php
/**
 * Vendor Dashboard Navigation
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'astoundify_wc_themes_before_vendor_dashboard_navigation' ); ?>

<nav class="navigation navigation--dashboard">
	<div class="container">
		<ul class="nav nav-tabs">

			<?php foreach ( astoundify_wc_themes_vendors_get_dashboard_menu_items() as $endpoint => $label ) : ?>
				<li class="<?php echo esc_attr( astoundify_wc_themes_get_vendors_dashboard_menu_item_classes( $endpoint ) ); ?> nav-item">
					<a href="<?php echo esc_url( astoundify_wc_themes_vendors_get_dashboard_endpoint_url( $endpoint ) ); ?>" class="nav-link">
						<?php echo esc_html( $label );

						if ( 'vendor-orders' === $endpoint ) :
							$count = astoundify_wc_themes_vendors_get_vendor_unfulfilled_products();

							if ( 0 !== $count ) : ?>
								<span class="badge badge--sm badge--pill badge-secondary"><?php echo esc_html( $count ); ?></span>
							<?php else : ?>
								<span class="badge badge--sm badge--pill badge-outline-gray-500">0</span>
							<?php endif; ?>
						<?php endif; ?>
					</a>
				</li>
			<?php endforeach; ?>

			<?php if ( has_integration( 'private-messages' ) ) : ?>
			<li class="nav-item">
				<a href="<?php echo esc_url( pm_get_permalink( 'dashboard' ) ); ?>" class="nav-link">
					<?php esc_html_e( 'Messages', 'vendify' ); ?>

					<?php if ( 0 !== (int) pm_get_unread_count( get_current_user_id() ) ) : ?>
						<span class="badge badge--sm badge--pill badge-secondary"><?php echo esc_html( pm_get_unread_count( get_current_user_id() ) ); ?></span>
					<?php else : ?>
						<span class="badge badge--sm badge--pill badge-outline-gray-500">0</span>
					<?php endif; ?>
				</a>
			</li>
			<?php endif; ?>

			<li class="nav-item">
				<a href="<?php echo esc_url( wp_logout_url( get_permalink() ) ); ?>" class="nav-link"><?php esc_html_e( 'Logout', 'vendify' ); ?></a>
			</li>

		</ul>
	</div>
</nav>

<?php do_action( 'astoundify_wc_themes_after_vendor_dashboard_navigation' ); ?>
