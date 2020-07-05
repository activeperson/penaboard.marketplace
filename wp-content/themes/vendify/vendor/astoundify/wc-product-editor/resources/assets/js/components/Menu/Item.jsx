import React from 'react';
import propTypes from 'prop-types';
import { NavLink } from 'react-router-dom';

const MenuItem = ( { label, id, Icon } ) => (
	<NavLink
		className={ `astoundify-wc-re-editor-menu__item ${ id }` }
		activeClassName="is-active"
		to={ `/${ id }` }
	>
		{ Icon() }
		{ label }
	</NavLink>
);

MenuItem.propTypes = {
	label: propTypes.string.isRequired,
	id: propTypes.string.isRequired,
	Icon: propTypes.func.isRequired,
};

export default MenuItem;
