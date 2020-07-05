import { takeLatest } from 'redux-saga/effects';
import {
	POST_UPDATE_SUCCESS,
	POST_UPDATE_FAILURE,
	POST_GET_SUCCESS,
	POST_GET_FAILURE,
} from 'redux/state/post';
import {
	VARIATION_UPDATE_SUCCESS,
	VARIATION_UPDATE_FAILURE,
} from 'redux/state/variation';

export const FRAME_READY = 'FRAME_READY';
export const FRAME_RELOAD = 'FRAME_RELOAD';
export const FRAME_UPDATE = 'FRAME_UPDATE';

const initialState = {
	ready: false,
};

export default function reducer( state = initialState, { type } ) {
	switch ( type ) {
		case FRAME_READY:
			return {
				ready: true,
			};
		case FRAME_RELOAD:
			return {
				ready: false,
			};
		default:
			return state;
	}
}

/**
 * Get all tags
 * @return {Object} Action
 */
export function frameReady() {
	return {
		type: FRAME_READY,
	};
}

export function reloadFrame() {
	return {
		type: FRAME_RELOAD,
	};
}

export function runOnFrame( payload ) {
	return {
		type: FRAME_UPDATE,
		payload,
	};
}

function* reloadSaga() {
	try {
		yield takeLatest(
			[
				POST_UPDATE_SUCCESS,
				POST_UPDATE_FAILURE,
				POST_GET_SUCCESS,
				POST_GET_FAILURE,
				VARIATION_UPDATE_SUCCESS,
				VARIATION_UPDATE_FAILURE,
			],
			function* execute() {
				const frame = document.getElementById(
					'astoundify-wc-re-previewer-frame'
				);
				yield frame.contentWindow.window.location.reload();
			}
		);
		// need to put the action immediately
		// then wait for post update success to actually trigger the reload, so things don't get out of sync
	} catch ( error ) {
		yield console.error( error );
	}
}

function* updateSaga( action ) {
	try {
		if ( typeof action.payload === 'function' ) {
			const { contentWindow } = document.getElementById(
				'astoundify-wc-re-previewer-frame'
			);
			yield action.payload( contentWindow );
		}
	} catch ( error ) {
		yield console.error( error );
	}
}

export function* previewSaga() {
	yield takeLatest( FRAME_RELOAD, reloadSaga );
	yield takeLatest( FRAME_UPDATE, updateSaga );
}
