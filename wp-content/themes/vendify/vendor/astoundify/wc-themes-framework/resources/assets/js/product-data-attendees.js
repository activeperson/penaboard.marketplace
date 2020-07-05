/**
 * Product Data: Attendees
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
	}, astoundifyWcThemesEventsProductData.attendees );

	/**
	 * Define an attendee.
	 *
	 * @since 1.0.0
	 */
	api.Models.Attendee = Backbone.Model.extend( {
		defaults: {
			type: 'external',
			name: '',
			email: '',
			location: ''
		}
	} );

	/**
	 * Manage attendees.
	 *
	 * @since 1.0.0
	 */
	api.Collections.Attendees = Backbone.Collection.extend( {
		model: api.Models.Attendee
	} );

	/**
	 * Single Attendee: Registered User
	 *
	 * @since 1.0.0
	 */
	api.Views.AttendeeUser = astoundifyWcThemesEventsProductData.Views.ExpandableItem.extend( {
		/**
		 * @since 1.0.0
		 */
		events: {
			'change .wc-customer-search': 'changeUserID',
			'click .delete': 'removeOne'
		},

		/**
		 * Update model data on an name change.
		 *
		 * @since 1.0.0
		 */
		changeUserID: function( e ) {
			var id = $( e.currentTarget ).data( 'cid' );

			var data = {
				'user_id' : this.$el.find( '.wc-customer-search' ).val(),
				'name' : this.$el.find( '.wc-customer-search option:selected' ).text()
			};

			this.collection.get( id ).set( data );
		}
	} );

	/**
	 * Toolbar
	 *
	 * @since 1.0.0
	 */
	api.Views.Toolbar = astoundifyWcThemesEventsProductData.Views.Toolbar.extend( {
		/**
		 * Add an empty item.
		 *
		 * @since 1.0.0
		 */
		addItem: function( e ) {
			e.preventDefault();

			// Add to collection.
			var item = this.collection.add( {
				type: $( '#attendee-type' ).val()
			} );

			// Set to state to "open".
			$( '[data-cid="' + item.cid + '"]' ).removeClass( 'closed' ).addClass( 'open' );
		}
	} );

	var collection = new api.Collections.Attendees();

	var attendees = new wp.Backbone.View( {
		el: $( '#wc_themes_attendees_options_inner' ),
		collection: collection
	} );

	// Add the toolbar.
	attendees.views.add( new api.Views.Toolbar( {
		collection: collection,
		template: wp.template( 'attendeeAddToolbar' )
	} ) );

	// Add a list of items.
	attendees.views.add( new astoundifyWcThemesEventsProductData.Views.SortableList( {
		id: 'astoundify-wc-themes-attendee-items',
		collection: collection,

		// Available types of attendees.
		itemViews: {

			// External data.
			'external': astoundifyWcThemesEventsProductData.Views.ExpandableItem.extend( {
				className: 'wc-metabox attendee closed',
				contentTemplate: wp.template( 'attendeeExternal' ),
				headerTemplate: wp.template( 'attendeeHeader' )
			} ),

			// Internal WP_User
			'user': api.Views.AttendeeUser.extend( {
				className: 'wc-metabox attendee closed',
				contentTemplate: wp.template( 'attendeeUser' ),
				headerTemplate: wp.template( 'attendeeHeader' )
			} )
		}
	} ) );

	// Add stored data loaded via Localize Script.
	attendees.collection.add( api.data );

	// Render HTML
	attendees.render();

}( window ));
