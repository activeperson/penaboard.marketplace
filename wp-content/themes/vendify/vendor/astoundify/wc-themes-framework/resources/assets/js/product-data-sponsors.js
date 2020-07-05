/**
 * Product Data: Sponsors
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
	}, astoundifyWcThemesEventsProductData.sponsors );

	/**
	 * Define a sponsor.
	 *
	 * @since 1.0.0
	 */
	api.Models.Sponsor = Backbone.Model.extend( {
		defaults: {
			type: 'external',
			name: '',
			email: '',
			image: '',
			url: ''
		}
	} );

	/**
	 * Manage sponsors.
	 *
	 * @since 1.0.0
	 */
	api.Collections.Sponsors = Backbone.Collection.extend( {
		model: api.Models.Sponsor
	} );

	var collection = new api.Collections.Sponsors();

	var sponsors = new wp.Backbone.View( {
		el: $( '#wc_themes_sponsors_options_inner' ),
		collection: collection
	} );

	// Add the top toolbar.
	sponsors.views.add( new astoundifyWcThemesEventsProductData.Views.Toolbar( {
		collection: collection,
		template: wp.template( 'sponsorAddToolbar' )
	} ) );

	// Add a list of items.
	sponsors.views.add( new astoundifyWcThemesEventsProductData.Views.SortableList( {
		id: 'astoundify-wc-themes-sponsor-items',
		collection: collection,

		// Available types of sponsors.
		itemViews: {

			// External sponsor item.
			'external': astoundifyWcThemesEventsProductData.Views.ExpandableItem.extend( {
				className: 'wc-metabox sponsor closed',
				i18n: api.i18n,
				headerTemplate: wp.template( 'sponsorHeader' ),
				contentTemplate: wp.template( 'sponsorExternal' )
			} )

		}
	} ) );

	// Add stored data loaded via Localize Script.
	sponsors.collection.add( api.data );

	// Render HTML
	sponsors.render();

}( window ));
