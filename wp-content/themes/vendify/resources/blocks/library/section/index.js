/**
 * External dependencies.
 */
import classnames from 'classnames';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { InspectorControls, withColors } = wp.blockEditor;
const { InnerBlocks, PanelColorSettings, getColorClassName } = wp.editor;
const { PanelBody, SelectControl } = wp.components;
const { Fragment } = wp.element;
const { compose } = wp.compose;

/**
 * Register "Section" block.
 *
 * @since 1.0.0
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'vendify/section', {
	title: __( 'Section' ),
	description: __( 'Divide your page in to sections.' ),
	icon: 'align-center',
	category: 'vendify',
	keywords: [
		__( 'section' ),
	],
	attributes: {
		backgroundColor: {
			type: 'string',
			default: 'light',
		},
		borderColor: {
			type: 'string',
			default: 'neutral',
		},
		customBackgroundColor: {
			type: 'string',
		},
		customBorderColor: {
			type: 'string',
		},
		borderOptions: {
			type: 'string',
			default: 'both',
		},
	},

	/**
	 * Ensure the block is always in full align mode.
	 *
	 * @return {Object} Wrapper properties.
	 */
	getEditWrapperProps() {
		return {
			'data-align': 'full',
		};
	},

	/**
	 * Edit mode.
	 *
	 * @param {Object} props Block properties.
	 */
	edit: compose( withColors( 'backgroundColor', 'borderColor' ) )( ( props ) => {
		const { className, setBackgroundColor, setBorderColor, backgroundColor, borderColor, attributes, setAttributes } = props;
		const { borderOptions } = attributes;

		const controls = (
			<InspectorControls>
				<PanelColorSettings
					title={ __( 'Color Settings' ) }
					colorSettings={ [
						{
							value: backgroundColor.color,
							onChange: setBackgroundColor,
							label: __( 'Background Color' ),
						},
						{
							value: borderColor.color,
							onChange: setBorderColor,
							label: __( 'Border Color' ),
						},
					] }
				/>

				<SelectControl
					label={ __( 'Border' ) }
					value={ borderOptions }
					options={ [
						{
							value: 'both',
							label: __( 'Top and Bottom' ),
						},
						{
							value: 'top',
							label: __( 'Top only' ),
						},
						{
							value: 'bottom',
							label: __( 'Bottom only' ),
						},
					] }
					onChange={ ( newValue ) => setAttributes( { borderOptions: newValue } ) }
				/>
			</InspectorControls>
		);

		const backgroundClass = getColorClassName( 'background-color', backgroundColor );
		const borderClass = getColorClassName( 'border-color', borderColor );

		const sectionClasses = classnames(
			className,
			{
				'has-background-color': backgroundColor.color,
				[ backgroundColor.class ]: backgroundColor.class,
				'has-border-color': borderColor.color,
				[ borderColor.class ]: borderColor.class,
				'no-bottom': 'top' === borderOptions,
				'no-top': 'bottom' === borderOptions,
			}
		);

		const sectionStyles = {
			backgroundColor: backgroundColor.color,
			borderColor: borderColor.color,
		}

		return (
			<Fragment>
				{ controls }
				<div className={ sectionClasses } style={ sectionStyles }>
					<InnerBlocks templateInsertUpdatesSelection={ false } />
				</div>
			</Fragment>
		);
	} ),

	/**
	 * Save mode.
	 *
	 * @param {Object} props Block properties.
	 * @return {string}
	 */
	save( { attributes } ) {
		const { className, backgroundColor, borderColor, borderOptions, customBackgroundColor, customBorderColor } = attributes;

		const backgroundClass = getColorClassName( 'background-color', backgroundColor );
		const borderClass = getColorClassName( 'border-color', borderColor );

		const sectionClasses = classnames(
			className,
			'alignfull',
			{
				'has-border-color': borderColor || customBorderColor,
				[ borderClass ]: borderClass,
				'has-background': backgroundColor || customBackgroundColor,
				[ backgroundClass ]: backgroundClass,
				'no-bottom': 'top' === borderOptions,
				'no-top': 'bottom' === borderOptions,
			}
		);

		const sectionStyles = {
			backgroundColor: backgroundClass ? undefined : customBackgroundColor,
			borderColor: borderClass ? undefined : customBorderColor,
		}

		return (
			<div className={ sectionClasses } style={ sectionStyles }>
				<div className="container">
					<InnerBlocks.Content />
				</div>
			</div>
		);
	},
} );
