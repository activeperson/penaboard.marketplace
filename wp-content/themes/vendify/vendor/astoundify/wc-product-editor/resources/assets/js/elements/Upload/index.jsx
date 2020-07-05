import React, { Fragment } from 'react';
import Dropzone from 'react-dropzone';
import propTypes from 'prop-types';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;

const Upload = ( { onDrop, multiple } ) => (
	<Fragment>
		<Dropzone
			onDrop={ onDrop }
			multiple={ multiple }
			className="astoundify-wrp-media-dropzone"
		>
			<p className="astoundify-wc-re-gallery-drag-image">{ __( 'Drag an image, or' ) } <span>{ __( 'Browse Files' ) }</span></p>
			<p className="astoundify-wc-re-gallery-size">
				{ __( 'No larger than' ) } { window.astoundifyWrp.maxUpload }.
			</p>
			<img alt="" src={ `${ astoundifyWrp.pluginUrl }/public/images/upload-media.png` } className="astoundify-wrp-media-dropzone-icon" />
		</Dropzone>
	</Fragment>
);

Upload.propTypes = {
	onDrop: propTypes.func.isRequired,
	multiple: propTypes.bool,
};

Upload.defaultProps = {
	multiple: true,
};

export default Upload;
