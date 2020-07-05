import React, { Fragment } from 'react';
import { connect } from 'react-redux';
import propTypes from 'prop-types';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;

import { updateVariation } from 'redux/state/variation';
import { reloadFrame } from 'redux/state/preview';
import { variationShape } from 'shapes/variation';
import { getWeightUnit, getDimensionsUnit } from 'utils/product';
import { apiRequest } from 'utils/api';

import Text from 'elements/TextInput';
import Select from 'elements/Select';

class VariationShipping extends React.Component {
  static propTypes = {
  	variation: variationShape.isRequired,
  	updateVariation: propTypes.func.isRequired,
  	reloadFrame: propTypes.func.isRequired,
  	weightUnit: propTypes.string.isRequired,
  	dimensionsUnit: propTypes.string.isRequired,
  };

  state = {
  	shippingClasses: [],
  	loading: true,
  };

  async componentDidMount() {
  	apiRequest( 'wc/v2/products/shipping_classes?per_page=100' ).then( ( data ) => {
  		const shippingClasses = data.map( ( shippingClass ) => ( {
  			label: shippingClass.name,
  			value: shippingClass.slug,
  		} ) );
  		this.setState( {
  			shippingClasses,
  			loading: false,
  		} );
  	} );
  }

  handleSave = ( event ) => {
  	const {
  		target: { name, value },
  	} = event;
  	const { variation } = this.props;
  	if ( name.indexOf( '.' ) === -1 ) {
  		if ( value !== variation[ name ] ) {
  			this.props.updateVariation( variation.id, { [ name ]: value } );
  		}
  	} else {
  		const [ object, property ] = name.split( '.' );
  		if ( value !== variation[ object ][ property ] ) {
  			this.props.updateVariation( variation.id, {
  				[ object ]: { [ property ]: value },
  			} );
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
			variation: { weight, dimensions, shipping_class: shippingClass },
			weightUnit,
			dimensionsUnit,
		} = this.props;

		return (
			<Fragment>
				<Text
					id="weight"
					label={ __( `Weight (${ weightUnit })` ) }
					placeholder="0.00"
					value={ weight }
					onBlur={ this.handleSave }
				/>
				<Text
					id="dimensions.length"
					label={ __( `Length (${ dimensionsUnit })` ) }
					placeholder="0.00"
					value={ dimensions.length }
					onBlur={ this.handleSave }
				/>
				<Text
					id="dimensions.width"
					label={ __( `Width (${ dimensionsUnit })` ) }
					placeholder="0.00"
					value={ dimensions.width }
					onBlur={ this.handleSave }
				/>
				<Text
					id="dimensions.height"
					label={ __( `Height (${ dimensionsUnit })` ) }
					placeholder="0.00"
					value={ dimensions.height }
					onBlur={ this.handleSave }
				/>
				<Select
					id="shipping_class"
					label={ __( 'Shipping Class' ) }
					options={ this.state.shippingClasses }
					value={ shippingClass }
					onChange={ this.saveAndReload }
					loading={ this.state.loading }
				/>
			</Fragment>
		);
  }
}

const mapStateToProps = ( { post } ) => ( {
	post,
	weightUnit: getWeightUnit(),
	dimensionsUnit: getDimensionsUnit(),
	elements: window.astoundifyWrp.elements,
} );

export default connect( mapStateToProps, { updateVariation, reloadFrame } )(
	VariationShipping
);
