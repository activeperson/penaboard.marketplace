import { put, call, takeLatest, select } from 'redux-saga/effects';
import { normalize, schema } from 'normalizr';
import { reloadFrame } from 'redux/state/preview';
import { addToast } from 'redux/state/toasts';
import { POST_GET_SUCCESS } from 'redux/state/post';
import { apiRequest } from 'utils/api';
import { mergeState, insertToState, removeFromState } from 'utils/reducers';

export const VARIATION_GET_REQUEST = 'VARIATION_GET_REQUEST';
export const VARIATION_GET_SUCCESS = 'VARIATION_GET_SUCCESS';
export const VARIATION_GET_FAILURE = 'VARIATION_GET_FAILURE';

export const VARIATION_FETCH_REQUEST = 'VARIATION_FETCH_REQUEST';
export const VARIATION_FETCH_SUCCESS = 'VARIATION_FETCH_SUCCESS';
export const VARIATION_FETCH_FAILURE = 'VARIATION_FETCH_FAILURE';

export const VARIATION_CREATE_REQUEST = 'VARIATION_CREATE_REQUEST';
export const VARIATION_CREATE_SUCCESS = 'VARIATION_CREATE_SUCCESS';
export const VARIATION_CREATE_FAILURE = 'VARIATION_CREATE_FAILURE';

export const VARIATION_UPDATE_REQUEST = 'VARIATION_UPDATE_REQUEST';
export const VARIATION_UPDATE_SUCCESS = 'VARIATION_UPDATE_SUCCESS';
export const VARIATION_UPDATE_FAILURE = 'VARIATION_UPDATE_FAILURE';

export const VARIATION_DELETE_REQUEST = 'VARIATION_DELETE_REQUEST';
export const VARIATION_DELETE_SUCCESS = 'VARIATION_DELETE_SUCCESS';
export const VARIATION_DELETE_FAILURE = 'VARIATION_DELETE_FAILURE';

export const VARIATION_KEY = 'variations';
export const VARIATION_ENTITY = new schema.Entity( VARIATION_KEY, {} );
export const VARIATION_SCHEMA = [ VARIATION_ENTITY ];

const initialState = [];

export default function reducer( state = initialState, { type, payload } ) {
	switch ( type ) {
		case VARIATION_FETCH_SUCCESS:
			return mergeState( state, payload, VARIATION_KEY );
		case VARIATION_GET_SUCCESS:
		case VARIATION_UPDATE_SUCCESS:
		case VARIATION_CREATE_SUCCESS:
			return insertToState( state, payload.variation.id, payload.variation );
		case VARIATION_DELETE_SUCCESS:
			return removeFromState( state, payload.variationId );
		default:
			return state;
	}
}

/**
 * Get one variation
 * @return {Object} Action
 */
export function getVariation( variationId ) {
	return {
		type: VARIATION_GET_REQUEST,
		payload: {
			variationId,
		},
	};
}

export function variationGetSuccess( variation ) {
	return {
		type: VARIATION_GET_SUCCESS,
		payload: {
			variation,
		},
	};
}

function variationGetFailure( error ) {
	return {
		type: VARIATION_GET_FAILURE,
		payload: {
			error,
		},
	};
}

/**
 * Fetch all variations
 * @return {Object} Action
 */
export function fetchVariations() {
	return {
		type: VARIATION_FETCH_REQUEST,
	};
}

export function variationFetchSuccess( variations ) {
	return {
		type: VARIATION_FETCH_SUCCESS,
		payload: {
			data: normalize( variations, VARIATION_SCHEMA ).entities,
		},
	};
}

function variationFetchFailure( error ) {
	return {
		type: VARIATION_FETCH_FAILURE,
		payload: {
			error,
		},
	};
}

/**
 * Variation update action
 * @param  {string} variationId
 * @param  {Object} patch       Parameters to update
 * @return {Object}             Action
 */
export function updateVariation( variationId, patch ) {
	return {
		type: VARIATION_UPDATE_REQUEST,
		payload: {
			variationId,
			patch,
		},
	};
}

function variationUpdateSuccess( variation ) {
	return {
		type: VARIATION_UPDATE_SUCCESS,
		payload: {
			variation,
		},
	};
}

