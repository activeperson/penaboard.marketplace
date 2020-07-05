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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<div id="astoundify-wc-themes-dashboard-activities">
	<h2 class="dashboard-section-title"><?php esc_html_e( 'Latest Activity', 'astoundify-wc-themes' ); ?></h2>

	<?php if ( ! empty( $activities_by_timestamp ) ) : ?>

		<ul>
			<?php foreach ( $activities_by_timestamp as $activity ) : ?>
				<li>
					<?php echo astoundify_wc_themes_vendors_activity_get_content( $activity ); ?>
				</li>
			<?php endforeach; ?>
		</ul>
	
	<?php else : ?>

		<p><?php esc_html_e( 'No activity found.', 'astoundify-wc-themes' ); ?></p>

	<?php endif; ?>

	<?php foreach ( $activities_by_groups as $group ) : if ( empty( $group['activities'] ) ) : continue; endif; ?>
		<h3><?php echo esc_attr( $group['label'] ); ?></h3>

		<ul>
			<?php foreach ( $group['activities'] as $activity ) : ?>
			<li>
				<?php echo astoundify_wc_themes_vendors_activity_get_content( $activity ); ?>
			</li>
			<?php endforeach; ?>
		</ul>
	<?php endforeach; ?>

</div>
