<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.0.0
 */

namespace Astoundify\Vendify;

defined( 'ABSPATH' ) || exit;

// Translators: %s: Quantity.
$label = ! empty( $args['product_name'] ) ? sprintf( __( '%s quantity', 'vendify' ), wp_strip_all_tags( $args['product_name'] ) ) : __( 'Quantity', 'vendify' );

if ( $max_value && $min_value === $max_value ) { ?>
	<div class="quantity hidden">
		<input
			type="hidden"
			id="<?php echo esc_attr( $input_id ); ?>"
			class="qty" name="<?php echo esc_attr( $input_name ); ?>"
			value="<?php echo esc_attr( $min_value ); ?>"
		/>
	</div>

	<?php
} else {
	if ( isset( $args['type'] ) && 'number' === $args['type'] ) { ?>

	<div class="custom-numeric-input">
		<?php do_action( 'woocommerce_before_quantity_input_field' ); ?>
		<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_html_e( 'Qty', 'vendify' ); ?>:</label>
		<input
			type="number"
			id="<?php echo esc_attr( $input_id ); ?>"
			class="form-control form-control-numeric"
			step="<?php echo esc_attr( $step ); ?>"
			min="<?php echo esc_attr( $min_value ); ?>"
			max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
			name="<?php echo esc_attr( $input_name ); ?>"
			value="<?php echo esc_attr( $input_value ); ?>"
			title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'vendify' ); ?>"
			pattern="<?php echo esc_attr( $pattern ); ?>"
			inputmode="<?php echo esc_attr( $inputmode ); ?>"
		/>
		<?php do_action( 'woocommerce_after_quantity_input_field' ); ?>
	</div>

	<?php } else { ?>

	<div class="custom-numeric-input">
		<?php do_action( 'woocommerce_before_quantity_input_field' ); ?>
		<input
			type="text"
			id="<?php echo esc_attr( $input_id ); ?>"
			class="form-control form-control-numeric"
			step="<?php echo esc_attr( $step ); ?>"
			min="<?php echo esc_attr( $min_value ); ?>"
			max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
			name="<?php echo esc_attr( $input_name ); ?>"
			value="<?php echo esc_attr( $input_value ); ?>"
			title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'vendify' ); ?>"
			size="4"
			pattern="<?php echo esc_attr( $pattern ); ?>"
			inputmode="<?php echo esc_attr( $inputmode ); ?>"
		/>

		<button class="btn-icon btn-icon--minus" aria-label="Decrease">
		<?php
		svg(
			[
				'icon'    => 'minus',
				'classes' => [ 'ico--xs' ],
			]
		); ?>
		</button>
		<button class="btn-icon btn-icon--plus" aria-label="Increase">
		<?php
		svg(
			[
				'icon'    => 'plus',
				'classes' => [ 'ico--xs' ],
			]
		); ?>
		</button>
		<?php do_action( 'woocommerce_after_quantity_input_field' ); ?>
	</div>

	<?php
	}
}
