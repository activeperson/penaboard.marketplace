/**
 * External dependencies.
 */
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
import TestimonialEdit from './edit.js';
import { dimRatioToClass, backgroundImageStyles } from './../../utils';

export const validAlignments = [ 'wide', 'full' ];

/**
 * Register "Testimonial" block.
 *
 * @since 1.0.0
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'vendify/testimonial', {
	title: __( 'Testimonial' ),
	description: __( 'Add a testimonial with an optional video' ),
	icon: 'format-quote',
	category: 'vendify',
	keywords: [
		__( 'testimonial' ),
		__( 'quote' ),
	],
	attributes: {
		quote: {
			type: 'array',
			source: 'children',
			selector: '.testimonial-banner__quote p',
		},
		cite: {
			type: 'array',
			source: 'children',
			selector: '.testimonial-banner__author-name',
		},
		videoText: {
			type: 'array',
			source: 'children',
			selector: '.testimonial-banner__watch span',
		},
		videoUrl: {
			type: 'string',
		},
		avatarUrl: {
			type: 'string',
		},
		avatarId: {
			type: 'number',
		},
		backgroundUrl: {
			type: 'string',
		},
		backgroundId: {
			type: 'number',
		},
		hasParallax: {
			type: 'boolean',
			default: false,
		},
		dimRatio: {
			type: 'number',
			default: 50,
		},
		align: {
			type: 'string',
		},
	},

	/**
	 * Ensure the block is always in full align mode.
	 *
	 * @param {Object} attributes Block attributes.
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
	edit: TestimonialEdit,

	/**
	 * Save mode.
	 *
	 * @param {Object} attributes Block attributes.
	 * @return {string} Block.
	 */
	save( { attributes, className } ) {
		const { quote, cite, avatarUrl, videoUrl, videoText, hasParallax, dimRatio, backgroundUrl, align } = attributes;

		const classNames = classnames(
			'testimionial-banner',
			dimRatioToClass( dimRatio ),
			{
				[ `align${ align }` ]: align,
				'has-background-dim': dimRatio !== 0,
				'has-parallax': hasParallax,
			}
		);

		const imageStyle = backgroundImageStyles( backgroundUrl );

		return (
			<div className={ className }>
				<div className={ classNames } style={ imageStyle } data-url={ backgroundUrl }>
					<div className="container">
						<div className="testimonial-banner__content">

							{ quote && quote.length > 0 && (
								<blockquote className="testimonial-banner__quote">
									<RichText.Content tagName="p" value={ quote } />
								</blockquote>
							) }

							{ cite && cite.length > 0 && (
								<div className="testimonial-banner__author">
									{ avatarUrl && (
										<img src={ avatarUrl } alt="" />
									) }

									<RichText.Content className="testimonial-banner__author-name" tagName="span" value={ cite } />
								</div>
							) }

							{ videoUrl && videoUrl.length > 0 && (
								<a href={ videoUrl } className="testimonial-banner__watch" target="_blank" rel="noindex noopener noreferrer">
									{ videoText && videoText.length > 0 && (
										<RichText.Content tagName="span" value={ videoText } />
									) }
								</a>
							) }

						</div>
					</div>
				</div>
			</div>
		);
	},
} );
