import {
	put,
	call,
	select,
	actionChannel,
	take,
	all,
} from 'redux-saga/effects';
import { uploadMedia } from 'utils/api';
import { updatePost } from 'redux/state/post';
import { updateVariation } from './variation';

export const MEDIA_FETCH_REQUEST = 'MEDIA_FETCH_REQUEST';
export const MEDIA_FETCH_SUCCESS = 'MEDIA_FETCH_SUCCESS';
export const MEDIA_FETCH_FAILURE = 'MEDIA_FETCH_FAILURE';

export const MEDIA_GET_REQUEST = 'MEDIA_GET_REQUEST';
export const MEDIA_GET_SUCCESS = 'MEDIA_GET_SUCCESS';
export const MEDIA_GET_FAILURE = 'MEDIA_GET_FAILURE';

export const MEDIA_CREATE_REQUEST = 'MEDIA_CREATE_REQUEST';
export const VARIATION_MEDIA_CREATE_REQUEST = 'VARIATION_MEDIA_CREATE_REQUEST';
export const MEDIA_CREATE_SUCCESS = 'MEDIA_CREATE_SUCCESS';
export const MEDIA_CREATE_FAILURE = 'MEDIA_CREATE_FAILURE';

export const MEDIA_UPDATE_REQUEST = 'MEDIA_UPDATE_REQUEST';
export const MEDIA_UPDATE_SUCCESS = 'MEDIA_UPDATE_SUCCESS';
export const MEDIA_UPDATE_FAILURE = 'MEDIA_UPDATE_FAILURE';

const initialState = {
	items: [],
	replacePrimary: false,
};

export default function reducer( state = initialState, { type, payload } ) {
	switch ( type ) {
		case MEDIA_CREATE_SUCCESS:
			return {
				...state,
				items: payload.media,
				replacePrimary: false,
			};
		default:
			return state;
	}
}

export function createMedia( file, position = 0 ) {
	return {
		type: MEDIA_CREATE_REQUEST,
		payload: {
			file,
			position,
		},
	};
}

export function variationCreateMedia( file, variationId ) {
	return {
		type: VARIATION_MEDIA_CREATE_REQUEST,
		payload: {
			file,
			variationId,
		},
	};
}

export function mediaCreateSuccess( media ) {
	return {
		type: MEDIA_CREATE_SUCCESS,
		payload: {
			media,
		},
	};
}

function mediaCreateFailure( error ) {
	return {
		type: MEDIA_CREATE_FAILURE,
		payload: {
			error,
		},
	};
}

function* createSaga( action ) {
	try {
		const { type, payload } = action;
		const media = yield call( uploadMedia, payload );

		yield put( mediaCreateSuccess( media ) );

		const newImage = {
			id: media.id,
			date_created: media.date,
			date_created_gmt: media.date_gmt,
			date_modified: media.modified,
			date_modified_gmt: media.modified_gmt,
			src: media.source_url,
			name: media.title.rendered,
			alt: media.alt_text,
			position: payload.position,
		};

		const post = yield select( ( state ) => state.post );

		const patch = {
			images: [
				...post.images.filter( ( image ) => image.name !== 'Placeholder' ),
				newImage,
			],
		};

		yield put( updatePost( post.id, patch ) );
	} catch ( error ) {
		yield put( mediaCreateFailure( error ) );
	}
}

function* variationSaga( action ) {
	try {
		const {
			payload: { file, variationId },
		} = action;
		const media = yield call( uploadMedia, { file } );
		yield put( mediaCreateSuccess( media ) );
		const patch = {
			image: {
				id: media.id,
				date_created: media.date,
				date_created_gmt: media.date_gmt,
				date_modified: media.modified,
				date_modified_gmt: media.modified_gmt,
				src: media.source_url,
				name: media.title.rendered,
				alt: media.alt_text,
			},
		};
		yield put( updateVariation( variationId, patch ) );
	} catch ( error ) {
		yield put( mediaCreateFailure( error ) );
	}
}

export function* uploadChannel() {
	const channel = yield actionChannel( [
		MEDIA_CREATE_REQUEST,
	] );
	while ( true ) {
		const action = yield take( channel );
		yield call( createSaga, action );
	}
}

export function* variationUploadChannel() {
	const channel = yield actionChannel( VARIATION_MEDIA_CREATE_REQUEST );
	while ( true ) {
		const action = yield take( channel );
		yield call( variationSaga, action );
	}
}

export function mediaSaga() {
	return all( [ uploadChannel(), variationUploadChannel() ] );
}
