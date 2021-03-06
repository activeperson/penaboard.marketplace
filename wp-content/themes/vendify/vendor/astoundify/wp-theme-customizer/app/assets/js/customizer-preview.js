/* global wp, jQuery, astoundifyThemeCustomizerPreview */
(function( $ ){

	var _window = $(window),
		api = wp.customize;

	var astoundifyThemeCustomizerPreview = window.astoundifyThemeCustomizerPreview || {};

	/**
	 * Handle style controls.
	 *
	 * @since 1.0.0
	 */
	astoundifyThemeCustomizerPreview = $.extend( window.astoundifyThemeCustomizerPreview, {
		styleControls: {},
		fontFamilyControls: {},

		/**
		 * Bind all controls to automatically update inline CSS.
		 *
		 * @since 1.0.0
		 */
		initStyles: function() {
			var self = this;

			_.each( self.getStyleControls(), function( value, settingId ) {
				api( settingId, function( setting ) {
					setting.bind( _.debounce( function( to ) {
						self.retrieveStyles( settingId )
					}, 250 ) );
				} );
			} );
		},

		/**
		 * Bind font family controls update WebFont.
		 *
		 * @see https://github.com/typekit/webfontloader
		 *
		 * @since 1.0.0
		 */
		initFontFamilies: function() {
			var self = this;

			_.each( self.getFontFamilyControls(), function( value, settingId ) {
				api( settingId, function( setting ) {
					setting.bind( _.debounce( function( to ) {
						self.retrieveFontJson( settingId, setting )
					}, 250 ) );
				} );
			} );
		},

		/**
		 * Update styles dynamically.
		 *
		 * @since 1.0.0
		 */
		retrieveStyles: function( settingId ) {
			api.preview.trigger( 'loading-initiated' );

			var self = astoundifyThemeCustomizerPreview;
			var updatedStyleControls = {};

			api( settingId, function( setting ) {
				updatedStyleControls[ settingId ] = setting();
			} );

			wp.ajax.send( 'astoundify-themecustomizer-css', {
				data: {
					'astoundify-themecustomizer-customized-controls': updatedStyleControls
				},
				success: function( response ) {
					self.replaceStyles( response );
					api.preview.trigger( 'loading-failed' ); // All this does is remove a body class currently. Not super safe though.
				},
				failure: function( response ) {
					api.preview.trigger( 'loading-failed' ); // All this does is remove a body class currently. Not super safe though.
				}
			});
		},

		/**
		 * Update WebFont dynamically.
		 *
		 * @since 1.0.0
		 */
		retrieveFontJson: function( settingId, setting ) {
			api.preview.trigger( 'loading-initiated' );
			
			var self = astoundifyThemeCustomizerPreview;
			var updatedFontFamilyControls = {};

			updatedFontFamilyControls[ settingId ] = setting();

			wp.ajax.send( 'astoundify-themecustomizer-webfont', {
				data: {
					'astoundify-themecustomizer-customized-controls': updatedFontFamilyControls
				},
				success: function( response ) {
					WebFont.load( response );
					api.preview.trigger( 'loading-failed' ); // All this does is remove a body class currently. Not super safe though.
					self.retrieveStyles();
				}
			});
		},

		/**
		 * Update the styles in the document
		 *
		 * @since 1.0.0
		 */
		replaceStyles: function( styles ) {
			selector = this.stylesheet;

			$( '#' + selector ).remove();

			$( '<div>', {
				id: selector,
				html: '&shy;<style>' + styles + '</style>',
			} ).appendTo( 'body' );
		},

		/**
		 * Out out all active controls, find the ones that relate to CSS.
		 * This is pretty basic and hacky at the moment, and shuold be made more
		 * dynamic in the future.
		 *
		 * @since 1.0.0
		 */
		getStyleControls: function() {
			var self = astoundifyThemeCustomizerPreview;

			if ( self.styleControls.length > 1 ) {
				return self.styleControls;
			}

			var extras = [ 
				'background_color', 
				'header_textcolor'
			];

			_.each( api.settings.values, function( value, key ) {
				if( 
						key.match( /color/i ) ||
						key.match( /font\-weight/i ) ||
						key.match( /font\-size/i ) ||
						key.match( /line\-height/i ) ||
						extras.indexOf( key ) != -1
					) { 
					self.styleControls[ key ] = value;
				}
			});

			return self.styleControls;
		},

		/**
		 * Get all font-family controls.
		 *
		 * @since 1.0.0
		 */
		getFontFamilyControls: function() {
			var self = astoundifyThemeCustomizerPreview;

			if ( self.fontFamilyControls.length > 1 ) {
				return self.fontFamilyControls;
			}

			_.each( api.settings.values, function( value, key ) {
				if( key.match( /font\-family/i ) ) { 
					self.fontFamilyControls[ key ] = value;
				}
			});

			return self.fontFamilyControls;
		}
	} );

	$(document).ready(function() {
		astoundifyThemeCustomizerPreview.initStyles();
		astoundifyThemeCustomizerPreview.initFontFamilies();
	});

})( jQuery );
