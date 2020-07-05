/**
 * Product Data: Schedule
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
	}, astoundifyWcThemesEventsProductData.schedule );

	/**
	 * Define a day.
	 *
	 * @since 1.0.0
	 */
	api.Models.Day = Backbone.Model.extend( {
		defaults: {
			type: 'day',
			day: null,
			start: null,
			end: null
		}
	} );

	/**
	 * Add a custom event to the item row.
	 *
	 * @since 1.0.0
	 */
	api.Views.Day = astoundifyWcThemesEventsProductData.Views.ExpandableItem.extend( {
		/**
		 * @since 1.0.0
		 */
		events: {
			'change .schedule-date': 'changeDate',
			'click .delete': 'removeOne',
			'click .upload_image_button': 'uploadImage'
		},

		/**
		 * @since 1.0.0
		 */
		changeDate : function( e ) {
			var id = $( e.currentTarget ).data( 'cid' );

			this.collection.get( id ).set( 'date', $( e.currentTarget ).val() );
		}
	} );

	/**
	 * Manage days.
	 *
	 * @since 1.0.0
	 */
	api.Collections.Days = Backbone.Collection.extend( {
		model: api.Models.Day
	} );

	var collection = new api.Collections.Days();

	var schedule = new wp.Backbone.View( {
		el: $( '#wc_themes_schedule_options_inner' ),
		collection: collection
	} );

	// Add the toolbar.
	schedule.views.add( new astoundifyWcThemesEventsProductData.Views.Toolbar( {
		collection: collection,
		template: wp.template( 'scheduleAddToolbar' )
	} ) );

	// Add a list of items.
	schedule.views.add( new astoundifyWcThemesEventsProductData.Views.SortableList( {
		id: 'astoundify-wc-themes-schedule-items',
		collection: collection,

		// Available types of schedule.
		itemViews: {

			// Single day.
			'day': api.Views.Day.extend( {
				className: 'wc-metabox day closed',
				contentTemplate: wp.template( 'dayTime' ),
				headerTemplate: wp.template( 'dayTimeHeader' )
			} )

		}
	} ) );

	// Add stored data loaded via Localize Script.
	schedule.collection.add( api.data );

	// Render HTML
	schedule.render();

}( window ));
