/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;

import { put, call, takeLatest, select } from 'redux-saga/effects';
import { apiRequest, attributeRequest } from 'utils/api';
import { reloadFrame } from 'redux/state/preview';
import { addToast } from 'redux/state/toasts';

export const POST_GET_REQUEST = 'POST_GET_REQUEST';
export const POST_GET_SUCCESS = 'POST_GET_SUCCESS';
export const POST_GET_FAILURE = 'POST_GET_FAILURE';

export const POST_CREATE_REQUEST = 'POST_CREATE_REQUEST';
export const POST_CREATE_SUCCESS = 'POST_CREATE_SUCCESS';
export const POST_CREATE_FAILURE = 'POST_CREATE_FAILURE';

export const POST_UPDATE_REQUEST = 'POST_UPDATE_REQUEST';
export const POST_UPDATE_SUCCESS = 'POST_UPDATE_SUCCESS';
export const POST_UPDATE_FAILURE = 'POST_UPDATE_FAILURE';

export const UPDATE_ATTRIBUTES_REQUEST = 'UPDATE_ATTRIBUTES_REQUEST';
export const UPDATE_ATTRIBUTES_SUCCESS = 'UPDATE_ATTRIBUTES_SUCCESS';
export const UPDATE_ATTRIBUTES_FAILURE = 'UPDATE_ATTRIBUTES_FAILURE';

const initialState = {};

export default function reducer( state = initialState, { type, payload } ) {
	switch ( type ) {
		case POST_GET_SUCCESS:
			return {
				...state,
				...payload.posts,
			};
		case POST_UPDATE_SUCCESS:
			return {
				...payload.post,
			};
		case POST_UPDATE_FAILURE:
			return {
				...payload.post,
			};
		default:
			return state;
	}
}

/**
 * Get all posts
 * @return {Object} Action
 */
export function getPost( postId ) {
	return {
		type: POST_GET_REQUEST,
		payload: {
			postId,
		},
	};
}

export function postGetSuccess( posts ) {
	return {
		type: POST_GET_SUCCESS,
		payload: {
			posts,
		},
	};
}

function postGetFailure( error ) {
	return {
		type: POST_GET_FAILURE,
		payload: {
			error,
		},
	};
}

/**
 * Post update action
 * @param  {string} postId
 * @param  {Object} patch       Parameters to update
 * @return {Object}             Action
 */
export function updatePost( postId, patch ) {
	return {
		type: POST_UPDATE_REQUEST,
		payload: {
			postId,
			patch: {
				status: 'draft',
				...patch,
			},
		},
	};
}

function postUpdateSuccess( post ) {
	return {
		type: POST_UPDATE_SUCCESS,
		payload: {
			post,
		},
	};
}

function postUpdateFailure( { message }, post ) {
	return {
		type: POST_UPDATE_FAILURE,
		error: message,
		payload: {
			post,
		},
	};
}

export function updateAttributesRequest( attributes, history = null ) {
	return {
		type: UPDATE_ATTRIBUTES_REQUEST,
		payload: {
			attributes,
			history,
		},
	};
}

function updateAttributesSuccess( attribute ) {
	return {
		type: UPDATE_ATTRIBUTES_SUCCESS,
		payload: {
			attribute,
		},
	};
}

function updateAttributesFailure( error ) {
	return {
		type: UPDATE_ATTRIBUTES_FAILURE,
		payload: {
			error,
		},
	};
}

function* fetchSaga( action ) {
	try {
		const { postId } = action.payload;
		const post = yield call( apiRequest, `wc/v2/products/${ postId }` );
		yield put( postGetSuccess( post ) );
	} catch ( error ) {
		yield put( postGetFailure( error ) );
	}
}

function* updateSaga( action ) {
	const originalPost = yield select( ( state ) => state.post );
	try {
		const { postId, patch } = action.payload;
		const post = yield call(
			apiRequest,
			`wc/v2/products/${ postId }`,
			'PUT',
			patch
		);
		if ( patch.status === 'publish' ) {
			yield put( reloadFrame() );
		}

		Object.entries( patch ).forEach( ( [ key, value ] ) => {
			if ( typeof post[ key ] !== 'object' && post[ key ] !== value ) {
				console.error( { key, old: post[ key ], new: value } );
				throw new Error( __( 'API save failed.' ) );
			}
		} );
		yield put( postUpdateSuccess( post ) );
	} catch ( error ) {
		yield put( postUpdateFailure( error, originalPost ) );
		yield put(
			addToast( __( 'We\'re sorry, there was an error updating your changes.' ), {
				sticky: true,
				reload: true,
			} )
		);
	}
}

function* attributeSaga( { payload: { attributes, history } } ) {
	try {
		const { postId } = window.astoundifyWrp;
		const { type: productType, attributes: prevAttributes } = yield select(
			( state ) => state.post
		);
		const attribute = yield call(
			attributeRequest,
			attributes,
			postId,
			productType
		);
		yield put( updateAttributesSuccess( attribute ) );
		yield put( reloadFrame() );
		yield put( getPost( postId ) );
		if ( attributes.length > prevAttributes.length ) {
			yield put( history.push( `/attributes/${ attributes.length - 1 }` ) );
		}
	} catch ( error ) {
		yield put( updateAttributesFailure( error ) );
	}
}

export function* postSaga() {
	yield takeLatest( POST_GET_REQUEST, fetchSaga );
	yield takeLatest( POST_UPDATE_REQUEST, updateSaga );
	yield takeLatest( UPDATE_ATTRIBUTES_REQUEST, attributeSaga );
}
