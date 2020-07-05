<?php
/**
 * Plugin installer.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Setup
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Load Astoundify Plugin Installer
 *
 * @see https://github.com/astoundify/wp-plugin-installer
 *
 * @since 1.0.0
 */
function plugin_installer() {
	$lib = get_template_directory() . '/vendor/astoundify/wp-plugin-installer';

	if ( file_exists( $lib . '/astoundify-plugininstaller.php' ) ) {
		include_once $lib . '/astoundify-plugininstaller.php';

		// Setup.
		astoundify_plugininstaller(
			[
				'plugins'       => [ 'woocommerce', 'woo-gutenberg-products-block', 'safe-svg', 'if-menu', 'wp-user-avatars', /* 'private-messages', 'favorites' */ ],
				'forceActivate' => true,
				'l10n'          => [
					'buttonActivePlugin'    => esc_html__( 'Active', 'vendify' ),
					'buttonErrorActivating' => esc_html__( 'Error', 'vendify' ),
					// Translators: %s Plugin name.
					'activationFailed'      => esc_html__( 'Activation failed: %s', 'vendify' ),
					'invalidPlugin'         => esc_html__( 'Invalid plugin supplied.', 'vendify' ),
					'invalidNonce'          => esc_html__( 'Invalid nonce supplied.', 'vendify' ),
					'invalidCap'            => esc_html__( 'You do not have permission to install plugins on this site.', 'vendify' ),
					'activateAll'           => esc_html__( 'Install and Activate All', 'vendify' ),
					'activateAllComplete'   => esc_html__( 'Complete', 'vendify' ),
				],
				'install_url'   => get_template_directory_uri() . '/vendor/astoundify/wp-plugin-installer',
			]
		);
	}
}
add_action( 'admin_init', 'Astoundify\Vendify\plugin_installer', 5 );

/**
 * Display static plugin cards to buy/download extra plugins.
 *
 * @since 1.0.0
 */
