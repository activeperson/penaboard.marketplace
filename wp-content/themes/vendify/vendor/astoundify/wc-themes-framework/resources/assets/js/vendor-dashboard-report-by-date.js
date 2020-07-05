/**
 * Vendor Report By Date (REST API).
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
	api.Models.Chart = astoundifyWcThemesVendorsDashboard.apiModel.extend({
		routeName: 'vendor/dashboard-report-by-date',
		methods: [ 'GET' ],
		defaults: {
		},
	});

	/**
	 * Views: Render the output.
	 *
	 * @since 1.0.0
	 */
	api.Views.Chart = wp.Backbone.View.extend( {
		initialize: function() {
			var that = this;

			this.$el.block({
				message: null,
				overlayCSS: {
					background: 'transparent',
					opacity: 0.6,
				},
				css: {
					width: '100%'
				}
			});

			this.model.fetch({
				success: function() {
					that.$el.unblock();
				},
			});

			this.listenTo( this.model, 'change', this.render );
		},

		events: {
			'submit #dashboard-reports-form': 'submitForm',
			'change #reports-start-date-input': 'changeDate',
			'change #reports-end-date-input': 'changeDate',
		},

		changeDate: function(e) {
			e.preventDefault();
			var that = this;
			var startDate = $( '#reports-start-date-input' ).val();
			var endDate = $( '#reports-end-date-input' ).val();

			if ( '' === startDate || '' === endDate ) {
				return false;
			}

			this.$el.block({
				message: null,
				overlayCSS: {
					background: 'transparent',
					opacity: 0.6,
				},
				css: {
					width: '100%'
				}
			});

			this.model.fetch( {
				data: {
					range: 'custom',
					start_date: startDate,
					end_date: endDate,
				},
				success: function() {
					that.$el.unblock();
				},
			} );
		},

		submitForm: function( e ) {
			e.preventDefault();
			var that = this;
			var theForm = $(e.target);

			this.$el.block({
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			});

			this.model.fetch( {
				data: {
					range: 'custom',
					start_date: theForm.find( 'input[name="start_date"]' ).val(),
					end_date: theForm.find( 'input[name="end_date"]' ).val(),
				},
				success: function() {
					that.$el.unblock();
				},
			} );
		},

		render: function() {
			var self = this;
			var changed = this.model.changedAttributes();

			_.each( changed, function( value, key ) {

				if ( 'chart_commission' === key ) {

					var reportChart = new Chart( self.$el.find( '.chart-commission-placeholder.main' ), {
						type: 'line',
						data: value,
						options: {
							maintainAspectRatio: false,
							legend: { // Do not display legend.
								display: false,
							},
							tooltips: { // Tooltips setup.
								displayColors: false,
								mode: 'single',
								cornerRadius: 0,
								callbacks: {
									title: function( tooltipItems, data ) {
										return data.tooltips_titles[ tooltipItems[0].index ];
									},
									label: function( tooltipItems, data ) {
										return data.datasets[tooltipItems.datasetIndex].tooltips_contents[tooltipItems.index];
									},
								},
							},
							scales: {
								yAxes: [{
									gridLines: {
										display: false,
									},
									ticks: {
										beginAtZero:true
									}
								}],
								xAxes: [{
									gridLines: {
										display: false,
									},
									ticks: {
										zeroLineWidth: 0,
									},
								}],
							},
						},
					} );

				} else {
					var el = self.$el.find( '.' + key );

					if ( 0 === el.length ) {
						return;
					}

					// if this is a number, keep the decimals number at 2.
					if ( ! isNaN( value ) && parseFloat(value).toFixed ) {
						value = parseFloat(value).toFixed(2).replace(".00", "");
					}
					
					el.html( value ).addClass( 'astoundify-wc-themes-stat-updated' );

					setTimeout( function() {
						el.removeClass( 'astoundify-wc-themes-stat-updated' );
					}, 1000 );
				}

			} );

			return this;
		},
	} );

	/**
	 * Bind items to to the DOM.
	 *
	 * @since 1.0.0
	 */
	$(function() {

		// Date Fields.
		var dateField = function( field ) {
			field.datepicker({
				defaultDate: '',
				dateFormat: 'yy-mm-dd',
				numberOfMonths: 1,
				showButtonPanel: false,
			});
		};
		dateField( $( '#reports-start-date-input' ) );
		dateField( $( '#reports-end-date-input' ) );

		new api.Views.Chart({
			el: '#astoundify-wc-themes-dashboard-report-by-date',
			model: new api.Models.Chart,
		}).render();

	});

})( window );
