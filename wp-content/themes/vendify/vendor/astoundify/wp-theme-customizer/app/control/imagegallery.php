<?php
/**
 * Image Gallery.
 *
 * @uses WP_Customize_Control
 *
 * @package Astoundify
 * @subpackage ThemeCustomizer
 * @since 1.4.0
 */
class Astoundify_ThemeCustomizer_Control_ImageGallery extends WP_Customize_Control {

	/**
	 * @since 1.4.0
	 * @access public
	 * @var string $type
	 */
	public $type = 'ImageGallery';

	/**
	 * @since 1.4.0
	 * @access public
	 * @var array $labels
	 */
	public $labels;

	/**
	 * Set our custom arguments to class properties, and other things.
	 *
	 * @since 1.4.0
	 * @param oject $manager WP_Customize_Manager
	 * @param string $id
	 * @param array $args
	 */
	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );

		$this->labels = wp_parse_args( $this->labels, array(
			'select'       => __( 'Select Images', 'astoundify-themecustomizer' ),
			'change'       => __( 'Modify Gallery', 'astoundify-themecustomizer' ),
			'default'      => __( 'Default', 'astoundify-themecustomizer' ),
			'remove'       => __( 'Remove', 'astoundify-themecustomizer' ),
			'placeholder'  => __( 'No images selected', 'astoundify-themecustomizer' ),
			'frame_title'  => __( 'Select Gallery Images', 'astoundify-themecustomizer' ),
			'frame_button' => __( 'Choose Images', 'astoundify-themecustomizer' ),
		) );
	}

	/**
	 * Send the current selection to the control JS.
	 *
	 * This allows external Javascript libraries to manipulate the
	 * control/setting easily.
	 *
	 * @since 1.4.0
	 */
	public function to_json() {
		parent::to_json();

		$this->json['label']       = esc_html( $this->label );
		$this->json['file_type' ]  = 'image';
		$this->json['labels' ]     = $this->labels;
	}

	/**
	 * Output the control HTML
	 *
	 * @since 1.4.0
	 */
	public function render_content() {}

	/**
		* An Underscore (JS) template for this control's content (but not its container).
		*
		* Class variables for this control class are available in the `data` JS object;
		* export custom variables by overriding {@see WP_Customize_Control::to_json()}.
		*
		* @see WP_Customize_Control::print_template()
		*
		* @since 1.4.0
		*/
	protected function content_template() {
		$data = $this->json();
?>
		<#
		_.defaults( data, <?php echo wp_json_encode( $data ) ?> );
		data.input_id = 'input-' + String( Math.random() );
		#>

		<span class="customize-control-title"><label for="{{ data.input_id }}">{{ data.label }}</label></span>

		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<div class="attachment-media-view">

			<# if ( 0 != data.attachments.length ) { #>
			<div class="image-gallery-attachments">
				<# _.each( data.attachments, function( attachment ) { #>
					<div class="image-gallery-thumbnail-wrapper" data-post-id="{{ attachment.id }}">
						<img class="attachment-thumb" src="{{ attachment.sizes.thumbnail.url }}" draggable="false" alt="<?php esc_attr_e( 'Image Thumbnail', 'astoundify-themecustomizer' ) ?>" />
					</div>
				<#	} ) #>
			</div>
			<# } else { #>
				<div class="placeholder">
					<?php echo esc_html( $this->labels['placeholder'] ); ?>
				</div>
			<# } #>

			<div class="actions">
				<button type="button" class="button upload-button" id="image-gallery-modify-gallery">{{ data.labels.change }}</button>

				<# if ( 0 != data.attachments.length ) { #>
					<button type="button" class="button reset-button" id="image-gallery-reset-gallery">{{ data.labels.remove }}</button>
				<# } #>
			</div>

		</div>

		<div class="customize-control-notifications"></div>
<?php
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

		wp_enqueue_script( 'astoundify-themecustomizer-imagegallery', $install_url . '/assets/js/controls/ImageGallery.js', array( 'jquery', 'customize-controls' ), false, true );
		wp_enqueue_style( 'astoundify-themecustomizer-imagegallery', $install_url . '/assets/css/controls/imagegallery.css' );
	}
}