function plugin_installer_extras() { ?>

<div class="plugin-card plugin-card-woocommerce-product-vendors">
	<div class="plugin-card-top">
		<div class="name column-name">
			<h3>
				<a href="https://astoundify.com/go/woocommerce-product-vendors/">
					<?php esc_html_e( 'WooCommerce Product Vendors', 'vendify' ); ?>
					<img src="<?php echo esc_url( get_template_directory_uri() . '/public/images/woocommerce.svg' ); ?>" class="plugin-icon" alt="<?php esc_attr_e( 'Logo.', 'vendify' ); ?>">
				</a>
			</h3>
		</div>
		<div class="action-links">
			<ul class="plugin-action-buttons">
				<?php if ( class_exists( 'WC_Product_Vendors' ) ) { ?>
					<li><button type="button" class="button button-disabled" disabled="disabled"><?php esc_html_e( 'Active', 'vendify' ); ?></button></li>
					<li><a href="https://astoundify.com/go/woocommerce-product-vendors/" aria-label="<?php esc_html_e( 'More information about WooCommerce', 'vendify' ); ?>"><?php esc_html_e( 'More Details', 'vendify' ); ?></a></li>
				<?php } else { ?>
					<li><a href="https://astoundify.com/go/woocommerce-product-vendors/" class="button button-primary"><?php esc_html_e( 'Download', 'vendify' ); ?></a></li>
					<li><a href="<?php echo esc_url( admin_url( 'plugin-install.php?tab=upload' ) ); ?>"><?php esc_html_e( 'Install', 'vendify' ); ?></a></li>
				<?php } ?>
			</ul>
		</div>
		<div class="desc column-description">
			<p><?php esc_html_e( 'Set up a multi-vendor marketplace that allows vendors to manage their own products and earn commissions By Automattic.', 'vendify' ); ?></p>
			<p class="authors"> <cite><?php esc_html_e( 'By', 'vendify' ); ?> <a href="https://woocommerce.com"><?php esc_html_e( 'Automattic', 'vendify' ); ?></a></cite></p>
		</div>
	</div>
</div>

<div class="plugin-card">
	<div class="plugin-card-top">
		<div class="name column-name">
			<h3>
				<a href="http://astoundify.com/products/favorites">
				<?php esc_html_e( 'Favorites', 'vendify' ); ?>
					<img src="<?php echo esc_url( get_template_directory_uri() . '/public/images/favorites.svg' ); ?>" class="plugin-icon" alt="<?php esc_html_e( 'Favorites', 'vendify' ); ?>">
				</a>
			</h3>
		</div>

		<div class="action-links">
			<ul class="plugin-action-buttons">
				<?php if ( defined( 'ASTOUNDIFY_FAVORITES_VERSION' ) ) { ?>
					<li><button type="button" class="button button-disabled" disabled="disabled"><?php esc_html_e( 'Active', 'vendify' ); ?></button></li>
				<?php } else { ?>
					<li><a href="https://astoundify.com/account/downloads" class="button button-primary"><?php esc_html_e( 'Download', 'vendify' ); ?></a></li>
					<li><a href="<?php echo esc_url( admin_url( 'plugin-install.php?tab=upload' ) ); ?>"><?php esc_html_e( 'Install', 'vendify' ); ?></a></li>
				<?php } ?>
			</ul>
		</div>

		<div class="desc column-description">
			<p><?php esc_html_e( 'Create organized lists of favorited products and vendors.', 'vendify' ); ?></p>
		</div>
	</div>

	<div class="plugin-card-bottom">
		<p>
			<?php echo sprintf(
				esc_html__( 'Please %1$sdownload%3$s and %2$sinstall%3$s this plugin purchase from Astoundify.com', 'vendify' ),
				'<a href="' . esc_url( 'https://astoundify.com/account/downloads/' ) . '">',
				'<a href="' . esc_url( admin_url( 'plugin-install.php?tab=upload' ) ) . '">',
				'</a>'
			); ?>
		</p>
	</div>
</div>

<?php // if ( has_integration( 'private-messages' ) ) : ?>
<div class="plugin-card">
	<div class="plugin-card-top">
		<div class="name column-name">
			<h3>
		<!--<a href="https://astoundify.com/checkout/?edd_action=add_to_cart&download_id=54115&discount=THANKYOU">-->
				<a href="https://astoundify.com/products/private-messages/">
					<?php esc_html_e( 'Private Messages', 'vendify' ); ?>
					<img src="<?php echo esc_url( get_template_directory_uri() . '/public/images/private-messages.svg' ); ?>" class="plugin-icon" alt="<?php esc_html_e( 'Private Messages', 'vendify' ); ?>">
				</a>
			</h3>
		</div>

		<div class="action-links">
			<ul class="plugin-action-buttons">
				<?php if ( class_exists( 'Private_Messages' ) ) { ?>
					<li><button type="button" class="button button-disabled" disabled="disabled"><?php esc_html_e( 'Active', 'vendify' ); ?></button></li>
				<?php } else { ?>
					<li><a href="https://astoundify.com/account/downloads" class="button button-primary"><?php esc_html_e( 'Download', 'vendify' ); ?></a></li>
					<li><a href="<?php echo esc_url( admin_url( 'plugin-install.php?tab=upload' ) ); ?>"><?php esc_html_e( 'Install', 'vendify' ); ?></a></li>
				<?php } ?>
			</ul>
		</div>

		<div class="desc column-description">
			<p><?php esc_html_e( 'Allow your users to easily communicate one-on-one by sending private messages to each other directly.', 'vendify' ); ?></p>
		</div>
	</div>

	<div class="plugin-card-bottom">
		<p>
		<?php echo sprintf(
			esc_html__( 'Please %1$sdownload%3$s and %2$sinstall%3$s this plugin purchase from Astoundify.com', 'vendify' ),
			'<a href="' . esc_url( 'https://astoundify.com/account/downloads/' ) . '">',
			'<a href="' . esc_url( admin_url( 'plugin-install.php?tab=upload' ) ) . '">',
			'</a>'
		); ?>
		</p>
	</div>
</div>
<?php }
add_action( 'astoundify_plugininstaller_list_start', 'Astoundify\Vendify\plugin_installer_extras' );
