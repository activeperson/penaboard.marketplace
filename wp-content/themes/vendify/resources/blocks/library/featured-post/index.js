/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;
const { ServerSideRender } = wp.components;
const { registerBlockType } = wp.blocks;
const { InspectorControls, BlockControls, BlockAlignmentToolbar } = wp.blockEditor;
const { PanelBody, TextControl } = wp.components;

import classnames from 'classnames';

export const validAlignments = [ 'wide', 'full' ];

const blockName = 'vendify/featured-post';

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
	title: __( 'Featured Post' ),
	description: __( 'Add a featured post.' ),
	icon: 'admin-post',
	category: 'vendify',
	keywords: [
		__( 'featured' ),
		__( 'post' ),
	],
	attributes: {
		postID: {
			type: 'string',
			default: '1'
		},
		linkText: {
			type: 'string',
			default: 'View More'
		},
		align: {
			type: 'string',
		}
	},

	/**
	 * Ensure block alignment is reflected.
	 *
	 * @param {Object} attrributes Block attributes.
	 * @return {Object} Wrapper properties.
	 */
	getEditWrapperProps( attributes ) {
		const {
			align,
		} = attributes;

		if ( -1 !== validAlignments.indexOf( align ) ) {
			return { 'data-align': align };
		}
	},

	/**
	 * Edit mode.
	 *
	 * @param {Object} props Block properties.
	 * @return {string} Edit block mode.
	 */
	edit( props ) {
		const { attributes, setAttributes } = props;
		const { postID, linkText, align } = attributes;

		const classNames = classnames(
			'featured-post',
			{
				[ `align${ align }` ]: align,
			}
		);

		return (
			<div className={ classNames }>
				<BlockControls>
					<BlockAlignmentToolbar
						value={ align }
						onChange={ ( value ) => setAttributes( { align: value } ) }
						controls={ validAlignments }
					/>
				</BlockControls>
				<InspectorControls>
					<PanelBody>
						<TextControl
							label={ __( 'Post ID' ) }
							value={ postID }
							onChange={ ( postID ) => setAttributes( { postID } ) }
						/>
{/**
						<TextControl
							label={ __( '"View More" URL' ) }
							value={ attributes.link || '' }
							onChange={ ( link ) => {
								setAttributes( {
									link,
								} );
							} }
						/>
*/}
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
				</InspectorControls>

				<ServerSideRender block={ blockName } attributes={ attributes } />
			</div>
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
