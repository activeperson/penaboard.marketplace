<?php
/**
 * Style Kit
 *
 * @since 1.4.0
 */
class Astoundify_ThemeCustomizer_Control_StyleKit extends Astoundify_ThemeCustomizer_Control_ControlGroup {

	/**
	 * Public URI to screenshot locations.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string $screenshots
	 */
	public $screenshots;

	/**
	 * Output the control HTML
	 *
	 * @since 1.4.0
	 */
	public function render_content() {
		$name = '_customize-radio-' . $this->id; ?>

		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

		<?php
		foreach ( $this->group as $group_id => $group_data ) {
			$url = esc_url( trailingslashit( $this->screenshots ) . $group_id . '.jpg' );

			if ( isset( $group_data['thumbnail_data'] ) ) {
				$url = esc_attr( $group_data['thumbnail_data'] );
			} else {
				$url_parse = wp_parse_url( $url );
				if ( ! file_exists( $url_parse['path'] ) ) {
					continue;
				}
			} ?>
			<p>
				<label>
					<?php
					printf(
						'<input %1$s name="%2$s" value="%3$s" type="radio" %4$s %5$s />',
						$this->get_link(),
						esc_attr( $name ),
						esc_attr( $group_id ),
						$this->generate_linked_control_data( $group_data['controls'] ),
						checked( $group_id, sanitize_title( $this->value() ), false )
					); ?>

					<span class="label"><?php echo esc_attr( $group_data['title'] ); ?></span>
					<img src="<?php echo $url; // WPCS: XSS ok; ?>" alt="<?php esc_attr_e( 'Style preview.', 'astoundify-themecustomizer' ); ?>" class="style-kit-preview" />
				</label>
			</p>
		<?php }
	}

	/**
	 * Enqueue custom scripts
	 *
	 * @since 1.4.0
	 * @return void
	 */
	public function enqueue() {
		parent::enqueue();

		$install_url = trailingslashit( astoundify_themecustomizer_get_option( 'install_url' ) );
		wp_enqueue_style( 'astoundify-themecustomizer-stylekit', $install_url . '/assets/css/controls/stylekit.css' );
	}
}