import React from 'react';
import propTypes from 'prop-types';

const Checkbox = ( { label, value, title, description, onChange, id } ) => (
	<div className="form-group">
		{ title && <label>{ title }</label> }
		{ description && <p>{ description }</p> }
		<label className="custom-control custom-checkbox">
			<input
				name={ id }
				type="checkbox"
				defaultChecked={ value }
				className="custom-control-input"
				onChange={ onChange }
			/>
			<span className="custom-control-indicator" />
			<span className="custom-control-description">
				{ label }
			</span>
		</label>
	</div>
);

Checkbox.propTypes = {
	label: propTypes.string.isRequired,
	value: propTypes.bool.isRequired,
	title: propTypes.string,
	description: propTypes.string,
	onChange: propTypes.func.isRequired,
	id: propTypes.string.isRequired,
};

Checkbox.defaultProps = {
	title: '',
	description: '',
};

export default Checkbox;
