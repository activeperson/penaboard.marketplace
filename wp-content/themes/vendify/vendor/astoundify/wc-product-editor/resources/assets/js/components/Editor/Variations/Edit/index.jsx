import React from 'react';
import propTypes from 'prop-types';
import { Link, Redirect } from 'react-router-dom';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;

import { arrayOfVariations } from 'shapes/variation';
import postShape from 'shapes/post';
import { replace } from 'utils/array';
import Tab from 'components/Editor/Tab';
import TextInput from 'elements/TextInput';
import Checkbox from 'elements/Checkbox';
import Button from 'elements/Button';
import PrimaryImage from 'elements/Upload/PrimaryImage';
import Divider from 'elements/Divider';
import Shipping from './Shipping';
import Stock from './Stock';
import Attributes from './Attributes';

class EditVariation extends React.Component {
  static propTypes = {
  	// variations: arrayOfVariations.isRequired,
  	match: propTypes.shape( {
  		params: propTypes.shape( {
  			variationId: propTypes.string.isRequired,
  		} ),
  	} ).isRequired,
  	updateVariation: propTypes.func.isRequired,
  	deleteVariation: propTypes.func.isRequired,
  	post: postShape.isRequired,
  	variationCreateMedia: propTypes.func.isRequired,
  };

  onDrop = ( files ) => {
  	const {
  		variationCreateMedia,
  		match: {
  			params: { variationId },
  		},
  	} = this.props;

  	files.forEach( ( file ) => variationCreateMedia( file, variationId ) );
  };

	/**
	 * Unset a variation image.
	 */
	deleteImage = () => {
  	const {
  		updateVariation,
  		match: {
  			params: { variationId },
  		},
  	} = this.props;

		return updateVariation( variationId, {
			target: {
				name: 'image',
				value: {},
			},
		} );
	}

  updateVariation = ( event ) => {
  	const {
  		match: {
  			params: { variationId },
  		},
  		updateVariation,
  	} = this.props;

  	return updateVariation( variationId, event );
  };

  updateAttribute = ( id, name, event ) => {
  	const {
  		match: {
  			params: { variationId },
  		},
  		updateVariation,
  		variations,
  	} = this.props;

  	const { attributes } = variations[ variationId ];

  	const {
  		target: { value: option },
  	} = event;

  	const newAttribute = { id, name, option };

  	const newEvent = {
  		target: { name: 'attributes' },
  	};

  	const attributeIndex = attributes.findIndex( ( attr ) => attr.name === name );
  	if ( ! attributes || attributes.length === 0 ) {
  		newEvent.target.value = [ newAttribute ];
  	} else if ( attributeIndex === -1 ) {
  		newEvent.target.value = [ ...attributes, newAttribute ];
  	} else {
  		newEvent.target.value = replace( attributes, attributeIndex, newAttribute );
  	}
  	updateVariation( variationId, newEvent );
  };

	render() {
		const {
			variations,
			match: {
				params: { variationId },
			},
			deleteVariation,
			post,
		} = this.props;

		const variation = variations[ variationId ];

		if ( ! variation ) {
			return <Redirect to="/variations" />;
		}

		const {
			virtual,
			downloadable,
			regular_price: regularPrice,
			sale_price: salePrice,
			image,
		} = variation;

		return (
			<Tab title={ __( `Variation #${ variationId }` ) }>
				<PrimaryImage
					variation={ variation }
					onDrop={ this.onDrop }
					deleteImage={ this.deleteImage }
					image={ image }
				/>

				<Divider />

				<Checkbox
					id="virtual"
					label={ __( 'Virtual' ) }
					value={ !! virtual }
					onChange={ this.updateVariation }
				/>

				<Divider />

				<TextInput
					id="regular_price"
					label={ __( 'Regular Price' ) }
					value={ regularPrice }
					onBlur={ this.updateVariation }
				/>

				<TextInput
					id="sale_price"
					label={ __( 'Sale Price' ) }
					value={ salePrice }
					onBlur={ this.updateVariation }
				/>

				<Divider />

				<Shipping
					variation={ variation }
					updateVariation={ this.updateAttribute }
				/>

				<Divider />

				<Stock variation={ variation } updateVariation={ this.updateVariation } />

				<Divider />

				<Attributes
					variation={ variation }
					updateVariation={ this.updateAttribute }
					post={ post }
				/>

				<div className="form-group form-group--flex form-group--space-between form-group--submit">
					<Link
						to="/variations"
						className="btn btn-sm btn-dark"
					>
						{ __( 'Back' ) }
					</Link>

					<Button danger onClick={ () => deleteVariation( variationId ) }>
						{ __( 'Delete' ) }
					</Button>
				</div>
			</Tab>
  	);
  }
}

export default EditVariation;