function variationUpdateFailure( { message }, variation ) {
	return {
		type: VARIATION_UPDATE_FAILURE,
		error: message,
		payload: {
			variation,
		},
	};
}

/**
 * Delete Variation Action
 * @param {number} variationId id of variation to be deleted
 */
export function deleteVariation( variationId ) {
	return {
		type: VARIATION_DELETE_REQUEST,
		payload: {
			variationId,
		},
	};
}

function variationDeleteSuccess( variationId ) {
	return {
		type: VARIATION_DELETE_SUCCESS,
		payload: {
			variationId,
		},
	};
}

function variationDeleteFailure( { message }, variationId ) {
	return {
		type: VARIATION_DELETE_FAILURE,
		error: message,
		payload: {
			variationId,
		},
	};
}

/**
 * Create Variation Action
 * @param {number} postId id of post to add variation to
 */
export function createVariation( attributes, history ) {
	return {
		type: VARIATION_CREATE_REQUEST,
		payload: {
			attributes,
			history,
		},
	};
}

function variationCreateSuccess( variation ) {
	return {
		type: VARIATION_CREATE_SUCCESS,
		payload: {
			variation,
		},
	};
}

function variationCreateFailure( { message } ) {
	return {
		type: VARIATION_CREATE_FAILURE,
		payload: {
			error: message,
		},
	};
}

function* getOneSaga( action ) {
	try {
		const { postId } = window.astoundifyWrp;
		const { variationId } = action.payload;
		const variations = yield call(
			apiRequest,
			`wc/v2/products/${ postId }/variations/${ variationId }`
		);
		yield put( variationGetSuccess( variations ) );
	} catch ( error ) {
		yield put( variationGetFailure( error ) );
	}
}

function* fetchSaga() {
	try {
		const { postId } = window.astoundifyWrp;
		const variations = yield call(
			apiRequest,
			`wc/v2/products/${ postId }/variations/`
		);
		yield put( variationFetchSuccess( variations ) );
	} catch ( error ) {
		yield put( variationFetchFailure( error ) );
	}
}

function* updateSaga( action ) {
	const { postId } = window.astoundifyWrp;
	const { variationId, patch } = action.payload;
	const variations = yield select( ( state ) => state.variations );
	const original = variations[ variationId ];
	try {
		const variation = yield call(
			apiRequest,
			`wc/v2/products/${ postId }/variations/${ variationId }`,
			'PUT',
			patch
		);

		yield put( reloadFrame() );
		yield put( variationUpdateSuccess( variation ) );
	} catch ( error ) {
		yield put( variationUpdateFailure( error, original ) );
		yield put(
			addToast(
				'We\'re sorry, there was a problem saving data. Please reload and/or try again later.',
				{
					sticky: true,
					reload: true,
				}
			)
		);
	}
}

function* deleteSaga( action ) {
	const { variationId } = action.payload;
	try {
		const { postId } = window.astoundifyWrp;
		yield call(
			apiRequest,
			`wc/v2/products/${ postId }/variations/${ variationId }`,
			'DELETE'
		);
		yield put( variationDeleteSuccess( variationId ) );
	} catch ( error ) {
		yield put( variationDeleteFailure( error, variationId ) );
	}
}

function* createSaga( action ) {
	const { postId } = window.astoundifyWrp;
	try {
		const {
			payload: { attributes, history },
		} = action;
		const variation = yield call(
			apiRequest,
			`wc/v2/products/${ postId }/variations`,
			'POST',
			{ attributes }
		);
		yield put( variationCreateSuccess( variation ) );
		yield history.push( `/variations/${ variation.id }` );
	} catch ( error ) {
		yield put( variationCreateFailure( error ) );
	}
}

export function* variationSaga() {
	yield takeLatest( VARIATION_FETCH_REQUEST, fetchSaga );
	yield takeLatest( POST_GET_SUCCESS, fetchSaga );
	yield takeLatest( VARIATION_GET_REQUEST, getOneSaga );
	yield takeLatest( VARIATION_UPDATE_REQUEST, updateSaga );
	yield takeLatest( VARIATION_DELETE_REQUEST, deleteSaga );
	yield takeLatest( VARIATION_CREATE_REQUEST, createSaga );
}
