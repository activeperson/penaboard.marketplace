/**
 * Event Filters
 *
 * @since 1.0.0
 */
( function( window, undefined ) {

	window.wp = window.wp || {};

	var document = window.document;
	var $ = window.jQuery;
	var wp = window.wp;
	var $document = $(document);

	/**
	 * Date Field
	 *
	 * @since 1.0.0
	 */
	astoundifyWcThemesEventFilters.DateField = function( field ) {
		field.datepicker({
			defaultDate: '',
			dateFormat: astoundifyWcThemesEventFilters.settings.dateFormat,
			numberOfMonths: 1,
			showButtonPanel: false,
		});
	};

	/**
	 * Radius Field Slider
	 *
	 * @since 1.0.0
	 */
	astoundifyWcThemesEventFilters.RadiusFieldSlider = function( field ) {
		var settings = astoundifyWcThemesEventFilters.settings.radius;
		var $field = field.siblings( '.location-radius-field' );
		var $text = $( '.location-radius-field-value' );

		$field.hide();
		$text.html( $field.val() + ' ' + settings.unit );

		field.slider({
			range: "max",
			animate: true,
			min: settings.min,
			max: settings.max,
			value: $field.val(),
			step: settings.step,
			slide: function( event, ui ) {
				$field.val( ui.value ).trigger( 'change' );
			},
		});

		$field.change( function() {
			$text.html( $( this ).val() + ' ' + settings.unit );
		});
	};

	/**
	 * Location Field
	 *
	 * @since 1.0.0
	 */
	astoundifyWcThemesEventFilters.LocationField = function( field ) {
		// Check if google maps loaded.
		if ( typeof google !== 'object' || typeof google.maps !== 'object') {
			return;
		}

		// Fields.
		var $lat = $( '#event-location-lat-field' );
		var $lng = $( '#event-location-lng-field' );

		// Helper.
		var settings = astoundifyWcThemesEventFilters.settings;
		var geocoder = new google.maps.Geocoder();

		var updateFields = function( pos ) {
			if ( undefined === pos || '' === pos ) {
				$lat.val( '' );
				$lng.val( '' );
			} else {
				$lat.val( pos.lat() );
				$lng.val( pos.lng() );
			}
		};

		var geoLocateIt = function() {
			if ( '' === field.val() ) {
				updateFields( '' );
			} else {
				geocoder.geocode( {
					'address': field.val(),
				}, function( results ) {
					updateFields( results[0].geometry.location );
				} );
			}
		};

		// Enable autocomplete in location field.
		var addressAutoComplete = new google.maps.places.Autocomplete( field[0], settings.autoCompleteArgs );

		// On Clicking Location Drop Down.
		google.maps.event.addListener( addressAutoComplete, 'place_changed', function() {
			var place = addressAutoComplete.getPlace();

			if( undefined === place ) {
				updateFields( '' );
			} else {
				updateFields( place.geometry.location );
			}
		});

		// On Enter/After Select Drop Down.
		google.maps.event.addDomListener( field[0], 'keydown', function(e) { 
			if ( e.keyCode == 13 ) {
				e.preventDefault(); 

				$( ".pac-container" ).hide(); // Hide autocomplete option.
				geoLocateIt();
			}
		});

		// On Change.
		google.maps.event.addDomListener( field[0], 'change', function(e) { 
			geoLocateIt();
		});
	};

	/**
	 * AJAX Filters
	 *
	 * @since 1.0.0
	 */
	astoundifyWcThemesEventFilters.ajaxSearch = function() {
		var $form = $( '#astoundify-wc-themes-events-filters-form' );
		var $loop = $( '#astoundify-wc-themes-loop' );
		var $page = $form.find( '#page' );

		// Check if it's an event search.
		// @link https://davidwalsh.name/query-string-javascript
		var isEventsSearch = false;
		var urlParams = new URLSearchParams( window.location.search );
		if ( urlParams.has( 's' ) && urlParams.has( 'post_type' ) && urlParams.has( 'location' ) && 'product' === urlParams.get( 'post_type' ) ) {
			isEventsSearch = true;
		}

		// Add classes.
		if ( isEventsSearch ) {
			$( '.woocommerce-pagination' ).addClass( 'ajax-events-pagination' );
			$( '.woocommerce-ordering' ).addClass( 'ajax-events-ordering' );
		}

		// AJAX Ordering.
		$( '.woocommerce-ordering' ).on( 'submit', function() {
			e.preventDefault(); // Disable WC ordering submit script.
		});
		$(document).on( 'change', '.woocommerce-ordering', function(e) {
			e.preventDefault();
			var orderby = $( this ).find( 'select[name="orderby"]' ).val();
			if ( ! $( '#events-orderby-field' ).length ) {
				$form.append( '<input id="events-orderby-field" type="hidden" name="orderby" value="' + orderby + '">' );
			} else {
				$( '#events-orderby-field' ).val( orderby );
			}
			$form.submit();
		} );

		// On AJAX Pagination.
		$(document).on( 'click', '.woocommerce-pagination a', function(e) {
			e.preventDefault();

			var to = $(this).text();

			if ( isNaN( to ) ) {
				var forward = $(this).hasClass( 'next' );

				if ( forward ) {
					to = Number( $page.val() ) + Number(1);
				} else {
					to = Number( $page.val() ) - Number(1);
				}
			}

			$page.val( to );
			$form.submit();
		} );

		// On Event Search Form Submit.
		$form.on( 'submit', function(e) {
			e.preventDefault();

			$loop.block({
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			});

			var querystring = $form.serialize();

			wp.ajax.send( {
				data: {
					action: 'astoundify_wc_themes_events_product_results',
					formData: querystring,
				},
				success: function(response) {
					$loop.html( response );
					$( '.woocommerce-pagination' ).addClass( 'ajax-events-pagination' );
					$( '.woocommerce-ordering' ).addClass( 'ajax-events-ordering' );
					if ( $( '#events-orderby-field' ).val() ) {
						$( '.woocommerce-ordering select[name="orderby"]' ).val( $( '#events-orderby-field' ).val() );
					}
					$loop.unblock();

					window.history.pushState( '', '', '?' + querystring );
				},
				error: function() {
					$loop.unblock();
				},
			} );
		} );
	};

	/**
	 * Wait for DOM ready.
	 *
	 * @since 1.0.0
	 */
	$document.ready( function() {
		// Filters Date Field.
		astoundifyWcThemesEventFilters.DateField( $( '#event-schedule-start-field' ) );
		astoundifyWcThemesEventFilters.DateField( $( '#event-schedule-end-field' ) );

		// Filters Location Field.
		astoundifyWcThemesEventFilters.LocationField( $( '#event-location-field' ) );
		astoundifyWcThemesEventFilters.RadiusFieldSlider( $( '#event-location-radius-field-slider' ) );

		// Monitor search.
		astoundifyWcThemesEventFilters.ajaxSearch();
	} );

}( window ) );