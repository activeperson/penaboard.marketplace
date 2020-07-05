/**
 * Vendor Overview (REST API).
 *
 * @since 1.0.0
 */
(function( window, undefined ){

	window.wp = window.wp || {};
	var document = window.document;
	var $ = window.jQuery;

	/**
	 * Scope for current file.
	 */
	var api = {
		Models: {},
		Collections: {},
		Views: {}
	};

	/**
	 * Backbone Model.
	 * Using WPApiBaseModel to handle the cookie, etc.
	 *
	 * @since 1.0.0
	 *
	 * @extends WPApiBaseModel
	 */
	api.Models.Overview = astoundifyWcThemesVendorsDashboard.apiModel.extend({
		routeName: 'vendor/dashboard-overview',
		methods: [ 'GET' ],
		defaults: {
			weekly_average: 0,
			total_items_sold: 0,
			average_ratings: 0,
			total_reviews: 0,
		}
	});

	/**
	 * Views: Render the output.
	 *
	 * @since 1.0.0
	 */
	api.Views.Overview = wp.Backbone.View.extend( {
		/**
		 * @since 1.0.0
		 */
		initialize: function() {
			this.listenTo( this.model, 'change', this.update );
		},

		/**
		 * @since 1.0.0
		 */
		render: function() {
			this.$el.block({
				message: null,
				overlayCSS: {
					background: 'transparent',
					opacity: 0.6,
					width: '100%'
				}
			});
		},

		/**
		 * @since 1.0.0
		 */
		update: function() {
			var self = this;
			var changed = this.model.changedAttributes();

			_.each( changed, function( value, key ) {
				var el = self.$el.find( '#' + key );

				if ( 0 === el.length ) {
					return;
				}

				// if this is a number, keep the decimals number at 2.
				if ( ! isNaN( value ) && parseFloat(value).toFixed ) {
					value = parseFloat(value).toFixed(2).replace(".00", "");
				}

				// Add updated status.
				el.html( value ).addClass( 'astoundify-wc-themes-stat-updated' );

				setTimeout( function() {
					el.removeClass( 'astoundify-wc-themes-stat-updated' );
				}, 1000 );
			} );
		},
	} );

	/**
	 * Bind items to to the DOM.
	 *
	 * @since 1.0.0
	 */
	$(function() {
		var model = new api.Models.Overview;
		var el = '#astoundify-wc-themes-dashboard-overview';

		new api.Views.Overview({
			el: el,
			model: model,
		}).render();

		model.fetch({
			success: function() {
				$( el ).unblock();
			},
		});

	});

})( window );
