import React from 'react';
import propTypes from 'prop-types';
import cn from 'classnames';

const Button = ( { children, outline, primary, success, danger, small, onClick, dark } ) => (
	<button
		className={ cn( 'btn', {
			'btn-outline-neutral': outline,
			'btn-primary': primary,
			'btn-success': success,
			'btn-danger': danger,
			'btn-sm': small,
			'btn-dark': dark,
		} ) }
		onClick={ onClick }
	>
		{ children }
	</button>
);

Button.defaultProps = {
	outline: false,
	primary: false,
	small: true,
	dark: false,
};

Button.propTypes = {
	outline: propTypes.bool,
	primary: propTypes.bool,
	small: propTypes.bool,
	dark: propTypes.bool,
	children: propTypes.node.isRequired,
	onClick: propTypes.func.isRequired,
};

export default Button;
