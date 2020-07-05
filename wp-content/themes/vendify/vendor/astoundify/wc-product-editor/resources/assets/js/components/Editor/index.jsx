import React from 'react';
import { Switch, Route } from 'react-router-dom';
import LoadingOrContent from 'components/LoadingOrContent';
import loadingShape from 'shapes/loading';

import Attributes from './Attributes';
import Details from './Details';
import Media from './Media';
import Related from './Related';
import Shipping from './Shipping';
import Stock from './Stock';
import Variations from './Variations';

const Editor = ( { loading } ) => (
	<Switch>
		<Route exact path="/" render={ () => null } />
		<Route path="*">
			<div className="astoundify-wc-re-body is-active">
				<LoadingOrContent loading={ loading.post || loading.media }>
					<Route path="/attributes" component={ Attributes } />
					<Route path="/details" component={ Details } />
					<Route path="/media" component={ Media } />
					<Route path="/related" component={ Related } />
					<Route path="/shipping" component={ Shipping } />
					<Route path="/stock" component={ Stock } />
					<Route path="/variations" component={ Variations } />
				</LoadingOrContent>
			</div>
		</Route>
	</Switch>
);

Editor.propTypes = {
	loading: loadingShape.isRequired,
};

export default Editor;
