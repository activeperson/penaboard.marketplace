/**
 * External dependencies.
 */
import { get, times } from 'lodash';
import classnames from 'classnames';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { RichText } = wp.blockEditor;

/**
 * Internal dependencies.
 */
import FeaturesEdit from './edit.js';

export const validAlignments = [ 'wide', 'full' ];

/**
 * Register "Features" block.
 *
 * @since 1.0.0
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'vendify/features', {
	title: __( 'Features' ),
	description: __( 'Tell the world what your site is all about.' ),
	icon: 'columns',
	category: 'vendify',
	keywords: [
		__( 'features' ),
	],
	supports: [
		'align',
	],
	attributes: {
		features: {
			type: 'array',
			source: 'query',
			selector: '.feature-block__col',
			query: {
				title: {
					source: 'children',
					selector: '.feature-block__col-title',
				},
				description: {
					source: 'children',
					selector: '.feature-block__col-description',
				},
				url: {
					type: 'string',
					source: 'attribute',
					selector: '.feature-block__col-image img',
					attribute: 'src',
				},
				id: {
					type: 'number',
				},
			},
			default: [ [], [], [] ],
		},
		columns: {
			type: 'number',
			default: 3,
		},
		iconAlign: {
			type: 'string',
			default: 'top',
		},
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
	 */
	edit: FeaturesEdit,

	/**
	 * Save mode.
	 *
	 * @param {Object} attributes Block attributes.
	 * @return {string}
	 */
	save( { attributes } ) {
		const { features, columns, iconAlign } = attributes;

		const classNames = classnames(
			'feature-block',
			{
				[ `feature-block--${ iconAlign }-aligned` ]: true,
				[ `columns-${ columns }` ]: true,
			}
		);

		const isTop = 'top' === iconAlign;

		return (
			<div className={ classNames }>
				<div className="feature-block__cols js-dynamic-slider">
					{ times( columns, ( index ) => {
						const { title, description, url } = get( features, [ index ] );

						return (
							<div className={ `feature-block__col ${ ! isTop ? 'media' : '' }` } key={ index }>
								{ url && (
									<div className="feature-block__col-image">
										<img src={ url } alt="" />
									</div>
								) }

								<div className="media-body">

									{ title && title.length > 0 && (
										<RichText.Content tagName="h3" className="feature-block__col-title" value={ title } />
									) }

									{ description && description.length > 0 && (
										<RichText.Content tagName="p" className="feature-block__col-description" value={ description } />
									) }

								</div>
							</div>
						);
					} ) }
				</div>
			</div>
		);
	},
} );
