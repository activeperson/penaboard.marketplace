import React, { Fragment } from 'react';
import { connect } from 'react-redux';
import propTypes from 'prop-types';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;

import { updatePost } from 'redux/state/post';
import { reloadFrame, runOnFrame } from 'redux/state/preview';
import postShape from 'shapes/post';

import Tab from 'components/Editor/Tab';
import Checkbox from 'elements/Checkbox';
import Text from 'elements/TextInput';
import Select from 'elements/Select';
import Divider from 'elements/Divider';

class Stock extends React.Component {
  static propTypes = {
  	post: postShape.isRequired,
  	updatePost: propTypes.func.isRequired,
  	reloadFrame: propTypes.func.isRequired,
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

  handleCheckSave = ( event ) => {
  	const {
  		post: { id: postId, ...post },
  	} = this.props;

  	const {
  		target: { name, checked },
  	} = event;

  	if ( checked !== post[ name ] ) {
  		this.props.updatePost( postId, { [ name ]: checked } );
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
  		post: {
  			manage_stock: manageStock,
  			in_stock: inStock,
  			sold_individually: soldIndividually,
  			sku,
  			stock_quantity: stockQuantity,
  			backorders,
  			type,
  		},
  	} = this.props;

  	return (
			<Tab title={ __( 'Stock' ) }>
				<Fragment>
					{ type !== 'variable' && (
						<Text
							id="sku"
							label={ __( 'SKU' ) }
							value={ sku }
							onBlur={ this.saveAndReload }
							onChange={ () => null }
							tooltip={ __( 'SKU refers to a stock-keeping unit. A unique identifier for each distinct product that can be purchased' ) }
						/>
					) }

					{ type !== 'variable' && (
						<Checkbox
							id="manage_stock"
							label={ __( 'Enable stock management"') }
							title={ __( 'Manage Stock?' ) }
							value={ !! manageStock }
							onChange={ this.saveAndReload }
						/>
					) }

					{ type !== 'variable' && manageStock && (
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

							<Select
								id="in_stock"
								label={__( 'Stock Status' ) }
								options={ [
									{ label: __( 'Out of stock' ), value: false },
									{ label: __( 'In stock' ), value: true },
								] }
								value={ inStock }
								onChange={ this.saveAndReload }
							/>
						</Fragment>
					) }

					<Checkbox
						id="sold_individually"
						label={ __( 'Limit one item per order' ) }
						title={ __( 'Sold Individually?' ) }
						value={ !! soldIndividually }
						onChange={ this.saveAndReload }
					/>
				</Fragment>
			</Tab>
  	);
  }
}

const mapStateToProps = ( { post } ) => ( {
	post,
} );

export default connect( mapStateToProps, {
	updatePost,
	reloadFrame,
	runOnFrame,
} )( Stock );
