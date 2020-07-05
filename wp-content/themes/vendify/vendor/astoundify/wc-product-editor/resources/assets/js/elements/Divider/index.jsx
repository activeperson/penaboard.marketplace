import React from 'react';
import propTypes from 'prop-types';
import cn from 'classnames';

const BASE_CLASS = 'astoundify-wc-re-hr';

const Divider = ( { large, xlarge } ) => (
	<hr
		className={ cn( BASE_CLASS, {
			[ `${ BASE_CLASS }--lg` ]: large && ! xlarge,
			[ `${ BASE_CLASS }--xl` ]: xlarge,
		} ) }
	/>
);

Divider.propTypes = {
	large: propTypes.bool,
	xlarge: propTypes.bool,
};

Divider.defaultProps = {
	large: false,
	xlarge: false,
};

export default Divider;
