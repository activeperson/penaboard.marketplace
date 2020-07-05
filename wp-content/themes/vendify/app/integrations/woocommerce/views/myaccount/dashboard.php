<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.6.0
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$activities = woocommerce_get_customer_activity(); ?>

<div class="row">

	<div id="astoundify-wc-themes-dashboard-activities" class="dashboard__main-column <?php if ( ! has_integration( 'private-messages' ) ) { ?>dashboard__only-column<?php } ?>">

		<?php wc_print_notices(); ?>

		<section class="activity">
			<header class="activity__header">
				<h3><?php esc_html_e( 'Recent Activity', 'vendify' ); ?></h3>

				<nav class="navigation">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#tab-all" role="tab">
								<?php esc_html_e( 'All', 'vendify' ); ?>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#tab-orders" role="tab">
								<?php esc_html_e( 'Purchases', 'vendify' ); ?>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#tab-reviews" role="tab">
								<?php esc_html_e( 'Reviews', 'vendify' ); ?>
							</a>
						</li>

						<?php if ( has_integration( 'favorites' ) ) { ?>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#tab-favorites" role="tab">
								<?php esc_html_e( 'Favorites', 'vendify' ); ?>
							</a>
						</li>
						<?php } ?>
					</ul>
				</nav>
			</header>

			<div class="activity__body tab-content">

				<?php foreach ( $activities as $activity => $items ) { ?>
					<div id="tab-<?php echo esc_attr( $activity ); ?>" class="tab-pane <?php echo 'all' === $activity ? 'active' : null; ?>" role="tabpanel">
						<?php
						if ( ! empty( $items ) ) {
							foreach ( $items as $item ) {
								wc_get_template( 'myaccount/partials/activity/' . $item['type'] . '.php', $item );
							}
						} else { ?>
							<p class="activity__none"><?php esc_html_e( 'No activity found.', 'vendify' ); ?></p>
						<?php } ?>
					</div>
				<?php } ?>

			</div>
		</section>

	</div>

	<?php view( 'app/integrations/private-messages/views/message-list' ); ?>

</div>
