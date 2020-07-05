/**
 * WordPress dependencies.
 *
 * @var vendifyEditorSettings
 */
const { __ } = wp.i18n;
const { ServerSideRender } = wp.components;
const { registerBlockType } = wp.blocks;
const { Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, TextControl, SelectControl, RangeControl } = wp.components;

const blockName = 'vendify/featured-vendors';

if ( vendifyEditorSettings.hasVendorIntegration === "1" ) {

	/**
	 * Register "Features Vendors" block.
	 *
	 * @since 1.0.0
	 *
	 * @param  {string}   name     Block name.
	 * @param  {Object}   settings Block settings.
	 * @return {?WPBlock}          The block, if it has been successfully
	 *                             registered; otherwise `undefined`.
	 */
	registerBlockType( blockName, {
		title: __( 'Featured Vendors' ),
		description: __( 'Display the latest featured vendors.' ),
		icon: 'groups',
		category: 'layout',
		keywords: [
			__( 'vendor' ),
			__( 'featured' ),
		],
		attributes: {
			link: {
				type: 'string',
			},
			linkText: {
				type: 'string',
			},
			visitButtonStyle: {
				type: 'string',
			},
			rows: {
				type: 'Number',
			},
		},

		/**
		 * Edit mode.
		 *
		 * @param {Object} props Block properties.
		 * @return {string} Edit block mode.
		 */
		edit( props ) {
			const { attributes, setAttributes } = props;
			const { link, linkText, visitButtonStyle, rows } = attributes;

			return (
				<Fragment>
					<InspectorControls>
						<PanelBody title={__( '"View more" Button' )}>

							<SelectControl
								label={ __( 'Button Style' ) }
								value={ visitButtonStyle }
								options={ [
									{
										value: 'link',
										label: __( 'Classic' ),
									},
									{
										value: 'btn-secondary',
										label: __( 'Button' ),
									},
									{
										value: 'btn-outline-secondary',
										label: __( 'Outline Button' ),
									}
								] }
								onChange={ ( newValue ) => setAttributes( { visitButtonStyle: newValue } ) }
							/>

							<TextControl
								label={ __( '"View More" URL' ) }
								value={ link || '' }
								onChange={ ( link ) => {
									setAttributes( {
										link,
									} );
								} }
							/>

							<TextControl
								label={ __( '"View More" Text' ) }
								value={ linkText || '' }
								onChange={ ( linkText ) => {
									setAttributes( {
										linkText,
									} );
								} }
							/>
						</PanelBody>
						<PanelBody title={__( 'Layout' )}>
							<RangeControl
								label={ __( 'Rows' ) }
								value={ rows || 1 }
								min={ 1 }
								max={ 5 }
								onChange={ ( rows ) => {
									setAttributes( {
										rows,
									} );
								} }
							/>
						</PanelBody>
					</InspectorControls>

					<ServerSideRender block={ blockName } attributes={ attributes } />
				</Fragment>
			);
		},

		/**
		 * Save mode.
		 *
		 * @return {null} Nothing.
		 */
		save() {
			return null;
		},
	} );
}
