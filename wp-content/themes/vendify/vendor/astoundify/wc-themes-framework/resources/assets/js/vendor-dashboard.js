/**
 * Vendor Dashboard
 *
 * @since 1.0.0
 */
(function( window, undefined ){

	window.wp = window.wp || {};
	var document = window.document;
	var $ = window.jQuery;

	/**
	 * REST API Model
	 * This is needed to use cookie in rest API to use current user data.
	 *
	 * @since 1.0.0
	 */
	astoundifyWcThemesVendorsDashboard.apiModel = wp.api.WPApiBaseModel.extend({
		apiRoot: wpApiSettings.root || '/wp-json',
		versionString: 'astoundify/wc-themes/v1/',
		nonce: function() {
			return wpApiSettings.nonce;
		},
		url: function() {
			return this.apiRoot + this.versionString + this.routeName;
		}
	});

	/**
	 * Bind items to to the DOM.
	 *
	 * @since 1.0.0
	 */
	$(function() {

		// Open media modal to upload image.
		$( document ).on( 'click', '.vendors-upload-button', function(e) {
			e.preventDefault();

			var this_button = $( this );

			// If media frame doesn't exist, create it with some options.
			var media_frame = wp.media.frames.file_frame = wp.media({
				className: 'media-frame vendor-dashboard-media-frame',
				frame: 'select',
				title: this_button.data( 'title' ),
				button: { text:  this_button.data( 'insert' ) },
				multiple: false,
			});

			// Insert URL.
			media_frame.on( 'select', function(){
				var this_attachment = media_frame.state().get('selection').first().toJSON();
				this_button.parents( '.vendors-upload-field' ).find( 'input[type="hidden"]' ).val( this_attachment.id ).trigger( 'change' );
				this_button.parents( '.vendors-upload-field' ).find( '.vendors-upload-thumbnail' ).attr( 'src', this_attachment.url ).show();
				this_button.parents( '.vendors-upload-field' ).find( '.vendors-upload-remove' ).toggle();
			});

			// Open frame.
			media_frame.open();
		});

		// Clear input.
		$( document ).on( 'click', '.vendors-upload-remove', function(e){
			e.preventDefault();

			var $button  = $( this );
			var $preview = $button.parents( '.vendors-upload-field' ).find( '.vendors-upload-thumbnail' );

			$button.parents( '.vendors-upload-field' ).find( 'input[type="hidden"]' ).val( '' ).trigger( 'change' );
			$button.hide();

			$preview.attr( 'src', $preview.data( 'placeholder' ) )
		});

	});

})( window );
