import React from 'react';
import propTypes from 'prop-types';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;

const Toast = ( { color, dismiss, text, reload } ) => (
	<li className="astoundify-wc-re__toast" style={ { backgroundColor: color } }>
		<p className="astoundify-wc-re__toast-content">
			{ text }
			{ reload && (
				<button
					className="astoundify-wc-re__toast-btn"
					onClick={ () => window.location.reload() }
				>
					{ __( 'Reload page' ) }
				</button>
			) }
		</p>
		<button className="astoundify-wc-re__toast-dismiss" onClick={ dismiss }>
      &times;
		</button>
	</li>
);

Toast.propTypes = {
	color: propTypes.string.isRequired,
	dismiss: propTypes.func.isRequired,
	text: propTypes.string.isRequired,
	reload: propTypes.bool,
};

Toast.defaultProps = {
	reload: false,
};

export default Toast;
