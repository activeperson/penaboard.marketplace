/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;
const { ServerSideRender } = wp.components;
const { registerBlockType } = wp.blocks;
const { Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, TextControl, RangeControl, SelectControl } = wp.components;

const blockName = 'vendify/blog-posts';

/**
 * Register "Blog Posts" block.
 *
 * @since 1.0.0
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( blockName, {
	title: __( 'Blog Posts' ),
	description: __( 'Add a grid of recent blog posts.' ),
	icon: 'admin-post',
	category: 'vendify',
	keywords: [
		__( 'blog' ),
		__( 'post' ),
		__( 'latest' ),
	],
	attributes: {
		link: {
			type: 'string',
		},
		linkText: {
			type: 'string',
		},
		cardStyle: {
			type: 'string',
		},
		visitButtonStyle: {
			type: 'string',
		},
		number: {
			type: 'number',
			default: 3,
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
		const { link, linkText, number, visitButtonStyle, cardStyle } = attributes;

		return (
			<Fragment>
				<InspectorControls>
					<PanelBody title={__( 'Grid Options' )}>
						<SelectControl
							label={ __( 'Card Style' ) }
							value={ cardStyle }
							options={ [
								{
									value: 'classic',
									label: __( 'Classic' ),
								},
								{
									value: 'card',
									label: __( 'Card' ),
								},
								{
									value: 'dark',
									label: __( 'Dark' ),
								}
							] }
							onChange={ ( newValue ) => setAttributes( { cardStyle: newValue } ) }
						/>

						<RangeControl
							label={ __( 'Number of Posts' ) }
							value={ number }
							onChange={ ( number ) => setAttributes( { number } ) }
							min={ 3 }
							max={ 99 }
							step={ 3 }
						/>
					</PanelBody>

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
									value: 'btn-primary',
									label: __( 'Button' ),
								},
								{
									value: 'btn-outline-primary',
									label: __( 'Outline Button' ),
								}
							] }
							onChange={ ( newValue ) => setAttributes( { visitButtonStyle: newValue } ) }
						/>
						<TextControl
							label={ __( '"View More" URL' ) }
							value={ attributes.link || '' }
							onChange={ ( link ) => {
								setAttributes( {
									link,
								} );
							} }
						/>

						<TextControl
							label={ __( '"View More" Text' ) }
							value={ attributes.linkText || '' }
							onChange={ ( linkText ) => {
								setAttributes( {
									linkText,
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
