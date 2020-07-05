import { combineReducers } from 'redux';
import categories from 'redux/state/categories';
import loading from 'redux/state/loading';
import media from 'redux/state/media';
import post from 'redux/state/post';
import tags from 'redux/state/tags';
import preview from 'redux/state/preview';
import toasts from 'redux/state/toasts';
import variations from 'redux/state/variation';

const rootReducer = combineReducers( {
	categories,
	loading,
	media,
	post,
	tags,
	preview,
	toasts,
	variations,
} );

export default rootReducer;
