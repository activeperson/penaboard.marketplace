import React from 'react';
import { Link } from 'react-router-dom';

import { variationShape } from 'shapes/variation';
import TextInput from 'elements/TextInput';
import noop from 'constants/noop';

// @todo Create an <Icon> component.
import CogIcon from 'icons/cog';

const VariationField = ( { variation: { id, attributes } } ) => {
	const value = attributes ?
		attributes.map( ( { name, option } ) => `${ name }: ${ option }` ).join( ', ' ) :
		'';
	return (
		<div className="form-group form-group--flex form-group--variation">
			<TextInput
				id={ `variation-${ id }` }
				label=""
				name="name"
				value={ value }
				onChange={ noop }
				onBlur={ noop }
				disabled
			/>
			<Link to={ `/variations/${ id }` }>
				<CogIcon />
			</Link>
		</div>
	);
};

VariationField.propTypes = {
	variation: variationShape.isRequired,
};
export default VariationField;
