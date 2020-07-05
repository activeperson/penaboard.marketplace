<?php
/**
 * Customize.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Setup
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<p><?php esc_html_e( 'Manage the appearance and behavior of various theme components with the live customizer.', 'vendify' ); ?></p>

<ul>
	<li><a href="<?php echo esc_url_raw( admin_url( 'customize.php?autofocus[section]=style-kit' ) ); ?>"><?php esc_html_e( 'Choose a Style Kit', 'vendify' ); ?></a> <?php esc_html_e( 'or', 'vendify' ); ?> <a href="<?php echo esc_url_raw( admin_url( 'customize.php?autofocus[panel]=colors' ) ); ?>"><?php esc_html_e( 'change colors', 'vendify' ); ?></a></li>
	<li><a href="<?php echo esc_url_raw( admin_url( 'customize.php?autofocus[section]=font-pack' ) ); ?>"><?php esc_html_e( 'Choose a Font Pack', 'vendify' ); ?></a> <?php esc_html_e( 'or', 'vendify' ); ?> <a href="<?php echo esc_url_raw( admin_url( 'customize.php?autofocus[panel]=typography' ) ); ?>"><?php esc_html_e( 'change typography', 'vendify' ); ?></a></li>
</ul>

<p><a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary button-large"><?php esc_html_e( 'Launch Customizer', 'vendify' ); ?></a></p>
