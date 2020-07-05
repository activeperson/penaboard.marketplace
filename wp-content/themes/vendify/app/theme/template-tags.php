<?php
/**
 * Template tag helpers.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Return the current version of the parent theme.
 *
 * @since 1.0.0
 *
 * @return string
 */
function get_theme_version() {
	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
		return time();
	}

	$version = wp_get_theme()->Version;

	if ( wp_get_theme()->parent() ) {
		$version = wp_get_theme()->parent()->Version;
	}

	return $version;
}

/**
 * Get an integration.
 *
 * @since 1.0.0
 *
 * @param string $integration The name of the registered integration.
 * @return false|Integration
 */
function get_integration( $integration ) {
	return Integrations::get_integration( $integration );
}

/**
 * Check if Vendify is working with a 3rd party integration.
 *
 * @since 1.0.0
 *
 * @param string $integration The name of the registered integration.
 * @return bool
 */
function has_integration( $integration ) {
	$integration = get_integration( $integration );

	if ( ! $integration ) {
		return false;
	}

	return $integration->is_active();
}

/**
 * Check if we are using a certian header style.
 *
 * @since 1.0.0
 *
 * @param mixed $styles Header style(s).
 * @return bool
 */
function is_header_style( $styles ) {
	if ( ! is_array( $styles ) ) {
		$styles = [ $styles ];
	}

	return in_array( (int) get_theme_mod( 'header-style', 1 ), $styles, true );
}

/**
 * Get the blog layout style.
 *
 * @since 1.0.0
 *
 * @return string
 */
function get_blog_layout_style() {
	return get_theme_mod( 'layout-blog', 'blog-1' );
}

/**
 * Check if the current element needs a `transparent` modifier.
 *
 * @since 1.0.0
 */
function transparent_item_classname() {
	$classname   = 'standard';
	$global      = get_theme_mod( 'header-transparency', true );
	$transparent = false;

	// Alternate blog layout has a transparent header.
	if ( ( is_home() && get_option( 'sticky_posts' ) ) ) {
		$transparent = true;
	}

	if ( get_post() && is_singular( [ 'post', 'page' ] ) && has_post_thumbnail( get_the_ID() ) ) {
		$transparent = true;
	}

	$transparent = apply_filters( 'vendify_is_transparent_header', $transparent );

	if ( $global && $transparent ) {
		$classname = 'transparent';
	} else {
		$classname = 'static';
	}

	return apply_filters( 'Astoundify\Vendify\transparent_item_classname', $classname, $transparent );
}

/**
 * Hero background image.
 *
 * @since 1.0.0
 *
 * @param string $url Default image.
 * @return string|null
 */
function hero_image_src( $url = false ) {
	if ( $url && '' !== $url ) {
		return $url;
	}

	// Featurd image.
	if ( get_post() && has_post_thumbnail() ) {
		return get_the_post_thumbnail_url( get_post(), 'cover' );
	}

	// Fallbacks.
	$image_id = false;
	$images   = get_theme_mod( 'hero-images', [] );

	if ( ! empty( $images ) ) {
		shuffle( $images );

		$image_id = current( $images );

		return esc_url( wp_get_attachment_image_url( $image_id, 'cover' ) );
	}

	return null;
}

/**
 * Determine if post content has an available "hero" block that can be used first.
 *
 * @since 1.0.0
 */
function content_has_hero_block( $content ) {
	if ( ! function_exists( 'Astoundify\Vendify\gutenberg_content_has_hero_block' ) ) {
		return false;
	}

	return gutenberg_content_has_hero_block( $content );
}

/**
 * Determine if the website supports multiple vendors.
 *
 * @since 1.0.0
 */
function is_multiple_vendors() {
	return apply_filters( 'vendify_is_multiple_vendors', ( defined( 'WC_PRODUCT_VENDORS_VERSION' ) && WC_PRODUCT_VENDORS_VERSION ) );
}

/**
 * Determine if the header icon are needed for a theme mod.
 *
 * @since 1.0.0
 *
 * @param string $mod Key of theme mod.
 * @param string $default Default theme mod value.
 * @return bool
 */
function display_header_icon( $mod = null, $default = 'always' ) {
	if ( ! $mod ) {
		return false;
	}

	$mod = get_theme_mod( $mod, $default );

	// Turned off display.
	if ( 'never' === $mod ) {
		return false;
	}

	// User only.
	if ( 'user-only' === $mod && ! is_user_logged_in() ) {
		return false;
	}

	return true;
}

/**
 * Determine if we are on the blog and you can subscribe.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function vendify_is_blog() {
	return ( is_home() || is_singular( [ 'post', 'page' ] ) ) && 'post' == get_post_type();
}

/**
 * Returns an excerpt limited by a certain amount of characters.
 *
 * @param int $limit
 *
 * @return bool|string|string[]|null
 */
function get_limited_excerpt( $limit = 220 ){
	$excerpt = get_the_content();
	$excerpt = preg_replace(" ([.*?])",'',$excerpt);
	$excerpt = strip_shortcodes($excerpt);
	$excerpt = strip_tags($excerpt);
	$excerpt = substr($excerpt, 0, $limit);
	$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
	$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
	$excerpt = $excerpt.' ...';
	return $excerpt;
}

/**
 * Filter the post password form with our own.
 *
 * @param $html
 *
 * @return string
 */
function wp_post_password_form( $html ) {
	global $post;

	$label  = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );

	return sprintf(
		'<form action="%1$s" class="post-password-form" method="post">
		<p>%2$s</p>
		<p><label for="%3$s" class="text-hidden">%4$s<input name="post_password" id="%3$s" type="password" size="20" placeholder="%4$s" /></label> <input type="submit" name="Submit" value="%5$s" class="btn btn-primary"/></p></form>',
		esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ),
		__( 'This content is password protected. To view it please enter your password below:', 'vendify' ),
		$label,
		__( 'Password:', 'vendify' ),
		esc_attr_x( 'Enter', 'post password form', 'vendify' )
	);
}
add_filter( 'the_password_form', 'Astoundify\Vendify\wp_post_password_form' );

/**
 *
 */
function add_author_bio_header(){ ?>
	<div class="blog-bio__social">
		<?php
		foreach ( wp_get_user_contact_methods() as $method => $value ) {
			if ( '' === $value ) {
				continue;
			} ?>
			<a class="blog-bio__social__link" href="<?php echo esc_url( $value ); ?>" rel="nofollow">
				<?php
				svg(
					[
						'icon'    => $method,
						'classes' => [ 'ico--sm' ],
					]
				); ?>
			</a>
		<?php } ?>

	<?php if ( '' !== get_the_author_meta( 'url' ) ) : ?>
		<a class="blog-bio__social__link" href="<?php echo esc_url( get_the_author_meta( 'url' ) ); ?>" rel="nofollow">
			<?php
			svg(
				[
					'icon'    => 'more',
					'classes' => [ 'ico--sm' ],
				]
			); ?>
		</a>
	<?php endif; ?>
	</div>
<?php }
add_action( 'vendify_blog-bio-header', 'Astoundify\Vendify\add_author_bio_header' );
