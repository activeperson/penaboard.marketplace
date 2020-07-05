import { shape, bool } from 'prop-types';

export default shape( {
	categories: bool,
	media: bool,
	post: bool,
	tags: bool,
} );
