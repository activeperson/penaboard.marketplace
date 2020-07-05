import React from 'react';
import propTypes from 'prop-types';
import Header from 'components/Editor/Header';

const Tab = ( { children, title } ) => (
	<div className="astoundify-wc-re-tab is-active">
		<Header title={ title } />
		<section className="astoundify-wc-re-content">{ children }</section>
	</div>
);

Tab.propTypes = {
	children: propTypes.node.isRequired,
	title: propTypes.string.isRequired,
};

export default Tab;
