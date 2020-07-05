import React, { Component } from 'react';
import propTypes from 'prop-types';
import { connect } from 'react-redux';
import { Link } from 'react-router-dom';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;

import { createVariation } from 'redux/state/variation';
import postShape from 'shapes/post';
import Tab from 'components/Editor/Tab';
import Button from 'elements/Button';
import Select from 'elements/Select';

class NewVariation extends Component {
  static propTypes = {
  	post: postShape.isRequired,
  	createVariation: propTypes.func.isRequired,
  	history: propTypes.shape().isRequired,
  };

  state = {
  	attributes: {},
  };

  handleChange = ( { target: { name, value } }, attributeName ) => {
  	this.setState( ( { attributes } ) => ( {
  		attributes: {
  			...attributes,
  			[ attributeName ]: {
  				id: name,
  				name: attributeName,
  				option: value,
  			},
  		},
  	} ) );
	}

  handleSubmit = () => {
  	const attributes = Object.values( this.state.attributes );
  	this.props.createVariation( attributes, this.props.history );
  };

	render() {
		const {
			post: { attributes },
		} = this.props;

		return (
			<Tab title={ __( 'New Variation' ) }>
				{ attributes.map( ( { name, id, options } ) => (
					<div className="form-group form-group--flex">
						<Select
							key={ name }
							label={ name }
							id={ id.toString() }
							options={ options.map( ( option ) => ( {
								label: option,
								value: option,
							} ) ) }
							value=""
							onChange={ ( event ) => this.handleChange( event, name ) }
						/>
					</div>
				) ) }

				<div className="form-group form-group--flex form-group--space-between">
					<Link
						to="/variations"
						className="btn btn-sm btn-dark"
					>
						{ __( 'Back' ) }
					</Link>

					<Button success onClick={ this.handleSubmit }>
						{ __( 'Create Variation' ) }
					</Button>
				</div>
			</Tab>
		);
  }
}

const mapStateToProps = ( { post } ) => ( { post } );

export default connect( mapStateToProps, { createVariation } )( NewVariation );
