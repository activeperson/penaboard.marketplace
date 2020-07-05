import React, { Fragment } from 'react';
import propTypes from 'prop-types';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;

import postShape from 'shapes/post';
import Upload from 'elements/Upload';

// @todo Create an <Icon> component.
import TrashIcon from 'icons/trash';

class PrimaryImage extends React.Component {
  static propTypes = {
  	onDrop: propTypes.func.isRequired,
  	image: postShape.isRequired,
  };

	render() {
		const { image, onDrop, deleteImage } = this.props;

		let variationImage = image;

		if ( 0 === variationImage.id ) {
			variationImage = false;
		}

		return (
			<div className="form-group">
				{ variationImage && (
					<div className="astoundify-wc-re-gallery__image astoundify-wc-re-gallery__image-big">
						<img src={ variationImage.src } alt={ __( 'Product' ) } />

						<button
							className="astoundify-wc-re-gallery__delete"
							onClick={ deleteImage }
						>
							<TrashIcon />
						</button>
					</div>
				) }

				{ ! variationImage && (
					<Upload onDrop={ onDrop } multiple={ false } />
				) }
			</div>
		);
  }
}

export default PrimaryImage;
