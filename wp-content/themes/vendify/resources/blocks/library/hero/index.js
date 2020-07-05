/**
 * External dependencies.
 */
import classnames from 'classnames';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { InnerBlocks } = wp.editor;

/**
 * Internal dependencies.
 */
import HeroEdit from './edit.js';

/**
 * Register "Hero" block.
 *
 * @since 1.0.0
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'vendify/hero', {
	title: __( 'Hero' ),
	description: __( 'Grab your visitor\'s attention with a hero callout!' ),
	icon: 'align-full-width',
	category: 'vendify',
	keywords: [
		__( 'hero' ),
		__( 'call to action' ),
	],
	attributes: {
		title: {
			type: 'string',
		},
		subtitle: {
			type: 'string',
		},
		url: {
			type: 'string',
		},
		align: {
			type: 'string',
		},
		contentAlign: {
			type: 'string',
			default: 'center',
		},
		id: {
			type: 'number',
		},
		hasParallax: {
			type: 'boolean',
			default: false,
		},
		hasAnimation: {
			type: 'boolean',
			default: true,
		},
		dimRatio: {
			type: 'number',
			default: 50,
		},
		paddingTop: {
			type: 'number',
			default: 130,
		},
		paddingBottom: {
			type: 'number',
			default: 130,
		},
	},

	/**
	 * Ensure block alignment is reflected.
	 *
	 * @param {Object} attrributes Block attributes.
	 * @return {Object} Wrapper properties.
	 */
	getEditWrapperProps( attributes ) {
		return {
			'data-align': 'full',
		};
	},

	/**
	 * Edit mode.
	 */
	edit: HeroEdit,

	/**
	 * Save mode.
	 *
	 * Output handled on the server.
	 *
	 * @param {Object} attributes Block attributes.
	 * @return {string}
	 */
	save() {
		return <InnerBlocks.Content />
	},
} );
