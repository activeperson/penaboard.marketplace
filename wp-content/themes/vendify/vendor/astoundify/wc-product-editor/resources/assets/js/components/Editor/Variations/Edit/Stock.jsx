import React, { Fragment } from 'react';
import { connect } from 'react-redux';
import propTypes from 'prop-types';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;

import { updateVariation } from 'redux/state/variation';
import { reloadFrame, runOnFrame } from 'redux/state/preview';
import { variationShape } from 'shapes/variation';

import Checkbox from 'elements/Checkbox';
import Text from 'elements/TextInput';
import Select from 'elements/Select';

class VariationStock extends React.Component {
  static propTypes = {
  	variation: variationShape.isRequired,
  	updateVariation: propTypes.func.isRequired,
  	reloadFrame: propTypes.func.isRequired,
  };

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

  handleCheckSave = ( event ) => {
  	const {
  		variation: { id: variationId, ...variation },
  	} = this.props;
  	const {
  		target: { name, checked },
  	} = event;
  	if ( checked !== variation[ name ] ) {
  		this.props.updateVariation( variationId, { [ name ]: checked } );
  	}
  };

  saveAndReload = ( event ) => {
  	const { type } = event.target;
  	this.props.reloadFrame();
  	if ( type === 'checkbox' ) {
  		this.handleCheckSave( event );
  	} else {
  		this.handleSave( event );
  	}
  };

  handleQuantitySave = ( event ) => {
  	const eventWithInt = {
  		...event,
  		target: {
  			...event.target,
  			name: event.target.name,
  			value: Number( event.target.value ),
  		},
  	};
  	this.props.reloadFrame();
  	this.handleSave( eventWithInt );
  };

	render() {
		const {
			variation: {
				manage_stock: manageStock,
				in_stock: inStock,
				sku,
				stock_quantity: stockQuantity,
				backorders,
				type,
			},
		} = this.props;

		return (
			<Fragment>
				<Text
					id="sku"
					label={ __( 'SKU' ) }
					value={ sku }
					onBlur={ this.saveAndReload }
					onChange={ () => null }
					tooltip={ __( 'SKU refers to a stock-keeping unit. A unique identifier for each distinct product that can be purchased' ) }
				/>

				{ type !== 'external' && (
					<Fragment>
						<Checkbox
							id="manage_stock"
							label={ __( 'Enable stock management' ) }
							title={ __( 'Manage Stock?' ) }
							value={ !! manageStock }
							onChange={ this.saveAndReload }
						/>

						{ manageStock && (
							<Fragment>
								<Text
									id="stock_quantity"
									label={ __( 'Stock Quantity' ) }
									value={ stockQuantity || '0' }
									onBlur={ this.handleQuantitySave }
									onChange={ () => null }
								/>
								<Select
									id="backorders"
									label={ __( 'Allow Backorders?' ) }
									options={ [
										{ label: __( 'Do not allow' ), value: 'no' },
										{ label: __( 'Allow, but notify customer' ), value: 'notify' },
										{ label: __( 'Allow' ), value: 'yes' },
									] }
									value={ backorders }
									onChange={ this.saveAndReload }
								/>
							</Fragment>
						) }

						{ type !== 'variable' && (
							<Select
								id="in_stock"
								label={ __( 'Stock Status' ) }
								options={ [
									{ label: __( 'Out of stock' ), value: false },
									{ label: __( 'In stock' ), value: true },
								] }
								value={ inStock }
								onChange={ this.saveAndReload }
							/>
						) }
					</Fragment>
				) }
			</Fragment>
		);
  }
}

export default connect( null, {
	updateVariation,
	reloadFrame,
	runOnFrame,
} )( VariationStock );
