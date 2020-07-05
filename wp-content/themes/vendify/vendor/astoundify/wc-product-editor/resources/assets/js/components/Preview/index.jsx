import React from 'react';
import propTypes from 'prop-types';
import postShape from 'shapes/post';

class Preview extends React.PureComponent {
  static propTypes = {
  	post: postShape.isRequired,
  	setFrameRef: propTypes.func.isRequired,
  	frameReady: propTypes.func.isRequired,
  };

  createRef = ( ref ) => {
  	const { setFrameRef, frameReady } = this.props;
  	setFrameRef( ref );
  	this.previewFrame = ref;
  	this.previewFrame.onload = () => {
  		frameReady();
  	};
  };

  render() {
  	const {
  		post: { id },
  	} = this.props;
  	return (
			<div className="astoundify-wc-re-previewer">
  			<iframe
					id="astoundify-wc-re-previewer-frame"
					title="Product Preview"
					src={ `${ astoundifyWrp.homeUrl }?post_type=product&p=${ id }&preview=true&wcre_preview=true` }
					ref={ this.createRef }
  			/>
  		</div>
  	);
  }
}

export default Preview;
