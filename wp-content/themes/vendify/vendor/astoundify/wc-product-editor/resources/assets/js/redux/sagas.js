import { all, put } from 'redux-saga/effects';
import { categorySaga, fetchCategories } from 'redux/state/categories';
import { mediaSaga } from 'redux/state/media';
import { postSaga, getPost } from 'redux/state/post';
import { tagsSaga, fetchTags } from 'redux/state/tags';
import { previewSaga } from 'redux/state/preview';
import { toastsSaga } from 'redux/state/toasts';
import { variationSaga } from 'redux/state/variation';

const { postId } = window.astoundifyWrp;

function* startUp() {
	yield all( [
		put( getPost( postId ) ),
		put( fetchCategories() ),
		put( fetchTags() ),
	] );
}

export default function* rootSaga() {
	yield all( [
		previewSaga(),
		categorySaga(),
		mediaSaga(),
		postSaga(),
		tagsSaga(),
		toastsSaga(),
		variationSaga(),
		startUp(),
	] );
}
