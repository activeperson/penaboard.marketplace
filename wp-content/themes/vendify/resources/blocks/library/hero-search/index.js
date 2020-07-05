/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { InspectorControls } = wp.blockEditor;
const { Disabled, PanelBody, TextControl } = wp.components;
const { ServerSideRender } = wp.editor;
const { Fragment } = wp.element;

/**
 * Register "Hero Search" block.
 *
 * @since 1.0.0
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'vendify/hero-search', {
	title: __( 'Search Form' ),
	description: __( 'Search for products or vendors.' ),
	icon: 'search',
	category: 'vendify',
	keywords: [
		__( 'hero' ),
		__( 'search' ),
	],
	attributes: {
		keywordPlaceholder: {
			type: 'string',
			default: 'Keyword...',
		},
		// locationPlaceholder: {
		// 	type: 'string',
		// 	default: 'Location...',
		// },
		searchValue: {
			type: 'string',
			default: 'Find',
		},
	},

	/**
	 * Edit mode.
	 */
	edit( { attributes, setAttributes } ) {
		return (
			<Fragment>
				<InspectorControls>
					<PanelBody>
						<TextControl
							label={ __( 'Keywords Placeholder' ) }
							value={ attributes.keywordPlaceholder || '' }
							onChange={ ( keywordPlaceholder ) => {
								setAttributes( {
									keywordPlaceholder,
								} );
							} }
						/>

						<TextControl
							label={ __( 'Vendor Location Placeholder' ) }
							value={ attributes.locationPlaceholder || '' }
							onChange={ ( locationPlaceholder ) => {
								setAttributes( {
									locationPlaceholder,
								} );
							} }
						/>

						<TextControl
							label={ __( 'Submit Button' ) }
							value={ attributes.searchValue || '' }
							onChange={ ( searchValue ) => {
								setAttributes( {
									searchValue,
								} );
							} }
						/>
					</PanelBody>
				</InspectorControls>

				<Disabled>
					<ServerSideRender block="vendify/hero-search" attributes={ attributes } />
				</Disabled>
			</Fragment>
		);
	},

	/**
	 * Save mode.
	 *
	 * Output handled on the server.
	 *
	 * @return null
	 */
	save() {
		return null;
	},
} );
