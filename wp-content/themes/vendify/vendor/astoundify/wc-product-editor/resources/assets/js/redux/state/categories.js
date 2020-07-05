import { put, call, takeLatest } from 'redux-saga/effects';
import { apiRequest } from 'utils/api';
import { categoryShape } from '../../shapes/category';

export const CATEGORY_FETCH_REQUEST = 'CATEGORY_FETCH_REQUEST';
export const CATEGORY_FETCH_SUCCESS = 'CATEGORY_FETCH_SUCCESS';
export const CATEGORY_FETCH_FAILURE = 'CATEGORY_FETCH_FAILURE';

export const CATEGORY_GET_REQUEST = 'CATEGORY_GET_REQUEST';
export const CATEGORY_GET_SUCCESS = 'CATEGORY_GET_SUCCESS';
export const CATEGORY_GET_FAILURE = 'CATEGORY_GET_FAILURE';

export const CATEGORY_CREATE_REQUEST = 'CATEGORY_CREATE_REQUEST';
export const CATEGORY_CREATE_SUCCESS = 'CATEGORY_CREATE_SUCCESS';
export const CATEGORY_CREATE_FAILURE = 'CATEGORY_CREATE_FAILURE';

export const CATEGORY_UPDATE_REQUEST = 'CATEGORY_UPDATE_REQUEST';
export const CATEGORY_UPDATE_SUCCESS = 'CATEGORY_UPDATE_SUCCESS';
export const CATEGORY_UPDATE_FAILURE = 'CATEGORY_UPDATE_FAILURE';

const initialState = {
	items: [],
};

export default function reducer( state = initialState, { type, payload } ) {
	switch ( type ) {
		case CATEGORY_FETCH_SUCCESS:
			return {
				...state,
				items: payload.categories,
			};
		case CATEGORY_UPDATE_SUCCESS:
			return {
				...state,
				items: payload.categories,
			};
		case CATEGORY_CREATE_SUCCESS:
			return {
				items: [ ...state.items, payload.category ],
			};
		default:
			return state;
	}
}

/**
 * Get all categories
 * @return {Object} Action
 */
export function fetchCategories() {
	return {
		type: CATEGORY_FETCH_REQUEST,
	};
}

export function categoryFetchSuccess( categories ) {
	return {
		type: CATEGORY_FETCH_SUCCESS,
		payload: {
			categories,
		},
	};
}

function categoryFetchFailure( error ) {
	return {
		type: CATEGORY_FETCH_FAILURE,
		payload: {
			error,
		},
	};
}

export function createCategory( name ) {
	return {
		type: CATEGORY_CREATE_REQUEST,
		payload: {
			name,
		},
	};
}

function createCategorySuccess( category ) {
	return {
		type: CATEGORY_CREATE_SUCCESS,
		payload: {
			category,
		},
	};
}

function createCategoryFailure( error ) {
	return {
		type: CATEGORY_CREATE_FAILURE,
		payload: {
			error,
		},
	};
}

function* fetchSaga() {
	try {
		const response = yield call( apiRequest, 'astoundify/wc-product-editor/v1/products/categories' );
		yield put( categoryFetchSuccess( response ) );
	} catch ( error ) {
		yield put( categoryFetchFailure( error ) );
	}
}

function* createSaga( action ) {
	try {
		const { payload } = action;
		const category = yield call( apiRequest, 'astoundify/wc-product-editor/v1/products/categories', 'POST', payload );
		yield put( createCategorySuccess( category ) );
	} catch ( error ) {
		yield put( createCategoryFailure( error ) );
	}
}

export function* categorySaga() {
	yield takeLatest( CATEGORY_FETCH_REQUEST, fetchSaga );
	yield takeLatest( CATEGORY_CREATE_REQUEST, createSaga );
}
