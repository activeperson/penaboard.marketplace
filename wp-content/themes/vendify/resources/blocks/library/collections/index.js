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
const { getColorClassName } = wp.editor;

/**
 * Internal dependencies.
 */
import CollectionsEdit from './edit.js';
import { dimRatioToClass, backgroundImageStyles } from './../../utils';
import Deprecated110 from './deprecated110';

export const validAlignments = [ 'wide', 'full' ];

const blockAttributes = {
	collections: {
		type: 'array',
		source: 'query',
		selector: '.collection-card',
		query: {
			badge: {
				type: 'string',
				source: 'children',
				selector: '.collection-card__badge',
			},
			supTitle: {
				type: 'string',
				source: 'children',
				selector: '.collection-card__category',
			},
			title: {
				type: 'string',
				source: 'children',
				selector: '.collection-card__title',
			},
			description: {
				type: 'string',
				source: 'children',
				selector: '.collection-card__description',
			},
			link: {
				type: 'string',
				source: 'attribute',
				selector: '.collection-card__link',
				attribute: 'href',
			},
			url: {
				type: 'string',
				source: 'attribute',
				selector: '.collection-card__image',
				attribute: 'data-url',
			},
			id: {
				type: 'number',
				source: 'attribute',
				selector: '.collection-card__image',
				attribute: 'data-id',
			},
		},
		default: [ [], [], [] ],
	},
	hasParallax: {
		type: 'boolean',
		default: false,
	},
	hasTextBgBlur: {
		type: 'boolean',
		default: false,
	},
	dimRatio: {
		type: 'number',
		default: 50,
	},
	cards: {
		type: 'number',
		default: 3,
	},
	align: {
		type: 'string',
	},
	backgroundColor: {
		type: 'string',
	},
	textColor: {
		type: 'string',
	},
	badgeTextColor: {
		type: 'string',
		default: 'light'
	},
	badgeBackgroundColor: {
		type: 'string',
		default: 'primary'
	},
	customTextColor: {
		type: "string"
	},
	customBackgroundColor: {
		type: "string"
	},
};

/**
 * Register "Collections" block.
 *
 * @since 1.0.0
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'vendify/collections', {
	title: __( 'Collections' ),
	description: __( 'Quickly link to different area\'s of your website or highlight new products.' ),
	icon: 'screenoptions',
	category: 'vendify',
	keywords: [
		__( 'collections' ),
	],
	attributes: blockAttributes,

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
	edit: CollectionsEdit,

	/**
	 * Save mode.
	 *
	 * @param {Object} attributes Block attributes.
	 * @return {string} Block.
	 */
	save( { attributes } ) {
		const {
			collections,
			align,
			hasParallax,
			hasTextBgBlur,
			dimRatio,
			cards,
			backgroundColor,
			textColor,
			badgeTextColor,
			badgeBackgroundColor,
			customBackgroundColor,
			customTextColor,
			customBadgeTextColor,
			customBadgeBackgroundColor,
		} = attributes;
		const textClass = getColorClassName( 'color', textColor );
		const backgroundClass = getColorClassName( 'background-color', backgroundColor );
		const badgeTextClass = getColorClassName( 'color', badgeTextColor );
		const badgeBackgroundClass = getColorClassName( 'background-color', badgeBackgroundColor );
		const classNames = classnames(
			'collections',
			{
				[ `align${ align }` ]: align,
				[ `cards-${ cards }` ]: true,
				'has-text-bg': !!hasTextBgBlur,
			}
		);

		const textStyle = {
			color: textClass ? undefined : customTextColor,
		};

		const textClassNames = classnames({
			'has-text-color': textColor || customTextColor,
			[ textClass ]: textClass,
		});

		const badgeClassNames = classnames( 'collection-card__badge', {
			[ `badge badge-${ badgeBackgroundColor }` ]: !!badgeBackgroundColor,
			[ `has-text-color has-${ badgeTextColor }-color` ]: !!badgeTextColor
		});

		const buttonClassNames = classnames( 'collection-card__visit', {
			[ `button btn-${ badgeBackgroundColor }` ]: !!badgeBackgroundColor,
			[ `has-text-color has-${ badgeTextColor }-color` ]: !!badgeTextColor
		});

		const badgeStyle = {
			color: badgeTextClass ? undefined : customBadgeTextColor,
			backgroundColor: badgeBackgroundClass ? undefined : customBadgeBackgroundColor
		};

		return (
			<div className={ classNames }>
				{ times( cards, ( index ) => {
					// Every collection shares child attributes.
					const { supTitle, title, description, badge, link, url, id } = get( collections, [ index ] ) || {};

					let imageStyle = backgroundImageStyles( url );

					if ( ! backgroundClass && imageStyle ) {
						imageStyle.backgroundColor = customBackgroundColor;
					}

					const imageClassName = classnames(
						'collection-card__image',
						dimRatioToClass( dimRatio ),
						{
							'has-parallax': hasParallax,
							'has-background': backgroundColor || customBackgroundColor,
							[ backgroundClass ]: backgroundClass,
						}
					);

					return (
						<div className="collection-card-wrap" key={ index }>
							<div className="collection-card">
								{ link && link.length > 0 && (
									<a href={ link } className={textClassNames + " collection-card__link"} style={textStyle} />
								) }

								<div className="collection-card__content">
									{ badge && badge.length > 0 && (
										<RichText.Content tagName="div" className={badgeClassNames} style={badgeStyle} value={ badge } />
									) }

									<div className="collection-card__content-inner">
										{ supTitle && supTitle.length > 0 && (
											<RichText.Content tagName="div" className={textClassNames + " collection-card__category"} value={ supTitle } style={textStyle} />
										) }

										{ title && title.length > 0 && (
											<RichText.Content tagName="h3" className={textClassNames + " collection-card__title"} value={ title } style={textStyle} />
										) }

										{ description && description.length > 0 && (
											<RichText.Content tagName="div" className={textClassNames + " collection-card__description"} value={ description } style={textStyle} />
										) }
									</div>

									{ link && link.length > 0 && (
										0 !== index ? (
											<span className={textClassNames + " collection-card__arrow"} style={textStyle}>&rarr;</span>
										) : (
											<span className={buttonClassNames} style={badgeStyle}>{ __( 'View' ) }</span>
										)
									) }
								</div>

								{ url && (
									<div data-id={ id } data-url={ url } style={ imageStyle } className={ imageClassName }></div>
								) }
							</div>
						</div>
					);
				} ) }
			</div>
		);
	},
	deprecated: [
		{
			attributes: {
				...blockAttributes,
			},
			save: Deprecated110,
		}
	]
} );
