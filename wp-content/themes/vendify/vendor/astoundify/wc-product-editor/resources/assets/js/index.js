/**
 * External dependencies.
 */
import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import configureStore from 'redux/store';

/**
 * Internal dependencies.
 */
import App from 'components/App';

// Import assets so Webpack can move them.
import './../scss/app.scss';
import 'sprite.svg';
import 'upload-media.png';

const store = configureStore();

const Root = () => (
	<Provider store={ store }>
		<App />
	</Provider>
);

ReactDOM.render( <Root />, document.getElementById( 'astoundify-wc-re-wrapper' ) );
