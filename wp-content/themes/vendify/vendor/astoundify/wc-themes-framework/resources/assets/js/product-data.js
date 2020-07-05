/**
 * Product Data (Admin)
 *
 * @since 1.0.0
 */
(function( window, undefined ){

	window.wp = window.wp || {};
	var wp = window.wp;
	var $ = window.jQuery;

	/**
	 * Alias for current file.
	 */
	var api = astoundifyWcThemesEventsProductData;

	// Add Reuseable Functions.
	api.Functions = {};

	/**
	 * Upload Image
	 *
	 * @since 1.0.0
	 */
	api.Functions.UploadImageField = function( button, options ) {
		var uploadOptions = {
			'title': 'Upload',
			'button': 'Insert'
		};

		_.extend( uploadOptions, options );

		var mediaFrame = wp.media( {
			className: 'media-frame astoundify-wc-themes-media-frame',
			frame: 'select',
			title: uploadOptions.title,
			button: {
				text: uploadOptions.button
			},
			multiple: false
		} );

		var img = button.find( 'img' );
		var input = button.find( 'input[type="hidden"]' );

		// Has image.
		if ( button.hasClass( 'remove' ) ) {
			img.attr( 'src', '' );
			input.val( '' );

			button
				.removeClass( 'remove' )
				.trigger( 'change' );
		} else {
			mediaFrame
				.on( 'select', function() {
					var attachment = mediaFrame.state().get( 'selection' ).first().toJSON();

					img.attr( 'src', attachment.sizes.thumbnail.url );
					input.val( attachment.id );

					button.addClass( 'remove' ).trigger( 'change' );
				} )
				.open();
		}
	};

	/**
	 * Date Field
	 *
	 * @since 1.0.0
	 */
	api.Functions.DateField = function( field ) {
		field.datepicker({
			defaultDate: '',
			dateFormat: 'yy-mm-dd',
			numberOfMonths: 1,
			showButtonPanel: true,
		});
	};

	// Add Reuseable Views.
	api.Views = {};

	/**
	 * Toolbar
	 *
	 * @since 1.0.0
	 */
	api.Views.Toolbar = Backbone.View.extend( {
		tagName: 'div',
		className: 'toolbar',

		/**
		 * @since 1.0.0
		 */
		initialize: function( options ) {
		 	_.extend( this, options );
		},

		/**
		 * @since 1.0.0
		 */
		events: {
			'click #add-item': 'addItem',
			'keyup #filter': 'filter'
		},

		/**
		 * @since 1.0.0
		 */
		render: function() {
			this.$el.html( this.template() );
		},

		/**
		 * Add an empty item.
		 *
		 * Can be overridden in an extended class.
		 *
		 * @since 1.0.0
		 */
		addItem: function( e ) {
			e.preventDefault();

			// Add to collection.
			var item = this.collection.add( {} );

			// Set to state to "open".
			$( '[data-cid="' + item.cid + '"]' ).removeClass( 'closed' ).addClass( 'open' );
		},

		/**
		 * Filter a collection. Hides an item but does not remove it.
		 *
		 * @since 1.0.0
		 */
		filter: function( e ) {
			var self = this;
			var $input = $(e.target);
			var search = $input.val();
			var pattern = new RegExp( search, "gi" );
			var missing = [];

			missing = this.collection.filter( function( model ) {
				return ! pattern.test( model.get( 'name' ) );
			} );

			self.collection.trigger( 'filter', missing );
		}
	} );

	/**
	 * Sortable List.
	 *
	 * Useful to add sortable list in WC product data meta box.
	 *
	 * @since 1.0.0
	 */
	api.Views.SortableList = wp.Backbone.View.extend( {
		className: 'wc-metaboxes',

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		initialize: function( options ) {
			// Set a holder for sub-view items.
			this._viewsByCid = {};

		 	_.extend( this, options );

			// Faster to add/remove item instead of re-render the list.
			this.listenTo( this.collection, 'add', this.addOne );
			this.listenTo( this.collection, 'remove', this.removeOne );
			this.listenTo( this.collection, 'filter', this.filter );
		},

		/**
		 * @since 1.0.0
		 */
		render: function() {
			this.$el.sortable( {
				cursor: 'move',
				axis: 'y',
				scrollSensitivity: 40,
				forcePlaceholderSize: true,
				helper: 'clone',
				opacity: 0.65,
				placeholder: 'wc-metabox-sortable-placeholder',
				start: function( event, ui ) {
					ui.item.css( 'background-color', '#f6f6f6' );
				},
				stop: function( event, ui ) {
					ui.item.removeAttr( 'style' );
				}
			} );

			return this;
		},

		/**
		 * Add a single item to the list.
		 *
		 * @since 1.0.0
		 */
		addOne: function( item ) {
			// Get the view of the item/model by item type property.
			var constructor = this.itemViews[ item.get( 'type' ) ];

			// Load the item/model to the view.
			var view = new constructor( {
				model: item,
				collection: this.collection
			} );

			// Add the item in the DOM.
			this.views.add( view );

			// Reinit WooCommerce Enhanced search.
			$( '.wc-customer-search' ).trigger( 'wc-enhanced-select-init' );
			api.Functions.DateField( $( '.date_field_input' ) );

			// Keep a reference to this subview ID so we can destroy the HTML.
			return this._viewsByCid[ item.cid ] = view;
		},

		/**
		 * Remove a single item from the list.
		 *
		 * @since 1.0.0
		 */
		removeOne: function( item ) {
			var self = this;
			var view = self._viewsByCid[ item.cid ];

			if ( view ) {
				// Actually remove from HTML.
				view.remove();

				// Delete internal reference.
				delete self._viewsByCid[ item.cid ];
			}
		},

		/**
		 * Filter found items.
		 *
		 * @since 1.0.0
		 */
		filter: function( missing ) {
			var self = this;

			// Show all.
			if ( _.isEmpty( missing ) ) {
				_.each ( this.views.get(), function( view ) {
					view.$el.show();
				} );

				return;
			}

			// Hide missing items.
			_.each( missing, function( model ) {
				self._viewsByCid[ model.cid ].$el.hide();
			} );
		}
	} );

	/**
	 * Expandable list item view.
	 *
	 * @since 1.0.0
	 */
	api.Views.ExpandableItem = wp.Backbone.View.extend( {
		/**
		 * @since 1.0.0
		 */
		initialize: function( options ) {
		 	_.extend( this, options );
		},

		/**
		 * @since 1.0.0
		 */
		attributes: function() {
			return {
				'data-cid': this.model.cid
			};
		},

		/**
		 * @since 1.0.0
		 */
		events: {
			'keyup .item-name': 'changeName',
			'click .delete': 'removeOne',
			'click .upload_image_button': 'uploadImage'
		},

		/**
		 * Update model data on an name change.
		 *
		 * @since 1.0.0
		 */
		changeName: function( e ) {
			var id = $( e.currentTarget ).data( 'cid' );

			this.collection.get( id ).set( 'name', $( e.currentTarget ).val() );
		},

		/**
		 * Upload Image
		 *
		 * @since 1.0.0
		 */
		uploadImage: function( e ) {
			e.preventDefault();

			var button = $( e.currentTarget );
			var id = button.data( 'cid' );

			// Upload button.
			api.Functions.UploadImageField( button, {
				'title': this.i18n.uploadTitle,
				'button': this.i18n.insertImageButtonText
			} );

			// Set data.
			this.collection.get( id ).set( 'image', button.find( 'input[type="hidden"]' ).val() );
		},

		/**
		 * @since 1.0.0
		 */
		render: function() {
			this.views.add( new astoundifyWcThemesEventsProductData.Views.ExpandableItemHeader( {
				model: this.model,
				template: this.headerTemplate
			} ) );

			this.views.add( new astoundifyWcThemesEventsProductData.Views.ExpandableItemContent( {
				model: this.model,
				template: this.contentTemplate
			} ) );
		},

		/**
		 * Remove a person from the list.
		 *
		 * @since 1.0.0
		 */
		removeOne: function( e ) {
			e.preventDefault(); // Possibly warn.

			var id = $( e.currentTarget ).data( 'cid' );

			// Remove from collections.
			this.collection.remove( id ).destroy();
		}
	} );

	/**
	 * Expandable item header.
	 *
	 * @since 1.0.0
	 */
	api.Views.ExpandableItemHeader = Backbone.View.extend( {
		tagName: 'h3',

		/**
		 * @since 1.0.0
		 */
		initialize: function( options ) {
		 	_.extend(this, options);

			this.listenTo( this.model, 'change', this.render );
		},

		/**
		 * @since 1.0.0
		 */
		render: function() {
			// Add the unique model ID to the JSON.
			var data = _.extend( {}, this.model.toJSON(), { cid: this.model.cid } );

			this.$el.html( this.template( data ) );
		}
	} );

	/**
	 * Expandable item content.
	 *
	 * @since 1.0.0
	 */
	api.Views.ExpandableItemContent = Backbone.View.extend( {
		className: 'wc-metabox-content woocommerce_variable_attributes',

		/**
		 * @since 1.0.0
		 */
		initialize: function( options ) {
		 	_.extend(this, options);
		},

		/**
		 * @since 1.0.0
		 */
		render: function() {
			// Add the unique model ID to the JSON.
			var data = _.extend( {}, this.model.toJSON(), { cid: this.model.cid } );

			this.$el.html( this.template( data ) );
		}
	} );


	/**
	 * Handle WooCommerce tabs/panels.
	 *
	 * @since 1.0.0
	 */
	$(document.body).on( 'wc-init-tabbed-panels', function() {

		$( '.pricing' ).addClass( 'show_if_event' ); // Display price fields in event.
		$( '.inventory_options, ._manage_stock_field, .stock_fields, ._stock_status_field, ._sold_individually_field' ).addClass( 'show_if_event' ); // Display inventory fields in event.
		$( '._sold_individually_field' ).parent( 'div' ).addClass( 'show_if_event' );
		$( '.shipping_options' ).addClass( 'hide_if_event' );
		$( '.attribute_options' ).addClass( 'hide_if_event' );
		$( '.location_options' ).addClass( 'show_if_event' ); // Show location only for Events currently.

		// External Event.
		var external_product_fields = $( '#events-external-fields' );
		var internal_product_fields = $( '.product_data_tabs .inventory_options' );

		var mark_external_event = function() {
			if ( 'event' === $( '#product-type' ).val() ) {
				if( $( '#_external_event' ).is( ':checked' ) ) {
					$( '#_ticket' ).prop( 'checked', false ).trigger( 'change' ).prop( 'disabled', true );
					external_product_fields.show().addClass( 'show_if_event' );
					internal_product_fields.hide().removeClass( 'show_if_event' );
				} else {
					$( '#_ticket' ).prop( 'disabled', false ).trigger( 'change' );
					external_product_fields.hide().removeClass( 'show_if_event' );
					internal_product_fields.show().addClass( 'show_if_event' );
				}
			} else {
				external_product_fields.hide().removeClass( 'show_if_event' );
				internal_product_fields.addClass( 'show_if_event' );
			}
		}

		mark_external_event();
		$( '#_external_event' ).change( function() {
			mark_external_event();
		} );

		$( '#product-type' ).change(); // Trigger on load.

	});

}( window ));
