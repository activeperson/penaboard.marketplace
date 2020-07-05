import React from 'react';
import { connect } from 'react-redux';
import propTypes from 'prop-types';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;

import postShape from 'shapes/post';
import { updatePost } from 'redux/state/post';
import { createMedia } from 'redux/state/media';
import { reloadFrame } from 'redux/state/preview';
import { withoutPlaceholder } from 'selectors/post';
import Tab from 'components/Editor/Tab';

import Gallery from './Gallery';
import PrimaryImage from './PrimaryImage';

class Media extends React.Component {
  static propTypes = {
  	post: postShape.isRequired,
  	updatePost: propTypes.func.isRequired,
  	createMedia: propTypes.func.isRequired,
  	reloadFrame: propTypes.func.isRequired,
  };

  state = {
  	showPrimaryImageUpload: false,
  };

  onDrop = ( files ) => {
  	files.forEach( ( file, i ) => this.props.createMedia( file, i ) );

  	this.props.reloadFrame();
  };

  savePrimaryImage = ( [ file ] ) => {
  	this.props.createMedia( file, 0 );

  	this.props.reloadFrame();
  };

  deleteImage = ( { id, position } ) => {
  	const { images, id: postId } = this.props.post;

  	const patch = {
  		images: images.filter( ( image ) => image.id !== id ),
  	};

  	this.props.updatePost( postId, patch );

  	// Image was originally featured -- allow another image to replace it.
  	this.setState( {
  		showPrimaryImageUpload: 0 === position,
  	} );
  };

	render() {
		const { post } = this.props;
		const { images } = post;

		return (
			<Tab title={ __( 'Media' ) }>
				<PrimaryImage
					post={ post }
					onDrop={ this.savePrimaryImage }
					deleteImage={ this.deleteImage }
					showPrimaryImageUpload={ this.state.showPrimaryImageUpload }
				/>

				<Gallery
					post={ post }
					onDrop={ this.onDrop }
					deleteImage={ this.deleteImage }
					showPrimaryImageUpload={ this.state.showPrimaryImageUpload }
				/>
			</Tab>
		);
  }
}

const mapStateToProps = ( state ) => ( {
	post: withoutPlaceholder( state ),
} );

export default connect( mapStateToProps, {
	createMedia,
	updatePost,
	reloadFrame,
} )( Media );
