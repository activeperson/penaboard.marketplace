import React, { Component, Fragment } from 'react';
import propTypes from 'prop-types';
import { connect } from 'react-redux';
import { HashRouter } from 'react-router-dom';

import loadingShape from 'shapes/loading';
import postShape from 'shapes/post';
import { frameReady } from 'redux/state/preview';
import { updatePost } from 'redux/state/post';
import ActionBar from 'components/ActionBar';
import MenuBar from 'components/Menu';
import Preview from 'components/Preview';
import Editor from 'components/Editor';
import LoadingOverlay from 'components/LoadingOverlay';
import Toasts from 'components/Toasts';

class App extends Component {
  static propTypes = {
  	loading: loadingShape.isRequired,
  	post: postShape.isRequired,
  	frameReady: propTypes.func.isRequired,
  	preview: propTypes.shape().isRequired,
  	updatePost: propTypes.func.isRequired,
  };

  publishPost = () => {
  	const {
  		post: { id },
  	} = this.props;
  	this.props.updatePost( id, { status: 'publish' } );
  };

  render() {
  	const { loading, post, preview } = this.props;
		return (
			<HashRouter>
				<Fragment>
					<ActionBar publishPost={ this.publishPost } post={ post } />
					<MenuBar post={ post } />
					<Editor loading={ loading } />
					<LoadingOverlay loading={ ! preview.ready }>
						<Preview
							post={ post }
							setFrameRef={ ( ref ) => {
								this.previewFrame = ref;
							} }
							runOnFrame={ this.runOnFrame }
							frameReady={ this.props.frameReady }
						/>
					</LoadingOverlay>
					<Toasts />
				</Fragment>
			</HashRouter>
		);
  }
}

const mapStateToProps = ( { loading, post, preview } ) => ( {
	loading,
	post,
	preview,
} );

export default connect( mapStateToProps, { frameReady, updatePost } )( App );
