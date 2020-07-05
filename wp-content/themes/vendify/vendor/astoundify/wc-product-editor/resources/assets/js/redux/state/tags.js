import { put, call, takeLatest } from 'redux-saga/effects';
import { apiRequest } from 'utils/api';

export const TAGS_FETCH_REQUEST = 'TAGS_FETCH_REQUEST';
export const TAGS_FETCH_SUCCESS = 'TAGS_FETCH_SUCCESS';
export const TAGS_FETCH_FAILURE = 'TAGS_FETCH_FAILURE';

export const TAGS_GET_REQUEST = 'TAGS_GET_REQUEST';
export const TAGS_GET_SUCCESS = 'TAGS_GET_SUCCESS';
export const TAGS_GET_FAILURE = 'TAGS_GET_FAILURE';

export const TAGS_CREATE_REQUEST = 'TAGS_CREATE_REQUEST';
export const TAGS_CREATE_SUCCESS = 'TAGS_CREATE_SUCCESS';
export const TAGS_CREATE_FAILURE = 'TAGS_CREATE_FAILURE';

export const TAGS_UPDATE_REQUEST = 'TAGS_UPDATE_REQUEST';
export const TAGS_UPDATE_SUCCESS = 'TAGS_UPDATE_SUCCESS';
export const TAGS_UPDATE_FAILURE = 'TAGS_UPDATE_FAILURE';

const initialState = {
	items: [],
};

export default function reducer( state = initialState, { type, payload } ) {
	switch ( type ) {
		case TAGS_FETCH_SUCCESS:
			return {
				...state,
				items: payload.tags,
			};
		case TAGS_UPDATE_SUCCESS:
			return {
				...state,
				items: payload.tags,
			};
		case TAGS_CREATE_SUCCESS:
			return {
				items: [ ...state.items, payload.tag ],
			};
		default:
			return state;
	}
}

/**
 * Get all tags
 * @return {Object} Action
 */
export function fetchTags() {
	return {
		type: TAGS_FETCH_REQUEST,
	};
}

export function tagsFetchSuccess( tags ) {
	return {
		type: TAGS_FETCH_SUCCESS,
		payload: {
			tags,
		},
	};
}

function tagsFetchFailure( error ) {
	return {
		type: TAGS_FETCH_FAILURE,
		payload: {
			error,
		},
	};
}

export function createTag( name ) {
	return {
		type: TAGS_CREATE_REQUEST,
		payload: {
			name,
		},
	};
}

function createTagSuccess( tag ) {
	return {
		type: TAGS_CREATE_SUCCESS,
		payload: {
			tag,
		},
	};
}

function createTagFailure( error ) {
	return {
		type: TAGS_CREATE_FAILURE,
		payload: {
			error,
		},
	};
}

function* fetchSaga() {
	try {
		const response = yield call( apiRequest, 'astoundify/wc-product-editor/v1/products/tags' );
		yield put( tagsFetchSuccess( response ) );
	} catch ( error ) {
		yield put( tagsFetchFailure( error ) );
	}
}

function* createSaga( action ) {
	try {
		const { payload } = action;

		const tag = yield call( apiRequest, 'astoundify/wc-product-editor/v1/products/tags', 'POST', payload );

		yield put( createTagSuccess( tag ) );
	} catch ( error ) {
		yield put( createTagFailure( error ) );
	}
}

export function* tagsSaga() {
	yield takeLatest( TAGS_FETCH_REQUEST, fetchSaga );
	yield takeLatest( TAGS_CREATE_REQUEST, createSaga );
}
