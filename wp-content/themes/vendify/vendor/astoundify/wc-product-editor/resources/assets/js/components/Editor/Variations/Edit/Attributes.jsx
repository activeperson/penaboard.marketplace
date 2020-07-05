import React, { Fragment } from 'react';
import propTypes from 'prop-types';
import Select from 'elements/Select';
import { variationShape } from 'shapes/variation';
import postShape from 'shapes/post';

const getAttributeValue = ( variation, options, name ) => {
	const attribute = variation.attributes.find( ( att ) => att.name === name );
	if ( ! attribute ) {
		return '';
	}
	const selected = options.find( ( value ) => value === attribute.option );
	return selected || '';
};

const VariationEditAttributes = ( {
	variation,
	updateVariation,
	post: { attributes },
} ) => (
	<Fragment>
		{ attributes.map( ( { name, options, position, id } ) => (
			<Select
				key={ `variation-attribute-${ name }` }
				id={ `attributes.${ id.toString() }` }
				label={ name }
				options={ options.map( ( option ) => ( { label: option, value: option } ) ) }
				position={ position }
				value={ getAttributeValue( variation, options, name ) }
				onChange={ ( event ) => updateVariation( id, name, event ) }
			/>
		) ) }
	</Fragment>
);

VariationEditAttributes.propTypes = {
	variation: variationShape.isRequired,
	post: postShape.isRequired,
	updateVariation: propTypes.func.isRequired,
};

export default VariationEditAttributes;
