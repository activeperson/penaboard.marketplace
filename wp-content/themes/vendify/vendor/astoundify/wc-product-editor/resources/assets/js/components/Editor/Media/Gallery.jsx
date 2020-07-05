import React, { Fragment } from 'react';
import propTypes from 'prop-types';

import postShape from 'shapes/post';
import Upload from 'elements/Upload';

// @todo Create an <Icon> component.
import TrashIcon from 'icons/trash';

const Gallery = ( {
	post,
	deleteImage,
	onDrop,
} ) => {
	const { images } = post;
	const galleryImages = images.slice( 1 );

	return images.length > 0 && (
		<div className="form-group">
			<label>Product Gallery</label>

			<Upload post={ post } onDrop={ onDrop } />

			{ galleryImages.length > 0 && (
				<div className="astoundify-wc-re-gallery__thumbnails">
					{ galleryImages.map( ( image ) => (
						<div
							key={ `${ image.position }-${ image.id }` }
							className="astoundify-wc-re-gallery__thumbnail astoundify-wc-re-gallery__image-small"
							style={ { backgroundImage: `url(${ image.src })` } }
						>
							<button
								className="astoundify-wc-re-gallery__delete"
								onClick={ () => deleteImage( image ) }
							>
								<TrashIcon />
							</button>
						</div>
					) ) }
				</div>
			) }
		</div>
	);
};

Gallery.propTypes = {
	post: postShape.isRequired,
	deleteImage: propTypes.func.isRequired,
};

export default Gallery;
