import React from 'react';
import propTypes from 'prop-types';
import { connect } from 'react-redux';
import { Switch, Route, withRouter, Link } from 'react-router-dom';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;

import { frameReady } from 'redux/state/preview';
import { variationCreateMedia } from 'redux/state/media';
import postShape from 'shapes/post';
import { updateVariation, deleteVariation } from 'redux/state/variation';
import { arrayOfVariations } from 'shapes/variation';
import Tab from 'components/Editor/Tab';
import VariationField from './VariationField';
import EditVariation from './Edit';
import NewVariation from './New';

class Variations extends React.Component {
  static propTypes = {
  	// @todo Idk why this is not consistent.
  	// variations: arrayOfVariations.isRequired,
  	post: postShape.isRequired,
  	updateVariation: propTypes.func.isRequired,
  	frameReady: propTypes.func.isRequired,
  	variationCreateMedia: propTypes.func.isRequired,
  	deleteVariation: propTypes.func.isRequired,
  	history: propTypes.shape( {
  		push: propTypes.func.isRequired,
  	} ).isRequired,
  };

  handleSave = ( id, { target: { name, value } } ) => {
  	const { variations } = this.props;
  	const variation = variations[ id ];

  	// Ghetto
  	if ( 'on' === value ) {
  		value = true;
  	} else if ( 'off' === value ) {
  		value = false;
  	}

  	if ( name.indexOf( '.' ) === -1 ) {
  		if ( value !== variation[ name ] ) {
  			this.props.updateVariation( id, { [ name ]: value } );
  		} else {
  			this.props.frameReady();
  		}
  	} else {
  		const [ object, property ] = name.split( '.' );
  		if ( value !== variation[ object ][ property ] ) {
  			this.props.updateVariation( id, {
  				[ object ]: { [ property ]: value },
  			} );
  		} else {
  			this.props.frameReady();
  		}
  	}
  };

	render() {
		const { post } = this.props;
		const variations = Object.values( this.props.variations );
		return (
			<Switch>
				<Route
					exact
					path="/variations"
					render={ () => (
						<Tab title={ __( 'Variations' ) } >
							<div className="form-group">
								<label>{ __( 'Add your product variations' ) }</label>

								<small className="form-control__help">
									{ __( 'Add variations if this product comes in multiple versions, like different sizes or colors.' ) }
								</small>
							</div>

							{ variations.map( ( variation, index ) => (
								<VariationField
									key={ variation.id }
									index={ index }
									variation={ variation }
								/>
							) ) }

							<div className="form-group form-group--submit">
								<Link
									to="/variations/new"
									className="btn btn-sm btn-dark"
								>
									{ variations.length === 0 ?
										__( 'Add variation' ) :
										__( 'Add another variation' ) }
								</Link>
							</div>
						</Tab>
					) }
				/>
				<Route
					exact
					path="/variations/new"
					render={ ( routeProps ) => (
						<NewVariation
							{ ...routeProps }
							createVariation={ this.createVariation }
							post={ post }
						/>
					) }
				/>
				<Route
					path="/variations/:variationId"
					render={ ( routeProps ) => (
						<EditVariation
							{ ...routeProps }
							variations={ this.props.variations }
							updateVariation={ this.handleSave }
							deleteVariation={ this.props.deleteVariation }
							variationCreateMedia={ this.props.variationCreateMedia }
							post={ post }
						/>
					) }
				/>
			</Switch>
		);
  }
}

const mapStateToProps = ( { variations, post } ) => ( {
	variations,
	post,
} );

export default connect( mapStateToProps, {
	updateVariation,
	frameReady,
	variationCreateMedia,
	deleteVariation,
} )( withRouter( Variations ) );
