/**
 * External dependencies.
 */
import { get, times, pick, forEach } from 'lodash';
import classnames from 'classnames';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;
const { getBlobByURL } = wp.blob;
const { Component, Fragment } = wp.element;
const { compose } = wp.compose;
const {
	RichText,
	BlockControls,
	BlockAlignmentToolbar,
	InspectorControls,
	withColors
} = wp.blockEditor;
const {
	MediaUpload,
	editorMediaUpload,
	URLInput,
	PanelColorSettings,
	ContrastChecker
} = wp.editor;

const { withFallbackStyles, withNotices, PanelBody, RangeControl, ToggleControl, IconButton } = wp.components;

const applyFallbackStyles = withFallbackStyles( ( node, ownProps ) => {
	const { textColor, backgroundColor } = ownProps.attributes;
	const editableNode = node.querySelector( '[contenteditable="true"]' );

	//verify if editableNode is available, before using getComputedStyle.
	const computedStyles = editableNode ? getComputedStyle( editableNode ) : null;
	return {
		fallbackBackgroundColor: backgroundColor || ! computedStyles ? undefined : computedStyles.backgroundColor,
		fallbackTextColor: textColor || ! computedStyles ? undefined : computedStyles.color
	};
} );

/**
 * Internal dependencies.
 */
import { validAlignments } from './index.js';
import { updateDeep, dimRatioToClass, backgroundImageStyles } from './../../utils';

/**
 * Edit a list of collections.
 */
class CollectionsEdit extends Component {
	constructor() {
		super( ...arguments );

		this.updateCollection = this.updateCollection.bind( this );
		this.onSelectImage = this.onSelectImage.bind( this );
	}

	/**
	 * Get the image's IDs from the URL so they can be preselected when editing.
	 */
	componentDidMount() {
		const { attributes } = this.props;
		const { collections, cards } = attributes;

		times( cards, ( index ) => {
			const { id, url = '' } = collections[ index ];

			if ( ! id && url.indexOf( 'blob:' ) === 0 ) {
				const file = getBlobByURL( url );

				if ( file ) {
					editorMediaUpload( {
						filesList: [ file ],
						onFileChange: ( [ image ] ) => {
							this.updateCollection( index, pick( image, [ 'id', 'url' ] ) );
						},
						allowedType: 'image',
					} );
				}
			}
		} );
	}

	/**
	 * Helper to update an individual feature's image.
	 *
	 * @param {number} index Feature index to update.
	 * @param {Object} media WordPress media object.
	 */
	onSelectImage( index, media ) {
		if ( ! media ) {
			return;
		}

		const vars = pick( media, [ 'id', 'url' ] );

		forEach( vars, ( value, key ) => {
			this.updateCollection( index, {
				[ key ]: value,
			} );
		} );
	}

	/**
	 * Helper to update an individual collection.
	 *
	 * @param {number} index Collection index to update.
	 * @param {Object} update Object properties to update.
	 */
	updateCollection( index, update ) {
		const { attributes, setAttributes } = this.props;

		setAttributes( {
			collections: updateDeep( attributes.collections, index, update ),
		} );
	}

