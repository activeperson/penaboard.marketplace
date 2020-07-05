/**
 * External dependencies.
 */
import React, { Fragment } from 'react';
import propTypes from 'prop-types';
const { find } = _;

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;

/**
 * Internal dependencies.
 */
import postShape from 'shapes/post';
import Upload from 'elements/Upload';

// @todo Create an <Icon> component.
import TrashIcon from 'icons/trash';

const PrimaryImage = ( {
	post,
	onDrop,
	deleteImage,
} ) => {
	const { images } = post;
	const featuredImage = find( post.images, { position: 0 } );

	return (
		<div className="form-group">
			<label>{ __( 'Product Image' ) }</label>

			{ featuredImage && (
				<div className="astoundify-wc-re-gallery__image astoundify-wc-re-gallery__image-big">
					<img src={ featuredImage.src } alt={ __( 'Product' ) } />

					<button
						className="astoundify-wc-re-gallery__delete"
						onClick={ () => deleteImage( featuredImage ) }
					>
						<TrashIcon />
					</button>
				</div>
			) }

			{ ! featuredImage && (
				<Upload onDrop={ onDrop } multiple={ false } />
			) }
		</div>
	);
};

PrimaryImage.propTypes = {
	onDrop: propTypes.func.isRequired,
	deleteImage: propTypes.func.isRequired,
	post: postShape.isRequired,
};

export default PrimaryImage;
