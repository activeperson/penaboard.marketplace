import React from 'react';
import propTypes from 'prop-types';
import { Link } from 'react-router-dom';

import { attributeShape } from 'shapes/post';
import TextInput from 'elements/TextInput';

// @todo Create an <Icon> component.
import CogIcon from 'icons/cog';

const AttributeField = ( { attribute: { name }, index, updateAttribute } ) => (
	<div className="form-group form-group--flex form-group--space-between form-group--attribute">
		<TextInput
			label={ false }
			id={ `attribute-${ index }` }
			name="name"
			value={ name }
			onChange={ () => null }
			onBlur={ ( event ) => updateAttribute( index, event ) }
			onFocus={ ( event ) => event.target.select() }
		/>
		<Link to={ `/attributes/${ index }` }>
			<CogIcon />
		</Link>
	</div>
);

AttributeField.propTypes = {
	attribute: attributeShape.isRequired,
	index: propTypes.number.isRequired,
	updateAttribute: propTypes.func.isRequired,
};
export default AttributeField;
