<?php
/**
 * Dashboard Page: Activities Section
 *
 * @var array $activities_by_timestamp Activities by timezone.
 * @var array $activities_by_groups Activities by groups.
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
	exit; // Exit if accessed directly.
} ?>

<div class="row">
	<div id="astoundify-wc-themes-dashboard-activities" class="dashboard__main-column <?php if ( ! has_integration( 'private-messages' ) ) { ?>dashboard__only-column<?php } ?>">

		<section class="activity">
			<header class="activity__header">
				<h3><?php esc_html_e( 'Recent Activity', 'vendify' ); ?></h3>

				<nav class="navigation">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#tab-all" role="tab">All</a>
						</li>

						<?php
						foreach ( $activities_by_groups as $group ) {
							if ( empty( $group['activities'] ) ) {
								continue;
							} ?>
						<li class="nav-item">
							<a class="nav-link" href="#tab-<?php echo sanitize_title( $group['label'] ); ?>" data-toggle="tab" role="tab"><?php echo esc_html( $group['label'] ); ?></a>
						</li>
						<?php } ?>
					</ul>
				</nav>
			</header>

			<div class="activity__body tab-content">
				<div id="tab-all" class="tab-pane active" role="tabpanel">
					<?php
					if ( ! empty( $activities_by_timestamp ) ) {
						foreach ( $activities_by_timestamp as $activity ) {
							echo astoundify_wc_themes_vendors_activity_get_content( $activity );
						}
					} else { ?>
						<p class="activity__none"><?php esc_html_e( 'No activity found.', 'vendify' ); ?></p>
					<?php } ?>
				</div>

				<?php
				foreach ( $activities_by_groups as $group ) {
					if ( empty( $group['activities'] ) ) {
						continue;
					} ?>
					<div id="tab-<?php echo sanitize_title( $group['label'] ); ?>" class="tab-pane" role="tabpanel">
						<?php
						foreach ( $group['activities'] as $activity ) {
							echo astoundify_wc_themes_vendors_activity_get_content( $activity );
						} ?>
					</div>
				<?php } ?>
			</div>
		</section>

	</div>

	<?php view( 'app/integrations/private-messages/views/message-list' ); ?>
</div>
