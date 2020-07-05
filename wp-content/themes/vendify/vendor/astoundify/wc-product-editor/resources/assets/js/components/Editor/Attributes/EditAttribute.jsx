import React, { Fragment } from 'react';
import propTypes from 'prop-types';
import { Link, Redirect } from 'react-router-dom';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;

import { arrayOfAttributes } from 'shapes/post';
import TextInput from 'elements/TextInput';
import AttributeTags from 'elements/MultiSelect/AttributeTags';
import Button from 'elements/Button';

const EditAttribute = ( {
	attributes,
	match: {
		params: { attributeId },
	},
	updateAttribute,
	removeAttribute,
} ) => {
	const attribute = attributes[ attributeId ];
	if ( ! attribute ) {
		return <Redirect to="/attributes" />;
	}
	return (
		<Fragment>
			<TextInput
				id={ `name-${ attributeId }` }
				name="name"
				label={ __( 'Name' ) }
				value={ attribute.name }
				onBlur={ ( event ) => updateAttribute( attributeId, event ) }
				onChange={ () => null }
				onFocus={ ( event ) => event.target.select() }
			/>

			<AttributeTags
				id={ `name-${ attributeId }` }
				name="options"
				label={ __ ('Options' ) }
				options={ attribute.options }
				updateAttribute={ updateAttribute }
				placeholder={ __( 'Enter a value ...' ) }
				attributeId={ attributeId }
			/>

			<div className="form-group form-group--flex form-group--space-between form-group--submit">
				<Link
					to="/attributes"
					className="btn btn-sm btn-dark"
				>
					{ __( 'Back' ) }
				</Link>
				<Button danger onClick={ () => removeAttribute( attributeId ) }>
					{ __( 'Delete' ) }
				</Button>
			</div>
		</Fragment>
	);
};

EditAttribute.propTypes = {
	attributes: arrayOfAttributes.isRequired,
	match: propTypes.shape( {
		params: propTypes.shape( {
			attributeId: propTypes.string.isRequired,
		} ),
	} ).isRequired,
	updateAttribute: propTypes.func.isRequired,
	removeAttribute: propTypes.func.isRequired,
};
export default EditAttribute;
