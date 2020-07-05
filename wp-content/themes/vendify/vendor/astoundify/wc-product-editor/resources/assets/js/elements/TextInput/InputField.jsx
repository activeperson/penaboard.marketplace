import React from 'react';
import propTypes from 'prop-types';

const InputField = ( {
	id,
	placeholder,
	value,
	onBlur,
	onChange,
	onFocus,
	name,
	disabled,
} ) => (
	<input
		type="text"
		className="form-control"
		name={ name || id }
		id={ id }
		placeholder={ placeholder }
		defaultValue={ value }
		onBlur={ onBlur }
		onChange={ onChange }
		onFocus={ onFocus }
		disabled={ disabled }
	/>
);

InputField.propTypes = {
	id: propTypes.string.isRequired,
	placeholder: propTypes.string,
	value: propTypes.oneOfType( [
		propTypes.string,
		propTypes.number,
	] ),
	name: propTypes.string,
	onBlur: propTypes.func.isRequired,
	onChange: propTypes.func,
	onFocus: propTypes.func,
	disabled: propTypes.bool,
};

InputField.defaultProps = {
	placeholder: '',
	onFocus: () => null,
	onChange: () => null,
	name: '',
	disabled: false,
};

export default InputField;
