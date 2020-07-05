import { createSelector } from 'reselect';

export const getPost = ( state ) => state.post;

export const withoutPlaceholder = createSelector( [ getPost ], ( post ) => ( {
	...post,
	images: post.images.filter( ( image ) => image.name !== 'Placeholder' ),
} ) );
