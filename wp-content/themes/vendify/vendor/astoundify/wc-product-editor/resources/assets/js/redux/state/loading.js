import { combineReducers } from 'redux';

import {
	POST_GET_REQUEST,
	POST_GET_SUCCESS,
	POST_GET_FAILURE,
	UPDATE_ATTRIBUTES_REQUEST,
	UPDATE_ATTRIBUTES_SUCCESS,
	UPDATE_ATTRIBUTES_FAILURE,
} from 'redux/state/post';
import {
	CATEGORY_FETCH_REQUEST,
	CATEGORY_FETCH_SUCCESS,
	CATEGORY_FETCH_FAILURE,
	CATEGORY_CREATE_FAILURE,
	CATEGORY_CREATE_REQUEST,
	CATEGORY_CREATE_SUCCESS,
} from 'redux/state/categories';

import {
	TAGS_FETCH_REQUEST,
	TAGS_FETCH_SUCCESS,
	TAGS_FETCH_FAILURE,
	TAGS_CREATE_REQUEST,
	TAGS_CREATE_SUCCESS,
	TAGS_CREATE_FAILURE,
} from 'redux/state/tags';

/**
 * Utility function to making a simple reducer to swap the loading indicator status.
 *
 * @param {string} request - The request constant to use
 * @param {string} success - The success constant to use
 * @param {string} failure - The failure constant to use
 * @return {function} a reducer
 */
export function makeReducer( request, success, failure ) {
	return function reducer( state = false, action ) {
		if ( action.type === request ) {
			return true;
		} else if ( action.type === success || action.type === failure ) {
			return false;
		}
		return state;
	};
}

/**
 * Utility function to create a reducer that listens to mutliple actions and
 * swap loading indicator status
 *
 * @param  {Array.String} startActions - Actions that intiate loading
 * @param  {Array.String} finishActions - Actions that stop loading
 * @return {Function}
 */
export function makeMultiActionReducer( startActions, finishActions ) {
	let counter = 0;
	return function reducer( state = false, action ) {
		if ( startActions.indexOf( action.type ) !== -1 ) {
			counter += 1;
		} else if ( finishActions.indexOf( action.type ) !== -1 && counter > 0 ) {
			counter -= 1;
		} else {
			return state;
		}
		return counter > 0;
	};
}

export default combineReducers( {
	categories: makeMultiActionReducer(
		[ CATEGORY_FETCH_REQUEST, CATEGORY_CREATE_REQUEST ],
		[ CATEGORY_FETCH_SUCCESS, CATEGORY_CREATE_SUCCESS ],
		[ CATEGORY_FETCH_FAILURE, CATEGORY_CREATE_FAILURE ]
	),
	// media: false,
	post: makeMultiActionReducer(
		[ POST_GET_REQUEST, UPDATE_ATTRIBUTES_REQUEST ],
		[ POST_GET_SUCCESS, UPDATE_ATTRIBUTES_SUCCESS ],
		[ POST_GET_FAILURE, UPDATE_ATTRIBUTES_FAILURE ]
	),
	tags: makeMultiActionReducer(
		[ TAGS_CREATE_REQUEST, TAGS_FETCH_REQUEST ],
		[ TAGS_CREATE_SUCCESS, TAGS_FETCH_SUCCESS ],
		[ TAGS_CREATE_FAILURE, TAGS_FETCH_FAILURE ]
	),
} );
