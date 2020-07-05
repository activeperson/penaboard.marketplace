import React from 'react';
import propTypes from 'prop-types';

const InputGroup = ( { title, description, options, hint } ) => (
	<div className="form-group">
		{ title && <h5>{ title }</h5> }
		{ description && <p>{ description }</p> }

		{ options.map(
			( { id, label, onChange, onBlur, value, placeholder, defaultValue } ) => (
				<label
					key={ id }
					className="label input--spec"
					data-name={ label }
				>
					<input
						name={ id }
						id={ id }
						type="text"
						className="form-control form-control-spec"
						placeholder={ placeholder }
						defaultValue={ defaultValue }
						value={ value }
						onChange={ onChange }
						onBlur={ onBlur }
					/>
				</label>
			)
		) }

		{ hint && <div className="astoundify-wc-re-form-hint">{ hint }</div> }
	</div>
);

InputGroup.propTypes = {
	title: propTypes.string.isRequired,
	description: propTypes.oneOfType( [ propTypes.string, propTypes.bool ] ),
	options: propTypes.arrayOf( propTypes.shape() ).isRequired,
	hint: propTypes.oneOfType( [ propTypes.string, propTypes.bool ] ),
};

InputGroup.defaultProps = {
	hint: false,
	description: false,
};

export default InputGroup;
