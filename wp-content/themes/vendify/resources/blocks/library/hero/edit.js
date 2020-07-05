/**
 * External dependencies.
 */
import { isEmpty } from 'lodash';
import classnames from 'classnames';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;
const { Component, Fragment } = wp.element;
const { InspectorControls, RichText, BlockControls } = wp.blockEditor;
const { InnerBlocks, AlignmentToolbar, MediaUpload, MediaPlaceholder } = wp.editor;
const { IconButton, PanelBody, RangeControl, ToggleControl, Toolbar, withNotices } = wp.components;

/**
 * Internal dependencies.
 */
import { dimRatioToClass, backgroundImageStyles } from './../../utils';

/**
 * Edit a hero.
 */
class HeroEdit extends Component {

	/**
	 * Render Block.
	 *
	 * @return {string} Block editing.
	 */
	render() {
		const { attributes, setAttributes, isSelected, className, noticeOperations, noticeUI } = this.props;
		const { url, title, subtitle, align, contentAlign, id, hasParallax, hasAnimation, dimRatio, paddingTop, paddingBottom } = attributes;

		const updateAlignment = ( nextAlign ) => setAttributes( { align: nextAlign } );
		const toggleParallax = () => setAttributes( { hasParallax: ! hasParallax } );
		const toggleAnimation = () => setAttributes( { hasAnimation: ! hasAnimation } );
		const toggleSearchForm = () => setAttributes( { hasSearchForm: ! hasSearchForm } );
		const setDimRatio = ( ratio ) => {
			if ( ratio === 5 ) {
				setAttributes( { dimRatio: 0 } )
			} else {
				setAttributes( { dimRatio: ratio } )
			}
		};
		const setPaddingTop = ( padding ) => setAttributes( { paddingTop: padding } );
		const setPaddingBottom = ( padding ) => setAttributes( { paddingBottom: padding } );

		const onSelectImage = ( media ) => {
			if ( ! media || ! media.url ) {
				setAttributes( { url: undefined, id: undefined } );
				return;
			}
			setAttributes( { url: media.url, id: media.id } );
		};

		const style = backgroundImageStyles( url );
		const classes = classnames(
			className,
			dimRatioToClass( dimRatio ),
			{
				'has-background-dim': dimRatio !== 0,
				'has-parallax': hasParallax,
				'hero--animatable': hasAnimation,
			}
		);

		const controls = (
			<Fragment>
				<BlockControls>
					<AlignmentToolbar
						value={ contentAlign }
						onChange={ ( nextAlign ) => {
							return setAttributes( { contentAlign: nextAlign } );
						} }
					/>
					<Toolbar>
						<MediaUpload
							onSelect={ onSelectImage }
							type="image"
							value={ id }
							render={ ( { open } ) => (
								<IconButton
									className="components-toolbar__control"
									label={ __( 'Edit image' ) }
									icon="edit"
									onClick={ open }
								/>
							) }
						/>
					</Toolbar>
				</BlockControls>
				{ !! url && (
					<InspectorControls>
						<PanelBody title={ __( 'Background Image' ) }>
							<ToggleControl
								label={ __( 'Parallax Background' ) }
								checked={ !! hasParallax }
								onChange={ toggleParallax }
							/>
							<ToggleControl
								label={ __( 'Animated Background' ) }
								checked={ !! hasAnimation }
								onChange={ toggleAnimation }
							/>
							<RangeControl
								label={ __( 'Background Opacity' ) }
								value={ dimRatio }
								onChange={ setDimRatio }
								min={ 0 }
								max={ 90 }
								step={ 5 }
							/>
						</PanelBody>
						<PanelBody title={ __( 'Size' ) } initialOpen={ false }>
							<RangeControl
								label={ __( 'Top Padding (px)' ) }
								value={ paddingTop }
								onChange={ setPaddingTop }
								min={ 0 }
								max={ 500 }
								step={ 1 }
							/>
							<RangeControl
								label={ __( 'Bottom Padding (px)' ) }
								value={ paddingBottom }
								onChange={ setPaddingBottom }
								min={ 0 }
								max={ 500 }
								step={ 1 }
							/>
						</PanelBody>
					</InspectorControls>
				) }
			</Fragment>
		);

		if ( ! url ) {
			const hasTitle = ! isEmpty( title );
			const icon = hasTitle ? undefined : 'format-image';
			const label = hasTitle ? (
				<RichText
					tagName="h2"
					value={ title }
					onChange={ ( value ) => setAttributes( { title: value } ) }
					inlineToolbar
				/>
			) : __( 'Background Image' );

			return (
				<Fragment>
					{ controls }
					<MediaPlaceholder
						icon={ icon }
						className={ className }
						labels={ {
							title: label,
							name: __( 'an image' ),
						} }
						onSelect={ onSelectImage }
						accept="image/*"
						type="image"
						notices={ noticeUI }
						onError={ noticeOperations.createErrorNotice }
					/>
				</Fragment>
			);
		}

		return (
			<Fragment>
				{ controls }

				<div
					data-url={ url }
					style={ style }
					className={ classes }
				>
					<div
						className={ `hero-block__content has-${ contentAlign }-content` }
						style={ {
							paddingTop: `${ paddingTop }px`,
							paddingBottom: `${ paddingBottom }px`,
						} }
					>
						<InnerBlocks
							allowedBlocks={
								[
									'core/paragraph',
									'core/heading',
									'core/button',
									'core/image',
									'core/spacer',
									'core/columns',
									'vendify/hero-search',
								]
							}
							template={
								[
									[ 'core/heading' ],
									[ 'core/paragraph' ],
									[ 'core/button' ]
								]
							}
							templateInsertUpdatesSelection={ false }
						/>
					</div>
				</div>
			</Fragment>
		);
	}

}

export default withNotices( HeroEdit );
