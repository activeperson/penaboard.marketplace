import PropTypes from 'prop-types';
import React from 'react';
import { connect } from 'react-redux';
import { removeToast } from 'redux/state/toasts';
import Toast from './Toast';

const Toasts = ( { toasts, ...props } ) => (
	<ul className="astoundify-wc-re__toasts">
		{ toasts.map( ( toast ) => {
			const { id } = toast;
			return (
				<Toast { ...toast } key={ id } dismiss={ () => props.removeToast( id ) } />
			);
		} ) }
	</ul>
);

Toasts.propTypes = {
	removeToast: PropTypes.func.isRequired,
	toasts: PropTypes.arrayOf( PropTypes.object ).isRequired,
};

const mapStateToProps = ( state ) => ( {
	toasts: state.toasts,
} );

export default connect( mapStateToProps, { removeToast } )( Toasts );
