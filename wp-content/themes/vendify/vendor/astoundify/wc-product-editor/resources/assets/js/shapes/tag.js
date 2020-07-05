import { shape, arrayOf, string, number } from 'prop-types';

export const tagShape = shape( {
	id: number.isRequired,
	name: string.isRequired,
	slug: string.isRequired,
	description: string,
	count: number.isRequired,
} );

export const arrayOfTags = arrayOf( tagShape );
