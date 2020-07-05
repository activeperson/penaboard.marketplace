/**
 * Externa dependencies.
 */
import { find } from 'lodash';
import classnames from 'classnames';

/**
 * WordPress dependencies.
 */
const { addFilter } = wp.hooks;
const { __ } = wp.i18n;
const { Fragment } = wp.element;
const { createHigherOrderComponent } = wp.compose;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, SelectControl } = wp.components;

/**
 * Add new inspector control panel.
 *
 * @param {function|component} BlockEdit component.
 * @return {string} Wrapped component.
 */
addFilter( 'editor.BlockEdit', 'vendify/withInspectorControl', createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		if ( 'core/button' !== props.name ) {
			return <BlockEdit { ...props } />;
		}

		const { setAttributes } = props;
		const { size } = props.attributes;

		if ( 'core/button' !== props.name ) {
			return <BlockEdit { ...props } />;
		}

		return (
			<Fragment>
				<div className={ `btn-${ size }` }>
					<BlockEdit { ...props } />
				</div>

				<InspectorControls>

					<PanelBody
						title={ __( 'Button Size' ) }
					>
						<SelectControl
							value={ size }
							options={ [
								{
									value: 'sm',
									label: __( 'Small' ),
								},
								{
									value: 'default',
									label: __( 'Default' ),
								},
								{
									value: 'lg',
									label: __( 'Large' ),
								},
							] }
							onChange={ ( newValue ) => setAttributes( { size: newValue } ) }
						/>
					</PanelBody>

				</InspectorControls>
			</Fragment>
		);
	};
}, 'withInspectorControl' ) );

/**
 * Expose extra attributes for new controls.
 *
 * @param {Object} settings Settings configuration.
 * @param {string} name Block name.
 */
addFilter( 'blocks.registerBlockType', 'vendify/button', ( settings, name ) => {
	if ( 'core/button' !== name ) {
		return settings;
	}

	const { styles } = settings;

	const squared = find( styles, { name: 'squared' } );
	const outline = find( styles, { name: 'outline' } );

	return {
		...settings,
		styles: [
			{
				...squared,
				isDefault: true,
			},
			outline,
		],
		attributes: {
			...settings.attributes,
			size: {
				type: 'string',
				default: 'default',
			},
		},
	}
} );

/**
 * Update classname on save.
 */
addFilter( 'blocks.getSaveContent.extraProps', 'vendify/button', ( props, blockType, attributes ) => {
	const { size = 'default' } = attributes;

	if ( 'core/button' !== blockType.name ) {
		return props;
	}

	if ( size ) {
		return {
			...props,
			className: classnames( props.className, {
				[ `btn-${ size }` ]: 'default' !== size,
			} ),
		}
	}

	return props;
} );

wp.blocks.registerBlockStyle( 'core/button', {
	name: 'rounded',
	label: 'Rounded'
} );
