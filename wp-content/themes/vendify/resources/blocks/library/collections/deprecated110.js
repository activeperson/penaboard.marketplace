/**
 * External dependencies.
 */
import { get, times } from 'lodash';
import classnames from 'classnames';

import { dimRatioToClass, backgroundImageStyles } from './../../utils';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;
const { RichText } = wp.blockEditor;
const { getColorClassName } = wp.editor;

export default function Deprecated110({ attributes } ) {
	const {
		collections,
		align,
		hasParallax,
		hasTextBgBlur,
		dimRatio,
		cards,
		backgroundColor,
		textColor,
		customBackgroundColor,
		customTextColor,
	} = attributes;

	const textClass = getColorClassName( 'color', textColor );
	const backgroundClass = getColorClassName( 'background-color', backgroundColor );
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
									<RichText.Content tagName="div" className="collection-card__badge" value={ badge } />
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
										<span className="collection-card__visit">{ __( 'View' ) }</span>
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
};

