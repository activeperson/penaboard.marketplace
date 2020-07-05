import { createStore, applyMiddleware } from 'redux';
import { composeWithDevTools } from 'redux-devtools-extension';
import createSagaMiddleware from 'redux-saga';
import rootReducer from 'redux/reducers';
import rootSaga from 'redux/sagas';

export default function() {
	const sagaMiddleware = createSagaMiddleware();
	const store = createStore(
		rootReducer,
		composeWithDevTools( applyMiddleware( sagaMiddleware ) )
	);
	sagaMiddleware.run( rootSaga );

	if ( process.env.NODE_ENV !== 'production' ) {
		if ( module.hot ) {
			module.hot.accept( './reducers', () => {
				store.replaceReducer( rootReducer );
			} );
		}
	}

	return store;
}
