/**
 * External dependencies.
 */
import classnames from 'classnames';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;
const { Component, Fragment } = wp.element;
const { RichText, BlockControls, BlockAlignmentToolbar, InspectorControls } = wp.blockEditor;
const { MediaUpload, MediaPlaceholder } = wp.editor;
const { withNotices, PanelBody, RangeControl, TextControl, ToggleControl, IconButton } = wp.components;

/**
 * Internal dependencies.
 */
import { validAlignments } from './index.js';
import { dimRatioToClass, backgroundImageStyles } from './../../utils';

/**
 * Edit a testimonial.
 */
class TestimonialEdit extends Component {
	render() {
		const { attributes, setAttributes, className, isSelected, noticeUI } = this.props;
		const { quote, cite, avatarUrl, avatarId, videoText, videoUrl, backgroundUrl, backgroundId, hasParallax, dimRatio, align } = attributes;

		const onSelectBackgroundImage = ( media ) => setAttributes( { backgroundUrl: media.url, backgroundId: media.id } );
		const onSelectAvatarImage = ( media ) => setAttributes( { avatarUrl: media.url, avatarId: media.id } );
		const toggleParallax = () => setAttributes( { hasParallax: ! hasParallax } );
		const setDimRatio = ( ratio ) => setAttributes( { dimRatio: ratio } );

		const controls = (
			<Fragment>

				<BlockControls>
					<BlockAlignmentToolbar
						value={ align }
						onChange={ ( value ) => setAttributes( { align: value } ) }
						controls={ validAlignments }
					/>
					<MediaUpload
						onSelect={ onSelectBackgroundImage }
						type="image"
						value={ backgroundId }
						render={ ( { open } ) => (
							<IconButton
								className="components-toolbar__control"
								label={ __( 'Edit image' ) }
								icon="edit"
								onClick={ open }
							/>
						) }
					/>
				</BlockControls>

				<InspectorControls>
					<PanelBody>
						<TextControl
							label={ __( 'Video URL' ) }
							value={ videoUrl || '' }
							onChange={ ( videoUrl ) => {
								setAttributes( {
									videoUrl,
								} );
							} }
						/>
					</PanelBody>

					{ !! backgroundUrl && (
						<PanelBody title={ __( 'Background Image Settings' ) }>
							<ToggleControl
								label={ __( 'Fixed Background' ) }
								checked={ !! hasParallax }
								onChange={ toggleParallax }
							/>
							<RangeControl
								label={ __( 'Background Opacity' ) }
								value={ dimRatio }
								onChange={ setDimRatio }
								min={ 10 }
								max={ 90 }
								step={ 5 }

							/>
						</PanelBody>
					) }
				</InspectorControls>

			</Fragment>
		);

		if ( ! backgroundUrl ) {
			return (
				<Fragment>
					{ controls }
					<MediaPlaceholder
						icon="format-image"
						className={ className }
						labels={ {
							title: __( 'Background Image' ),
							name: __( 'an image' ),
						} }
						onSelect={ onSelectBackgroundImage }
						accept="image/*"
						type="image"
					/>
				</Fragment>
			);
		}

		const imageClassNames = classnames(
			'testimonial-banner',
			dimRatioToClass( dimRatio ),
			{
				'has-background-dim': dimRatio !== 0,
				'has-parallax': hasParallax,
			}
		);

		const imageStyle = backgroundImageStyles( backgroundUrl );

		return (
			<Fragment>
				{ noticeUI }
				{ controls }

				<div className={ className }>
					<div className={ imageClassNames } style={ imageStyle } data-url={ backgroundUrl }>
						<div className="container">
							<div className="testimonial-banner__content">

								{ ( quote || isSelected ) && (
									<blockquote className="testimonial-banner__quote">
										<RichText
											tagName="p"
											value={ quote }
											multitline={ true }
											onChange={ ( quote ) => setAttributes( { quote: quote } ) }
											placeholder={ 'I love this website...' }
											keepPlaceholderOnFocus
										/>
									</blockquote>
								) }

								<div className="testimonial-banner__author">
									<MediaUpload
										gallery={ false }
										multiple={ false }
										onSelect={ onSelectAvatarImage }
										type="image"
										value={ avatarId }
										render={ ( { open } ) => (
											isSelected || ( ! avatarUrl && isSelected ) ? (
												<IconButton className="edit-image" icon="format-image" onClick={ open } />
											) : (
												<img src={ avatarUrl } alt="" />
											)
										) }
									/>

									{ ( cite || isSelected ) && (
										<span className="testimonial-banner__author-name">
											<RichText
												tagName="span"
												value={ cite }
												multitline={ false }
												onChange={ ( cite ) => setAttributes( { cite } ) }
												placeholder={ 'John Doe' }
											/>
										</span>
									) }
								</div>

								{ ( videoText || videoUrl || isSelected ) && (
									<div className="testimonial-banner__watch">
										<RichText
											tagName="span"
											value={ videoText }
											multitline={ false }
											onChange={ ( videoText ) => setAttributes( { videoText } ) }
											placeholder={ 'Watch the Video' }
											keepPlaceholderOnFocus
										/>
									</div>
								) }

							</div>
						</div>
					</div>
				</div>
			</Fragment>
		);
	}
}

export default withNotices( TestimonialEdit );
