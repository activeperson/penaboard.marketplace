import React from 'react';
import propTypes from 'prop-types';
import { connect } from 'react-redux';
import { Switch, Route, withRouter } from 'react-router-dom';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;

import { replace, remove } from 'utils/array';
import {
	updatePost,
	updateAttributesRequest as updateAttributes,
} from 'redux/state/post';
import { transformAttributes } from 'utils/attributes';
import postShape from 'shapes/post';
import Tab from 'components/Editor/Tab';
import Button from 'elements/Button';
import AttributeField from './AttributeFields';
import EditAttribute from './EditAttribute';

class Attributes extends React.Component {
  static propTypes = {
  	post: postShape.isRequired,
  	updatePost: propTypes.func.isRequired,
  	updateAttributes: propTypes.func.isRequired,
  	history: propTypes.shape( {
  		push: propTypes.func.isRequired,
  	} ).isRequired,
  };

  createAttribute = () => {
  	const { history } = this.props;
  	const { attributes } = this.props.post;
  	const attribute = {
  		id: attributes.length,
  		name: __( 'New Attribute' ),
  		position: attributes.length,
  		visible: true,
  		variation: true,
  		options: [ __( 'New Option' ) ],
  	};
  	const updatedAttributes = transformAttributes( [ ...attributes, attribute ] );
  	this.props.updateAttributes( updatedAttributes, history );
  };

  updateAttribute = ( index, { target: { name, value } } ) => {
  	const { attributes } = this.props.post;
  	const attribute = attributes[ index ];
  	if ( attribute.name === value ) {
  		return;
  	}
  	const newAttribute = {
  		...attributes[ index ],
  		[ name ]: value,
  	};
  	const updatedAttributes = transformAttributes(
  		replace( attributes, index, newAttribute )
  	);
  	this.props.updateAttributes( updatedAttributes );
  };

  removeAttribute = ( index ) => {
  	const { attributes } = this.props.post;
  	const updatedAttributes = transformAttributes( remove( attributes, index ) );
  	this.props.updateAttributes( updatedAttributes );
  	this.props.history.push( '/attributes' );
  };

	render() {
		const { attributes } = this.props.post;
		return (
			<Tab title="Attributes">
				<Switch>
					<Route exact path="/attributes">
						{ () => (
							<React.Fragment>
								<div className="form-group">
									<label>{ __( 'Add your product attributes' ) }</label>

									<small className="form-control__help">
										{ __( 'Add attributes if this product comes in multiple versions, like different sizes or colors.' ) }
									</small>
								</div>

								{ attributes.map( ( attribute, index ) => (
									<AttributeField
										key={ attribute.position }
										index={ index }
										attribute={ attribute }
										updateAttribute={ this.updateAttribute }
									/>
								) ) }

								<div className="form-group form-group--submit">
									<Button dark onClick={ this.createAttribute }>
										{ attributes.length === 0 ?
											__( 'Add attribute' ) :
											__( 'Add another attribute' ) }
									</Button>
								</div>
							</React.Fragment>
						) }
					</Route>
					<Route
						path="/attributes/:attributeId"
						render={ ( routeProps ) => (
							<EditAttribute
								{ ...routeProps }
								attributes={ attributes }
								updateAttribute={ this.updateAttribute }
								removeAttribute={ this.removeAttribute }
							/>
						) }
					/>
				</Switch>
			</Tab>
		);
  }
}

const mapStateToProps = ( state ) => ( {
	post: state.post,
} );

export default connect( mapStateToProps, { updatePost, updateAttributes } )(
	withRouter( Attributes )
);
