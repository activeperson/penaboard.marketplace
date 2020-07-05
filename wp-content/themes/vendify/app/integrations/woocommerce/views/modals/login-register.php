<?php
/**
 * Login/Register screen.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Theme
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
} ?>

<div class="modal modal--fullscreen fade" data-backdrop="false" id="access-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

			<section class="access__column access__column--sign-in">
				<div class="access__content access__content--sign-in">

					<header class="access__header">
						<div class="access__logo">
							<?php partial( 'branding' ); ?>
						</div>

						<button type="button" class="btn-icon btn-icon--close" data-dismiss="modal" aria-label="<?php esc_attr_e( 'Close', 'vendify' ); ?>">
							<?php
							svg(
								[
									'icon'    => 'close',
									'classes' => [ 'ico--xs' ],
								]
							); ?>
						</button>
					</header>

					<form class="form--transparent mb-auto mt-auto" method="POST" action="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">

						<h2 class="h3 access__form-title"><?php echo esc_html( get_theme_mod( 'login-register-title-login', 'Sign In' ) ); ?></h2>

						<?php do_action( 'woocommerce_login_form_start' ); ?>

						<div class="form-group">
							<p class="form-row">
								<label for="username" class="label label--required"><?php esc_html_e( 'Username or email', 'vendify' ); ?></label>
								<input type="text" class="form-control" name="username" id="username" placeholder="<?php esc_attr_e( 'Your Username', 'vendify' ); ?>" />
							</p>
						</div>

						<div class="form-group">
							<p class="form-row">
								<label for="password" class="label label--required"><?php esc_html_e( 'Password', 'vendify' ); ?></label>
								<input class="form-control" type="password" name="password" id="password" placeholder="<?php esc_attr_e( 'Your Password', 'vendify' ); ?>" />
							</p>
						</div>

						<?php do_action( 'woocommerce_login_form' ); ?>

						<div class="form-group">
							<input type="hidden" name="redirect" value="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" />

							<label class="woocommerce-form__label woocommerce-form__label-for-checkbox custom-control custom-checkbox">
								<input class="woocommerce-form__input woocommerce-form__input-checkbox custom-control-input" name="rememberme" type="checkbox" id="rememberme" value="forever" />
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description"><?php esc_html_e( 'Remember me', 'vendify' ); ?></span>
							</label>
						</div>

						<div class="form-group">
							<?php wp_nonce_field( 'woocommerce-login' ); ?>

							<button type="submit" class="btn btn-primary btn-block" name="login" value="<?php esc_attr_e( 'Sign In', 'vendify' ); ?>"><?php esc_html_e( 'Sign In', 'vendify' ); ?></button>
						</div>

						<div class="access__helpers">
							<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="link"><?php esc_html_e( 'Lost your password?', 'vendify' ); ?></a>

							<?php if ( get_option( 'users_can_register' ) ) { ?>
							<a class="link js-switch-access-screen has-icon" data-screen="sign-up" href="">
								<?php
								esc_html_e( 'Don\'t have an account?', 'vendify' );

								svg(
									[
										'icon'    => 'long-arrow-right',
										'classes' => [ 'ico--xs', 'ml-2' ],
									]
								); ?>
							</a>
							<?php } ?>
						</div>

						<?php do_action( 'woocommerce_login_form_end' ); ?>
					</form>

				</div>
			</section>

			<?php if ( get_option( 'users_can_register' ) ) { ?>

				<section class="access__column access__column--sign-up">
					<div class="access__content access__content--sign-up">
						<header class="access__header">
							<div class="access__logo">
								<?php partial( 'branding' ); ?>
							</div>

							<button type="button" class="btn-icon btn-icon--close" data-dismiss="modal" aria-label="<?php esc_attr_e( 'Close', 'vendify' ); ?>">
								<?php
								svg(
									[
										'icon'    => 'close',
										'classes' => [ 'ico--xs' ],
									]
								); ?>
							</button>
						</header>

						<div class="mb-auto mt-auto">

							<h2 class="h3 access__form-title"><?php echo esc_html( get_theme_mod( 'login-register-title-register', 'Create an Account' ) ); ?></h2>

							<?php if ( get_option( 'users_can_register' ) ) : ?>

							<form class="form--transparent" method="POST" action="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">

								<?php do_action( 'woocommerce_register_form_start' ); ?>

								<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

									<div class="form-group">
										<label for="reg_username" class="label label--required"><?php esc_html_e( 'Username', 'vendify' ); ?></label>
										<input type="text" class="woocommerce-Input woocommerce-Input--text form-control" name="username" id="reg_username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
									</div>

								<?php endif; ?>

								<div class="form-group">
									<label for="reg_email" class="label label--required"><?php esc_html_e( 'Email address', 'vendify' ); ?></label>
									<input type="email" class="woocommerce-Input woocommerce-Input--text form-control" name="email" id="reg_email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" placeholder="<?php esc_html_e( 'example@example.com', 'vendify' ); ?>" /><?php // @codingStandardsIgnoreLine ?>
								</div>

								<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

									<div class="form-group">
										<label for="reg_password" class="label label--required"><?php esc_html_e( 'Password', 'vendify' ); ?></label>
										<input type="password" class="woocommerce-Input woocommerce-Input--text form-control" name="password" id="reg_password" placeholder="<?php esc_html_e( '*********', 'vendify' ); ?>" />
									</div>

								<?php endif; ?>

								<?php do_action( 'woocommerce_register_form' ); ?>

								<div class="form-group"></div>

								<div class="form-group">
									<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
									<button type="submit" class="woocommerce-Button btn btn-primary btn-block" name="register" value="<?php esc_attr_e( 'Sign Up', 'vendify' ); ?>"><?php esc_html_e( 'Sign Up', 'vendify' ); ?></button>
								</div>

								<div class="access__helpers">
									<a class="link has-icon js-switch-access-screen" data-screen="sign-in" href="">
										<?php
										svg(
											[
												'icon'    => 'long-arrow-left',
												'classes' => [ 'ico--xs', 'mr-2' ],
											]
										);

										esc_html_e( 'I have an account', 'vendify' ); ?>
									</a>
								</div>

								<?php do_action( 'woocommerce_register_form_end' ); ?>
							</form>

							<?php else : ?>

								<p><?php esc_html_e( 'Registration is disabled.', 'vendify' ); ?></p>

							<?php endif; ?>
						</div>

					</div>
				</section>

			<?php } ?>

			<aside class="access__column access__column--slider">
				<div class="access__slider flickity--image">
					<?php foreach ( get_theme_mod( 'login-register-gallery', [] ) as $image ) : ?>
						<div class="access__slide" style="background-image: url(<?php echo wp_get_attachment_image_url( $image, 'cover' ); ?>);"></div>
					<?php endforeach; ?>
				</div>

				<div class="access__slider__content">
					<div class="access__slider__icon">
					<?php if ( get_theme_mod( 'login-register-icon', false ) ) : ?>
						<img src="<?php echo esc_url( get_theme_mod( 'login-register-icon', false ) ); ?>" alt="<?php esc_attr_e( 'Register Icon.', 'vendify' ) ?>" />
					<?php else : ?>
						<img src="<?php echo esc_url( get_template_directory_uri() . '/public/images/shop-icon-white.svg' ); ?>" alt="<?php esc_attr_e( 'Shop Icon.', 'vendify' ) ?>" />
					<?php endif; ?>
					</div>

					<h2 class="access__slider__title display-2">
						<?php echo esc_html( get_theme_mod( 'login-register-title', 'Start your own shop today.' ) ); ?>
					</h2>

					<div class="lead">
						<?php echo wp_kses_post( wpautop( get_theme_mod( 'login-register-content', "It&#39;s free and easy!\n\n<a href='#' class='btn btn-outline-light'>Learn More</a>" ) ) ); ?>
					</div>
				</div>
			</aside>

		</div>
	</div>
</div>

<style>
.access__slide:after {
	opacity: <?php echo get_theme_mod( 'login-register-gallery-overlay', 0.5 ); ?>
}
</style>
