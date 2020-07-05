/**
 * Product locations.
 *
 * @since 1.0.0
 */
(function( window, undefined ){

	window.wp = window.wp || {};
	var wp = window.wp;
	var $ = window.jQuery;

	/**
	 * Scope for current file.
	 */
	var api = _.extend( {}, {
		Models: {},
		Collections: {},
		Views: {}
	}, astoundifyWcThemesEventsProductData.location );

	/**
	 * A location.
	 *
	 * @since 1.0.0
	 */
	api.Models.Location = Backbone.Model.extend({
		defaults: {
			address: false,
			address_1: false,
			address_2: false,
			city: false,
			postcode: false,
			country: false,
			state: false,
			latitude: false,
			longitude: false
		}
	});

	/**
	 * Fields
	 *
	 * @since 1.0.0
	 */
	api.Views.Fields = Backbone.View.extend({
		/**
		 * @since 1.0.0
		 */
		initialize: function( options ) {
		 	_.extend( this, options );

			var self = this;

			// Enable autocomplete.
			this.autocomplete = new google.maps.places.Autocomplete( document.getElementById( 'address' ) );
			
			// Disable form submission on enter.
			$( '#address' ).on( 'keydown', function( event ) { 
				if ( event.keyCode === 13 ) { 
					event.preventDefault(); 
				}
			}); 

			// Update location data when selecting a suggestion.
			this.autocomplete.addListener( 'place_changed', function() {
				self.placeChanged();
			} );

			// Update DOM fields when the location data changes.
			this.listenTo( this.model, 'change', function() {
				self.updateFields();
			} );
		},

		/**
		 * Generate more usable location information from the returned address components.
		 *
		 * @since 1.0.0
		 */
		placeChanged: function() {
			var place = this.autocomplete.getPlace();
			var street, streetNumber, city, postCode, country, state = '';

			// Set model data based on address components.
			for( var i = 0; i < place.address_components.length; i++ ) {
				var addressType = place.address_components[i].types[0];

				switch ( addressType ) {
					case 'route' :
						street = place.address_components[i]['long_name'];
						break;
					case 'street_number' :
						streetNumber = place.address_components[i]['long_name'];
						break;
					case 'postal_town' :
					case 'locality' :
					case 'sublocality_level_1' :
						city = place.address_components[i]['long_name'];
						break;
					case 'postal_code' :
						postCode = place.address_components[i]['long_name'];
						break;
					case 'country' :
						country = place.address_components[i]['short_name'];
						break;
					case 'administrative_area_level_1' :
						state = place.address_components[i]['long_name'];
						break;
				}
			}

			this.model.clear();

			// Set model coordinates.
			this.model.set({
				address_1: '' !== street ? ( streetNumber ? ( streetNumber + ' ' + street ) : street ) : street,
				address_2: '',
				city: '' !== city ? city : ( place.vicinity ? place.vicinity : city ),
				postcode: postCode,
				country: country,
				state: state,
				latitude: place.geometry.location.lat(),
				longitude: place.geometry.location.lng()
			});

			this.map.addMarker( new google.maps.LatLng( this.model.get( 'latitude' ), this.model.get( 'longitude' ) ) );
		},

		/**
		 * Update field values.
		 *
		 * @since 1.0.0
		 */
		updateFields: function() {
			_.each( this.model.changed, function( value, attribute ) {
				if ( value ) {
					$( '#' + attribute ).val( value );
				}
			} );
		}
	});

	/**
	 * Map View.
	 *
	 * @since 1.0.0
	 */
	api.Views.Map = Backbone.View.extend({
		/**
		 * @since 1.0.0
		 */
		map: false,

		/**
		 * @since 1.0.0
		 */
		marker: false,

		/**
		 * @since 1.0.0
		 */
		located: false,

		/**
		 * @since 1.0.0
		 */
		center: new google.maps.LatLng( -34.397, 150.644 ),

		/**
		 * Create map.
		 *
		 * @since 1.0.0
		 */
		render: function() {
			// Generate map.
			this.map = new google.maps.Map( document.getElementById( 'astoundify-wc-themes-product-location-map' ), {
				zoom: 12
			} );

			// Need to wait for map to be available to add data.
			this.model.set( api.data );

			// Use a previously saved location as center.
			if ( this.model.get( 'latitude' ) && this.model.get( 'longitude' ) ) {
				this.center = new google.maps.LatLng( this.model.get( 'latitude' ), this.model.get( 'longitude' ) );
				this.map.setCenter( this.center );
				this.addMarker( this.center );
			}
		},

		/**
		 * Rerender the map when the WooCommerce panel tabs change.
		 *
		 * @since 1.0.0
		 */
		rerender: function() {
			google.maps.event.trigger( this.map, 'resize' );
			this.map.setCenter( this.center );
		},

		/**
		 * Add a marker to the map.
		 *
		 * @since 1.0.0
		 */
		addMarker: function( position ) {
			if ( ! this.marker ) {
				this.marker = new google.maps.Marker({
					map: this.map
				});
			}

			this.center = position;
			this.marker.setPosition( position );
			this.map.setCenter( position );
		}
	});

	/**
	 * Panel view.
	 *
	 * @since 1.0.0
	 */
	api.Views.Panel = wp.Backbone.View.extend({
		/**
		 * @since 1.0.0
		 */
		initialize: function( options ) {
		 	_.extend( this, options );
		},

		/**
		 * @since 1.0.0
		 */
		render: function() {
			this.map = new api.Views.Map({
				model: this.model
			});

			this.fields = new api.Views.Fields({
				model: this.model,
				map: this.map
			});

			this.fields.render();
			this.map.render();
		}
	});

	/**
	 * Handle WooCommerce tabs/panels.
	 *
	 * @since 1.0.0
	 */
	$(document.body).on( 'wc-init-tabbed-panels', function() {

		var panel = new api.Views.Panel({
			el: '#location_product_data',
			model: new api.Models.Location()
		} );

		panel.render();

		/**
		 * Reload Google Map when tab is switched.
		 *
		 * @since 1.0.0
		 */
		$( '.location_options' ).on( 'click', function() {
			panel.map.rerender();
		} );
	});

}( window ));
