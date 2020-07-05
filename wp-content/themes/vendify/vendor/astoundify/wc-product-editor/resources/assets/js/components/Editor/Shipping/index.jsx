import React from 'react';
import { connect } from 'react-redux';
import propTypes from 'prop-types';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;

import { updatePost } from 'redux/state/post';
import { reloadFrame } from 'redux/state/preview';
import postShape from 'shapes/post';
import { getWeightUnit, getDimensionsUnit } from 'utils/product';
import { apiRequest } from 'utils/api';

import Tab from 'components/Editor/Tab';
import Text from 'elements/TextInput';
import Select from 'elements/Select';

class Shipping extends React.Component {
  static propTypes = {
  	post: postShape.isRequired,
  	updatePost: propTypes.func.isRequired,
  	reloadFrame: propTypes.func.isRequired,
  	weightUnit: propTypes.string.isRequired,
  	dimensionsUnit: propTypes.string.isRequired,
  };

  state = {
  	loading: true,
  };

  handleSave = ( event ) => {
  	const {
  		target: { name, value },
  	} = event;
  	const { post } = this.props;
  	if ( name.indexOf( '.' ) === -1 ) {
  		if ( value !== post[ name ] ) {
  			this.props.updatePost( post.id, { [ name ]: value } );
  		}
  	} else {
  		const [ object, property ] = name.split( '.' );
  		if ( value !== post[ object ][ property ] ) {
  			this.props.updatePost( post.id, { [ object ]: { [ property ]: value } } );
  		}
  	}
  };

  saveAndReload = ( event ) => {
  	const { type } = event.target;
  	if ( type === 'checkbox' ) {
  		this.handleCheckSave( event );
  	} else {
  		this.handleSave( event );
  	}
  	this.props.reloadFrame();
  };

  render() {
  	const {
  		post: { weight, dimensions, shipping_class: shippingClass },
  		weightUnit,
  		dimensionsUnit,
  	} = this.props;

  	return (
			<Tab title={ __( 'Shipping' ) }>
				<Text
					id="weight"
					label={ `Weight (${ weightUnit })` }
					placeholder="0.00"
					value={ weight }
					onBlur={ this.handleSave }
				/>
				<Text
					id="dimensions.length"
					label={ `Length (${ dimensionsUnit })` }
					placeholder="0.00"
					value={ dimensions.length }
					onBlur={ this.handleSave }
				/>
				<Text
					id="dimensions.width"
					label={ `Width (${ dimensionsUnit })` }
					placeholder="0.00"
					value={ dimensions.width }
					onBlur={ this.handleSave }
				/>
				<Text
					id="dimensions.height"
					label={ `Height (${ dimensionsUnit })` }
					placeholder="0.00"
					value={ dimensions.height }
					onBlur={ this.handleSave }
				/>
			</Tab>
  	);
  }
}

const mapStateToProps = ( { post } ) => ( {
	post,
	weightUnit: getWeightUnit(),
	dimensionsUnit: getDimensionsUnit(),
	elements: window.astoundifyWrp.elements,
} );

export default connect( mapStateToProps, { updatePost, reloadFrame } )( Shipping );
