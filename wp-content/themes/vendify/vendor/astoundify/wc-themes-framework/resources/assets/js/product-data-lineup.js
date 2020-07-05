/**
 * Product Data: Lineup
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
	}, astoundifyWcThemesEventsProductData.lineup );

	/**
	 * Define a person.
	 *
	 * @since 1.0.0
	 */
	api.Models.Person = Backbone.Model.extend( {
		defaults: {
			type: 'external',
			name: '',
			email: '',
			image: '',
			title: '',
			url: ''
		}
	} );

	/**
	 * Manage a lineup.
	 *
	 * @since 1.0.0
	 */
	api.Collections.Lineup = Backbone.Collection.extend( {
		model: api.Models.Person
	} );

	var collection = new api.Collections.Lineup();

	var lineup = new wp.Backbone.View( {
		el: $( '#wc_themes_lineup_options_inner' ),
		collection: collection
	} );

	// Add the toolbar.
	lineup.views.add( new astoundifyWcThemesEventsProductData.Views.Toolbar( {
		collection: collection,
		template: wp.template( 'lineupAddToolbar' )
	} ) );

	// Add a list of items.
	lineup.views.add( new astoundifyWcThemesEventsProductData.Views.SortableList( {
		id: 'astoundify-wc-themes-lineup-items',
		collection: collection,

		// Available types of lineup.
		itemViews: {

			// External person.
			'external': astoundifyWcThemesEventsProductData.Views.ExpandableItem.extend( {
				className: 'wc-metabox lineup-person closed',
				i18n: api.i18n,
				contentTemplate: wp.template( 'personExternal' ),
				headerTemplate: wp.template( 'personHeader' )
			} )

		}
	} ) );

	// Add stored data loaded via Localize Script.
	lineup.collection.add( api.data );

	// Render HTML
	lineup.render();

}( window ));
