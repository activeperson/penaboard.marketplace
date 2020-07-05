import React from 'react';
import { connect } from 'react-redux';
import propTypes from 'prop-types';
import { apiRequest } from 'utils/api';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;

import { updatePost } from 'redux/state/post';
import { reloadFrame } from 'redux/state/preview';
import postShape from 'shapes/post';

import Tab from 'components/Editor/Tab';
import ProductSearch from 'elements/MultiSelect/ProductSearch';

class Related extends React.Component {
  static propTypes = {
  	post: postShape.isRequired,
  	updatePost: propTypes.func.isRequired,
  	reloadFrame: propTypes.func.isRequired,
  };

  state = {
  	products: [],
  	loading: true,
  };

  async componentDidMount() {
		const { vendor: { products } } = astoundifyWrp;

  	apiRequest( `wc/v2/products?include=${ products.join( ',' ) }` ).then( ( products ) => {
  		const options = products.map( ( product ) => ( {
  			label: product.name,
  			value: product.id,
  		} ) );
  		this.setState( {
  			products: options,
  			loading: false,
  		} );
  	} );
  }

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
  		post: { upsell_ids: upsells, cross_sell_ids: crossSells },
  	} = this.props;

  	return (
			<Tab title={ __( 'Related' ) }>
				<ProductSearch
					id="upsell_ids"
					label={ __( 'Upsells' ) }
					options={ this.state.products }
					value={ upsells }
					onChange={ this.saveAndReload }
					placeholder={ __( 'Search for product...' ) }
					loading={ this.state.loading }
				/>
				<ProductSearch
					id="cross_sell_ids"
					label={ __( 'Cross-Sells' ) }
					options={ this.state.products }
					value={ crossSells }
					onChange={ this.saveAndReload }
					placeholder={ __( 'Search for product...' ) }
					loading={ this.state.loading }
				/>
			</Tab>
  	);
  }
}

const mapStateToProps = ( { post } ) => ( { post } );

export default connect( mapStateToProps, { updatePost, reloadFrame } )( Related );