	/**
	 * Render Block.
	 *
	 * @return {string} Block editing.
	 */
	render() {
		const { props } = this;
		const {
			attributes,
			setAttributes,
			className,
			noticeUI,
			isSelected,
			setBackgroundColor,
			setTextColor,
			setBadgeTextColor,
			setBadgeBackgroundColor,
			fallbackBackgroundColor,
			fallbackTextColor,
		} = props;

		const backgroundColorProp = props.backgroundColor;
		const textColorProp = props.textColor;
		const badgeTextColorProp = props.badgeTextColor;
		const badgeBackgroundColorProp = props.badgeBackgroundColor;
		const {
			collections,
			align,
			hasParallax,
			hasTextBgBlur,
			dimRatio,
			cards = 3,
			backgroundColor,
			textColor,
			badgeTextColor,
			badgeBackgroundColor,
		} = attributes;

		const controls = (
			<Fragment>
				<BlockControls>
					<BlockAlignmentToolbar
						value={ align }
						onChange={ ( value ) => setAttributes( { align: value } ) }
						controls={ validAlignments }
					/>
				</BlockControls>

				<InspectorControls>
					<PanelBody>
						<ToggleControl
							label={ __( 'Show Extra Collections' ) }
							checked={ 5 === cards }
							onChange={ () => setAttributes( { cards: ( 5 === cards ? 3 : 5 ) } ) }
						/>
					</PanelBody>
					<PanelBody title={ __( 'Background Image Settings' ) }>
						<ToggleControl
							label={ __( 'Fixed Background' ) }
							checked={ hasParallax }
							onChange={ ( hasParallax ) => setAttributes( { hasParallax } ) }
						/>
						<ToggleControl
							label={ __( 'Text Background' ) }
							checked={ hasTextBgBlur }
							onChange={ ( hasTextBgBlur ) => setAttributes( { hasTextBgBlur } ) }
						/>
						<RangeControl
							label={ __( 'Dark Overlay' ) }
							value={ dimRatio }
							onChange={ ( dimRatio ) => setAttributes( { dimRatio } ) }
							min={ 0 }
							max={ 90 }
							step={ 5 }
						/>
					</PanelBody>
					<PanelColorSettings
						title={ __( 'Color Settings' ) }
						colorSettings={ [
							{
								value: backgroundColorProp.color,
								onChange: setBackgroundColor,
								label: __( 'Background Color' ),
							},
							{
								value: textColorProp.color,
								onChange: setTextColor,
								label: __( 'Text Color' ),
							},
							{
								value: badgeBackgroundColorProp.color,
								onChange: setBadgeBackgroundColor,
								label: __( 'Badge Color' ),
							},
							{
								value: badgeTextColorProp.color,
								onChange: setBadgeTextColor,
								label: __( 'Badge Text Color' ),
							},
						]}
					>
						{ textColorProp.hasOwnProperty( 'color' ) && backgroundColorProp.hasOwnProperty( 'color' ) && (
							<ContrastChecker
								{ ...{
									textColor: textColorProp.color,
									backgroundColor: backgroundColorProp.color,
									badgeTextColor: badgeTextColorProp.color,
									badgeBackgroundColor: badgeBackgroundColorProp.color,
									fallbackTextColor,
									fallbackBackgroundColor,
								} }
								isLargeText={ false }
							/>
						)}
					</PanelColorSettings>
				</InspectorControls>
			</Fragment>
		);

		const classNames = classnames(
			'collections',
			{
				[ className ]: true,
				[ `align${ align }` ]: align,
				[ `cards-${ cards }` ]: true,
				'has-text-bg': !!hasTextBgBlur,
			}
		);

		const textClassNames = classnames({
			[ `has-text-color has-${ textColor }-color` ]: !!textColor
		});

		const textStyle = {
			color: textColorProp.color,
		};

		const badgeClassNames = classnames( 'collection-card__badge', {
			[ `badge badge-${ badgeBackgroundColor }` ]: !!badgeBackgroundColor,
			[ `has-text-color has-${ badgeTextColor }-color` ]: !!badgeTextColor
		});

		const buttonClassNames = classnames( 'collection-card__visit', {
			[ `btn btn-${ badgeBackgroundColor }` ]: !!badgeBackgroundColor,
			[ `has-text-color has-${ badgeTextColor }-color` ]: !!badgeTextColor
		});

		const badgeStyle = {
			color: badgeTextColorProp.color,
			backgroundColor: badgeBackgroundColorProp.color
		};

		return (
			<Fragment>
				{ noticeUI }
				{ controls }

				<div className={ classNames }>
					{ times( cards, ( index ) => {
						// Every collection shares child attributes.
						const { supTitle, title, description, badge, link, url, id } = get( collections, [ index ] ) || {};

						let imageStyle = backgroundImageStyles( url );

						if ( backgroundColorProp.color && imageStyle ) {
							imageStyle.backgroundColor = backgroundColorProp.color;
						}

						const imageClassName = classnames(
							'collection-card__image',
							dimRatioToClass( dimRatio ),
							{
								'has-background-dim': dimRatio !== 0,
								'has-parallax': hasParallax,
								[ `has-background has-${ backgroundColor }-background-color` ]: !!backgroundColor,
							}
						);

						return (
							<Fragment key={ index }>
								<div className="collection-card-wrap">
									<div className="collection-card">
										<div className="collection-card__content">
											{ ( badge || isSelected ) && (
												<div className={badgeClassNames}>
													<RichText
														value={ badge }
														style={badgeStyle}
														multitline={ false }
														onChange={ ( badge ) => this.updateCollection( index, { badge } ) }
														placeholder={ 'Sale' }
													/>
												</div>
											) }

											<div className="collection-card__content-inner">
												{ ( supTitle || isSelected ) && (
													<RichText
														className={textClassNames + " collection-card__category"}
														style={textStyle}
														value={ supTitle }
														multitline={ false }
														onChange={ ( supTitle ) => this.updateCollection( index, { supTitle } ) }
														placeholder={ 'Collection supTitle' }
													/>
												) }

												{ ( title || isSelected ) && (
													<RichText
														tagName="h3"
														className={textClassNames + " collection-card__title"}
														style={textStyle}
														value={ title }
														multitline={ false }
														onChange={ ( title ) => this.updateCollection( index, { title } ) }
														placeholder={ 'Collection Title' }
													/>
												) }

												{ ( description || isSelected ) && (
													<RichText
														className={textClassNames + " collection-card__description"}
														style={textStyle}
														value={ description }
														multitline={ false }
														onChange={ ( description ) => this.updateCollection( index, { description } ) }
														placeholder={ 'Collection description...' }
													/>
												) }
											</div>

											{ link && (
												0 !== index ? (
													<span className={textClassNames + " collection-card__arrow"} style={textStyle}>&rarr;</span>
												) : (
													<span className={buttonClassNames} style={badgeStyle}>{ __( 'View' ) }</span>
												)
											) }
										</div>

										{ url && (
											<div data-url={ url } data-id={ id } style={ imageStyle } className={ imageClassName } ></div>
										) }
									</div>

									{ isSelected && (
										<div className="collection-card-edit">
											<URLInput
												value={ link }
												onChange={ ( link ) => this.updateCollection( index, { link } ) }
											/>

											<MediaUpload
												gallery={ false }
												multiple={ false }
												onSelect={ ( media ) => this.onSelectImage( index, media ) }
												type="image"
												value={ id }
												render={ ( { open } ) => (
													<IconButton className="edit-image" icon="format-image" onClick={ open } />
												) }
											/>
										</div>
									) }
								</div>
							</Fragment>
						);
					} ) }
				</div>
			</Fragment>
		);
	}
}

export default compose([
	withColors( {
		backgroundColor: 'background-color',
		textColor: 'color',
		badgeBackgroundColor: 'background-color',
		badgeTextColor: 'color'
	} ),
	withNotices,
	applyFallbackStyles
])( CollectionsEdit );
